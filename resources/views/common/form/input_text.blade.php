<div class="form-group {{ $class ?? '' }} @error($name) has-danger @enderror">
    <label for="{{ $name }}Input">{{ $slot }}</label>
    <input type="text" name="{{ $name }}" class="form-control @error($name) form-control-danger @enderror" id="{{ $name }}Input" placeholder="{{ $placeholder ?? $slot }}" value="{{ $value }}">
    @error($name) <label id="{{ $name }}-error" class="error mt-2 text-danger" for="{{ $name }}Input">{{ $message }}</label> @enderror
</div>
