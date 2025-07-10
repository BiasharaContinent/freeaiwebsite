<div class="dynamic-item education-item border p-3 mb-3">
    <input type="hidden" name="educations[{{ $index }}][id]" value="{{ $education->id ?? '' }}">
    <button type="button" class="btn btn-sm btn-danger remove-item-btn float-right mb-2">Remove</button>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="edu_degree_{{ $index }}">{{ __('Degree / Qualification') }} <span class="text-danger">*</span></label>
            <input type="text" name="educations[{{ $index }}][degree]" id="edu_degree_{{ $index }}" class="form-control" value="{{ old('educations.'.$index.'.degree', $education->degree ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="edu_institution_{{ $index }}">{{ __('Institution') }} <span class="text-danger">*</span></label>
            <input type="text" name="educations[{{ $index }}][institution]" id="edu_institution_{{ $index }}" class="form-control" value="{{ old('educations.'.$index.'.institution', $education->institution ?? '') }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="edu_major_{{ $index }}">{{ __('Major / Field of Study') }}</label>
            <input type="text" name="educations[{{ $index }}][major]" id="edu_major_{{ $index }}" class="form-control" value="{{ old('educations.'.$index.'.major', $education->major ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="edu_city_state_{{ $index }}">{{ __('City, State (e.g. Boston, MA)') }}</label>
            <input type="text" name="educations[{{ $index }}][city_state]" id="edu_city_state_{{ $index }}" class="form-control" value="{{ old('educations.'.$index.'.city_state', $education->city_state ?? '') }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="edu_grad_start_date_{{ $index }}">{{ __('Start Date') }}</label>
            <input type="date" name="educations[{{ $index }}][graduation_start_date]" id="edu_grad_start_date_{{ $index }}" class="form-control" value="{{ old('educations.'.$index.'.graduation_start_date', $education->graduation_start_date ? \Carbon\Carbon::parse($education->graduation_start_date)->format('Y-m-d') : '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="edu_grad_end_date_{{ $index }}">{{ __('End Date / Expected Graduation') }}</label>
            <input type="date" name="educations[{{ $index }}][graduation_end_date]" id="edu_grad_end_date_{{ $index }}" class="form-control" value="{{ old('educations.'.$index.'.graduation_end_date', $education->graduation_end_date ? \Carbon\Carbon::parse($education->graduation_end_date)->format('Y-m-d') : '') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="edu_details_{{ $index }}">{{ __('Details (e.g., GPA, Honors, Relevant Coursework - one per line)') }}</label>
        <textarea name="educations[{{ $index }}][details]" id="edu_details_{{ $index }}" class="form-control" rows="3">{{ old('educations.'.$index.'.details', $education->details ?? '') }}</textarea>
        <small class="form-text text-muted">{{__('Tip: Start each line with a hyphen (-) for bullet points.')}}</small>
    </div>
</div>
