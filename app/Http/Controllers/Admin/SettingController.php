<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingService $settingService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'settings' => $this->settingService->grouped(),
            'flat' => $this->settingService->all(),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable'],
            'group' => ['nullable', 'string', 'max:50'],
        ]);

        $group = $data['group'] ?? 'general';
        $this->settingService->setMany($data['settings'], $group);

        return response()->json([
            'message' => 'Settings updated successfully.',
            'settings' => $this->settingService->grouped(),
        ]);
    }
}
