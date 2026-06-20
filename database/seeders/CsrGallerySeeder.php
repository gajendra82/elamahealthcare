<?php

namespace Database\Seeders;

use App\Models\CsrGallery;
use Illuminate\Database\Seeder;

class CsrGallerySeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Community Health Camp',
            'Medical Screening Drive',
            'Healthcare Outreach Program',
            'Frontline Medical Support',
            'Public Health Initiative',
            'Free Health Check-up Camp',
            'Community Wellness Drive',
            'Rural Healthcare Access',
            'Medical Education Outreach',
            'Patient Care Initiative',
            'Health Awareness Program',
            'Clinical Screening Camp',
            'Community Medical Support',
            'Healthcare Volunteer Drive',
            'Preventive Health Camp',
            'Medical Service Outreach',
            'CSR Healthcare Activity',
        ];

        $descriptions = [
            'Delivering accessible healthcare and medical screening for underserved communities.',
            'Supporting community health through free check-ups and medical consultations.',
            'Elama Healthcare team serving patients through corporate social responsibility initiatives.',
        ];

        $importedImages = [];
        $files = glob(public_path('images/csr/csr-*.jpeg')) ?: [];
        natsort($files);

        foreach (array_values($files) as $index => $file) {
            $relativePath = 'images/csr/'.basename($file);
            $title = $titles[$index] ?? 'CSR Healthcare Activity';
            $description = $descriptions[$index % count($descriptions)];

            CsrGallery::query()->updateOrCreate(
                ['image' => $relativePath],
                [
                    'title' => $title,
                    'description' => $description,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

            $importedImages[] = $relativePath;
        }

        if ($importedImages !== []) {
            CsrGallery::query()->whereNotIn('image', $importedImages)->delete();
            $this->command?->info('Imported '.count($importedImages).' CSR gallery images.');
        }
    }

    /**
     * @return array<int, string>
     */
    public static function imagePaths(): array
    {
        $files = glob(public_path('images/csr/csr-*.jpeg')) ?: [];
        natsort($files);

        return array_values(array_map(
            fn (string $file) => 'images/csr/'.basename($file),
            $files
        ));
    }
}
