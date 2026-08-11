<?php

namespace Database\Seeders;

use App\Models\FormCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FormCategorySeeder extends Seeder
{
    private array $categories = [
        ['name' => 'Identity Documents',      'color' => '#3B82F6', 'children' => ['PAN Card','Passport','Aadhaar Card','Voter ID']],
        ['name' => 'Government Certificates', 'color' => '#10B981', 'children' => ['Income Certificate','Caste Certificate','Domicile Certificate','Birth Certificate','Death Certificate','Marriage Certificate']],
        ['name' => 'Tax and Finance',         'color' => '#F59E0B', 'children' => ['Income Tax Forms','GST Forms','Property Tax','Wealth Tax']],
        ['name' => 'Education Forms',         'color' => '#8B5CF6', 'children' => ['Scholarship Forms','Bonafide Certificate','Migration Certificate','TC Application']],
        ['name' => 'Pension and Welfare',     'color' => '#EC4899', 'children' => ['Old Age Pension','Widow Pension','Disability Pension','Family Pension']],
        ['name' => 'Employment and Jobs',     'color' => '#14B8A6', 'children' => ['Government Job Application','Employment Exchange','Contract Labour','ESI Forms']],
        ['name' => 'Police and Legal',        'color' => '#6366F1', 'children' => ['Police Clearance Certificate','FIR Application','Character Certificate','Bail Application']],
        ['name' => 'Property and Land',       'color' => '#F97316', 'children' => ['Mutation Application','Land Record','Building Plan Approval','No Objection Certificate']],
        ['name' => 'Transport and Driving',   'color' => '#EF4444', 'children' => ['Driving License','Vehicle Registration','Learner License','Pollution Certificate']],
        ['name' => 'Health and Medical',      'color' => '#22C55E', 'children' => ['Medical Certificate','Disability Certificate','Blood Bank Forms','Vaccination Certificate']],
        ['name' => 'Banking Forms',           'color' => '#0EA5E9', 'children' => ['Account Opening','Loan Application','Cheque Book Request','KYC Forms']],
        ['name' => 'Utility and Public',      'color' => '#A855F7', 'children' => ['Electricity Connection','Water Connection','Gas Connection','Ration Card']],
    ];

    public function run(): void
    {
        $sort = 1;
        foreach ($this->categories as $catData) {
            $parent = FormCategory::create([
                'name'       => $catData['name'],
                'slug'       => Str::slug($catData['name']),
                'color'      => $catData['color'],
                'is_active'  => true,
                'sort_order' => $sort++,
            ]);

            $childSort = 1;
            foreach ($catData['children'] as $childName) {
                FormCategory::create([
                    'parent_id'  => $parent->id,
                    'name'       => $childName,
                    'slug'       => Str::slug($catData['name'] . '-' . $childName),
                    'color'      => $catData['color'],
                    'is_active'  => true,
                    'sort_order' => $childSort++,
                ]);
            }
        }
    }
}
