<div class="dynamic-item custom-section-item border p-3 mb-3">
    <input type="hidden" name="custom_sections[{{ $index }}][id]" value="{{ $customSection->id ?? '' }}">
    <button type="button" class="btn btn-sm btn-danger remove-item-btn float-right mb-2">Remove</button>
    <div class="form-group">
        <label for="custom_title_{{ $index }}">{{ __('Section Title') }} <span class="text-danger">*</span></label>
        <input type="text" name="custom_sections[{{ $index }}][title]" id="custom_title_{{ $index }}" class="form-control" value="{{ old('custom_sections.'.$index.'.title', $customSection->title ?? '') }}">
    </div>
    <div class="form-group">
        <label for="custom_content_{{ $index }}">{{ __('Content (One item per line for lists)') }} <span class="text-danger">*</span></label>
        <textarea name="custom_sections[{{ $index }}][content]" id="custom_content_{{ $index }}" class="form-control" rows="4">{{ old('custom_sections.'.$index.'.content', $customSection->content ?? '') }}</textarea>
        <small class="form-text text-muted">{{__('Tip: Start each line with a hyphen (-) for bullet points if this section represents a list.')}}</small>
    </div>
</div>
