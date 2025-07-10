@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">{{ __('Template Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $template->name ?? '') }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $template->description ?? '') }}</textarea>
                    @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="type">{{ __('Type') }} <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                            @foreach($templateTypes as $typeValue)
                                <option value="{{ $typeValue }}" {{ (old('type', $template->type ?? '') == $typeValue) ? 'selected' : '' }}>
                                    {{ ucfirst($typeValue) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                     <div class="form-group col-md-6">
                        <label for="view_name">{{ __('Blade View Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="view_name" id="view_name" class="form-control @error('view_name') is-invalid @enderror" value="{{ old('view_name', $template->view_name ?? 'resumes.templates.new_template_name') }}" placeholder="e.g., resumes.templates.custom_template" required>
                        @error('view_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <small class="form-text text-muted">Path to the Blade file for rendering this template (e.g., <code>resumes.templates.my_cool_template</code>). It will look for <code>my_cool_template.blade.php</code> in <code>resources/views/resumes/templates/</code>.</small>
                    </div>
                </div>


                <div class="form-group">
                    <label for="preview_image">{{ __('Preview Image (Optional)') }}</label>
                    <input type="file" name="preview_image" id="preview_image" class="form-control-file @error('preview_image') is-invalid @enderror">
                    @error('preview_image') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    @if(isset($template) && $template->preview_image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $template->preview_image_path) }}" alt="Preview" style="max-height: 100px; border: 1px solid #ddd; padding: 5px;">
                             <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" name="remove_preview_image" value="1" id="remove_preview_image">
                                <label class="form-check-label" for="remove_preview_image">
                                    {{ __('Remove current image') }}
                                </label>
                            </div>
                        </div>
                    @endif
                </div>

                 <div class="form-group form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $template->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('Active (template can be selected by users)') }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">{{__('Design Specifications (Optional)')}}</div>
            <div class="card-body">
                 <p><small>These values can be accessed in your template's Blade file via <code>$resume->template->font_specs['body']</code> etc.</small></p>
                <fieldset>
                    <legend class="h6">{{__('Font Specs')}}</legend>
                    <div class="form-group">
                        <label for="font_specs_body">{{ __('Body Font') }}</label>
                        <input type="text" name="font_specs[body]" id="font_specs_body" class="form-control @error('font_specs.body') is-invalid @enderror" value="{{ old('font_specs.body', $template->font_specs['body'] ?? '') }}" placeholder="e.g., Arial, sans-serif">
                        @error('font_specs.body') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="font_specs_heading">{{ __('Heading Font') }}</label>
                        <input type="text" name="font_specs[heading]" id="font_specs_heading" class="form-control @error('font_specs.heading') is-invalid @enderror" value="{{ old('font_specs.heading', $template->font_specs['heading'] ?? '') }}" placeholder="e.g., Georgia, serif">
                        @error('font_specs.heading') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </fieldset>
                <hr>
                <fieldset>
                    <legend class="h6">{{__('Color Specs')}}</legend>
                    <div class="form-group">
                        <label for="color_specs_primary">{{ __('Primary Color (Hex)') }}</label>
                        <input type="text" name="color_specs[primary]" id="color_specs_primary" class="form-control @error('color_specs.primary') is-invalid @enderror" value="{{ old('color_specs.primary', $template->color_specs['primary'] ?? '') }}" placeholder="#333333">
                        @error('color_specs.primary') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="color_specs_accent">{{ __('Accent Color (Hex)') }}</label>
                        <input type="text" name="color_specs[accent]" id="color_specs_accent" class="form-control @error('color_specs.accent') is-invalid @enderror" value="{{ old('color_specs.accent', $template->color_specs['accent'] ?? '') }}" placeholder="#007bff">
                        @error('color_specs.accent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                     <div class="form-group">
                        <label for="color_specs_background">{{ __('Background Color (Hex)') }}</label>
                        <input type="text" name="color_specs[background]" id="color_specs_background" class="form-control @error('color_specs.background') is-invalid @enderror" value="{{ old('color_specs.background', $template->color_specs['background'] ?? '#FFFFFF') }}" placeholder="#FFFFFF">
                        @error('color_specs.background') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </fieldset>
                <hr>
                 <div class="form-group">
                    <label for="layout_specs_json">{{ __('Layout Specs (JSON)') }}</label>
                    <textarea name="layout_specs_json" id="layout_specs_json" class="form-control @error('layout_specs_json') is-invalid @enderror" rows="3" placeholder='e.g., {"column_widths": [70, 30], "show_sidebar": true}'>{{ old('layout_specs_json', (is_array($template->layout_specs_json ?? null) ? json_encode($template->layout_specs_json, JSON_PRETTY_PRINT) : ($template->layout_specs_json ?? ''))) }}</textarea>
                    @error('layout_specs_json') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    <small class="form-text text-muted">Advanced: Define custom layout rules as a valid JSON string.</small>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">{{ isset($template) ? __('Update Template') : __('Create Template') }}</button>
    <a href="{{ route('admin.templates.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
</div>
