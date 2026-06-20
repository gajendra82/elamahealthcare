<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\StorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct(
        private readonly StorageService $storage
    ) {}

    public function index(Request $request): JsonResponse
    {
        $items = Banner::query()
            ->ordered()
            ->paginate($request->integer('per_page', 15));

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:2000'],
            'image' => ['required', 'image', 'max:5120'],
            'video' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['image'] = $this->storage->store($request->file('image'), 'banners');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? true;

        $banner = Banner::query()->create($data);

        return response()->json([
            'message' => 'Banner created successfully.',
            'data' => $banner,
        ], 201);
    }

    public function show(Banner $banner): JsonResponse
    {
        return response()->json($banner);
    }

    public function update(Request $request, Banner $banner): JsonResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'video' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $this->storage->delete($banner->image);
            $data['image'] = $this->storage->store($request->file('image'), 'banners');
        }

        $banner->update($data);

        return response()->json([
            'message' => 'Banner updated successfully.',
            'data' => $banner->fresh(),
        ]);
    }

    public function destroy(Banner $banner): JsonResponse
    {
        $this->storage->delete($banner->image);
        $banner->delete();

        return response()->json(['message' => 'Banner deleted successfully.']);
    }
}
