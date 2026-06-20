<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Services\StorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function __construct(
        private readonly StorageService $storage
    ) {}

    public function index(Request $request): JsonResponse
    {
        $items = Partner::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->ordered()
            ->paginate($request->integer('per_page', 15));

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:5120'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storage->store($request->file('logo'), 'partners');
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? true;

        $partner = Partner::query()->create($data);

        return response()->json([
            'message' => 'Partner created successfully.',
            'data' => $partner,
        ], 201);
    }

    public function show(Partner $partner): JsonResponse
    {
        return response()->json($partner);
    }

    public function update(Request $request, Partner $partner): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:5120'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                $this->storage->delete($partner->logo);
            }
            $data['logo'] = $this->storage->store($request->file('logo'), 'partners');
        }

        $partner->update($data);

        return response()->json([
            'message' => 'Partner updated successfully.',
            'data' => $partner->fresh(),
        ]);
    }

    public function destroy(Partner $partner): JsonResponse
    {
        if ($partner->logo) {
            $this->storage->delete($partner->logo);
        }

        $partner->delete();

        return response()->json(['message' => 'Partner deleted successfully.']);
    }
}
