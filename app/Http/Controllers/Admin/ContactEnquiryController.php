<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactEnquiryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = ContactEnquiry::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->latestFirst()
            ->paginate($request->integer('per_page', 15));

        return response()->json($items);
    }

    public function show(ContactEnquiry $contactEnquiry): JsonResponse
    {
        if ($contactEnquiry->status === 'new') {
            $contactEnquiry->update(['status' => 'read']);
        }

        return response()->json($contactEnquiry->fresh());
    }

    public function update(Request $request, ContactEnquiry $contactEnquiry): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['new', 'read', 'replied'])],
        ]);

        $contactEnquiry->update($data);

        return response()->json([
            'message' => 'Enquiry status updated successfully.',
            'data' => $contactEnquiry->fresh(),
        ]);
    }
}
