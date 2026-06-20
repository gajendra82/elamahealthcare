<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    private const DIRECTORY = 'media';

    public function __construct(
        private readonly StorageService $storage
    ) {}

    public function index(Request $request): JsonResponse
    {
        $files = collect($this->storage->disk()->files(self::DIRECTORY))
            ->map(function (string $path) {
                return [
                    'path' => $path,
                    'url' => $this->storage->url($path),
                    'name' => basename($path),
                    'size' => $this->storage->disk()->size($path),
                    'last_modified' => $this->storage->disk()->lastModified($path),
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

        $path = $this->storage->store($request->file('file'), self::DIRECTORY);

        return response()->json([
            'message' => 'File uploaded successfully.',
            'data' => [
                'path' => $path,
                'url' => $this->storage->url($path),
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

        if (! $this->storage->exists($data['path'])) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $this->storage->delete($data['path']);

        return response()->json(['message' => 'File deleted successfully.']);
    }
}
