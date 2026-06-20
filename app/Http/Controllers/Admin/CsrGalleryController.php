<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CsrGallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CsrGalleryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = CsrGallery::query()
            ->ordered()
            ->paginate($request->integer('per_page', 15));

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['image'] = $request->file('image')->store('csr', 'public');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? true;

        $item = CsrGallery::query()->create($data);

        return response()->json([
            'message' => 'CSR gallery item created successfully.',
            'data' => $item,
        ], 201);
    }

    public function show(CsrGallery $csrGallery): JsonResponse
    {
        return response()->json($csrGallery);
    }

    public function update(Request $request, CsrGallery $csrGallery): JsonResponse
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($csrGallery->image);
            $data['image'] = $request->file('image')->store('csr', 'public');
        }

        $csrGallery->update($data);

        return response()->json([
            'message' => 'CSR gallery item updated successfully.',
            'data' => $csrGallery->fresh(),
        ]);
    }

    public function destroy(CsrGallery $csrGallery): JsonResponse
    {
        Storage::disk('public')->delete($csrGallery->image);
        $csrGallery->delete();

        return response()->json(['message' => 'CSR gallery item deleted successfully.']);
    }
}
