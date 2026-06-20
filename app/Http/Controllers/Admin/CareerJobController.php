<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CareerJobController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = CareerJob::query()
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%'.$request->string('search').'%'))
            ->withCount('applications')
            ->ordered()
            ->paginate($request->integer('per_page', 15));

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $job = CareerJob::query()->create($data);

        return response()->json([
            'message' => 'Career job created successfully.',
            'data' => $job,
        ], 201);
    }

    public function show(CareerJob $careerJob): JsonResponse
    {
        return response()->json($careerJob->loadCount('applications'));
    }

    public function update(Request $request, CareerJob $careerJob): JsonResponse
    {
        $data = $this->validateData($request, $careerJob->id);

        if (empty($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $careerJob->update($data);

        return response()->json([
            'message' => 'Career job updated successfully.',
            'data' => $careerJob->fresh()->loadCount('applications'),
        ]);
    }

    public function destroy(CareerJob $careerJob): JsonResponse
    {
        $careerJob->delete();

        return response()->json(['message' => 'Career job deleted successfully.']);
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => [$id ? 'sometimes' : 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('career_jobs', 'slug')->ignore($id)],
            'department' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', Rule::in(['full-time', 'part-time', 'contract'])],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
