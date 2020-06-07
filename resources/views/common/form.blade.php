<form method="post"
      action="{{ $action }}"
      @if (isset($media) && $media) enctype="multipart/form-data" @endif
      @if (isset($submit) && $submit) onSubmit="{{$submit}}" @endif
>
    @csrf
    @if ($edit)
        @method('PATCH')
    @else
        @method('POST')
    @endif
    {{ $slot }}
</form>

