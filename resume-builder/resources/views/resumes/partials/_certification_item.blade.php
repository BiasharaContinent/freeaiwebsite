<div class="dynamic-item certification-item border p-3 mb-3">
    <input type="hidden" name="certifications[{{ $index }}][id]" value="{{ $certification->id ?? '' }}">
    <button type="button" class="btn btn-sm btn-danger remove-item-btn float-right mb-2">Remove</button>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="cert_name_{{ $index }}">{{ __('Certification Name') }} <span class="text-danger">*</span></label>
            <input type="text" name="certifications[{{ $index }}][name]" id="cert_name_{{ $index }}" class="form-control" value="{{ old('certifications.'.$index.'.name', $certification->name ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="cert_org_{{ $index }}">{{ __('Issuing Organization') }}</label>
            <input type="text" name="certifications[{{ $index }}][issuing_organization]" id="cert_org_{{ $index }}" class="form-control" value="{{ old('certifications.'.$index.'.issuing_organization', $certification->issuing_organization ?? '') }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="cert_date_issued_{{ $index }}">{{ __('Date Issued') }}</label>
            <input type="date" name="certifications[{{ $index }}][date_issued]" id="cert_date_issued_{{ $index }}" class="form-control" value="{{ old('certifications.'.$index.'.date_issued', $certification->date_issued ? \Carbon\Carbon::parse($certification->date_issued)->format('Y-m-d') : '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="cert_expiration_date_{{ $index }}">{{ __('Expiration Date (Optional)') }}</label>
            <input type="date" name="certifications[{{ $index }}][expiration_date]" id="cert_expiration_date_{{ $index }}" class="form-control" value="{{ old('certifications.'.$index.'.expiration_date', $certification->expiration_date ? \Carbon\Carbon::parse($certification->expiration_date)->format('Y-m-d') : '') }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="cert_credential_id_{{ $index }}">{{ __('Credential ID (Optional)') }}</label>
            <input type="text" name="certifications[{{ $index }}][credential_id]" id="cert_credential_id_{{ $index }}" class="form-control" value="{{ old('certifications.'.$index.'.credential_id', $certification->credential_id ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="cert_credential_url_{{ $index }}">{{ __('Credential URL (Optional)') }}</label>
            <input type="url" name="certifications[{{ $index }}][credential_url]" id="cert_credential_url_{{ $index }}" class="form-control" value="{{ old('certifications.'.$index.'.credential_url', $certification->credential_url ?? '') }}">
        </div>
    </div>
</div>
