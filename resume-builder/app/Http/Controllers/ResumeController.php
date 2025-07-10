<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\PersonalInfo;
use App\Models\ProfessionalSummary;
use App\Models\WorkExperience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Certification;
use App\Models\Language;
use App\Models\Award;
use App\Models\CustomSection;
use App\Models\Template; // Add Template model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // For transactions
use Illuminate\Support\Str; // Added for Str::slug

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Potentially a dashboard page showing all user's resumes)
     * For now, let's assume /home or a dedicated dashboard handles this.
     */
    public function index()
    {
        $user = Auth::user();
        $resumes = $user->resumes()->latest()->paginate(10);
        return view('resumes.index', compact('resumes')); // We'll need to create this view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Pass any necessary data for the form, e.g., skill types
        $skillTypes = ['soft', 'hard', 'technical', 'other'];
        $templates = Template::active()->orderBy('name')->get();

        $aiPrefillData = null;
        if ($request->has('use_ai_data') && session()->has('ai_prefill_data')) {
            $aiPrefillData = session('ai_prefill_data');
            // Clear it from session after retrieving to prevent reuse on refresh,
            // or manage its lifecycle more carefully if user might go back and forth.
            // session()->forget('ai_prefill_data');
            // For now, let's keep it in session until form submission from create page.
            // It can be cleared in the store method if it came from AI.
        }

        return view('resumes.create', compact('skillTypes', 'templates', 'aiPrefillData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validatedData = $this->validateResumeRequest($request);

        DB::beginTransaction();
        try {
            // Create the main Resume record
            $resume = $user->resumes()->create([
                'title' => $validatedData['resume_title'] ?? 'My Resume',
                'format_type' => $validatedData['format_type'] ?? 'styled',
                'template_id' => $validatedData['template_id'] ?? null,
            ]);

            // Personal Info
            if (isset($validatedData['personal_info'])) {
                $personalData = $validatedData['personal_info'];
                if ($request->hasFile('personal_info.profile_photo')) {
                    $path = $request->file('personal_info.profile_photo')->store('profile_photos', 'public');
                    $personalData['profile_photo_path'] = $path;
                }
                $resume->personalInfo()->create($personalData);
            }

            // Professional Summary
            if (isset($validatedData['professional_summary']) && !empty($validatedData['professional_summary']['summary_text'])) {
                $resume->professionalSummary()->create($validatedData['professional_summary']);
            }

            // Work Experiences
            if (isset($validatedData['work_experiences'])) {
                foreach ($validatedData['work_experiences'] as $expData) {
                    if (!empty($expData['job_title'])) { // Basic check to avoid empty entries
                        $resume->workExperiences()->create($expData);
                    }
                }
            }

            // Educations
            if (isset($validatedData['educations'])) {
                foreach ($validatedData['educations'] as $eduData) {
                     if (!empty($eduData['degree']) && !empty($eduData['institution'])) {
                        $resume->educations()->create($eduData);
                    }
                }
            }

            // Skills (handle existing or create new skills)
            if (isset($validatedData['skills'])) {
                $skillIds = [];
                foreach ($validatedData['skills'] as $skillData) {
                    if (!empty($skillData['skill_name'])) {
                        $skill = Skill::firstOrCreate(
                            ['skill_name' => strtolower(trim($skillData['skill_name']))],
                            ['type' => $skillData['type'] ?? 'other']
                        );
                        $skillIds[] = $skill->id;
                    }
                }
                $resume->skills()->sync($skillIds);
            }

            // Certifications
            if (isset($validatedData['certifications'])) {
                foreach ($validatedData['certifications'] as $certData) {
                    if(!empty($certData['name'])){
                        $resume->certifications()->create($certData);
                    }
                }
            }

            // Languages
            if (isset($validatedData['languages'])) {
                foreach ($validatedData['languages'] as $langData) {
                     if(!empty($langData['language_name'])){
                        $resume->languages()->create($langData);
                    }
                }
            }

            // Awards
            if (isset($validatedData['awards'])) {
                foreach ($validatedData['awards'] as $awardData) {
                    if(!empty($awardData['award_name'])){
                        $resume->awards()->create($awardData);
                    }
                }
            }

            // Custom Sections
            if (isset($validatedData['custom_sections'])) {
                foreach ($validatedData['custom_sections'] as $customData) {
                    if(!empty($customData['title']) && !empty($customData['content'])){
                        $resume->customSections()->create($customData);
                    }
                }
            }

            DB::commit();

            // Clear AI prefill data from session if it was used
            if (session()->has('ai_prefill_data')) {
                session()->forget('ai_prefill_data');
                session()->forget('original_extracted_text');
            }

            return redirect()->route('resumes.edit', $resume->id)->with('success', 'Resume created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating resume: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Error creating resume: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * (Typically used for a "show" page, but edit might be more practical here)
     */
    public function show(Resume $resume)
    {
        $this->authorize('view', $resume); // Policy for authorization
        // Eager load relationships for efficiency
        $resume->load(
            'personalInfo', 'professionalSummary', 'workExperiences',
            'educations', 'skills', 'certifications', 'languages', 'awards', 'customSections'
        );
        return view('resumes.show', compact('resume')); // We'll need this view for preview
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function edit(Resume $resume)
    {
        $this->authorize('update', $resume); // Policy for authorization

        // Eager load relationships for efficiency
        $resume->load(
            'personalInfo', 'professionalSummary', 'workExperiences',
            'educations', 'skills', 'certifications', 'languages', 'awards', 'customSections', 'template'
        );
        $skillTypes = ['soft', 'hard', 'technical', 'other'];
        $templates = Template::active()->orderBy('name')->get();

        return view('resumes.edit', compact('resume', 'skillTypes', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resume $resume)
    {
        $this->authorize('update', $resume);
        $validatedData = $this->validateResumeRequest($request, $resume->id);

        DB::beginTransaction();
        try {
            $resume->update([
                'title' => $validatedData['resume_title'] ?? $resume->title,
                'format_type' => $validatedData['format_type'] ?? $resume->format_type,
                'template_id' => $validatedData['template_id'] ?? null,
            ]);

            // Personal Info (updateOrCreate)
            $personalData = $validatedData['personal_info'] ?? [];
            if ($request->hasFile('personal_info.profile_photo')) {
                // Handle deletion of old photo if necessary
                // Storage::disk('public')->delete($resume->personalInfo->profile_photo_path ?? '');
                $path = $request->file('personal_info.profile_photo')->store('profile_photos', 'public');
                $personalData['profile_photo_path'] = $path;
            } elseif (isset($personalData['remove_profile_photo']) && $personalData['remove_profile_photo'] == '1') {
                 // Handle deletion of old photo
                // Storage::disk('public')->delete($resume->personalInfo->profile_photo_path ?? '');
                $personalData['profile_photo_path'] = null;
            }

            $resume->personalInfo()->updateOrCreate(['resume_id' => $resume->id], $personalData);


            // Professional Summary (updateOrCreate)
            if (isset($validatedData['professional_summary'])) {
                 if(!empty($validatedData['professional_summary']['summary_text'])){
                    $resume->professionalSummary()->updateOrCreate(['resume_id' => $resume->id], $validatedData['professional_summary']);
                 } else if ($resume->professionalSummary) {
                    $resume->professionalSummary()->delete();
                 }
            }


            // Work Experiences (complex: delete old, update existing, create new)
            $this->syncRelatedData($resume, 'workExperiences', $validatedData['work_experiences'] ?? []);

            // Educations
            $this->syncRelatedData($resume, 'educations', $validatedData['educations'] ?? []);

            // Skills
            if (isset($validatedData['skills'])) {
                $skillIds = [];
                foreach ($validatedData['skills'] as $skillData) {
                     if (!empty($skillData['skill_name'])) {
                        $skill = Skill::firstOrCreate(
                            ['skill_name' => strtolower(trim($skillData['skill_name']))],
                            ['type' => $skillData['type'] ?? 'other']
                        );
                        $skillIds[] = $skill->id;
                    }
                }
                $resume->skills()->sync($skillIds);
            } else {
                $resume->skills()->detach(); // Remove all skills if none provided
            }

            // Certifications
            $this->syncRelatedData($resume, 'certifications', $validatedData['certifications'] ?? []);
            // Languages
            $this->syncRelatedData($resume, 'languages', $validatedData['languages'] ?? []);
            // Awards
            $this->syncRelatedData($resume, 'awards', $validatedData['awards'] ?? []);
            // Custom Sections
            $this->syncRelatedData($resume, 'customSections', $validatedData['custom_sections'] ?? []);


            DB::commit();
            return redirect()->route('resumes.edit', $resume->id)->with('success', 'Resume updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Error updating resume: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Error updating resume: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resume $resume)
    {
        $this->authorize('delete', $resume);
        try {
            $resume->delete(); // Cascade deletes should handle related data based on migration setup
            return redirect()->route('home')->with('success', 'Resume deleted successfully.'); // Or resumes.index if you create it
        } catch (\Exception $e) {
            // Log::error('Error deleting resume: ' . $e->getMessage());
            return back()->with('error', 'Error deleting resume.');
        }
    }

    /**
     * Helper function to sync related one-to-many data.
     * Deletes items not present in the input, updates existing, creates new.
     */
    private function syncRelatedData(Resume $resume, string $relationName, array $itemsData)
    {
        $existingIds = $resume->$relationName()->pluck('id')->all();
        $incomingIds = [];

        foreach ($itemsData as $itemData) {
            // Basic check to avoid processing empty/incomplete items
            $isItemValid = false;
            if ($relationName === 'workExperiences' && !empty($itemData['job_title'])) $isItemValid = true;
            else if ($relationName === 'educations' && !empty($itemData['degree']) && !empty($itemData['institution'])) $isItemValid = true;
            else if ($relationName === 'certifications' && !empty($itemData['name'])) $isItemValid = true;
            else if ($relationName === 'languages' && !empty($itemData['language_name'])) $isItemValid = true;
            else if ($relationName === 'awards' && !empty($itemData['award_name'])) $isItemValid = true;
            else if ($relationName === 'customSections' && !empty($itemData['title']) && !empty($itemData['content'])) $isItemValid = true;


            if (!$isItemValid && !isset($itemData['id'])) continue; // Skip empty new items

            if (isset($itemData['id'])) { // Existing item
                $item = $resume->$relationName()->find($itemData['id']);
                if ($item && $isItemValid) {
                    $item->update($itemData);
                    $incomingIds[] = $item->id;
                } else if ($item && !$isItemValid) { // If an existing item is now invalid (e.g. title cleared), mark for deletion
                    // Or, just let it be deleted by the diff if not in $incomingIds
                }
            } elseif ($isItemValid) { // New item
                $newItem = $resume->$relationName()->create($itemData);
                $incomingIds[] = $newItem->id;
            }
        }

        // Delete items that were not in the incoming data
        $idsToDelete = array_diff($existingIds, $incomingIds);
        if (!empty($idsToDelete)) {
            $resume->$relationName()->whereIn('id', $idsToDelete)->delete();
        }
    }


    /**
     * Validate the request data for store and update.
     */
    private function validateResumeRequest(Request $request, $resumeId = null)
    {
        $rules = [
            'resume_title' => 'nullable|string|max:255',
            'format_type' => 'nullable|in:ats,styled',
            'template_id' => 'nullable|integer|exists:templates,id', // Added template_id validation

            // Personal Info
            'personal_info.full_name' => 'required|string|max:255',
            'personal_info.email' => 'required|email|max:255',
            'personal_info.phone' => 'nullable|string|max:20',
            'personal_info.location' => 'nullable|string|max:255',
            'personal_info.linkedin_url' => 'nullable|url|max:255',
            'personal_info.github_url' => 'nullable|url|max:255',
            'personal_info.portfolio_url' => 'nullable|url|max:255',
            'personal_info.profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
            'personal_info.remove_profile_photo' => 'nullable|boolean',


            // Professional Summary
            'professional_summary.summary_text' => 'nullable|string',

            // Work Experiences (array of experiences)
            'work_experiences' => 'nullable|array',
            'work_experiences.*.id' => 'nullable|integer|exists:work_experiences,id', // For updates
            'work_experiences.*.job_title' => 'required_with:work_experiences.*.company|string|max:255',
            'work_experiences.*.company' => 'required_with:work_experiences.*.job_title|string|max:255',
            'work_experiences.*.city_state' => 'nullable|string|max:255',
            'work_experiences.*.start_date' => 'required_with:work_experiences.*.job_title|date',
            'work_experiences.*.end_date' => 'nullable|date|after_or_equal:work_experiences.*.start_date',
            'work_experiences.*.is_current' => 'nullable|boolean',
            'work_experiences.*.responsibilities' => 'nullable|string',

            // Educations (array of educations)
            'educations' => 'nullable|array',
            'educations.*.id' => 'nullable|integer|exists:educations,id',
            'educations.*.degree' => 'required_with:educations.*.institution|string|max:255',
            'educations.*.institution' => 'required_with:educations.*.degree|string|max:255',
            'educations.*.major' => 'nullable|string|max:255',
            'educations.*.city_state' => 'nullable|string|max:255',
            'educations.*.graduation_start_date' => 'nullable|date',
            'educations.*.graduation_end_date' => 'nullable|date|after_or_equal:educations.*.graduation_start_date',
            'educations.*.details' => 'nullable|string',

            // Skills (array of skills)
            'skills' => 'nullable|array',
            'skills.*.skill_name' => 'required_if:skills.*.id,null|string|max:255', // Required if new skill
            'skills.*.type' => 'nullable|string|in:soft,hard,technical,other',
            // 'skills.*.id' is not strictly needed here as we use firstOrCreate by name

            // Certifications
            'certifications' => 'nullable|array',
            'certifications.*.id' => 'nullable|integer|exists:certifications,id',
            'certifications.*.name' => 'required_with:certifications.*.issuing_organization|string|max:255',
            'certifications.*.issuing_organization' => 'nullable|string|max:255',
            'certifications.*.date_issued' => 'nullable|date',
            'certifications.*.credential_id' => 'nullable|string|max:255',
            'certifications.*.credential_url' => 'nullable|url|max:255',
            'certifications.*.expiration_date' => 'nullable|date|after_or_equal:certifications.*.date_issued',

            // Languages
            'languages' => 'nullable|array',
            'languages.*.id' => 'nullable|integer|exists:languages,id',
            'languages.*.language_name' => 'required_with:languages.*.proficiency|string|max:255',
            'languages.*.proficiency' => 'nullable|string|max:255',

            // Awards
            'awards' => 'nullable|array',
            'awards.*.id' => 'nullable|integer|exists:awards,id',
            'awards.*.award_name' => 'required_with:awards.*.awarding_body|string|max:255',
            'awards.*.awarding_body' => 'nullable|string|max:255',
            'awards.*.date_awarded' => 'nullable|date',
            'awards.*.summary' => 'nullable|string',

            // Custom Sections
            'custom_sections' => 'nullable|array',
            'custom_sections.*.id' => 'nullable|integer|exists:custom_sections,id',
            'custom_sections.*.title' => 'required_with:custom_sections.*.content|string|max:255',
            'custom_sections.*.content' => 'required_with:custom_sections.*.title|string',
        ];

        // Add authorization checks for existing sub-records if necessary, e.g.,
        // 'work_experiences.*.id' => ['nullable', 'integer', Rule::exists('work_experiences', 'id')->where('resume_id', $resumeId)],


        return $request->validate($rules);
    }

    /**
     * Serves dynamic form partials for AJAX requests.
     */
    public function getFormPartial(Request $request, $partialName)
    {
        $index = $request->query('index', 0);
        $validPartials = [
            '_work_experience_item',
            '_education_item',
            '_skill_item',
            '_certification_item',
            '_language_item',
            '_award_item',
            '_custom_section_item',
        ];

        if (!in_array($partialName, $validPartials)) {
            return response()->json(['error' => 'Invalid partial name'], 400);
        }

        // Data needed for some partials, e.g., skillTypes for _skill_item
        $data = ['index' => $index];
        if ($partialName === '_skill_item') {
            $data['skillTypes'] = ['soft', 'hard', 'technical', 'other'];
            $data['skill'] = null; // Ensure skill is null for a new item
        }
        // Add other data as needed for other partials, ensuring they are null for new items
        $data[strtolower(str_replace('_item', '', str_replace('_', '', $partialName)))] = null;


        // Ensure the view path is correct
        $viewPath = 'resumes.partials.' . $partialName;

        if (!view()->exists($viewPath)) {
            return response("Partial view {$viewPath} not found.", 404);
        }

        return view($viewPath, $data);
    }

    /**
     * Download the resume as a PDF.
     *
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(Resume $resume)
    {
        $this->authorize('view', $resume); // Ensure user is authorized to view (and thus download)

        // Eager load necessary relations
        $resume->load(
            'personalInfo', 'professionalSummary', 'workExperiences',
            'educations', 'skills', 'certifications', 'languages', 'awards', 'customSections', 'template'
        );

        if (!$resume->template || !view()->exists($resume->template->view_name)) {
            // Fallback if template or view is missing - perhaps use a default or show error
            // For now, let's try to render a very basic default if specific template fails
            // Or redirect back with an error:
            // return redirect()->route('resumes.show', $resume->id)->with('error', 'Selected template view not found. Cannot generate PDF.');

            // For this example, we'll try to render simple_ats as a fallback for PDF
            $viewName = 'resumes.templates.simple_ats';
            if (!view()->exists($viewName)) {
                 return redirect()->route('resumes.show', $resume->id)->with('error', 'Default template view not found. Cannot generate PDF.');
            }
        } else {
            $viewName = $resume->template->view_name;
        }

        // It's good practice to set options for dompdf, especially for complex CSS or external resources
        // For example, enabling remote resource loading if your templates use external images/fonts
        // config(['dompdf.options.isRemoteEnabled' => true]);
        // config(['dompdf.options.isHtml5ParserEnabled' => true]);


        // Using the facade:
        // $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewName, compact('resume'));
        // Or dependency injection:
        $pdf = app('dompdf.wrapper');
        $pdf->loadView($viewName, compact('resume'));


        $fileName = Str::slug($resume->personalInfo->full_name ?? 'resume') . '_' . Str::slug($resume->title ?? 'untitled') . '.pdf';

        return $pdf->download($fileName);
    }
}
