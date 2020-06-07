<div class="form-group {{ $class ?? '' }} @error($name) has-danger @enderror">
    <label for="{{ $name }}Input">{{ $slot }}</label>
    <textarea name="{{ $name }}" class="form-control ckeditor @error($name) form-control-danger @enderror" style="height: 50px">{{ $value }}</textarea>
    @error($name) <label id="{{ $name }}-error" class="error mt-2 text-danger" for="{{ $name }}Input">{{ $message }}</label> @enderror
</div>
