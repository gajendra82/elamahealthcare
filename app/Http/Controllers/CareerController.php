<?php

namespace App\Http\Controllers;

use App\Http\Requests\CareerApplicationRequest;
use App\Models\CareerJob;
use App\Services\CareerService;
use App\Services\SeoService;
use Illuminate\Http\RedirectResponse;

class CareerController extends Controller
{
    public function __construct(
        private readonly CareerService $careerService,
        private readonly SeoService $seoService
    ) {}

    public function index()
    {
        return view('pages.careers.index', [
            'seo' => $this->seoService->forPage(
                'Careers | Elama Healthcare',
                'Join Elama Healthcare and build your career with a globally recognized pharmaceutical company.'
            ),
            'jobs' => CareerJob::query()->active()->ordered()->get(),
        ]);
    }

    public function show(string $slug)
    {
        $job = CareerJob::query()->active()->where('slug', $slug)->firstOrFail();

        return view('pages.careers.show', [
            'seo' => $this->seoService->forPage(
                "{$job->title} | Careers at Elama Healthcare",
                strip_tags((string) $job->description)
            ),
            'job' => $job,
        ]);
    }

    public function apply(CareerApplicationRequest $request, string $slug): RedirectResponse
    {
        $job = CareerJob::query()->active()->where('slug', $slug)->firstOrFail();

        $this->careerService->store(
            $job,
            $request->validated(),
            $request->file('resume')
        );

        return redirect()
            ->route('careers.show', $job->slug)
            ->with('success', 'Your application has been submitted successfully. We will contact you soon.');
    }
}
