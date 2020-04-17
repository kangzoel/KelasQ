@php
   if ($errors->any()) {
        $content .= '<ul class="m-0 pl-3">';
        foreach ($errors->all() as $error) {
            $content .= "<li>$error</li>";
        }
        $content .= "</ul>";
    }
@endphp
@if (session('message') || $errors->any())
    <div class="alert alert-{{ $type }} {{ $class }} animated {{ $type == 'danger' ? 'shake' : 'fadeInDown'  }}" role="alert" style="animation-duration: 1s">
        {!! $content !!}
    </div>
@endif
