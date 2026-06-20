<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leadership;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadershipController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = Leadership::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->ordered()
            ->paginate($request->integer('per_page', 15));

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateData($request);
        $data['photo'] = $this->storePhoto($request);

        $leadership = Leadership::query()->create($data);

        return response()->json([
            'message' => 'Leadership member created successfully.',
            'data' => $leadership,
        ], 201);
    }

    public function show(Leadership $leadership): JsonResponse
    {
        return response()->json($leadership);
    }

    public function update(Request $request, Leadership $leadership): JsonResponse
    {
        $data = $this->validateData($request, $leadership->id);

        if ($request->hasFile('photo')) {
            if ($leadership->photo) {
                Storage::disk('public')->delete($leadership->photo);
            }
            $data['photo'] = $this->storePhoto($request);
        }

        $leadership->update($data);

        return response()->json([
            'message' => 'Leadership member updated successfully.',
            'data' => $leadership->fresh(),
        ]);
    }

    public function destroy(Leadership $leadership): JsonResponse
    {
        if ($leadership->photo) {
            Storage::disk('public')->delete($leadership->photo);
        }

        $leadership->delete();

        return response()->json(['message' => 'Leadership member deleted successfully.']);
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => [$id ? 'sometimes' : 'required', 'string', 'max:255'],
            'designation' => [$id ? 'sometimes' : 'required', 'string', 'max:255'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string'],
            'achievements' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function storePhoto(Request $request): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }

        return $request->file('photo')->store('leadership', 'public');
    }
}
