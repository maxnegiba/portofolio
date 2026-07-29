<?php

namespace App\Http\Controllers;

use App\Support\Projects\ProjectImagePath;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    public function show(ProjectImagePath $paths, int $width, string $path): Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        if ($width < 10 || $width > 2000) {
            abort(400, 'Invalid width');
        }

        $path = $paths->normalizeForStorage($path);

        if ($path === null || $paths->containsTraversal($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            abort(400, 'Invalid image path');
        }

        $sourcePath = $this->sourcePath($path);

        if ($sourcePath === null) {
            abort(404);
        }

        $cachePath = 'cache/'.$width.'/'.hash('sha256', $path).'.webp';

        if (Storage::disk('public')->exists($cachePath)) {
            return response()->file(Storage::disk('public')->path($cachePath), [
                'Content-Type' => 'image/webp',
                'Cache-Control' => 'public, max-age=31536000, immutable',
            ]);
        }

        try {
            $encoded = Image::read($sourcePath)
                ->scale(width: $width)
                ->toWebp(quality: 80);

            Storage::disk('public')->put($cachePath, (string) $encoded);

            return response((string) $encoded)
                ->header('Content-Type', 'image/webp')
                ->header('Cache-Control', 'public, max-age=31536000, immutable');
        } catch (\Throwable) {
            return response()->file($sourcePath, [
                'Cache-Control' => 'public, max-age=3600',
            ]);
        }
    }

    private function sourcePath(string $path): ?string
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->path($path);
        }

        $candidate = public_path($path);
        $realPublicPath = realpath(public_path());
        $realCandidate = realpath($candidate);

        if ($realPublicPath !== false
            && $realCandidate !== false
            && str_starts_with($realCandidate, $realPublicPath.DIRECTORY_SEPARATOR)
            && File::isFile($realCandidate)) {
            return $realCandidate;
        }

        return null;
    }
}
