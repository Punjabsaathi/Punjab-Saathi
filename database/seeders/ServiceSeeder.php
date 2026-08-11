<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceDocument;
use App\Models\ServiceFaq;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // ═══════════════════════════════════════════════════════════════
        // CATEGORY: identity
        // ═══════════════════════════════════════════════════════════════

        // ── 1. Aadhaar Update / Correction ──────────────────────────
        $s = Service::create([
            'title'            => 'Aadhaar Update / Correction',
            'slug'             => 'aadhaar-update-correction',
            'tag'              => 'UIDAI / Aadhaar',
            'category'         => 'identity',
            'icon'             => 'fa-pencil-square-o',
            'color'            => '#fc5e28',
            'short_desc'       => 'Correct name, date of birth, address, mobile number, or email on your Aadhaar card. Online and biometric update assistance.',
            'overview'         => '<p>Aadhaar Update service allows you to correct or update any inaccurate information on your Aadhaar card issued by UIDAI. Punjab Seva Kendra helps you update your Aadhaar details quickly without standing in long queues at enrolment centres.</p>
<p><strong>What can be updated?</strong></p>
<ul>
<li>Name correction (including spelling mistakes)</li>
<li>Date of birth correction</li>
<li>Address update (moved to new address)</li>
<li>Mobile number update or linking</li>
<li>Email ID update</li>
<li>Gender correction</li>
<li>Photo update</li>
</ul>
<p>We submit your update request on the official UIDAI portal (myAadhaar.uidai.gov.in) and track it until your updated Aadhaar is generated. You receive an SMS on your registered mobile when the update is approved.</p>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'Government portal fee (₹50) is charged separately by UIDAI. Our service fee covers form filling, document verification, and follow-up.',
            'eligibility'      => '<ul>
<li>Any Indian citizen who already has an Aadhaar card</li>
<li>Aadhaar holders whose details have changed (address, name after marriage, etc.)</li>
<li>Aadhaar cards with incorrect information (spelling errors, wrong DOB, etc.)</li>
<li>Children who need photo/biometric updates</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'Aadhaar Update / Correction in Punjab | Punjab Seva Kendra',
            'meta_description' => 'Correct name, address, DOB or mobile number on your Aadhaar card online. Punjab Seva Kendra processes Aadhaar updates in 3–7 days. Serving all 22 districts of Punjab.',
            'meta_keywords'    => 'aadhaar update punjab, aadhaar correction online, aadhaar address change, aadhaar name correction, aadhaar mobile link punjab',
            'sort_order'       => 2,
        ]);
        foreach ([
            ['label' => 'Existing Aadhaar Card',                 'note' => 'Original or photocopy',                        'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Address Proof (for address update)',     'note' => 'Utility bill / Ration card / Rent agreement',  'is_mandatory' => false, 'sort_order' => 2],
            ['label' => 'Birth Certificate / School Certificate', 'note' => 'For date of birth correction',                 'is_mandatory' => false, 'sort_order' => 3],
            ['label' => 'Marriage Certificate',                   'note' => 'For name change after marriage',               'is_mandatory' => false, 'sort_order' => 4],
            ['label' => 'Registered Mobile Number',               'note' => 'Required for OTP verification',                'is_mandatory' => true,  'sort_order' => 5],
            ['label' => 'Gazette Notification',                   'note' => 'Only for legal name change',                   'is_mandatory' => false, 'sort_order' => 6],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }
        foreach ([
            ['question' => 'How long does Aadhaar update take after submission?',           'answer' => 'After we submit your update request on the UIDAI portal, UIDAI typically processes it within 3–7 working days. You will receive an SMS on your registered mobile number when the update is approved.',                                                                                                                                   'sort_order' => 1],
            ['question' => 'Do I need to visit your office for Aadhaar update?',            'answer' => 'No. For most updates (name, address, email, mobile), everything can be done online. You just need to send us clear photos of your documents on WhatsApp. For biometric updates (photo, fingerprint), a visit to an enrolment centre is required — we will guide you on the nearest centre.',                                         'sort_order' => 2],
            ['question' => 'What documents do I need for address update?',                  'answer' => 'For address update, you need any one of: electricity bill, water bill, gas connection bill, ration card, bank passbook, rent agreement, or post office passbook. The document must show your name and new address.',                                                                                                                   'sort_order' => 3],
            ['question' => 'Can I update my Aadhaar if my mobile number is not registered?','answer' => 'If your mobile number is not registered on Aadhaar, online updates are not possible. In this case, you need to visit an Aadhaar enrolment centre. We can guide you to the nearest centre and help you with the process.',                                                                                                            'sort_order' => 4],
            ['question' => 'How many times can I update my Aadhaar details?',               'answer' => 'Name can be updated a maximum of 2 times. Date of birth can be updated only once. Address, mobile number, and email can be updated multiple times as needed.',                                                                                                                                                                      'sort_order' => 5],
        ] as $faq) {
            ServiceFaq::create(array_merge($faq, ['service_id' => $s->id]));
        }


        // ═══════════════════════════════════════════════════════════════
        // CATEGORY: certificates
        // ═══════════════════════════════════════════════════════════════

        // ── 2. Income Certificate ────────────────────────────────────
        $s = Service::create([
            'title'            => 'Income Certificate',
            'slug'             => 'income-certificate',
            'tag'              => 'Revenue Dept. / SDM',
            'category'         => 'certificates',
            'icon'             => 'fa-money',
            'color'            => '#059669',
            'short_desc'       => 'Required for scholarships, bank loans, government schemes, and college admissions. Issued by the SDM office on the Seva Kendra portal.',
            'overview'         => '<p>An Income Certificate is an official document issued by the Revenue Department (SDM office) of Punjab certifying the annual income of a family or individual. It is one of the most frequently required documents in Punjab.</p>
<p><strong>Where is it required?</strong></p>
<ul>
<li>Pre-matric and post-matric scholarship applications (NSP portal)</li>
<li>College and university admission under reserved categories</li>
<li>Bank loan applications (priority sector)</li>
<li>Government welfare schemes (PM-KISAN, PM Awas, etc.)</li>
<li>EWS certificate applications</li>
<li>Fee concession in government schools and colleges</li>
</ul>
<p>Punjab Seva Kendra submits your income certificate application on the official Seva Kendra / SDM portal and tracks it until the certificate is issued and digitally signed.</p>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹99 – ₹149',
            'fee_note'         => 'Government portal fee is included. Our service fee covers application filing, document verification, and certificate delivery.',
            'eligibility'      => '<ul>
<li>Any resident of Punjab</li>
<li>Students applying for scholarships</li>
<li>Families applying for BPL / welfare schemes</li>
<li>Individuals requiring proof of annual income for legal or financial purposes</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'Income Certificate Online Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get your income certificate issued online by the SDM office in Punjab. Required for scholarships, loans, and government schemes. Processing in 3–7 days. All 22 districts covered.',
            'meta_keywords'    => 'income certificate punjab, income certificate online, aay praman patra punjab, income certificate for scholarship punjab',
            'sort_order'       => 10,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',               'note' => 'of the applicant',          'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Ration Card',                 'note' => 'of the family',             'is_mandatory' => true,  'sort_order' => 2],
            ['label' => 'Self-Declaration of Income',  'note' => 'signed by applicant',       'is_mandatory' => true,  'sort_order' => 3],
            ['label' => 'Passport-size Photograph',    'note' => 'recent, white background',  'is_mandatory' => true,  'sort_order' => 4],
            ['label' => 'Bank Passbook / Statement',   'note' => 'optional but helpful',      'is_mandatory' => false, 'sort_order' => 5],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }
        foreach ([
            ['question' => 'How long is an income certificate valid?',               'answer' => 'Income certificates issued in Punjab are generally valid for one year from the date of issue. For scholarships, colleges typically require a certificate issued in the current financial year.',            'sort_order' => 1],
            ['question' => 'What income figure should I declare?',                   'answer' => 'You should declare the total annual income of all earning members of your family from all sources — agriculture, salary, business, and other sources. This is a self-declaration and should be truthful.','sort_order' => 2],
            ['question' => 'Can I get an income certificate for scholarship purposes?','answer' => 'Yes. Income certificate is a mandatory document for NSP scholarships and most Punjab government scholarship schemes. We process these urgently to meet scholarship deadlines.',                           'sort_order' => 3],
        ] as $faq) {
            ServiceFaq::create(array_merge($faq, ['service_id' => $s->id]));
        }


        // ── 3. Caste Certificate (SC / ST / OBC / EWS) ──────────────
        $s = Service::create([
            'title'            => 'Caste Certificate (SC / ST / OBC / EWS)',
            'slug'             => 'caste-certificate',
            'tag'              => 'Revenue Dept. / SDM',
            'category'         => 'certificates',
            'icon'             => 'fa-users',
            'color'            => '#059669',
            'short_desc'       => 'Caste certificate for SC, ST, OBC, and EWS categories. Required for government jobs, reservations, admissions, and welfare schemes.',
            'overview'         => '<p>A Caste Certificate is an official document issued by the Revenue Department of Punjab confirming that the holder belongs to a Scheduled Caste (SC), Scheduled Tribe (ST), Other Backward Class (OBC), or Economically Weaker Section (EWS).</p>
<p><strong>Where is it required?</strong></p>
<ul>
<li>Government job applications under reserved categories</li>
<li>College and university admissions under reservation quota</li>
<li>Central and state government scholarship applications</li>
<li>Welfare scheme benefits and subsidies</li>
<li>EWS certificate for general category with low income</li>
</ul>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹99 – ₹149',
            'fee_note'         => 'Government portal fee is included. Our service fee covers application filing, verification, and delivery.',
            'eligibility'      => '<ul>
<li>Any resident of Punjab belonging to SC, ST, OBC, or EWS category</li>
<li>Students applying for reserved category scholarships or admissions</li>
<li>Job applicants requiring category proof</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'Caste Certificate Online Punjab — SC / ST / OBC / EWS | Punjab Seva Kendra',
            'meta_description' => 'Get SC, ST, OBC, or EWS caste certificate issued online in Punjab. Required for government jobs, scholarships, and admissions. Processing in 3–7 days.',
            'meta_keywords'    => 'caste certificate punjab, sc certificate punjab, obc certificate punjab, ews certificate punjab, jaati praman patra punjab',
            'sort_order'       => 11,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',                        'note' => 'of the applicant',                        'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Ration Card',                         'note' => 'of the family',                           'is_mandatory' => true,  'sort_order' => 2],
            ['label' => 'Previous Caste Certificate or Proof', 'note' => 'parent\'s certificate or other evidence', 'is_mandatory' => false, 'sort_order' => 3],
            ['label' => 'Passport-size Photograph',            'note' => 'recent, white background',                'is_mandatory' => true,  'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 4. Residence / Domicile Certificate ─────────────────────
        $s = Service::create([
            'title'            => 'Residence / Domicile Certificate',
            'slug'             => 'residence-domicile-certificate',
            'tag'              => 'Revenue Dept. / SDM',
            'category'         => 'certificates',
            'icon'             => 'fa-home',
            'color'            => '#059669',
            'short_desc'       => 'Proof of residency in Punjab. Required for admissions, government jobs, and various state welfare schemes.',
            'overview'         => '<p>A Residence or Domicile Certificate is an official document issued by the Revenue Department of Punjab confirming that the holder is a permanent resident of the state. It is required for accessing state-specific benefits and reservations.</p>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹99 – ₹149',
            'fee_note'         => 'Government portal fee included.',
            'eligibility'      => '<ul>
<li>Any individual who has been a resident of Punjab for the required minimum period</li>
<li>Students applying for state quota admissions</li>
<li>Job applicants requiring state domicile proof</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Residence / Domicile Certificate Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get your residence or domicile certificate issued online in Punjab. Required for admissions, government jobs, and welfare schemes. Fast processing in 3–7 days.',
            'meta_keywords'    => 'residence certificate punjab, domicile certificate punjab, niwas praman patra punjab',
            'sort_order'       => 12,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',               'note' => 'of the applicant',              'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Ration Card or Utility Bill', 'note' => 'as address / residence proof', 'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Self-Declaration',            'note' => 'signed by applicant',           'is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 5. Property Nakal / Fard ─────────────────────────────────
        $s = Service::create([
            'title'            => 'Property Nakal / Fard',
            'slug'             => 'property-nakal-fard',
            'tag'              => 'Patwari / Jamabandi',
            'category'         => 'certificates',
            'icon'             => 'fa-map',
            'color'            => '#d97706',
            'short_desc'       => 'Certified copy of land and property records (Fard / Nakal) from the Punjab Land Records (Jamabandi) portal. Required for property disputes, loans, and sale deeds.',
            'overview'         => '<p>A Property Nakal (also known as Fard or Jamabandi Nakal) is a certified copy of land and property records maintained by the Punjab Revenue Department. It contains details of ownership, area, survey numbers, and rights over agricultural and non-agricultural land.</p>
<p><strong>When is it required?</strong></p>
<ul>
<li>Property sale or purchase transactions</li>
<li>Bank loan applications against property</li>
<li>Property disputes and court matters</li>
<li>Inheritance and succession claims</li>
<li>Government scheme applications (PM-KISAN, etc.)</li>
</ul>',
            'processing_time'  => '1–3 Days',
            'fee_range'        => '₹49 – ₹99',
            'fee_note'         => 'Government portal fee included. Quick processing service.',
            'eligibility'      => '<ul>
<li>Any landowner or their authorised representative</li>
<li>Legal heirs seeking land records</li>
<li>Banks and financial institutions (with authorisation)</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'Property Nakal / Fard Punjab — Land Records Online | Punjab Seva Kendra',
            'meta_description' => 'Get certified copy of land records (Fard / Nakal / Jamabandi) from Punjab Land Records portal. Fast processing in 1–3 days. Available for all 22 districts.',
            'meta_keywords'    => 'property nakal punjab, fard punjab, jamabandi nakal, land records punjab, khewat fard punjab',
            'sort_order'       => 13,
        ]);
        foreach ([
            ['label' => 'Khasra / Khata Number',      'note' => 'of the property',               'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Owner Name and Village Name', 'note' => 'for searching records',          'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'District Details',            'note' => 'district, tehsil, village name', 'is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 6. Mutation (Intkal) Application ─────────────────────────
        $s = Service::create([
            'title'            => 'Mutation (Intkal) Application',
            'slug'             => 'mutation-intkal-application',
            'tag'              => 'Revenue / Patwari',
            'category'         => 'certificates',
            'icon'             => 'fa-exchange',
            'color'            => '#d97706',
            'short_desc'       => 'Apply for property mutation after purchase, inheritance, or gift deed. We prepare and submit the online mutation application on the revenue portal.',
            'overview'         => '<p>Mutation (Intkal) is the process of updating land and property records in the government register when ownership changes. It is mandatory after any property transaction — purchase, inheritance, gift deed, or court order.</p>
<p><strong>When is mutation required?</strong></p>
<ul>
<li>After purchase of agricultural or non-agricultural land</li>
<li>After inheritance of property (through will or intestate succession)</li>
<li>After receiving property as a gift deed</li>
<li>After court decree or order regarding property</li>
</ul>',
            'processing_time'  => '15–30 Days',
            'fee_range'        => '₹199 – ₹499',
            'fee_note'         => 'Government fee and stamp duty are charged separately. Our service fee covers application preparation, filing, and follow-up.',
            'eligibility'      => '<ul>
<li>New property owners after purchase</li>
<li>Legal heirs after death of property owner</li>
<li>Gift deed recipients</li>
<li>Court-ordered property transfer beneficiaries</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Property Mutation (Intkal) Application Punjab | Punjab Seva Kendra',
            'meta_description' => 'Apply for property mutation (intkal) after purchase or inheritance in Punjab. Online application on revenue portal with expert assistance. Processing in 15–30 days.',
            'meta_keywords'    => 'mutation application punjab, intkal punjab, property mutation punjab, registry mutation punjab',
            'sort_order'       => 14,
        ]);
        foreach ([
            ['label' => 'Sale Deed / Will / Gift Deed', 'note' => 'registered document',          'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Aadhaar of All Parties',       'note' => 'buyer, seller, and witnesses', 'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Previous Fard / Nakal',        'note' => 'current land records',         'is_mandatory' => true, 'sort_order' => 3],
            ['label' => 'Affidavit',                    'note' => 'notarised, as per requirement', 'is_mandatory' => true, 'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 7. Character Certificate ─────────────────────────────────
        $s = Service::create([
            'title'            => 'Character Certificate',
            'slug'             => 'character-certificate',
            'tag'              => 'SDM / Police',
            'category'         => 'certificates',
            'icon'             => 'fa-certificate',
            'color'            => '#d97706',
            'short_desc'       => 'Police clearance / character certificate required for government jobs, passport, and visa applications in Punjab.',
            'overview'         => '<p>A Character Certificate (also called Police Clearance Certificate or PCC) is an official document confirming that the holder has no criminal record. It is issued by the local police or the SDM office.</p>
<p><strong>Where is it required?</strong></p>
<ul>
<li>Government job applications</li>
<li>Passport and visa applications</li>
<li>Immigration and emigration processes</li>
<li>Educational institutions</li>
<li>Professional licence applications</li>
</ul>',
            'processing_time'  => '5–10 Days',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'Government fee may apply separately. Our service fee covers application filing and follow-up.',
            'eligibility'      => '<ul>
<li>Any resident of Punjab requiring proof of good character</li>
<li>Government job applicants</li>
<li>Passport/visa applicants requiring PCC</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Character Certificate / Police Clearance Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get character certificate or police clearance certificate (PCC) issued in Punjab for jobs, passport, or visa. Expert assistance. Processing in 5–10 days.',
            'meta_keywords'    => 'character certificate punjab, police clearance certificate punjab, pcc punjab, character certificate for passport punjab',
            'sort_order'       => 15,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',             'note' => 'of the applicant',            'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Address Proof',            'note' => 'utility bill / ration card',   'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Passport-size Photograph', 'note' => 'recent, white background',     'is_mandatory' => true, 'sort_order' => 3],
            ['label' => 'Self-Declaration',         'note' => 'signed by applicant',          'is_mandatory' => true, 'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 8. Disability Certificate (UDID) ─────────────────────────
        $s = Service::create([
            'title'            => 'Disability Certificate (UDID)',
            'slug'             => 'disability-certificate-udid',
            'tag'              => 'Civil Surgeon / UDID',
            'category'         => 'certificates',
            'icon'             => 'fa-wheelchair',
            'color'            => '#8b5cf6',
            'short_desc'       => 'Apply for Unique Disability ID (UDID) card for persons with disabilities. Required for welfare schemes, concessions, and reservations.',
            'overview'         => '<p>The Unique Disability ID (UDID) Card is issued by the Ministry of Social Justice and Empowerment under the Rights of Persons with Disabilities Act, 2016. It is a single, unified document for persons with disabilities to access all government benefits and schemes.</p>
<p><strong>Benefits of UDID Card:</strong></p>
<ul>
<li>Reserved category benefits in government jobs and education</li>
<li>Travel concessions on railways and buses</li>
<li>Tax benefits and financial assistance</li>
<li>Access to Assistive Technology Scheme (ADIP)</li>
<li>Disability pension and welfare schemes</li>
</ul>',
            'processing_time'  => '7–15 Days',
            'fee_range'        => '₹149 – ₹249',
            'fee_note'         => 'No government fee for UDID application. Our service fee covers online application, document preparation, and follow-up.',
            'eligibility'      => '<ul>
<li>Any person with a disability as defined under the RPwD Act, 2016</li>
<li>Minimum 40% disability for most benefits</li>
<li>All age groups including children</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Disability Certificate / UDID Card Punjab | Punjab Seva Kendra',
            'meta_description' => 'Apply for UDID card (disability certificate) in Punjab online. Expert assistance for persons with disabilities. Processing in 7–15 days. All districts served.',
            'meta_keywords'    => 'udid card punjab, disability certificate punjab, divyang card punjab, udid application punjab',
            'sort_order'       => 16,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',                        'note' => 'of the applicant',               'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Medical Documents / Disability Proof', 'note' => 'hospital or doctor certificate', 'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Passport-size Photograph',            'note' => 'recent, white background',        'is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 9. Marriage Certificate ──────────────────────────────────
        $s = Service::create([
            'title'            => 'Marriage Certificate',
            'slug'             => 'marriage-certificate',
            'tag'              => 'Local Body / Registrar',
            'category'         => 'certificates',
            'icon'             => 'fa-heart',
            'color'            => '#e11d48',
            'short_desc'       => 'Online registration and certificate of marriage from the local registrar. Required for visa, property, and legal purposes.',
            'overview'         => '<p>A Marriage Certificate is an official document issued by the Registrar of Marriages confirming the legal registration of a marriage. It is an essential document for many legal, financial, and immigration purposes.</p>
<p><strong>Where is it required?</strong></p>
<ul>
<li>Spouse visa and immigration applications</li>
<li>Joint property and bank account registration</li>
<li>Name change on Aadhaar, PAN, and passport after marriage</li>
<li>Insurance and nominee nominations</li>
<li>Court and legal proceedings</li>
</ul>',
            'processing_time'  => '7–15 Days',
            'fee_range'        => '₹199 – ₹499',
            'fee_note'         => 'Government registration fee is charged separately. Our service fee covers application filing and coordination.',
            'eligibility'      => '<ul>
<li>Married couples of any religion</li>
<li>Both spouses must be above legal age (21 for male, 18 for female)</li>
<li>Marriage must have taken place in Punjab or one spouse must be a Punjab resident</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Marriage Certificate Registration Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get your marriage registered and obtain a marriage certificate in Punjab. Required for visa, name change, and legal purposes. Processing in 7–15 days.',
            'meta_keywords'    => 'marriage certificate punjab, marriage registration punjab, vivah praman patra punjab, marriage certificate online punjab',
            'sort_order'       => 17,
        ]);
        foreach ([
            ['label' => 'Aadhaar of Both Spouses',    'note' => 'mandatory for both',                    'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Marriage Photograph',         'note' => 'joint photo during ceremony',           'is_mandatory' => true,  'sort_order' => 2],
            ['label' => 'Two Witness Aadhaar Cards',   'note' => 'of both witnesses present at marriage', 'is_mandatory' => true,  'sort_order' => 3],
            ['label' => 'Marriage Invitation Card',    'note' => 'optional but helpful for proof',        'is_mandatory' => false, 'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 10. Shop & Establishment Registration ────────────────────
        $s = Service::create([
            'title'            => 'Shop & Establishment Registration',
            'slug'             => 'shop-establishment-registration',
            'tag'              => 'Labour Dept.',
            'category'         => 'certificates',
            'icon'             => 'fa-building',
            'color'            => '#0ea5e9',
            'short_desc'       => 'Register your shop, store, or business under the Punjab Shops and Commercial Establishments Act. Required for trade licences and GST registration.',
            'overview'         => '<p>Shop and Establishment Registration is mandatory for all commercial establishments in Punjab under the Punjab Shops and Commercial Establishments Act. It is one of the first legal requirements for starting a business.</p>
<p><strong>Who needs it?</strong></p>
<ul>
<li>Retail and wholesale shops</li>
<li>Restaurants, hotels, and eating establishments</li>
<li>Offices and commercial establishments</li>
<li>Service businesses (salons, repair shops, etc.)</li>
<li>Any business employing workers</li>
</ul>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹199 – ₹499',
            'fee_note'         => 'Government fee depends on the number of employees. Our service fee covers online registration and certificate delivery.',
            'eligibility'      => '<ul>
<li>Any business owner or proprietor in Punjab</li>
<li>Partnership firms and private limited companies</li>
<li>Shops and commercial establishments with at least one employee</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Shop & Establishment Registration Punjab | Punjab Seva Kendra',
            'meta_description' => 'Register your shop or business under Punjab Shops and Establishments Act online. Required for trade licence and GST. Processing in 3–7 days.',
            'meta_keywords'    => 'shop establishment registration punjab, dukan registration punjab, labour department registration punjab',
            'sort_order'       => 18,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card of Owner',  'note' => 'of the business owner / proprietor',   'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Business Address Proof',  'note' => 'rent agreement or ownership proof',    'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Photograph of Shop',      'note' => 'front view of the shop/establishment', 'is_mandatory' => true, 'sort_order' => 3],
            ['label' => 'PAN Card',                'note' => 'of the owner or firm',                 'is_mandatory' => true, 'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ═══════════════════════════════════════════════════════════════
        // CATEGORY: registrations
        // ═══════════════════════════════════════════════════════════════

        // ── 11. Birth Certificate ────────────────────────────────────
        $s = Service::create([
            'title'            => 'Birth Certificate',
            'slug'             => 'birth-certificate',
            'tag'              => 'Municipal / Panchayat',
            'category'         => 'registrations',
            'icon'             => 'fa-child',
            'color'            => '#0ea5e9',
            'short_desc'       => 'Register a birth and get a birth certificate from the municipal or panchayat office. Required for school admissions, passports, and Aadhaar.',
            'overview'         => '<p>A Birth Certificate is one of the most fundamental identity documents. It officially records the birth of a child and is required for virtually every government process throughout a person\'s life.</p>
<p><strong>Where is it required?</strong></p>
<ul>
<li>School admissions (mandatory from Class 1 onwards)</li>
<li>Aadhaar enrolment for children</li>
<li>Passport and visa applications</li>
<li>Insurance and bank account opening for minors</li>
<li>All government ID applications</li>
</ul>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'Government fee may apply for delayed registration. Our service fee covers filing and certificate delivery.',
            'eligibility'      => '<ul>
<li>Parents of newborns (registration within 21 days is free; delayed registration may incur a fee)</li>
<li>Adults without a birth certificate seeking first-time registration</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'Birth Certificate Registration Punjab | Punjab Seva Kendra',
            'meta_description' => 'Register a birth and get birth certificate from panchayat or municipal office in Punjab. Required for Aadhaar, school, and passport. Processing in 3–7 days.',
            'meta_keywords'    => 'birth certificate punjab, janam praman patra punjab, birth certificate online punjab, birth registration punjab',
            'sort_order'       => 20,
        ]);
        foreach ([
            ['label' => 'Hospital Discharge Slip or ANM Birth Register Entry', 'note' => 'proof of birth from hospital or ANM', 'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Aadhaar of Parents',   'note' => 'both parents\' Aadhaar cards',     'is_mandatory' => true,  'sort_order' => 2],
            ['label' => 'Marriage Certificate', 'note' => 'of the parents, if available',     'is_mandatory' => false, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 12. Death Certificate ────────────────────────────────────
        $s = Service::create([
            'title'            => 'Death Certificate',
            'slug'             => 'death-certificate',
            'tag'              => 'Municipal / Panchayat',
            'category'         => 'registrations',
            'icon'             => 'fa-heartbeat',
            'color'            => '#0ea5e9',
            'short_desc'       => 'Register a death and obtain a death certificate. Required for property succession, insurance claims, pension, and legal matters.',
            'overview'         => '<p>A Death Certificate is an official document issued by the municipal or panchayat authority recording the death of a person. It is required immediately after the death of a family member for legal, financial, and administrative purposes.</p>
<p><strong>Where is it required?</strong></p>
<ul>
<li>Property succession and inheritance proceedings</li>
<li>Insurance claim settlements</li>
<li>Pension discontinuation and family pension</li>
<li>Bank account and joint assets</li>
<li>Mutation of property records</li>
</ul>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'Government fee may apply for delayed registration. Our service fee covers filing and delivery.',
            'eligibility'      => '<ul>
<li>Immediate family members of the deceased</li>
<li>Any person who has information about the death</li>
<li>Legal representative or authorised person</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Death Certificate Registration Punjab | Punjab Seva Kendra',
            'meta_description' => 'Register a death and get death certificate from panchayat or municipal office in Punjab. Required for property, insurance, and pension. Processing in 3–7 days.',
            'meta_keywords'    => 'death certificate punjab, mrityu praman patra punjab, death registration punjab, death certificate online punjab',
            'sort_order'       => 21,
        ]);
        foreach ([
            ['label' => 'Hospital or Doctor\'s Death Certificate',  'note' => 'proof of death from hospital or doctor',     'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Aadhaar of Deceased',                      'note' => 'original Aadhaar card',                      'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Aadhaar of Family Member (Applicant)',      'note' => 'Aadhaar of person filing the application',   'is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 13. Ration Card — New Apply ──────────────────────────────
        $s = Service::create([
            'title'            => 'Ration Card — New Apply',
            'slug'             => 'ration-card-new-apply',
            'tag'              => 'Food & Civil Supplies',
            'category'         => 'registrations',
            'icon'             => 'fa-shopping-basket',
            'color'            => '#d97706',
            'short_desc'       => 'Apply for a new ration card under NFSA. Required for subsidised foodgrains, LPG connections, and various government schemes.',
            'overview'         => '<p>A Ration Card is issued by the Punjab Food and Civil Supplies Department under the National Food Security Act (NFSA). It entitles eligible families to subsidised foodgrains (wheat, rice, sugar) and is also used as a proof of identity and residence.</p>
<p><strong>Why you need a ration card:</strong></p>
<ul>
<li>Subsidised foodgrains from the Public Distribution System (PDS)</li>
<li>New LPG gas connection application</li>
<li>Various government welfare scheme benefits</li>
<li>Proof of address and family composition</li>
<li>Income certificate and other document applications</li>
</ul>',
            'processing_time'  => '15–30 Days',
            'fee_range'        => '₹199 – ₹299',
            'fee_note'         => 'Government application fee may apply. Our service fee covers application filing, verification, and follow-up.',
            'eligibility'      => '<ul>
<li>Families not already having a ration card in Punjab</li>
<li>Eligible under BPL, APL, or Antyodaya Anna Yojana (AAY) categories</li>
<li>Residents of Punjab with a permanent address</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'New Ration Card Apply Punjab | Punjab Seva Kendra',
            'meta_description' => 'Apply for a new ration card under NFSA in Punjab. Expert assistance for BPL, APL, and AAY ration card applications. Processing in 15–30 days.',
            'meta_keywords'    => 'ration card apply punjab, new ration card punjab, nfsa ration card punjab, ration card online apply punjab',
            'sort_order'       => 22,
        ]);
        foreach ([
            ['label' => 'Aadhaar of All Family Members', 'note' => 'mandatory for each member',          'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Residence Proof',               'note' => 'utility bill / rent agreement',      'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Family Photograph',             'note' => 'joint family photograph',            'is_mandatory' => true, 'sort_order' => 3],
            ['label' => 'Income Certificate',            'note' => 'to determine eligibility category',  'is_mandatory' => true, 'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 14. Ration Card — Update / Correction ───────────────────
        $s = Service::create([
            'title'            => 'Ration Card — Update / Correction',
            'slug'             => 'ration-card-update-correction',
            'tag'              => 'Food & Civil Supplies',
            'category'         => 'registrations',
            'icon'             => 'fa-pencil',
            'color'            => '#d97706',
            'short_desc'       => 'Add or remove family members, correct name or address on ration card, or transfer ration card on change of address.',
            'overview'         => '<p>Ration Card update services include adding newborn members, removing deceased members, correcting name or address errors, and transferring ration card when you move to a new address within or outside Punjab.</p>',
            'processing_time'  => '7–15 Days',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'Government portal fee included. Our service fee covers update filing and follow-up.',
            'eligibility'      => '<ul>
<li>Existing ration card holders in Punjab</li>
<li>Families who need to add or remove members</li>
<li>Those who have moved and need address update</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Ration Card Update / Correction Punjab | Punjab Seva Kendra',
            'meta_description' => 'Update or correct your Punjab ration card — add/remove members, change address, or fix name errors. Fast processing in 7–15 days.',
            'meta_keywords'    => 'ration card update punjab, ration card correction punjab, ration card member add punjab',
            'sort_order'       => 23,
        ]);
        foreach ([
            ['label' => 'Existing Ration Card',        'note' => 'original ration card',                          'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Aadhaar of Affected Member',   'note' => 'member being added or removed',                 'is_mandatory' => true,  'sort_order' => 2],
            ['label' => 'Death Certificate',            'note' => 'required only for member removal due to death', 'is_mandatory' => false, 'sort_order' => 3],
            ['label' => 'Birth Certificate',            'note' => 'required for adding a newborn',                 'is_mandatory' => false, 'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 15. LPG New Connection (PM Ujjwala) ─────────────────────
        $s = Service::create([
            'title'            => 'LPG New Connection (PM Ujjwala)',
            'slug'             => 'lpg-new-connection-pm-ujjwala',
            'tag'              => 'Oil Marketing / IOCL',
            'category'         => 'registrations',
            'icon'             => 'fa-fire',
            'color'            => '#e11d48',
            'short_desc'       => 'Apply for a new LPG gas connection under PM Ujjwala Yojana (free connection) or regular category.',
            'overview'         => '<p>PM Ujjwala Yojana (PMUY) provides free LPG gas connections to women belonging to BPL households. For non-BPL families, regular LPG connections are available from IOCL, HPCL, and BPCL.</p>
<p><strong>Benefits of PM Ujjwala Yojana:</strong></p>
<ul>
<li>Free LPG connection with deposit waiver for BPL families</li>
<li>EMI facility for first cylinder and regulator</li>
<li>Available across all oil marketing companies</li>
<li>Subsidy directly to bank account under DBT</li>
</ul>',
            'processing_time'  => '5–10 Days',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'Security deposit and first cylinder cost are paid to the oil company separately. Our service fee covers application filing and assistance.',
            'eligibility'      => '<ul>
<li>Women from BPL households for PM Ujjwala (free connection)</li>
<li>Any adult resident for regular LPG connection</li>
<li>Applicant should not already have an LPG connection</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'LPG New Connection / PM Ujjwala Yojana Punjab | Punjab Seva Kendra',
            'meta_description' => 'Apply for LPG new gas connection under PM Ujjwala Yojana or regular category in Punjab. Expert assistance and processing in 5–10 days.',
            'meta_keywords'    => 'lpg connection punjab, pm ujjwala punjab, gas connection apply punjab, ujjwala yojana punjab',
            'sort_order'       => 24,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',               'note' => 'of the applicant (woman of household for Ujjwala)', 'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Ration Card or BPL Card',    'note' => 'proof of BPL status for Ujjwala scheme',           'is_mandatory' => false, 'sort_order' => 2],
            ['label' => 'Bank Passbook',              'note' => 'for DBT subsidy credit',                            'is_mandatory' => true,  'sort_order' => 3],
            ['label' => 'Passport-size Photograph',   'note' => 'recent, white background',                          'is_mandatory' => true,  'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 16. E-Shram Card (NDUW) ──────────────────────────────────
        $s = Service::create([
            'title'            => 'E-Shram Card (NDUW)',
            'slug'             => 'e-shram-card',
            'tag'              => 'Ministry of Labour',
            'category'         => 'registrations',
            'icon'             => 'fa-id-badge',
            'color'            => '#8b5cf6',
            'short_desc'       => 'Register as an unorganised worker and get the E-Shram card. Provides access to government insurance, welfare benefits, and schemes.',
            'overview'         => '<p>The E-Shram Card (National Database of Unorganised Workers — NDUW) is issued by the Ministry of Labour and Employment. It is a universal account number (UAN) for unorganised workers that gives access to social security schemes and government benefits.</p>
<p><strong>Benefits of E-Shram Card:</strong></p>
<ul>
<li>₹2 lakh accident insurance under PMSBY</li>
<li>Access to Ayushman Bharat health card</li>
<li>Priority in government welfare schemes</li>
<li>Digital identity for unorganised sector workers</li>
<li>Future social security benefits</li>
</ul>',
            'processing_time'  => '1–2 Days',
            'fee_range'        => '₹49 – ₹99',
            'fee_note'         => 'No government fee. Our service fee covers registration assistance.',
            'eligibility'      => '<ul>
<li>Any unorganised sector worker aged 16–59 years</li>
<li>Not a member of EPFO, ESIC, or NPS</li>
<li>Workers in construction, agriculture, domestic service, street vending, etc.</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'E-Shram Card Registration Punjab | Punjab Seva Kendra',
            'meta_description' => 'Register for E-Shram card (NDUW) in Punjab. Get ₹2 lakh insurance and social security benefits. Same-day to 2-day processing. All 22 districts.',
            'meta_keywords'    => 'e shram card punjab, nduw registration punjab, labour card punjab, e shram card apply punjab',
            'sort_order'       => 25,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card with Linked Mobile Number', 'note' => 'OTP verification required', 'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Bank Account Details',                   'note' => 'account number and IFSC',   'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Occupation Details',                     'note' => 'type of work / trade',      'is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 17. GST Registration ─────────────────────────────────────
        $s = Service::create([
            'title'            => 'GST Registration',
            'slug'             => 'gst-registration',
            'tag'              => 'GST / Tax Dept.',
            'category'         => 'registrations',
            'icon'             => 'fa-university',
            'color'            => '#059669',
            'short_desc'       => 'Register your business under GST. Required for all businesses with annual turnover above ₹20 lakh and for e-commerce sellers.',
            'overview'         => '<p>GST (Goods and Services Tax) Registration is mandatory for businesses whose annual turnover exceeds ₹20 lakh (₹10 lakh in special category states) and for all e-commerce sellers regardless of turnover.</p>
<p><strong>Benefits of GST Registration:</strong></p>
<ul>
<li>Legal recognition as a registered supplier</li>
<li>Input Tax Credit (ITC) on purchases</li>
<li>Ability to sell across India without restrictions</li>
<li>Better credibility with buyers and banks</li>
<li>Mandatory for e-commerce platforms (Amazon, Flipkart, etc.)</li>
</ul>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹499 – ₹999',
            'fee_note'         => 'No government fee for GST registration. Our service fee covers registration, document filing, and certificate delivery.',
            'eligibility'      => '<ul>
<li>Businesses with turnover above ₹20 lakh per year</li>
<li>All e-commerce sellers irrespective of turnover</li>
<li>Interstate suppliers of goods or services</li>
<li>Voluntary registration for any business</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'GST Registration Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get your business registered under GST in Punjab. Expert assistance for GSTIN application. Processing in 3–7 days. Required for e-commerce and B2B sellers.',
            'meta_keywords'    => 'gst registration punjab, gstin punjab, gst apply punjab, gst certificate punjab',
            'sort_order'       => 26,
        ]);
        foreach ([
            ['label' => 'PAN Card',                          'note' => 'of the business owner or firm',            'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Aadhaar Card',                      'note' => 'of the authorised signatory',              'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Business Address Proof',            'note' => 'rent agreement or electricity bill',        'is_mandatory' => true, 'sort_order' => 3],
            ['label' => 'Bank Statement / Cancelled Cheque', 'note' => 'recent bank statement or cancelled cheque','is_mandatory' => true, 'sort_order' => 4],
            ['label' => 'Business Photographs',              'note' => 'photo of business premises',                'is_mandatory' => true, 'sort_order' => 5],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 18. Mobile Number Aadhaar Link ───────────────────────────
        $s = Service::create([
            'title'            => 'Mobile Number Aadhaar Link',
            'slug'             => 'mobile-number-aadhaar-link',
            'tag'              => 'UIDAI / Telecom',
            'category'         => 'registrations',
            'icon'             => 'fa-mobile',
            'color'            => '#0ea5e9',
            'short_desc'       => 'Link your mobile number with Aadhaar for OTP-based services, DigiLocker, banking, and government portals.',
            'overview'         => '<p>Linking your mobile number with Aadhaar is essential for accessing online government services, DigiLocker, digital banking, and UIDAI\'s OTP-based authentication. Without a registered mobile number, many Aadhaar-based services are inaccessible.</p>',
            'processing_time'  => 'Same Day',
            'fee_range'        => '₹49 – ₹99',
            'fee_note'         => 'No government fee. Our service fee covers assisted linking at the nearest enrolment centre if required.',
            'eligibility'      => '<ul>
<li>Any Aadhaar holder whose mobile number is not linked or is outdated</li>
<li>Persons who have changed their mobile number</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Mobile Number Aadhaar Link Punjab | Punjab Seva Kendra',
            'meta_description' => 'Link or update your mobile number with Aadhaar in Punjab. Required for OTP services, DigiLocker, and banking. Same-day assistance.',
            'meta_keywords'    => 'mobile aadhaar link punjab, aadhaar mobile number update punjab, aadhaar otp punjab',
            'sort_order'       => 27,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',  'note' => 'of the applicant',                     'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Mobile Phone',  'note' => 'the new mobile number to be linked',   'is_mandatory' => true, 'sort_order' => 2],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ═══════════════════════════════════════════════════════════════
        // CATEGORY: schemes
        // ═══════════════════════════════════════════════════════════════

        // ── 19. PM-KISAN Yojana Registration ────────────────────────
        $s = Service::create([
            'title'            => 'PM-KISAN Yojana Registration',
            'slug'             => 'pm-kisan-yojana-registration',
            'tag'              => 'Agri. / PM-KISAN',
            'category'         => 'schemes',
            'icon'             => 'fa-leaf',
            'color'            => '#059669',
            'short_desc'       => 'Register eligible farmers for PM-KISAN Samman Nidhi — ₹6,000 annual income support directly to bank account.',
            'overview'         => '<p>PM-KISAN Samman Nidhi is a central government scheme providing ₹6,000 per year (₹2,000 per installment, 3 installments) directly to eligible farmers\' bank accounts via Direct Benefit Transfer (DBT).</p>
<p><strong>Who is eligible?</strong></p>
<ul>
<li>Small and marginal farmers with cultivable land</li>
<li>All landholding farmer families (with some exclusions)</li>
<li>Land must be registered in the applicant\'s name</li>
</ul>',
            'processing_time'  => '7–15 Days',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'No government fee. Our service fee covers registration, KYC, and follow-up.',
            'eligibility'      => '<ul>
<li>Farmer families with cultivable land as per land records</li>
<li>Land registered in the name of the farmer</li>
<li>Aadhaar must be linked to bank account</li>
<li>Excludes institutional landholders, government employees, income taxpayers above ₹2 lakh</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'PM-KISAN Registration Punjab | Punjab Seva Kendra',
            'meta_description' => 'Register for PM-KISAN Samman Nidhi in Punjab and get ₹6,000 annually. Expert assistance for farmers. Processing in 7–15 days. All 22 districts served.',
            'meta_keywords'    => 'pm kisan registration punjab, pm kisan punjab, pm kisan apply punjab, kisan samman nidhi punjab',
            'sort_order'       => 30,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',                 'note' => 'linked with bank account',               'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Land Records (Khasra / Fard)', 'note' => 'proof of agricultural land ownership',   'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Bank Passbook',                'note' => 'account where ₹6,000 will be credited',  'is_mandatory' => true, 'sort_order' => 3],
            ['label' => 'Mobile Number',                'note' => 'registered with Aadhaar if possible',    'is_mandatory' => true, 'sort_order' => 4],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 20. Ayushman Bharat / PMJAY Card ────────────────────────
        $s = Service::create([
            'title'            => 'Ayushman Bharat / PMJAY Card',
            'slug'             => 'ayushman-bharat-pmjay-card',
            'tag'              => 'PMJAY / NHA',
            'category'         => 'schemes',
            'icon'             => 'fa-plus-square',
            'color'            => '#e11d48',
            'short_desc'       => 'Get Ayushman Bharat (PM-JAY) health card — ₹5 lakh free hospital treatment for eligible families. Check eligibility and apply.',
            'overview'         => '<p>Ayushman Bharat Pradhan Mantri Jan Arogya Yojana (PM-JAY) is the world\'s largest government-funded health insurance scheme. It provides ₹5 lakh per family per year for hospitalisation costs at empanelled government and private hospitals.</p>
<p><strong>Key benefits:</strong></p>
<ul>
<li>₹5 lakh per family per year for hospitalisation</li>
<li>Cashless treatment at 25,000+ empanelled hospitals</li>
<li>No restriction on family size</li>
<li>Pre-existing conditions covered from day one</li>
<li>Covers surgery, medicines, diagnostics, and follow-up care</li>
</ul>',
            'processing_time'  => '3–7 Days',
            'fee_range'        => '₹99 – ₹149',
            'fee_note'         => 'No government fee. Our service fee covers eligibility check, registration, and card generation.',
            'eligibility'      => '<ul>
<li>Families listed in SECC 2011 database</li>
<li>NFSA ration card holders (eligible automatically in many states)</li>
<li>Eligibility is checked on the official PM-JAY portal</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'Ayushman Bharat / PMJAY Card Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get Ayushman Bharat PM-JAY health card in Punjab. ₹5 lakh free hospital treatment per family per year. Eligibility check and registration in 3–7 days.',
            'meta_keywords'    => 'ayushman bharat punjab, pmjay card punjab, ayushman card apply punjab, pm jan arogya punjab',
            'sort_order'       => 31,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',      'note' => 'of the applicant / family head',        'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Ration Card (NFSA)', 'note' => 'proof of eligibility',                 'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Mobile Number',     'note' => 'for OTP and card delivery updates',     'is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 21. Scholarship Form Filling (NSP / Punjab) ──────────────
        $s = Service::create([
            'title'            => 'Scholarship Form Filling (NSP / Punjab)',
            'slug'             => 'scholarship-form-filling',
            'tag'              => 'NSP / Punjab Scholarship',
            'category'         => 'schemes',
            'icon'             => 'fa-graduation-cap',
            'color'            => '#3b82f6',
            'short_desc'       => 'Fill and submit state and central government scholarship forms for pre-matric and post-matric students from SC, ST, OBC, and minority categories.',
            'overview'         => '<p>Punjab Seva Kendra helps students fill and submit scholarship applications on the National Scholarship Portal (NSP) and Punjab scholarship portals. Scholarships are available for pre-matric (Class 1–10) and post-matric (Class 11 and above) students.</p>
<p><strong>Scholarships we assist with:</strong></p>
<ul>
<li>NSP Pre-Matric Scholarship (SC, ST, OBC, Minority)</li>
<li>NSP Post-Matric Scholarship (SC, ST, OBC, Minority)</li>
<li>Punjab State Post-Matric Scholarship</li>
<li>Dr. Ambedkar Post-Matric Scholarship</li>
<li>Merit-cum-Means Scholarships</li>
</ul>',
            'processing_time'  => '1–3 Days',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'Our service fee covers form filling, document upload, and submission. No government fee for scholarship applications.',
            'eligibility'      => '<ul>
<li>Students from SC, ST, OBC, or Minority communities</li>
<li>Family income within the prescribed limit (varies by scheme)</li>
<li>Enrolled in a recognised school or college in Punjab</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'NSP Scholarship Form Filling Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get NSP scholarship forms filled and submitted in Punjab. Pre-matric and post-matric scholarships for SC, ST, OBC, and minority students. Processing in 1–3 days.',
            'meta_keywords'    => 'nsp scholarship punjab, scholarship form filling punjab, post matric scholarship punjab, sc scholarship punjab',
            'sort_order'       => 32,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',           'note' => 'of the student',                         'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Income Certificate',      'note' => 'of the family / parent',                 'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Caste Certificate',       'note' => 'SC / ST / OBC / Minority proof',         'is_mandatory' => true, 'sort_order' => 3],
            ['label' => 'Previous Marksheet',      'note' => 'last qualifying examination marksheet',  'is_mandatory' => true, 'sort_order' => 4],
            ['label' => 'Bank Passbook',           'note' => 'student\'s own bank account',            'is_mandatory' => true, 'sort_order' => 5],
            ['label' => 'Admission Proof',         'note' => 'fee receipt or admission letter',        'is_mandatory' => true, 'sort_order' => 6],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 22. Old Age / Widow Pension ──────────────────────────────
        $s = Service::create([
            'title'            => 'Old Age / Widow Pension',
            'slug'             => 'old-age-widow-pension',
            'tag'              => 'Social Security / Punjab',
            'category'         => 'schemes',
            'icon'             => 'fa-female',
            'color'            => '#8b5cf6',
            'short_desc'       => 'Apply for old age pension, widow pension, or disabled person pension under Punjab government social security schemes.',
            'overview'         => '<p>Punjab government provides monthly financial assistance to senior citizens, widows, and persons with disabilities under various social security pension schemes administered by the Department of Social Security and Women & Child Development.</p>
<p><strong>Pension schemes available:</strong></p>
<ul>
<li>Old Age Samman Allowance (for persons above 58 years)</li>
<li>Widow and Destitute Women Allowance</li>
<li>Dependent Children Allowance</li>
<li>Disabled Person Allowance</li>
</ul>',
            'processing_time'  => '15–30 Days',
            'fee_range'        => '₹149 – ₹249',
            'fee_note'         => 'No government fee. Our service fee covers application filing, verification assistance, and follow-up.',
            'eligibility'      => '<ul>
<li>Senior citizens aged 58+ for old age pension</li>
<li>Widows with no source of income</li>
<li>Persons with 40%+ disability</li>
<li>Annual family income below the prescribed limit</li>
<li>Resident of Punjab</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Old Age Pension / Widow Pension Apply Punjab | Punjab Seva Kendra',
            'meta_description' => 'Apply for old age pension, widow pension, or disability pension under Punjab social security schemes. Expert assistance. Processing in 15–30 days.',
            'meta_keywords'    => 'old age pension punjab, widow pension punjab, budhapa pension punjab, disability pension punjab',
            'sort_order'       => 33,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',             'note' => 'of the applicant',                       'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Age Proof',                 'note' => 'birth certificate or school certificate', 'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Income Certificate',        'note' => 'to prove income below threshold',        'is_mandatory' => true, 'sort_order' => 3],
            ['label' => 'Bank Passbook',             'note' => 'for pension credit via DBT',             'is_mandatory' => true, 'sort_order' => 4],
            ['label' => 'Passport-size Photograph',  'note' => 'recent, white background',               'is_mandatory' => true, 'sort_order' => 5],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 23. PMJJBY / PMSBY Insurance ────────────────────────────
        $s = Service::create([
            'title'            => 'PMJJBY / PMSBY Insurance',
            'slug'             => 'pmjjby-pmsby-insurance',
            'tag'              => 'Jan Suraksha / Banking',
            'category'         => 'schemes',
            'icon'             => 'fa-shield',
            'color'            => '#059669',
            'short_desc'       => 'Enrol in PM Jeevan Jyoti Bima Yojana (life insurance at ₹436/year) and PM Suraksha Bima Yojana (accident insurance at ₹20/year).',
            'overview'         => '<p>PM Jan Suraksha schemes provide affordable life and accident insurance to all Indian citizens.</p>
<p><strong>PMJJBY (Pradhan Mantri Jeevan Jyoti Bima Yojana):</strong></p>
<ul>
<li>Life insurance cover of ₹2 lakh on death (any cause)</li>
<li>Annual premium: ₹436 (auto-deducted from bank account)</li>
<li>Available for ages 18–50 years</li>
</ul>
<p><strong>PMSBY (Pradhan Mantri Suraksha Bima Yojana):</strong></p>
<ul>
<li>Accident insurance cover of ₹2 lakh</li>
<li>Annual premium: just ₹20</li>
<li>Available for ages 18–70 years</li>
</ul>',
            'processing_time'  => '1–3 Days',
            'fee_range'        => '₹49 – ₹99',
            'fee_note'         => 'Annual insurance premium (₹436 for PMJJBY, ₹20 for PMSBY) is deducted from your bank account. Our service fee covers enrolment assistance.',
            'eligibility'      => '<ul>
<li>Age 18–50 years for PMJJBY; 18–70 years for PMSBY</li>
<li>Must have a savings bank account</li>
<li>Aadhaar linked to bank account preferred</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'PMJJBY / PMSBY Insurance Enrolment Punjab | Punjab Seva Kendra',
            'meta_description' => 'Enrol in PM Jeevan Jyoti Bima Yojana (₹436/year) and PM Suraksha Bima Yojana (₹20/year) in Punjab. Affordable life and accident insurance. Same-day enrolment.',
            'meta_keywords'    => 'pmjjby punjab, pmsby punjab, jan suraksha yojana punjab, life insurance government scheme punjab',
            'sort_order'       => 34,
        ]);
        foreach ([
            ['label' => 'Aadhaar with Linked Bank Account', 'note' => 'bank account must be active',           'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Mobile Number',                    'note' => 'registered with bank account',          'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Age Proof',                        'note' => 'PMJJBY: 18–50 years; PMSBY: 18–70 years','is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 24. PM Awas Yojana (PMAY) Registration ──────────────────
        $s = Service::create([
            'title'            => 'PM Awas Yojana (PMAY) Registration',
            'slug'             => 'pm-awas-yojana-registration',
            'tag'              => 'Housing / PMAY',
            'category'         => 'schemes',
            'icon'             => 'fa-home',
            'color'            => '#d97706',
            'short_desc'       => 'Apply for PM Awas Yojana housing subsidy for rural and urban beneficiaries. Eligibility check and application assistance.',
            'overview'         => '<p>Pradhan Mantri Awas Yojana (PMAY) is a housing scheme providing financial assistance to eligible families for construction or purchase of their first house.</p>
<p><strong>Two components:</strong></p>
<ul>
<li><strong>PMAY-Gramin (Rural):</strong> ₹1.20 lakh assistance for rural BPL families</li>
<li><strong>PMAY-Urban:</strong> Interest subsidy on home loans for EWS/LIG/MIG categories</li>
</ul>',
            'processing_time'  => '7–15 Days',
            'fee_range'        => '₹149 – ₹299',
            'fee_note'         => 'No government fee. Our service fee covers eligibility verification, application filing, and follow-up.',
            'eligibility'      => '<ul>
<li>Families without a pucca house anywhere in India</li>
<li>Annual income up to ₹18 lakh depending on category</li>
<li>Beneficiary family must not have received any central housing scheme benefit earlier</li>
<li>Resident of Punjab</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'PM Awas Yojana Registration Punjab | Punjab Seva Kendra',
            'meta_description' => 'Apply for PM Awas Yojana (PMAY) housing subsidy in Punjab. Gramin and urban PMAY assistance. Expert application support in 7–15 days.',
            'meta_keywords'    => 'pm awas yojana punjab, pmay apply punjab, awas yojana gramin punjab, housing scheme punjab',
            'sort_order'       => 35,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',          'note' => 'of the applicant and family members', 'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Income Certificate',    'note' => 'to verify income category',            'is_mandatory' => true,  'sort_order' => 2],
            ['label' => 'Bank Passbook',         'note' => 'for subsidy/assistance credit',        'is_mandatory' => true,  'sort_order' => 3],
            ['label' => 'Land Proof (Rural)',    'note' => 'for PMAY-Gramin applicants',           'is_mandatory' => false, 'sort_order' => 4],
            ['label' => 'Address Proof (Urban)', 'note' => 'for PMAY-Urban applicants',            'is_mandatory' => false, 'sort_order' => 5],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ═══════════════════════════════════════════════════════════════
        // CATEGORY: jobs
        // ═══════════════════════════════════════════════════════════════

        // ── 25. Punjab Govt Job Alerts ───────────────────────────────
        $s = Service::create([
            'title'            => 'Punjab Govt Job Alerts',
            'slug'             => 'punjab-govt-job-alerts',
            'tag'              => 'Punjab Govt / PSSSB',
            'category'         => 'jobs',
            'icon'             => 'fa-bell',
            'color'            => '#3b82f6',
            'short_desc'       => 'Get notified about the latest Punjab government vacancies — PSSSB, Punjab Police, PSPCL, Patwari, Clerk, Driver, Forest Guard, and more.',
            'overview'         => '<p>Stay updated with the latest Punjab government job vacancies. Punjab Seva Kendra tracks all major Punjab government recruitment notifications and updates you as soon as new vacancies are announced.</p>
<p><strong>Jobs we track:</strong></p>
<ul>
<li>Punjab Subordinate Services Selection Board (PSSSB)</li>
<li>Punjab Public Service Commission (PPSC)</li>
<li>Punjab Police Recruitment</li>
<li>PSPCL (Punjab State Power Corporation Ltd.)</li>
<li>Patwari, Clerk, Driver, Forest Guard, and more</li>
</ul>',
            'processing_time'  => 'Ongoing',
            'fee_range'        => 'Free',
            'fee_note'         => 'Job alerts are free. Minimal fee may apply for form filling assistance.',
            'eligibility'      => '<ul>
<li>Any job seeker interested in Punjab government vacancies</li>
<li>Eligibility varies by recruitment; check individual notifications</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Punjab Government Job Alerts — PSSSB, Police, PSPCL | Punjab Seva Kendra',
            'meta_description' => 'Get latest Punjab government job vacancy alerts — PSSSB, Punjab Police, PSPCL, Patwari, Clerk posts. Punjab Seva Kendra tracks all major government recruitments.',
            'meta_keywords'    => 'punjab government jobs, psssb vacancy, punjab police recruitment, pspcl vacancy, govt jobs punjab 2024',
            'sort_order'       => 40,
        ]);
        foreach ([
            ['label' => 'No documents needed — visit our /govt-jobs page for latest vacancies', 'note' => '', 'is_mandatory' => false, 'sort_order' => 1],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 26. Govt. Job Online Form Filling ───────────────────────
        $s = Service::create([
            'title'            => 'Govt. Job Online Form Filling',
            'slug'             => 'govt-job-online-form-filling',
            'tag'              => 'PSSSB / PPSC / Other',
            'category'         => 'jobs',
            'icon'             => 'fa-file-text-o',
            'color'            => '#3b82f6',
            'short_desc'       => 'We fill your online government job application form with 100% accuracy — correct eligibility, document upload, photo/signature, and fee payment.',
            'overview'         => '<p>A single mistake in a government job application form can lead to rejection or disqualification. Punjab Seva Kendra\'s trained operators fill your online government job application form with precision — verifying eligibility, uploading documents in the correct format, and completing fee payment.</p>
<p><strong>What we ensure:</strong></p>
<ul>
<li>Correct category and eligibility verification</li>
<li>Photo and signature in specified size and format</li>
<li>All required documents uploaded correctly</li>
<li>Exam fee payment via our payment gateway</li>
<li>Confirmation and acknowledgement copy provided</li>
</ul>',
            'processing_time'  => '1 Day',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'Exam fee is charged separately by the recruiting body. Our service fee covers form filling, document upload, and fee payment assistance.',
            'eligibility'      => '<ul>
<li>Any candidate applying for Punjab government jobs</li>
<li>Must meet the eligibility criteria of the specific recruitment</li>
</ul>',
            'is_popular'       => true,
            'is_active'        => true,
            'meta_title'       => 'Government Job Form Filling Punjab — PSSSB, PPSC | Punjab Seva Kendra',
            'meta_description' => 'Get your government job online application form filled accurately in Punjab. PSSSB, PPSC, Punjab Police and all government recruitment forms. Processing in 1 day.',
            'meta_keywords'    => 'govt job form filling punjab, psssb form filling, ppsc form filling punjab, online form filling service punjab',
            'sort_order'       => 41,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',               'note' => 'of the applicant',                         'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Educational Certificates',    'note' => 'all qualifications as per eligibility',    'is_mandatory' => true,  'sort_order' => 2],
            ['label' => 'Category Certificate',        'note' => 'SC / ST / OBC / EWS, if applicable',      'is_mandatory' => false, 'sort_order' => 3],
            ['label' => 'Photo and Signature',         'note' => 'in JPG format as per specification',       'is_mandatory' => true,  'sort_order' => 4],
            ['label' => 'Bank Details for Fee',        'note' => 'debit card or UPI for exam fee payment',   'is_mandatory' => true,  'sort_order' => 5],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 27. Admit Card / Hall Ticket Download ───────────────────
        $s = Service::create([
            'title'            => 'Admit Card / Hall Ticket Download',
            'slug'             => 'admit-card-hall-ticket-download',
            'tag'              => 'PSSSB / PPSC / Other',
            'category'         => 'jobs',
            'icon'             => 'fa-id-card-o',
            'color'            => '#8b5cf6',
            'short_desc'       => 'Download your admit card, hall ticket, or roll number slip for Punjab government exams. We also help if the portal shows errors.',
            'overview'         => '<p>Admit card download can sometimes be tricky — portal errors, forgotten login details, or browser issues. Punjab Seva Kendra helps you download your admit card quickly and correctly so you don\'t miss your exam.</p>',
            'processing_time'  => 'Same Day',
            'fee_range'        => '₹49 – ₹99',
            'fee_note'         => 'No government fee. Our service fee covers assisted admit card download.',
            'eligibility'      => '<ul>
<li>Any candidate who has applied for a Punjab government exam</li>
<li>Admit card must have been released by the recruiting body</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Admit Card / Hall Ticket Download Punjab — PSSSB, PPSC | Punjab Seva Kendra',
            'meta_description' => 'Download admit card or hall ticket for Punjab government exams — PSSSB, PPSC, Punjab Police. Expert assistance for portal errors. Same-day service.',
            'meta_keywords'    => 'admit card download punjab, hall ticket punjab, psssb admit card, ppsc hall ticket punjab',
            'sort_order'       => 42,
        ]);
        foreach ([
            ['label' => 'Registration Number / Application ID',    'note' => 'provided at time of form submission', 'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Date of Birth',                           'note' => 'as filled in the application form',   'is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Mobile Number Linked at Registration',    'note' => 'for OTP if required',                 'is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 28. University / Entrance Exam Form ─────────────────────
        $s = Service::create([
            'title'            => 'University / Entrance Exam Form',
            'slug'             => 'university-entrance-exam-form',
            'tag'              => 'Punjab Universities',
            'category'         => 'jobs',
            'icon'             => 'fa-graduation-cap',
            'color'            => '#059669',
            'short_desc'       => 'Fill online forms for Punjab university examinations, entrance tests (PUCAT, GNAT, etc.), and college registrations with correct document uploads.',
            'overview'         => '<p>Punjab Seva Kendra assists students in filling online registration forms for Punjab university examinations, entrance tests, and college admissions. Common exams include PUCAT (Punjabi University Common Admission Test), GNAT, LLB entrance tests, and university semester registration forms.</p>',
            'processing_time'  => '1 Day',
            'fee_range'        => '₹99 – ₹199',
            'fee_note'         => 'University exam fee is charged separately. Our service fee covers form filling and document upload assistance.',
            'eligibility'      => '<ul>
<li>Students applying for Punjab university entrance tests or examinations</li>
<li>Students registering for semester or annual exams</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'University / Entrance Exam Form Filling Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get university entrance exam and admission forms filled in Punjab — PUCAT, GNAT, and all Punjab university forms. Expert form filling in 1 day.',
            'meta_keywords'    => 'pucat form filling punjab, university form filling punjab, entrance exam form punjab, college admission form punjab',
            'sort_order'       => 43,
        ]);
        foreach ([
            ['label' => 'Aadhaar Card',            'note' => 'of the student',                        'is_mandatory' => true,  'sort_order' => 1],
            ['label' => 'Previous Marksheets',     'note' => 'all qualifying examinations',            'is_mandatory' => true,  'sort_order' => 2],
            ['label' => 'Category Certificate',    'note' => 'SC / ST / OBC / EWS, if applicable',   'is_mandatory' => false, 'sort_order' => 3],
            ['label' => 'Photo and Signature',     'note' => 'in specified JPG format',               'is_mandatory' => true,  'sort_order' => 4],
            ['label' => 'Fee Payment Details',     'note' => 'debit card or UPI for exam fee',        'is_mandatory' => true,  'sort_order' => 5],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 29. Exam Result & Answer Key Updates ─────────────────────
        $s = Service::create([
            'title'            => 'Exam Result & Answer Key Updates',
            'slug'             => 'exam-result-answer-key',
            'tag'              => 'PSSSB / PPSC / Other',
            'category'         => 'jobs',
            'icon'             => 'fa-trophy',
            'color'            => '#d97706',
            'short_desc'       => 'Check your Punjab government exam result, cut-off lists, answer keys, and merit list updates. We provide guidance on objection filing too.',
            'overview'         => '<p>Punjab Seva Kendra helps candidates check their Punjab government exam results, download answer keys, verify cut-off marks, and understand merit list calculations. We also guide candidates on how to file objections against incorrect answer keys.</p>',
            'processing_time'  => 'Same Day',
            'fee_range'        => '₹49 – ₹99',
            'fee_note'         => 'Objection filing fees (if any) are charged by the recruiting body separately. Our service fee covers result checking and guidance.',
            'eligibility'      => '<ul>
<li>Any candidate who appeared for a Punjab government exam</li>
<li>Result must have been declared by the recruiting body</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Punjab Govt Exam Result & Answer Key | Punjab Seva Kendra',
            'meta_description' => 'Check Punjab government exam results, answer keys, and cut-off lists for PSSSB, PPSC, and Punjab Police exams. Objection filing guidance available.',
            'meta_keywords'    => 'psssb result punjab, ppsc result punjab, punjab exam answer key, punjab exam cut off punjab',
            'sort_order'       => 44,
        ]);
        foreach ([
            ['label' => 'Registration Number / Roll Number', 'note' => 'from admit card',          'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Date of Birth',                     'note' => 'as per application form',  'is_mandatory' => true, 'sort_order' => 2],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }


        // ── 30. Online Fee Payment Assistance ───────────────────────
        $s = Service::create([
            'title'            => 'Online Fee Payment Assistance',
            'slug'             => 'online-fee-payment-assistance',
            'tag'              => 'All Portals',
            'category'         => 'jobs',
            'icon'             => 'fa-globe',
            'color'            => '#0ea5e9',
            'short_desc'       => 'Help with online fee payment for government exams, college forms, and official portals — especially for those without debit/credit cards or net banking.',
            'overview'         => '<p>Many government exam portals and college forms require online fee payment, which can be difficult for those without a debit card, credit card, or net banking. Punjab Seva Kendra accepts UPI and cash and makes the online payment on your behalf.</p>',
            'processing_time'  => 'Same Day',
            'fee_range'        => '₹49 – ₹99',
            'fee_note'         => 'The actual exam/application fee is collected separately. Our service charge covers payment assistance.',
            'eligibility'      => '<ul>
<li>Any candidate requiring online fee payment assistance</li>
<li>Students, job applicants, or citizens paying government portal fees</li>
</ul>',
            'is_popular'       => false,
            'is_active'        => true,
            'meta_title'       => 'Online Fee Payment Assistance Punjab | Punjab Seva Kendra',
            'meta_description' => 'Get help with online fee payment for government exams, college forms, and official portals in Punjab. UPI and cash accepted. Same-day service.',
            'meta_keywords'    => 'online fee payment punjab, exam fee payment punjab, government portal payment punjab',
            'sort_order'       => 45,
        ]);
        foreach ([
            ['label' => 'Application / Reference Number', 'note' => 'from the portal or form',         'is_mandatory' => true, 'sort_order' => 1],
            ['label' => 'Payment Amount and Portal Name', 'note' => 'exact fee and official portal name','is_mandatory' => true, 'sort_order' => 2],
            ['label' => 'Mobile Number',                  'note' => 'for payment confirmation',          'is_mandatory' => true, 'sort_order' => 3],
        ] as $doc) {
            ServiceDocument::create(array_merge($doc, ['service_id' => $s->id]));
        }

        $this->command->info('✅ Services seeded successfully! 30 services across 5 categories (identity, certificates, registrations, schemes, jobs).');
    }
}
