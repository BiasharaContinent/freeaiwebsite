<?php

namespace App\Policies;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResumePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // Any authenticated user can view their own list of resumes
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Resume $resume)
    {
        return $user->id === $resume->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Any authenticated user can create a resume
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Resume $resume)
    {
        return $user->id === $resume->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Resume $resume)
    {
        return $user->id === $resume->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Resume $resume)
    {
        return $user->id === $resume->user_id; // If you implement soft deletes for Resumes
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Resume $resume)
    {
        return $user->id === $resume->user_id; // If you implement soft deletes for Resumes
    }
}
