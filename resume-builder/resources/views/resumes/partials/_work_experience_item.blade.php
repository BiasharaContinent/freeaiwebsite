<div class="dynamic-item work-experience-item border p-3 mb-3">
    <input type="hidden" name="work_experiences[{{ $index }}][id]" value="{{ $experience->id ?? '' }}">
    <button type="button" class="btn btn-sm btn-danger remove-item-btn float-right mb-2">Remove</button>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="work_job_title_{{ $index }}">{{ __('Job Title') }} <span class="text-danger">*</span></label>
            <input type="text" name="work_experiences[{{ $index }}][job_title]" id="work_job_title_{{ $index }}" class="form-control" value="{{ old('work_experiences.'.$index.'.job_title', $experience->job_title ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="work_company_{{ $index }}">{{ __('Company') }} <span class="text-danger">*</span></label>
            <input type="text" name="work_experiences[{{ $index }}][company]" id="work_company_{{ $index }}" class="form-control" value="{{ old('work_experiences.'.$index.'.company', $experience->company ?? '') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="work_city_state_{{ $index }}">{{ __('City, State (e.g. New York, NY)') }}</label>
        <input type="text" name="work_experiences[{{ $index }}][city_state]" id="work_city_state_{{ $index }}" class="form-control" value="{{ old('work_experiences.'.$index.'.city_state', $experience->city_state ?? '') }}">
    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="work_start_date_{{ $index }}">{{ __('Start Date') }} <span class="text-danger">*</span></label>
            <input type="date" name="work_experiences[{{ $index }}][start_date]" id="work_start_date_{{ $index }}" class="form-control" value="{{ old('work_experiences.'.$index.'.start_date', $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->format('Y-m-d') : '') }}">
        </div>
        <div class="form-group col-md-5">
            <label for="work_end_date_{{ $index }}">{{ __('End Date') }}</label>
            <input type="date" name="work_experiences[{{ $index }}][end_date]" id="work_end_date_{{ $index }}" class="form-control" value="{{ old('work_experiences.'.$index.'.end_date', $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('Y-m-d') : '') }}" {{ (old('work_experiences.'.$index.'.is_current', $experience->is_current ?? false)) ? 'disabled' : '' }}>
        </div>
        <div class="form-group col-md-2 align-self-center">
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="work_experiences[{{ $index }}][is_current]" id="work_is_current_{{ $index }}" value="1" {{ (old('work_experiences.'.$index.'.is_current', $experience->is_current ?? false)) ? 'checked' : '' }}>
                <label class="form-check-label" for="work_is_current_{{ $index }}">
                    {{ __('Current Job') }}
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="work_responsibilities_{{ $index }}">{{ __('Responsibilities / Achievements (One per line)') }}</label>
        <textarea name="work_experiences[{{ $index }}][responsibilities]" id="work_responsibilities_{{ $index }}" class="form-control work-responsibilities-textarea" rows="4">{{ old('work_experiences.'.$index.'.responsibilities', $experience->responsibilities ?? '') }}</textarea>
        <small class="form-text text-muted">{{__('Tip: Start each line with a hyphen (-) for bullet points.')}}</small>
        <button type="button" class="btn btn-outline-primary btn-sm mt-2 suggest-bullets-btn"
                data-index="{{ $index }}"
                data-job-title-id="work_job_title_{{ $index }}"
                data-company-id="work_company_{{ $index }}"
                data-target-textarea="work_responsibilities_{{ $index }}">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-magic" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.5 2.672a.5.5 0 1 0 1 0V.843a.5.5 0 0 0-1 0v1.829Zm4.5.035A.5.5 0 0 0 13.293 2L12 3.293a.5.5 0 1 0 .707.707L14 2.707ZM7.293 4A.5.5 0 1 0 8 3.293L6.707 2A.5.5 0 0 0 6 2.707L7.293 4Zm-.646 2.354a.5.5 0 0 0 0 .708l1.147 1.146a.5.5 0 0 0 .708 0l1.146-1.147a.5.5 0 0 0 0-.708L8.354 5.5h.092a.5.5 0 0 0 0-1H8.354L7.207 3.354a.5.5 0 0 0-.708 0L5.354 4.5H5.26a.5.5 0 0 0 0 1h.092l1.147 1.146Z"/><path d="M12.026 8.5H4.002c-.264 0-.398.236-.28.465l.889 1.777c.115.23.38.388.653.388h4.804c.272 0 .538-.158.653-.388l.89-1.777a.304.304 0 0 0-.28-.465Z"/><path d="M3.5 13h9a.5.5 0 0 0 0-1h-9a.5.5 0 0 0 0 1Z"/><path d="M2.793 6.793A.5.5 0 0 1 2.5 6.5V4.707A.5.5 0 0 1 3 4.5h1.146a.5.5 0 0 1 0 1H3.5v1.207a.5.5 0 0 1-.707.707Z"/></svg>
            {{ __('AI Suggest Bullet Points') }}
        </button>
    </div>
</div>
