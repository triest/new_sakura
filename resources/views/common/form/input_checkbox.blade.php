<div class="form-check form-check-flat form-check-primary mb-3">
    <label class="form-check-label" for="{{ $name }}Input">{{ $slot }}
    <input type="checkbox" name="{{ $name }}" class="form-check-input" id="{{ $name }}Input" @if ($value) checked @endif>
        <i class="input-helper"></i>
    </label>
</div>
