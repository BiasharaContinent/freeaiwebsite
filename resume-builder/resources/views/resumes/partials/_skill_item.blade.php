<div class="dynamic-item skill-item border p-3 mb-3">
    {{-- For existing skills, their ID isn't directly submitted for update, as skills are handled by name (firstOrCreate) and then synced. --}}
    {{-- <input type="hidden" name="skills[{{ $index }}][id]" value="{{ $skill->id ?? '' }}"> --}}
    <button type="button" class="btn btn-sm btn-danger remove-item-btn float-right mb-2">Remove</button>
    <div class="form-row">
        <div class="form-group col-md-7">
            <label for="skill_name_{{ $index }}">{{ __('Skill Name') }} <span class="text-danger">*</span></label>
            <input type="text" name="skills[{{ $index }}][skill_name]" id="skill_name_{{ $index }}" class="form-control" value="{{ old('skills.'.$index.'.skill_name', $skill->skill_name ?? '') }}">
        </div>
        <div class="form-group col-md-5">
            <label for="skill_type_{{ $index }}">{{ __('Skill Type (Optional)') }}</label>
            <select name="skills[{{ $index }}][type]" id="skill_type_{{ $index }}" class="form-control">
                <option value="other" {{ (old('skills.'.$index.'.type', $skill->type ?? 'other') == 'other') ? 'selected' : '' }}>{{__('Other')}}</option>
                <option value="hard" {{ (old('skills.'.$index.'.type', $skill->type ?? '') == 'hard') ? 'selected' : '' }}>{{__('Hard Skill')}}</option>
                <option value="soft" {{ (old('skills.'.$index.'.type', $skill->type ?? '') == 'soft') ? 'selected' : '' }}>{{__('Soft Skill')}}</option>
                <option value="technical" {{ (old('skills.'.$index.'.type', $skill->type ?? '') == 'technical') ? 'selected' : '' }}>{{__('Technical Skill')}}</option>
                {{-- Allow for pre-defined skill types passed from controller --}}
                {{-- @if(isset($skillTypes))
                    @foreach($skillTypes as $type)
                        <option value="{{ $type }}" {{ (old('skills.'.$index.'.type', $skill->type ?? '') == $type) ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                @endif --}}
            </select>
        </div>
    </div>
    {{-- Optional: Add proficiency level for skill if desired --}}
    {{-- <div class="form-group">
        <label for="skill_proficiency_{{ $index }}">{{ __('Proficiency (Optional)') }}</label>
        <select name="skills[{{ $index }}][proficiency]" id="skill_proficiency_{{ $index }}" class="form-control">
            <option value="">Select Proficiency</option>
            <option value="beginner">Beginner</option>
            <option value="intermediate">Intermediate</option>
            <option value="advanced">Advanced</option>
            <option value="expert">Expert</option>
        </select>
    </div> --}}
</div>
