<div class="dynamic-item language-item border p-3 mb-3">
    <input type="hidden" name="languages[{{ $index }}][id]" value="{{ $language->id ?? '' }}">
    <button type="button" class="btn btn-sm btn-danger remove-item-btn float-right mb-2">Remove</button>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="lang_name_{{ $index }}">{{ __('Language') }} <span class="text-danger">*</span></label>
            <input type="text" name="languages[{{ $index }}][language_name]" id="lang_name_{{ $index }}" class="form-control" value="{{ old('languages.'.$index.'.language_name', $language->language_name ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="lang_proficiency_{{ $index }}">{{ __('Proficiency (e.g. Native, Fluent, Basic)') }}</label>
            <input type="text" name="languages[{{ $index }}][proficiency]" id="lang_proficiency_{{ $index }}" class="form-control" value="{{ old('languages.'.$index.'.proficiency', $language->proficiency ?? '') }}">
        </div>
    </div>
</div>
