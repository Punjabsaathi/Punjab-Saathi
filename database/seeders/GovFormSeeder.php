<?php

namespace Database\Seeders;

use App\Models\FormCategory;
use App\Models\GovForm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GovFormSeeder extends Seeder
{
    public function run(): void
    {
        $forms = [
            // Identity Documents
            ['category' => 'identity-documents', 'title' => 'PAN Card Application Form (Form 49A)', 'desc' => 'Application form for fresh PAN card allotment for Indian citizens.', 'keywords' => 'pan card, income tax, 49A, permanent account number', 'popular' => true, 'featured' => true],
            ['category' => 'identity-documents', 'title' => 'Passport Application Form (Form DS-82)', 'desc' => 'Offline application form for new Indian passport.', 'keywords' => 'passport, travel document, Ministry of External Affairs', 'popular' => true, 'featured' => true],
            ['category' => 'identity-documents', 'title' => 'Voter ID Card Enrollment Form (Form 6)', 'desc' => 'Form for new voter registration in the electoral roll.', 'keywords' => 'voter id, election card, EPIC, form 6', 'popular' => true, 'featured' => false],
            ['category' => 'identity-documents', 'title' => 'Aadhaar Enrollment / Correction Form', 'desc' => 'Form for new Aadhaar enrollment or updating existing Aadhaar details.', 'keywords' => 'aadhaar, UIDAI, biometric, address update', 'popular' => false, 'featured' => false],

            // Government Certificates
            ['category' => 'government-certificates', 'title' => 'Income Certificate Application Form', 'desc' => 'Application for income certificate issued by Tehsildar / SDM office.', 'keywords' => 'income certificate, tehsildar, annual income, Punjab', 'popular' => true, 'featured' => true],
            ['category' => 'government-certificates', 'title' => 'Caste Certificate Application Form (SC/OBC)', 'desc' => 'Application form for scheduled caste or OBC caste certificate in Punjab.', 'keywords' => 'caste certificate, SC, OBC, scheduled caste, Punjab', 'popular' => true, 'featured' => false],
            ['category' => 'government-certificates', 'title' => 'Domicile / Residence Certificate Form', 'desc' => 'Application for domicile certificate proving residence in Punjab.', 'keywords' => 'domicile certificate, residence, Punjab, bonafide resident', 'popular' => false, 'featured' => false],
            ['category' => 'government-certificates', 'title' => 'Birth Certificate Application Form', 'desc' => 'Form to apply for birth certificate from municipal or panchayat office.', 'keywords' => 'birth certificate, date of birth, municipal corporation', 'popular' => true, 'featured' => false],
            ['category' => 'government-certificates', 'title' => 'Death Certificate Application Form', 'desc' => 'Application for death certificate from civic authority.', 'keywords' => 'death certificate, municipal, panchayat', 'popular' => false, 'featured' => false],
            ['category' => 'government-certificates', 'title' => 'Marriage Certificate Application Form', 'desc' => 'Form for registration of marriage under the Hindu Marriage Act or Special Marriage Act.', 'keywords' => 'marriage certificate, Hindu Marriage Act, registration', 'popular' => true, 'featured' => false],

            // Tax and Finance
            ['category' => 'tax-and-finance', 'title' => 'Income Tax Return Form ITR-1 (Sahaj)', 'desc' => 'For salaried individuals with income up to ₹50 lakh.', 'keywords' => 'ITR-1, income tax return, sahaj, salaried', 'popular' => true, 'featured' => true],
            ['category' => 'tax-and-finance', 'title' => 'GST Registration Application Form (REG-01)', 'desc' => 'Application form for new GST registration for businesses.', 'keywords' => 'GST, registration, REG-01, GSTIN, business', 'popular' => false, 'featured' => false],

            // Education Forms
            ['category' => 'education-forms', 'title' => 'Scholarship Application Form (Post-Matric)', 'desc' => 'Application for post-matric scholarship for SC/OBC/minority students in Punjab.', 'keywords' => 'scholarship, post matric, SC, OBC, Punjab, students', 'popular' => true, 'featured' => true],
            ['category' => 'education-forms', 'title' => 'Bonafide Certificate Request Form', 'desc' => 'Form to request bonafide student certificate from school or college.', 'keywords' => 'bonafide certificate, student, school, college', 'popular' => false, 'featured' => false],
            ['category' => 'education-forms', 'title' => 'Migration Certificate Application Form', 'desc' => 'Application for migration certificate for transferring to another university.', 'keywords' => 'migration certificate, university transfer, board', 'popular' => false, 'featured' => false],

            // Pension and Welfare
            ['category' => 'pension-and-welfare', 'title' => 'Old Age Pension Application Form (Punjab)', 'desc' => 'Application for old age pension scheme for senior citizens in Punjab.', 'keywords' => 'old age pension, senior citizen, Punjab, welfare', 'popular' => true, 'featured' => true],
            ['category' => 'pension-and-welfare', 'title' => 'Widow Pension Application Form', 'desc' => 'Application for widow pension under Punjab Social Security Scheme.', 'keywords' => 'widow pension, social security, Punjab', 'popular' => true, 'featured' => false],
            ['category' => 'pension-and-welfare', 'title' => 'Disability Pension Application Form', 'desc' => 'Form for disability pension for persons with disability in Punjab.', 'keywords' => 'disability pension, handicapped, PWD, Punjab', 'popular' => false, 'featured' => false],

            // Transport and Driving
            ['category' => 'transport-and-driving', 'title' => 'Driving Licence Application Form (Form 4)', 'desc' => 'Application form for new driving licence at the RTO office.', 'keywords' => 'driving licence, RTO, form 4, motor vehicle', 'popular' => true, 'featured' => true],
            ['category' => 'transport-and-driving', 'title' => 'Learner Licence Application Form (Form 2)', 'desc' => 'Form to apply for learner/learning driving licence.', 'keywords' => 'learner licence, learning licence, form 2, RTO', 'popular' => true, 'featured' => false],
            ['category' => 'transport-and-driving', 'title' => 'Vehicle Registration Form (Form 20)', 'desc' => 'Application for registration of a new motor vehicle.', 'keywords' => 'vehicle registration, form 20, RTO, motor vehicle', 'popular' => false, 'featured' => false],

            // Property and Land
            ['category' => 'property-and-land', 'title' => 'Property Mutation Application Form', 'desc' => 'Application for mutation of property after sale, gift or inheritance.', 'keywords' => 'mutation, property transfer, patwari, jamabandi', 'popular' => true, 'featured' => false],
            ['category' => 'property-and-land', 'title' => 'No Objection Certificate (NOC) Form', 'desc' => 'Application for NOC from government authority for property or business.', 'keywords' => 'NOC, no objection certificate, property, Punjab', 'popular' => false, 'featured' => false],

            // Banking Forms
            ['category' => 'banking-forms', 'title' => 'Bank Account Opening Form (General)', 'desc' => 'Standard KYC form for opening savings or current bank account.', 'keywords' => 'bank account, KYC, savings account, current account', 'popular' => true, 'featured' => false],
            ['category' => 'banking-forms', 'title' => 'KYC Update Form', 'desc' => 'Form for updating Know Your Customer details with bank.', 'keywords' => 'KYC, know your customer, bank, update', 'popular' => false, 'featured' => false],

            // Utility and Public
            ['category' => 'utility-and-public', 'title' => 'New Electricity Connection Application', 'desc' => 'Application for new domestic or commercial electricity connection in Punjab (PSPCL).', 'keywords' => 'electricity connection, PSPCL, Punjab, new connection', 'popular' => true, 'featured' => false],
            ['category' => 'utility-and-public', 'title' => 'Ration Card Application Form (Punjab)', 'desc' => 'Application for new ration card or addition of family member in Punjab.', 'keywords' => 'ration card, PDS, food supply, Punjab', 'popular' => true, 'featured' => true],
        ];

        foreach ($forms as $index => $data) {
            $category = FormCategory::where('slug', $data['category'])->first();
            if (!$category) continue;

            GovForm::create([
                'category_id'       => $category->id,
                'title'             => $data['title'],
                'slug'              => Str::slug($data['title']),
                'short_description' => $data['desc'],
                'file_path'         => 'gov-forms/sample-form.pdf',
                'file_name'         => Str::slug($data['title']) . '.pdf',
                'file_mime'         => 'application/pdf',
                'file_size'         => rand(100000, 500000),
                'download_count'    => rand(50, 5000),
                'is_featured'       => $data['featured'],
                'is_popular'        => $data['popular'],
                'is_active'         => true,
                'sort_order'        => $index + 1,
                'published_date'    => now()->subDays(rand(1, 365)),
                'meta_keywords'     => $data['keywords'],
                'seo_title'         => $data['title'] . ' | Punjab Seva Kendra',
                'meta_description'  => $data['desc'],
            ]);
                    // Recalculate forms_count for all categories
            FormCategory::all()->each(function($category) {
                $category->update(['forms_count' => $category->forms()->where('is_active', true)->count()]);
            });
        }
    }

}