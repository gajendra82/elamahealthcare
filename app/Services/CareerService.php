<?php

namespace App\Services;

use App\Mail\CareerApplicationMail;
use App\Models\CareerApplication;
use App\Models\CareerJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

class CareerService
{
    public function __construct(
        private readonly SettingService $settingService,
        private readonly StorageService $storage
    ) {}

    public function store(CareerJob $job, array $data, UploadedFile $resume): CareerApplication
    {
        $path = $this->storage->store($resume, 'careers/resumes');

        $application = CareerApplication::query()->create([
            'career_job_id' => $job->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'cover_letter' => $data['cover_letter'] ?? null,
            'resume_path' => $path,
            'status' => 'pending',
        ])->load('careerJob');

        $recipient = $this->settingService->get('contact_email', config('mail.from.address'));

        if ($recipient) {
            Mail::to($recipient)->queue(new CareerApplicationMail($application));
        }

        return $application;
    }

    public function resumeUrl(CareerApplication $application): string
    {
        return $this->storage->url($application->resume_path) ?? '';
    }
}
