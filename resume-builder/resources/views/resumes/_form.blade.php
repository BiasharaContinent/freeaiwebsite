@csrf
<div class="row">
    <div class="col-md-8">
        {{-- Resume Title and Format --}}
        <div class="card mb-3">
            <div class="card-header">{{ __('Resume Details') }}</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="resume_title">{{ __('Resume Title (Optional)') }}</label>
                    <input type="text" name="resume_title" id="resume_title" class="form-control @error('resume_title') is-invalid @enderror" value="{{ old('resume_title', $resume->title ?? 'My Resume') }}">
                    @error('resume_title')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="format_type">{{ __('Choose Format') }}</label>
                    <select name="format_type" id="format_type" class="form-control @error('format_type') is-invalid @enderror">
                        <option value="styled" {{ old('format_type', $resume->format_type ?? 'styled') == 'styled' ? 'selected' : '' }}>{{ __('Styled (Design-heavy, Modern)') }}</option>
                        <option value="ats" {{ old('format_type', $resume->format_type ?? '') == 'ats' ? 'selected' : '' }}>{{ __('ATS-Optimized (Clean, Minimal)') }}</option>
                    </select>
                    @error('format_type')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Personal Info Section --}}
        <div class="card mb-3">
            <div class="card-header">{{ __('Personal Information') }}</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="pi_full_name">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="personal_info[full_name]" id="pi_full_name" class="form-control @error('personal_info.full_name') is-invalid @enderror" value="{{ old('personal_info.full_name', $resume->personalInfo->full_name ?? ($aiPrefillData['personal_info']['full_name'] ?? '')) }}" required>
                    @error('personal_info.full_name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pi_email">{{ __('Email') }} <span class="text-danger">*</span></label>
                        <input type="email" name="personal_info[email]" id="pi_email" class="form-control @error('personal_info.email') is-invalid @enderror" value="{{ old('personal_info.email', $resume->personalInfo->email ?? ($aiPrefillData['personal_info']['email'] ?? '')) }}" required>
                        @error('personal_info.email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pi_phone">{{ __('Phone') }}</label>
                        <input type="tel" name="personal_info[phone]" id="pi_phone" class="form-control @error('personal_info.phone') is-invalid @enderror" value="{{ old('personal_info.phone', $resume->personalInfo->phone ?? ($aiPrefillData['personal_info']['phone'] ?? '')) }}">
                        @error('personal_info.phone')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="pi_location">{{ __('Location (e.g. City, Country)') }}</label>
                    <input type="text" name="personal_info[location]" id="pi_location" class="form-control @error('personal_info.location') is-invalid @enderror" value="{{ old('personal_info.location', $resume->personalInfo->location ?? ($aiPrefillData['personal_info']['location'] ?? '')) }}">
                    @error('personal_info.location')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pi_linkedin_url">{{ __('LinkedIn Profile URL') }}</label>
                        <input type="url" name="personal_info[linkedin_url]" id="pi_linkedin_url" class="form-control @error('personal_info.linkedin_url') is-invalid @enderror" value="{{ old('personal_info.linkedin_url', $resume->personalInfo->linkedin_url ?? ($aiPrefillData['personal_info']['linkedin_url'] ?? '')) }}">
                        @error('personal_info.linkedin_url')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pi_github_url">{{ __('GitHub Profile URL') }}</label>
                        <input type="url" name="personal_info[github_url]" id="pi_github_url" class="form-control @error('personal_info.github_url') is-invalid @enderror" value="{{ old('personal_info.github_url', $resume->personalInfo->github_url ?? ($aiPrefillData['personal_info']['github_url'] ?? '')) }}">
                        @error('personal_info.github_url')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                 <div class="form-group">
                    <label for="pi_portfolio_url">{{ __('Portfolio/Website URL') }}</label>
                    <input type="url" name="personal_info[portfolio_url]" id="pi_portfolio_url" class="form-control @error('personal_info.portfolio_url') is-invalid @enderror" value="{{ old('personal_info.portfolio_url', $resume->personalInfo->portfolio_url ?? ($aiPrefillData['personal_info']['portfolio_url'] ?? '')) }}">
                    @error('personal_info.portfolio_url')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="pi_profile_photo">{{ __('Profile Photo (Optional)') }}</label>
                    <input type="file" name="personal_info[profile_photo]" id="pi_profile_photo" class="form-control-file @error('personal_info.profile_photo') is-invalid @enderror">
                    @error('personal_info.profile_photo')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    @if(isset($resume) && $resume->personalInfo && $resume->personalInfo->profile_photo_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $resume->personalInfo->profile_photo_path) }}" alt="Profile Photo" style="max-height: 100px; border-radius: 5px;">
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" name="personal_info[remove_profile_photo]" value="1" id="remove_profile_photo">
                                <label class="form-check-label" for="remove_profile_photo">
                                    {{ __('Remove current photo') }}
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Professional Summary Section --}}
        <div class="card mb-3">
            <div class="card-header">{{ __('Professional Summary') }}</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="ps_summary_text">{{ __('Summary') }}</label>
                    <textarea name="professional_summary[summary_text]" id="ps_summary_text" class="form-control @error('professional_summary.summary_text') is-invalid @enderror" rows="5">{{ old('professional_summary.summary_text', $resume->professionalSummary->summary_text ?? ($aiPrefillData['professional_summary']['summary_text'] ?? '')) }}</textarea>
                    @error('professional_summary.summary_text')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="suggest-summary-btn" data-target-textarea="ps_summary_text">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-magic" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.5 2.672a.5.5 0 1 0 1 0V.843a.5.5 0 0 0-1 0v1.829Zm4.5.035A.5.5 0 0 0 13.293 2L12 3.293a.5.5 0 1 0 .707.707L14 2.707ZM7.293 4A.5.5 0 1 0 8 3.293L6.707 2A.5.5 0 0 0 6 2.707L7.293 4Zm-.646 2.354a.5.5 0 0 0 0 .708l1.147 1.146a.5.5 0 0 0 .708 0l1.146-1.147a.5.5 0 0 0 0-.708L8.354 5.5h.092a.5.5 0 0 0 0-1H8.354L7.207 3.354a.5.5 0 0 0-.708 0L5.354 4.5H5.26a.5.5 0 0 0 0 1h.092l1.147 1.146Z"/><path d="M12.026 8.5H4.002c-.264 0-.398.236-.28.465l.889 1.777c.115.23.38.388.653.388h4.804c.272 0 .538-.158.653-.388l.89-1.777a.304.304 0 0 0-.28-.465Z"/><path d="M3.5 13h9a.5.5 0 0 0 0-1h-9a.5.5 0 0 0 0 1Z"/><path d="M2.793 6.793A.5.5 0 0 1 2.5 6.5V4.707A.5.5 0 0 1 3 4.5h1.146a.5.5 0 0 1 0 1H3.5v1.207a.5.5 0 0 1-.707.707Z"/></svg>
                        {{ __('AI Suggest Summary') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Work Experience Section --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Work Experience') }}
                <button type="button" class="btn btn-sm btn-success" id="add-experience-btn">{{ __('Add Experience') }}</button>
            </div>
            <div class="card-body" id="work-experience-section">
                @php
                    $workExperiences = old('work_experiences',
                        $resume->workExperiences ?? ($aiPrefillData['work_experiences'] ?? [])
                    );
                    if (is_a($workExperiences, 'Illuminate\Database\Eloquent\Collection')) {
                        $workExperiences = $workExperiences->toArray();
                    }
                @endphp
                @if(!empty($workExperiences) && count($workExperiences) > 0)
                    @foreach($workExperiences as $index => $experience)
                        @include('resumes.partials._work_experience_item', ['index' => $index, 'experience' => (object)$experience])
                    @endforeach
                @else
                    {{-- Add one blank by default if creating new, no old data, and no AI prefill --}}
                    @if(!isset($resume) && empty(old('work_experiences')) && empty($aiPrefillData['work_experiences']))
                         @include('resumes.partials._work_experience_item', ['index' => 0, 'experience' => null])
                    @else
                        <p class="text-muted no-experience-message">{{__('No work experiences added yet.')}}</p>
                    @endif
                @endif
            </div>
        </div>

        {{-- Education Section --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Education') }}
                <button type="button" class="btn btn-sm btn-success" id="add-education-btn">{{ __('Add Education') }}</button>
            </div>
            <div class="card-body" id="education-section">
                @php
                    $educations = old('educations',
                        $resume->educations ?? ($aiPrefillData['education_entries'] ?? [])
                    );
                    if (is_a($educations, 'Illuminate\Database\Eloquent\Collection')) {
                        $educations = $educations->toArray();
                    }
                @endphp
                @if(!empty($educations) && count($educations) > 0)
                    @foreach($educations as $index => $education)
                        @include('resumes.partials._education_item', ['index' => $index, 'education' => (object)$education])
                    @endforeach
                @else
                     @if(!isset($resume) && empty(old('educations')) && empty($aiPrefillData['education_entries']))
                        @include('resumes.partials._education_item', ['index' => 0, 'education' => null])
                     @else
                        <p class="text-muted no-education-message">{{__('No education entries added yet.')}}</p>
                     @endif
                @endif
            </div>
        </div>

        {{-- Skills Section --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Skills') }}
                <button type="button" class="btn btn-sm btn-success" id="add-skill-btn">{{ __('Add Skill') }}</button>
            </div>
            <div class="card-body" id="skills-section">
                @php
                    $skillsData = [];
                    if (old('skills')) {
                        $skillsData = old('skills');
                    } elseif (isset($resume) && $resume->skills) {
                        $skillsData = $resume->skills->map(function($skill) {
                            return ['skill_name' => $skill->skill_name, 'type' => $skill->type, 'id' => $skill->id];
                        })->toArray();
                    } elseif (isset($aiPrefillData['skills_list'])) {
                        $skillsData = $aiPrefillData['skills_list']; // AI provides array of ['skill_name' => ..., 'type' => ...]
                    }
                @endphp
                @if(!empty($skillsData) && count($skillsData) > 0)
                    @foreach($skillsData as $index => $skill)
                        @include('resumes.partials._skill_item', ['index' => $index, 'skill' => (object)$skill, 'skillTypes' => $skillTypes])
                    @endforeach
                @else
                    @if(!isset($resume) && empty(old('skills')) && empty($aiPrefillData['skills_list']))
                        @include('resumes.partials._skill_item', ['index' => 0, 'skill' => null, 'skillTypes' => $skillTypes])
                    @else
                         <p class="text-muted no-skill-message">{{__('No skills added yet.')}}</p>
                    @endif
                @endif
            </div>
        </div>

        {{-- Certifications Section --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Certifications') }}
                <button type="button" class="btn btn-sm btn-success" id="add-certification-btn">{{ __('Add Certification') }}</button>
            </div>
            <div class="card-body" id="certifications-section">
                 @php
                    $certifications = old('certifications',
                        $resume->certifications ?? ($aiPrefillData['certifications_list'] ?? [])
                    );
                    if (is_a($certifications, 'Illuminate\Database\Eloquent\Collection')) {
                        $certifications = $certifications->toArray();
                    }
                 @endphp
                @if(!empty($certifications) && count($certifications) > 0)
                    @foreach($certifications as $index => $certification)
                        @include('resumes.partials._certification_item', ['index' => $index, 'certification' => (object)$certification])
                    @endforeach
                @else
                    @if(!isset($resume) && empty(old('certifications')) && empty($aiPrefillData['certifications_list']))
                        @include('resumes.partials._certification_item', ['index' => 0, 'certification' => null])
                    @else
                        <p class="text-muted no-certification-message">{{__('No certifications added yet.')}}</p>
                    @endif
                @endif
            </div>
        </div>

        {{-- Languages Section --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Languages') }}
                <button type="button" class="btn btn-sm btn-success" id="add-language-btn">{{ __('Add Language') }}</button>
            </div>
            <div class="card-body" id="languages-section">
                @php
                    $languages = old('languages',
                        $resume->languages ?? ($aiPrefillData['languages_list'] ?? [])
                    );
                    if (is_a($languages, 'Illuminate\Database\Eloquent\Collection')) {
                        $languages = $languages->toArray();
                    }
                @endphp
                @if(!empty($languages) && count($languages) > 0)
                    @foreach($languages as $index => $language)
                        @include('resumes.partials._language_item', ['index' => $index, 'language' => (object)$language])
                    @endforeach
                @else
                    @if(!isset($resume) && empty(old('languages')) && empty($aiPrefillData['languages_list']))
                        @include('resumes.partials._language_item', ['index' => 0, 'language' => null])
                    @else
                        <p class="text-muted no-language-message">{{__('No languages added yet.')}}</p>
                    @endif
                @endif
            </div>
        </div>

        {{-- Awards Section --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Awards & Honors') }}
                <button type="button" class="btn btn-sm btn-success" id="add-award-btn">{{ __('Add Award') }}</button>
            </div>
            <div class="card-body" id="awards-section">
                @php
                    $awards = old('awards',
                        $resume->awards ?? ($aiPrefillData['awards_list'] ?? [])
                    );
                    if (is_a($awards, 'Illuminate\Database\Eloquent\Collection')) {
                        $awards = $awards->toArray();
                    }
                @endphp
                @if(!empty($awards) && count($awards) > 0)
                    @foreach($awards as $index => $award)
                        @include('resumes.partials._award_item', ['index' => $index, 'award' => (object)$award])
                    @endforeach
                @else
                    @if(!isset($resume) && empty(old('awards')) && empty($aiPrefillData['awards_list']))
                        @include('resumes.partials._award_item', ['index' => 0, 'award' => null])
                    @else
                        <p class="text-muted no-award-message">{{__('No awards added yet.')}}</p>
                    @endif
                @endif
            </div>
        </div>

        {{-- Custom Sections --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Custom Sections') }}
                <button type="button" class="btn btn-sm btn-success" id="add-custom-section-btn">{{ __('Add Custom Section') }}</button>
            </div>
            <div class="card-body" id="custom-sections-section">
                @php
                    $customSections = old('custom_sections',
                        $resume->customSections ?? ($aiPrefillData['custom_sections_list'] ?? [])
                    );
                    if (is_a($customSections, 'Illuminate\Database\Eloquent\Collection')) {
                        $customSections = $customSections->toArray();
                    }
                @endphp
                @if(!empty($customSections) && count($customSections) > 0)
                    @foreach($customSections as $index => $customSection)
                        @include('resumes.partials._custom_section_item', ['index' => $index, 'customSection' => (object)$customSection])
                    @endforeach
                @else
                     @if(!isset($resume) && empty(old('custom_sections')) && empty($aiPrefillData['custom_sections_list']))
                        {{-- Don't add a blank custom section by default unless user clicks add, even with AI --}}
                        <p class="text-muted no-custom-section-message">{{__('No custom sections added yet.')}}</p>
                     @else
                        <p class="text-muted no-custom-section-message">{{__('No custom sections added yet.')}}</p>
                     @endif
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Actions and Template Picker --}}
        <div class="card sticky-top mb-3">
            <div class="card-header">{{ __('Actions & Template') }}</div>
            <div class="card-body">
                @if(isset($templates) && $templates->count() > 0)
                    <div class="form-group">
                        <label for="template_id">{{ __('Choose a Template') }}</label>
                        <select name="template_id" id="template_id" class="form-control @error('template_id') is-invalid @enderror">
                            <option value="">{{ __('Select a Template (Optional)') }}</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}" data-type="{{ $template->type }}"
                                    {{ old('template_id', $resume->template_id ?? '') == $template->id ? 'selected' : '' }}>
                                    {{ $template->name }} ({{ ucfirst($template->type) }})
                                </option>
                            @endforeach
                        </select>
                        @error('template_id')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <small id="template-type-helper" class="form-text text-muted"></small>
                    </div>
                @else
                    <p>{{ __('No templates available yet. An administrator needs to add them.') }}</p>
                @endif

                <button type="submit" class="btn btn-primary btn-block">{{ isset($resume) ? __('Update Resume') : __('Save Resume') }}</button>
                @if(isset($resume) && $resume->id)
                    <a href="{{ route('resumes.show', $resume->id) }}" class="btn btn-secondary btn-block mt-2">{{ __('Preview') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function initializeDynamicSection(sectionId, addButtonId, templatePartialName, noItemMessageClass, initialItem = false) {
        const section = document.getElementById(sectionId);
        const addButton = document.getElementById(addButtonId);
        let itemIndex = section.querySelectorAll('.dynamic-item').length;
        const noItemMessageSelector = '.' + noItemMessageClass;

        function removeItem(event) {
            if (event.target.classList.contains('remove-item-btn')) {
                event.target.closest('.dynamic-item').remove();
                if (section.querySelectorAll('.dynamic-item').length === 0) {
                    const noItemMessage = section.querySelector(noItemMessageSelector);
                    if (noItemMessage) noItemMessage.style.display = 'block';
                }
            }
        }

        section.addEventListener('click', removeItem);

        addButton.addEventListener('click', function () {
            const noItemMessage = section.querySelector(noItemMessageSelector);
            if (noItemMessage) noItemMessage.style.display = 'none';

            // Fetch the template for the item using a simple approach for now
            // In a more complex app, you might use AJAX to fetch compiled Blade partials or use a JS templating engine
            fetch(`{{ url('/resume-partials') }}/${templatePartialName}?index=${itemIndex}`)
                .then(response => response.text())
                .then(html => {
                    const newItem = document.createElement('div');
                    newItem.classList.add('dynamic-item');
                    newItem.innerHTML = html;
                    section.appendChild(newItem);
                    itemIndex++;
                }).catch(error => console.error('Error fetching partial:', error));
        });

        // If initialItem is true and there are no items, add one (for create form)
        if (initialItem && section.querySelectorAll('.dynamic-item').length === 0) {
            // This part is tricky without server-side rendering of the first item.
            // The @include in blade handles the first item for "create" if no old data.
            // This JS initialItem is more for if all items are removed and then user wants to add first one back.
            // For now, the blade @include handles the very first one on page load for create.
        }
    }

    initializeDynamicSection('work-experience-section', 'add-experience-btn', '_work_experience_item', 'no-experience-message', {{ !isset($resume) && empty(old('work_experiences')) ? 'true' : 'false' }} );
    initializeDynamicSection('education-section', 'add-education-btn', '_education_item', 'no-education-message', {{ !isset($resume) && empty(old('educations')) ? 'true' : 'false' }} );
    initializeDynamicSection('skills-section', 'add-skill-btn', '_skill_item', 'no-skill-message', {{ !isset($resume) && empty(old('skills')) ? 'true' : 'false' }} );
    initializeDynamicSection('certifications-section', 'add-certification-btn', '_certification_item', 'no-certification-message', {{ !isset($resume) && empty(old('certifications')) ? 'true' : 'false' }} );
    initializeDynamicSection('languages-section', 'add-language-btn', '_language_item', 'no-language-message', {{ !isset($resume) && empty(old('languages')) ? 'true' : 'false' }});
    initializeDynamicSection('awards-section', 'add-award-btn', '_award_item', 'no-award-message', {{ !isset($resume) && empty(old('awards')) ? 'true' : 'false' }});
    initializeDynamicSection('custom-sections-section', 'add-custom-section-btn', '_custom_section_item', 'no-custom-section-message');


    // Handle "is_current" checkbox for work experience end_date
    document.getElementById('work-experience-section').addEventListener('change', function(event) {
        if (event.target.name && event.target.name.endsWith('[is_current]')) {
            const endDateInput = event.target.closest('.dynamic-item').querySelector('input[name$="[end_date]"]');
            if (endDateInput) {
                endDateInput.disabled = event.target.checked;
                if (event.target.checked) {
                    endDateInput.value = ''; // Clear end date if current
                }
            }
        }
    });
     // Trigger change on load for existing "current" jobs
    document.querySelectorAll('input[name$="[is_current]"]:checked').forEach(checkbox => {
        const endDateInput = checkbox.closest('.dynamic-item').querySelector('input[name$="[end_date]"]');
        if (endDateInput) {
            endDateInput.disabled = true;
        }
    });

    // Template Picker Helper
    const templateSelect = document.getElementById('template_id');
    const formatTypeSelect = document.getElementById('format_type');
    const templateTypeHelper = document.getElementById('template-type-helper');

    if (templateSelect && formatTypeSelect && templateTypeHelper) {
        function updateTemplateHelperAndSyncFormat() {
            const selectedOption = templateSelect.options[templateSelect.selectedIndex];
            const templateType = selectedOption.dataset.type;

            if (templateSelect.value && templateType) { // A template is selected
                templateTypeHelper.textContent = `This is a ${templateType.toUpperCase()} template. The "Choose Format" option will be updated.`;
                // Sync format_type dropdown
                if (formatTypeSelect.value !== templateType) {
                    formatTypeSelect.value = templateType;
                }
                // Optionally disable the format_type select if a template is chosen
                // formatTypeSelect.disabled = true;
            } else { // No template selected or "Select a Template" option
                templateTypeHelper.textContent = 'Select a template to automatically set its type (ATS/Styled), or choose format manually.';
                // formatTypeSelect.disabled = false; // Re-enable if it was disabled
            }
        }

        templateSelect.addEventListener('change', updateTemplateHelperAndSyncFormat);

        formatTypeSelect.addEventListener('change', function() {
            const selectedTemplateOption = templateSelect.options[templateSelect.selectedIndex];
            const templateType = selectedTemplateOption.dataset.type;

            if (templateSelect.value && templateType && this.value !== templateType) {
                templateTypeHelper.textContent = `Note: The selected template is ${templateType.toUpperCase()}, but resume format is now set to ${this.value.toUpperCase()}. Consider choosing a matching template.`;
                // Optionally, you could auto-clear the template selection:
                // templateSelect.value = "";
                // updateTemplateHelperAndSyncFormat();
            } else if (templateSelect.value && templateType && this.value === templateType) {
                 updateTemplateHelperAndSyncFormat(); // re-sync helper text
            } else if (!templateSelect.value) {
                 templateTypeHelper.textContent = 'Select a template to automatically set its type (ATS/Styled), or choose format manually.';
            }
        });

        // Initial call to set helper text and sync format if a template is pre-selected (e.g. on edit page)
        updateTemplateHelperAndSyncFormat();
    }

    // AI Suggestion Buttons
    const suggestSummaryBtn = document.getElementById('suggest-summary-btn');
    if (suggestSummaryBtn) {
        suggestSummaryBtn.addEventListener('click', function() {
            const targetTextareaId = this.dataset.targetTextarea;
            const targetTextarea = document.getElementById(targetTextareaId);
            const currentSummary = targetTextarea.value;

            // Collect work experiences for context (simplified)
            let workExperiencesContext = [];
            document.querySelectorAll('.work-experience-item').forEach(item => {
                const jobTitle = item.querySelector('input[name$="[job_title]"]')?.value;
                const company = item.querySelector('input[name$="[company]"]')?.value;
                if (jobTitle && company) {
                    workExperiencesContext.push({ job_title: jobTitle, company: company });
                }
            });

            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...';

            fetch("{{ route('ai.suggest.summary') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    current_summary: currentSummary,
                    work_experiences: workExperiencesContext
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.suggestion) {
                    targetTextarea.value = data.suggestion;
                } else if (data.error) {
                    alert('Error from AI: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error fetching summary suggestion:', error);
                alert('Could not fetch suggestion.');
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-magic" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.5 2.672a.5.5 0 1 0 1 0V.843a.5.5 0 0 0-1 0v1.829Zm4.5.035A.5.5 0 0 0 13.293 2L12 3.293a.5.5 0 1 0 .707.707L14 2.707ZM7.293 4A.5.5 0 1 0 8 3.293L6.707 2A.5.5 0 0 0 6 2.707L7.293 4Zm-.646 2.354a.5.5 0 0 0 0 .708l1.147 1.146a.5.5 0 0 0 .708 0l1.146-1.147a.5.5 0 0 0 0-.708L8.354 5.5h.092a.5.5 0 0 0 0-1H8.354L7.207 3.354a.5.5 0 0 0-.708 0L5.354 4.5H5.26a.5.5 0 0 0 0 1h.092l1.147 1.146Z"/><path d="M12.026 8.5H4.002c-.264 0-.398.236-.28.465l.889 1.777c.115.23.38.388.653.388h4.804c.272 0 .538-.158.653-.388l.89-1.777a.304.304 0 0 0-.28-.465Z"/><path d="M3.5 13h9a.5.5 0 0 0 0-1h-9a.5.5 0 0 0 0 1Z"/><path d="M2.793 6.793A.5.5 0 0 1 2.5 6.5V4.707A.5.5 0 0 1 3 4.5h1.146a.5.5 0 0 1 0 1H3.5v1.207a.5.5 0 0 1-.707.707Z"/></svg> {{ __("AI Suggest Summary") }}';
            });
        });
    }

    // Event delegation for dynamically added "Suggest Bullets" buttons
    document.getElementById('work-experience-section').addEventListener('click', function(event) {
        if (event.target.classList.contains('suggest-bullets-btn')) {
            const button = event.target;
            const targetTextareaId = button.dataset.targetTextarea;
            const targetTextarea = document.getElementById(targetTextareaId);
            const jobTitle = document.getElementById(button.dataset.jobTitleId)?.value || '';
            const company = document.getElementById(button.dataset.companyId)?.value || '';
            const currentResponsibilities = targetTextarea.value;

            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...';

            fetch("{{ route('ai.suggest.bullets') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    job_title: jobTitle,
                    company: company,
                    current_responsibilities: currentResponsibilities
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.suggestion) {
                    // Prepend with a hyphen if not already starting with one, for consistent list format
                    let newText = data.suggestion;
                    if (targetTextarea.value.trim().length > 0) { // If there's existing text, add a newline
                        targetTextarea.value += "\n- " + newText.replace(/^- /gm, '').replace(/\n- /gm, '\n- ');
                    } else {
                         targetTextarea.value = "- " + newText.replace(/^- /gm, '').replace(/\n- /gm, '\n- ');
                    }
                     // Ensure each line starts with "- "
                    targetTextarea.value = targetTextarea.value.split('\n').map(line => {
                        line = line.trim();
                        if (line.length > 0 && !line.startsWith('- ')) {
                            return '- ' + line;
                        }
                        return line;
                    }).join('\n');

                } else if (data.error) {
                    alert('Error from AI: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error fetching bullet points suggestion:', error);
                alert('Could not fetch suggestion.');
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-magic" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.5 2.672a.5.5 0 1 0 1 0V.843a.5.5 0 0 0-1 0v1.829Zm4.5.035A.5.5 0 0 0 13.293 2L12 3.293a.5.5 0 1 0 .707.707L14 2.707ZM7.293 4A.5.5 0 1 0 8 3.293L6.707 2A.5.5 0 0 0 6 2.707L7.293 4Zm-.646 2.354a.5.5 0 0 0 0 .708l1.147 1.146a.5.5 0 0 0 .708 0l1.146-1.147a.5.5 0 0 0 0-.708L8.354 5.5h.092a.5.5 0 0 0 0-1H8.354L7.207 3.354a.5.5 0 0 0-.708 0L5.354 4.5H5.26a.5.5 0 0 0 0 1h.092l1.147 1.146Z"/><path d="M12.026 8.5H4.002c-.264 0-.398.236-.28.465l.889 1.777c.115.23.38.388.653.388h4.804c.272 0 .538-.158.653-.388l.89-1.777a.304.304 0 0 0-.28-.465Z"/><path d="M3.5 13h9a.5.5 0 0 0 0-1h-9a.5.5 0 0 0 0 1Z"/><path d="M2.793 6.793A.5.5 0 0 1 2.5 6.5V4.707A.5.5 0 0 1 3 4.5h1.146a.5.5 0 0 1 0 1H3.5v1.207a.5.5 0 0 1-.707.707Z"/></svg> {{ __("AI Suggest Bullet Points") }}';
            });
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .dynamic-item {
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 5px;
        margin-bottom: 15px;
        position: relative; /* For absolute positioning of remove button */
    }
    .remove-item-btn {
        position: absolute;
        top: 5px;
        right: 10px;
    }
    .sticky-top {
        top: 20px; /* Adjust based on your navbar height or preference */
    }
</style>
@endpush
