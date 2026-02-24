@props(['path', 'alt' => '', 'class' => '', 'sizes' => '(max-width: 768px) 100vw, 50vw', 'width' => null, 'height' => null, 'loading' => 'lazy', 'fetchpriority' => 'auto'])

@if($path)
    @php
        $cleanPath = $path;
        // Remove /storage/ prefix if present
        if (str_starts_with($cleanPath, '/storage/')) {
            $cleanPath = substr($cleanPath, 9);
        } elseif (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        // Remove leading slash if any (for clean URL construction)
        $cleanPath = ltrim($cleanPath, '/');

        // We use url() instead of route() to prevent slash encoding in the path parameter
        // Route is /img/cache/{width}/{path}

        $widths = [400, 800, 1200];
        $srcsetParts = [];
        foreach ($widths as $w) {
            $url = url("/img/cache/{$w}/{$cleanPath}");
            $srcsetParts[] = "{$url} {$w}w";
        }
        $srcsetString = implode(', ', $srcsetParts);
        $src = url("/img/cache/800/{$cleanPath}");
    @endphp

    <img src="{{ $src }}"
         srcset="{{ $srcsetString }}"
         sizes="{{ $sizes }}"
         alt="{{ $alt }}"
         class="{{ $class }}"
         @if($width) width="{{ $width }}" @endif
         @if($height) height="{{ $height }}" @endif
         loading="{{ $loading }}"
         fetchpriority="{{ $fetchpriority }}">
@endif
