@foreach ($inputs as $input)
  <div class="mb-3">
    @if ($input->type == 1)
      <label class="contact-label">{{ convertUtf8($input->label) }} @if ($input->required == 1)<span class="text-danger">*</span>@endif</label>
      <input class="contact-input @error($input->name) is-invalid @enderror" type="text" name="{{ $input->name }}" placeholder="{{ convertUtf8($input->placeholder) }}" value="{{ old($input->name) }}">
      @error($input->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    @endif

    @if ($input->type == 2)
      <label class="contact-label">{{ convertUtf8($input->label) }} @if ($input->required == 1)<span class="text-danger">*</span>@endif</label>
      <select class="contact-input @error($input->name) is-invalid @enderror" name="{{ $input->name }}">
        <option value="" {{ old($input->name) == '' ? 'selected' : '' }} disabled>{{ convertUtf8($input->placeholder) }}</option>
        @foreach ($input->quote_input_options as $option)
          <option value="{{ convertUtf8($option->name) }}" {{ old($input->name) == convertUtf8($option->name) ? 'selected' : '' }}>{{ convertUtf8($option->name) }}</option>
        @endforeach
      </select>
      @error($input->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    @endif

    @if ($input->type == 3)
      <label class="contact-label d-block">{{ convertUtf8($input->label) }} @if ($input->required == 1)<span class="text-danger">*</span>@endif</label>
      @foreach ($input->quote_input_options as $option)
        <div class="form-check form-check-inline">
          <input class="form-check-input @error($input->name) is-invalid @enderror" type="checkbox" name="{{ $input->name }}[]" id="qi{{ $option->id }}" value="{{ convertUtf8($option->name) }}" {{ in_array(convertUtf8($option->name), old($input->name, [])) ? 'checked' : '' }}>
          <label class="form-check-label" for="qi{{ $option->id }}">{{ convertUtf8($option->name) }}</label>
        </div>
      @endforeach
      @error($input->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    @endif

    @if ($input->type == 4)
      <label class="contact-label">{{ convertUtf8($input->label) }} @if ($input->required == 1)<span class="text-danger">*</span>@endif</label>
      <textarea class="contact-input @error($input->name) is-invalid @enderror" name="{{ $input->name }}" rows="3" placeholder="{{ convertUtf8($input->placeholder) }}">{{ old($input->name) }}</textarea>
      @error($input->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    @endif

    @if ($input->type == 5)
      <label class="contact-label">{{ convertUtf8($input->label) }} @if ($input->required == 1)<span class="text-danger">*</span>@endif</label>
      <input type="file" class="form-control @error($input->name) is-invalid @enderror" name="{{ $input->name }}" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">
      <small class="text-muted">{{ __('Upload files: PDF, DOC, JPG, PNG, ZIP, RAR') }}</small>
      @error($input->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    @endif

    @if ($input->type == 6)
      <label class="contact-label">{{ convertUtf8($input->label) }} @if ($input->required == 1)<span class="text-danger">*</span>@endif</label>
      <input class="contact-input datepicker @error($input->name) is-invalid @enderror" name="{{ $input->name }}" type="text" placeholder="{{ convertUtf8($input->placeholder) }}" autocomplete="off" value="{{ old($input->name) }}">
      @error($input->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    @endif

    @if ($input->type == 7)
      <label class="contact-label">{{ convertUtf8($input->label) }} @if ($input->required == 1)<span class="text-danger">*</span>@endif</label>
      <input class="contact-input timepicker @error($input->name) is-invalid @enderror" name="{{ $input->name }}" type="text" placeholder="{{ convertUtf8($input->placeholder) }}" autocomplete="off" value="{{ old($input->name) }}">
      @error($input->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    @endif
  </div>
@endforeach
