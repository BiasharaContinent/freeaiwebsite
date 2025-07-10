<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::orderBy('name')->paginate(10);
        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templateTypes = ['ats', 'styled']; // For dropdown
        return view('admin.templates.create', compact('templateTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateTemplateRequest($request);

        if ($request->hasFile('preview_image')) {
            $path = $request->file('preview_image')->store('template_previews', 'public');
            $validatedData['preview_image_path'] = $path;
        }

        // Sanitize view_name: replace dots with slashes if user enters path-like string
        $validatedData['view_name'] = str_replace('/', '.', $validatedData['view_name']);
        // Ensure it follows a convention like 'resumes.templates.name'
        if(!Str::startsWith($validatedData['view_name'], 'resumes.templates.')){
            $validatedData['view_name'] = 'resumes.templates.' . Str::slug(basename($validatedData['view_name']), '_');
        }


        Template::create($validatedData);

        return redirect()->route('admin.templates.index')->with('success', 'Template created successfully.');
    }

    /**
     * Display the specified resource. (Not used due to `except(['show'])` in routes)
     */
    // public function show(Template $template) { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        $templateTypes = ['ats', 'styled'];
        return view('admin.templates.edit', compact('template', 'templateTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        $validatedData = $this->validateTemplateRequest($request, $template->id);

        if ($request->hasFile('preview_image')) {
            // Delete old image if it exists
            if ($template->preview_image_path) {
                Storage::disk('public')->delete($template->preview_image_path);
            }
            $path = $request->file('preview_image')->store('template_previews', 'public');
            $validatedData['preview_image_path'] = $path;
        } elseif ($request->input('remove_preview_image') == '1' && $template->preview_image_path) {
            Storage::disk('public')->delete($template->preview_image_path);
            $validatedData['preview_image_path'] = null;
        }

        // Sanitize view_name
        $validatedData['view_name'] = str_replace('/', '.', $validatedData['view_name']);
         if(!Str::startsWith($validatedData['view_name'], 'resumes.templates.')){
            $validatedData['view_name'] = 'resumes.templates.' . Str::slug(basename($validatedData['view_name']), '_');
        }

        $template->update($validatedData);

        return redirect()->route('admin.templates.index')->with('success', 'Template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        try {
            if ($template->preview_image_path) {
                Storage::disk('public')->delete($template->preview_image_path);
            }
            $template->delete();
            return redirect()->route('admin.templates.index')->with('success', 'Template deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle potential foreign key constraint violation if resumes are using this template
            // For onDelete('set null') on resumes.template_id, this should be fine.
            // If onDelete('restrict'), this would throw an error.
            return redirect()->route('admin.templates.index')->with('error', 'Could not delete template. It might be in use or another error occurred. Error: ' . $e->getMessage());
        }
    }

    /**
     * Validate the request for storing/updating a template.
     */
    private function validateTemplateRequest(Request $request, $templateId = null)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:templates,name' . ($templateId ? ',' . $templateId : ''),
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:ats,styled',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB
            'remove_preview_image' => 'nullable|boolean',
            'view_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9._-]+$/|unique:templates,view_name' . ($templateId ? ',' . $templateId : ''),
            'font_specs.body' => 'nullable|string|max:255',
            'font_specs.heading' => 'nullable|string|max:255',
            'color_specs.primary' => 'nullable|string|max:7', // hex color
            'color_specs.accent' => 'nullable|string|max:7',
            'color_specs.background' => 'nullable|string|max:7',
            'layout_specs_json' => 'nullable|json', // For more complex rules
            'is_active' => 'nullable|boolean',
        ];

        $validated = $request->validate($rules, [
            'view_name.regex' => 'The view name can only contain letters, numbers, dots, underscores, and hyphens.',
        ]);

        // Handle boolean for is_active
        $validated['is_active'] = $request->has('is_active');

        // Prepare JSON fields - cast to object if only one level, or handle as string then cast in model
        // For simplicity, we'll let direct assignment handle it if the input names are correct.
        // Or, more explicitly:
        $validated['font_specs'] = json_encode(['body' => $request->input('font_specs.body'), 'heading' => $request->input('font_specs.heading')]);
        $validated['color_specs'] = json_encode([
            'primary' => $request->input('color_specs.primary'),
            'accent' => $request->input('color_specs.accent'),
            'background' => $request->input('color_specs.background')
        ]);
        // If layout_specs_json is simple key-value, it can be handled similarly. If it's a raw JSON string:
        // $validated['layout_specs_json'] = $request->input('layout_specs_json');
        // The model's $casts to 'array' will handle encoding/decoding.
        // For direct input of JSON string:
        if ($request->filled('layout_specs_json')) {
            $decodedJson = json_decode($request->input('layout_specs_json'));
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Add a custom validation error if JSON is invalid
                // This requires a bit more setup with Validator::make manually.
                // For now, we assume valid JSON if provided or rely on database error.
            }
             $validated['layout_specs_json'] = $request->input('layout_specs_json'); // Store as string, model casts
        } else {
            $validated['layout_specs_json'] = null;
        }


        return $validated;
    }
}
