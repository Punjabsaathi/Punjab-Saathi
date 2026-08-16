<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Seeds the 5 categories that were previously hardcoded across
     * resources/views/pages/home.blade.php and services.blade.php,
     * folding both arrays' fields into one record per category so the
     * pages render identically once they switch to reading from the DB.
     */
    public function run(): void
    {
        $categories = [
            [
                'slug'        => 'identity',
                'name'        => 'Identity & ID Cards',
                'icon'        => 'fa-id-card',
                'color'       => '#fc5e28',
                'description' => 'Aadhaar enrolment and correction, PAN card apply and update, Voter ID, Driving Licence — all in one place.',
                'subheading'  => 'Aadhaar, PAN, Voter ID, Driving Licence — all processed online by certified operators.',
                'button_text' => 'See All ID Services',
                'sort_order'  => 1,
            ],
            [
                'slug'        => 'certificates',
                'name'        => 'Revenue & Certificates',
                'icon'        => 'fa-file-text',
                'color'       => '#059669',
                'description' => 'Caste certificate, residence certificate, property nakal, fard, and other revenue department documents.',
                'subheading'  => 'Income certificate, caste certificate, property records, and all revenue department documents for Punjab.',
                'button_text' => 'See All Certificates',
                'sort_order'  => 2,
            ],
            [
                'slug'        => 'registrations',
                'name'        => 'Registrations',
                'icon'        => 'fa-registered',
                'color'       => '#0ea5e9',
                'description' => 'Birth and death registration, ration card, pension schemes and government welfare scheme enrolment.',
                'subheading'  => 'Birth, death, ration card, and all essential registrations processed online for Punjab people.',
                'button_text' => 'Explore All Services',
                'sort_order'  => 3,
            ],
            [
                'slug'        => 'schemes',
                'name'        => 'Govt. Schemes',
                'icon'        => 'fa-heart',
                'color'       => '#8b5cf6',
                'description' => 'Pension, PM-KISAN, Ayushman Bharat, scholarships — get enrolled in the schemes you qualify for.',
                'subheading'  => 'Pension, PM-KISAN, Ayushman Bharat, scholarship — get enrolled in the schemes you deserve.',
                'button_text' => 'Explore Schemes',
                'sort_order'  => 4,
            ],
            [
                'slug'        => 'jobs',
                'name'        => 'Jobs & Forms',
                'icon'        => 'fa-briefcase',
                'color'       => '#3b82f6',
                'description' => 'Punjab Government job alerts, exam form filling, admit card downloads, and recruitment updates.',
                'subheading'  => 'Job alerts, exam form filling, admit card downloads, and result updates for Punjab government jobs.',
                'button_text' => 'View Job Services',
                'sort_order'  => 5,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category + ['is_active' => true]
            );
        }
    }
}
