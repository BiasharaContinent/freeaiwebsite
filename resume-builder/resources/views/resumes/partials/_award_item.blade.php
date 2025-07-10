<div class="dynamic-item award-item border p-3 mb-3">
    <input type="hidden" name="awards[{{ $index }}][id]" value="{{ $award->id ?? '' }}">
    <button type="button" class="btn btn-sm btn-danger remove-item-btn float-right mb-2">Remove</button>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="award_name_{{ $index }}">{{ __('Award / Honor Name') }} <span class="text-danger">*</span></label>
            <input type="text" name="awards[{{ $index }}][award_name]" id="award_name_{{ $index }}" class="form-control" value="{{ old('awards.'.$index.'.award_name', $award->award_name ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="award_body_{{ $index }}">{{ __('Awarding Body / Institution') }}</label>
            <input type="text" name="awards[{{ $index }}][awarding_body]" id="award_body_{{ $index }}" class="form-control" value="{{ old('awards.'.$index.'.awarding_body', $award->awarding_body ?? '') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="award_date_{{ $index }}">{{ __('Date Awarded') }}</label>
        <input type="date" name="awards[{{ $index }}][date_awarded]" id="award_date_{{ $index }}" class="form-control" value="{{ old('awards.'.$index.'.date_awarded', $award->date_awarded ? \Carbon\Carbon::parse($award->date_awarded)->format('Y-m-d') : '') }}">
    </div>
    <div class="form-group">
        <label for="award_summary_{{ $index }}">{{ __('Summary / Description (Optional)') }}</label>
        <textarea name="awards[{{ $index }}][summary]" id="award_summary_{{ $index }}" class="form-control" rows="2">{{ old('awards.'.$index.'.summary', $award->summary ?? '') }}</textarea>
    </div>
</div>
