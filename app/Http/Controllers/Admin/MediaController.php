<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    private const DISK = 'public';

    private const DIRECTORY = 'media';

    public function index(Request $request): JsonResponse
    {
        $files = collect(Storage::disk(self::DISK)->files(self::DIRECTORY))
            ->map(function (string $path) {
                return [
                    'path' => $path,
                    'url' => Storage::disk(self::DISK)->url($path),
                    'name' => basename($path),
                    'size' => Storage::disk(self::DISK)->size($path),
                    'last_modified' => Storage::disk(self::DISK)->lastModified($path),
                ];
            })
            ->sortByDesc('last_modified')
            ->values();

        if ($request->filled('search')) {
            $search = Str::lower($request->string('search')->toString());
            $files = $files->filter(fn (array $file) => Str::contains(Str::lower($file['name']), $search))->values();
        }

        return response()->json(['data' => $files]);
    }

    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'],
        ]);

        $path = $request->file('file')->store(self::DIRECTORY, self::DISK);

        return response()->json([
            'message' => 'File uploaded successfully.',
            'data' => [
                'path' => $path,
                'url' => Storage::disk(self::DISK)->url($path),
                'name' => basename($path),
            ],
        ], 201);
    }

    public function destroy(Request $request): JsonResponse
    {
        $data = $request->validate([
            'path' => ['required', 'string'],
        ]);

        if (! Str::startsWith($data['path'], self::DIRECTORY.'/')) {
            return response()->json(['message' => 'Invalid file path.'], 422);
        }

        if (! Storage::disk(self::DISK)->exists($data['path'])) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        Storage::disk(self::DISK)->delete($data['path']);

        return response()->json(['message' => 'File deleted successfully.']);
    }
}
