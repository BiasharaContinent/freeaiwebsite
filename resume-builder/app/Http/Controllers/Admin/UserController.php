<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Import Role model
use Illuminate\Support\Facades\Hash; // For password updates if added
use Illuminate\Validation\Rule; // For unique email validation on update

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::with('roles')->orderBy('name');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $users = $query->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * (Admin creating users might be less common than user self-registration)
     * For now, we can skip direct admin creation or make it very basic.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = Role::pluck('name', 'name')->all(); // Get all roles for assignment
        // return view('admin.users.create', compact('roles'));
        return redirect()->route('admin.users.index')->with('info', 'User creation by admin is not implemented. Users should register themselves.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        //     'roles' => 'nullable|array'
        // ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // if ($request->filled('roles')) {
        //     $user->syncRoles($request->roles);
        // }

        // return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('resumes', 'roles'); // Eager load resumes and roles
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all(); // Get all roles
        $user->load('roles'); // Ensure roles are loaded for the form
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed', // Allow password change
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name' // Ensure roles exist
        ]);

        $userData = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        if ($request->has('roles')) {
            // Prevent admin from removing their own Admin role if they are the only admin
            // This is a basic check, more robust logic might be needed for multi-admin scenarios
            if ($user->id === Auth()->user()->id && !in_array('Admin', $request->input('roles', [])) && User::role('Admin')->count() <= 1) {
                 return redirect()->route('admin.users.edit', $user->id)->with('error', 'You cannot remove your own Admin role as you are the only Admin.');
            }
            $user->syncRoles($request->input('roles', []));
        } else {
            // If no roles are provided, and this isn't the self-admin case above
             if ($user->id === Auth()->user()->id && User::role('Admin')->count() <= 1) {
                 return redirect()->route('admin.users.edit', $user->id)->with('error', 'You cannot remove your own Admin role as you are the only Admin.');
             }
            $user->syncRoles([]); // Remove all roles
        }


        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth()->user()->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account from the admin panel.');
        }

        // Prevent deleting the last admin
        if ($user->hasRole('Admin') && User::role('Admin')->count() <= 1) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete the last admin user.');
        }

        try {
            // Resumes have onDelete('cascade') for user_id, so they should be deleted too.
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}
