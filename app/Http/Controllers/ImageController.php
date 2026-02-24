<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function show($width, $path)
    {
        // Security check: validate width
        $width = (int) $width;
        if ($width < 10 || $width > 2000) {
            abort(400, 'Invalid width');
        }

        // Clean path to prevent directory traversal
        $path = str_replace('..', '', $path);

        // Define cache path
        // We append .webp to the original filename
        $cachePath = 'cache/' . $width . '/' . $path . '.webp';

        // Check if cached file exists in storage
        if (Storage::disk('public')->exists($cachePath)) {
             $file = Storage::disk('public')->path($cachePath);
             return response()->file($file, [
                 'Content-Type' => 'image/webp',
                 'Cache-Control' => 'public, max-age=31536000'
             ]);
        }

        // Locate source file
        $sourcePath = null;

        // 1. Check if it's in public disk (projects/thumbnails/...)
        if (Storage::disk('public')->exists($path)) {
            $sourcePath = Storage::disk('public')->path($path);
        }
        // 2. Check if it's a static asset in public folder (img/avatar.webp)
        // We accept path like 'img/avatar.webp'
        elseif (File::exists(public_path($path))) {
            $sourcePath = public_path($path);
        }

        if (!$sourcePath) {
            abort(404);
        }

        // Process Image
        try {
            $image = Image::read($sourcePath);

            // Resize respecting aspect ratio
            $image->scale(width: $width);

            // Encode to WebP
            $encoded = $image->toWebp(quality: 80);

            // Save to cache
            Storage::disk('public')->put($cachePath, (string) $encoded);

            // Return response
            return response((string) $encoded)
                ->header('Content-Type', 'image/webp')
                ->header('Cache-Control', 'public, max-age=31536000');

        } catch (\Exception $e) {
            // Fallback: return original if optimization fails, or 500
            // But we should try to serve something.
            // Let's abort 500 for now so we know if it breaks.
            abort(500, 'Image processing failed: ' . $e->getMessage());
        }
    }
}
