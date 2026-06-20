<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Services\StorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    public function __construct(
        private readonly StorageService $storage
    ) {}

    public function index(Request $request): JsonResponse
    {
        $items = News::query()
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%'.$request->string('search').'%'))
            ->latestNews()
            ->paginate($request->integer('per_page', 15));

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storage->store($request->file('image'), 'news');
        }

        $news = News::query()->create($data);

        return response()->json([
            'message' => 'News article created successfully.',
            'data' => $news,
        ], 201);
    }

    public function show(News $news): JsonResponse
    {
        return response()->json($news);
    }

    public function update(Request $request, News $news): JsonResponse
    {
        $data = $this->validateData($request, $news->id);

        if (empty($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            if ($news->image) {
                $this->storage->delete($news->image);
            }
            $data['image'] = $this->storage->store($request->file('image'), 'news');
        }

        $news->update($data);

        return response()->json([
            'message' => 'News article updated successfully.',
            'data' => $news->fresh(),
        ]);
    }

    public function destroy(News $news): JsonResponse
    {
        if ($news->image) {
            $this->storage->delete($news->image);
        }

        $news->delete();

        return response()->json(['message' => 'News article deleted successfully.']);
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => [$id ? 'sometimes' : 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('news', 'slug')->ignore($id)],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ]);
    }
}
