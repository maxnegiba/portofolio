@props([
    'path' => null,
    'src' => null,
    'alt' => '',
    'class' => '',
    'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw',
    'width' => null,
    'height' => null,
    'loading' => 'lazy',
    'fetchpriority' => 'auto',
])

@php
    $imagePath = $path ?? $src;
    $resolver = app(\App\Support\Projects\ProjectImagePath::class);
    $originalUrl = $resolver->publicUrl(is_string($imagePath) ? $imagePath : null);
    $optimizerPath = $resolver->optimizerPath(is_string($imagePath) ? $imagePath : null);
    $defaultWidth = $width ? (int) $width : 800;

    $srcset = null;
    $srcUrl = $originalUrl;

    if ($optimizerPath) {
        $widths = [300, 400, 600, 800, 1000, 1200];
        $srcset = collect($widths)
            ->map(fn (int $candidateWidth): string => route('image.cache', [
                'width' => $candidateWidth,
                'path' => $optimizerPath,
            ])." {$candidateWidth}w")
            ->implode(', ');
        $srcUrl = route('image.cache', ['width' => $defaultWidth, 'path' => $optimizerPath]);
    }
@endphp

@if($srcUrl)
    <img
        @if($optimizerPath)
            x-data
            x-on:error.once="$el.srcset = ''; $el.src = {{ \Illuminate\Support\Js::from($originalUrl) }}"
        @endif
        src="{{ $srcUrl }}"
        @if($srcset) srcset="{{ $srcset }}" @endif
        sizes="{{ $sizes }}"
        alt="{{ $alt }}"
        class="{{ $class }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        loading="{{ $loading }}"
        fetchpriority="{{ $fetchpriority }}"
        decoding="async"
    >
@endif
