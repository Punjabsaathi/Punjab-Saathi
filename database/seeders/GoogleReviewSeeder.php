<?php

namespace Database\Seeders;

use App\Models\GoogleReview;
use Illuminate\Database\Seeder;

class GoogleReviewSeeder extends Seeder
{
    /**
     * Real 5-star reviews copied from the Punjab Saathi Google Business
     * Profile (manually entered — see chat for why: Google Places API
     * needs Cloud billing enabled, which wasn't set up). Only reviews that
     * actually had text are included; star-only reviews with no comment
     * were skipped since they add nothing to display.
     */
    public function run(): void
    {
        $reviews = [
            ['reviewer_name' => 'Bunty Bunty', 'city' => 'Amritsar', 'review_text' => 'Excellent 👍👍'],
            ['reviewer_name' => 'Avjot Bedi', 'city' => 'Jalandhar', 'review_text' => 'Very good service, I recommended this.'],
            ['reviewer_name' => 'Mandeep Kaur', 'city' => 'Amritsar', 'review_text' => 'Excellent service.'],
            ['reviewer_name' => 'Kittu Bhagat', 'city' => 'Chandigarh', 'review_text' => 'Amazing 🤩😍😍'],
            ['reviewer_name' => 'Pooja Arora', 'city' => 'Ludhiana', 'review_text' => 'Excellent service, I applied for a voter card. Very nicely they dealt with and delivered the service.'],
            ['reviewer_name' => 'Kumari Komal', 'city' => 'Amritsar', 'review_text' => 'Bahut vadhiya experience 😊'],
            ['reviewer_name' => 'Preet Nijjar', 'city' => 'Jalandhar', 'review_text' => 'Excellent service — he helped me with my mom\'s passport application and made the whole process very easy and smooth. He was professional, helpful, and explained everything clearly. Highly recommended.'],
            ['reviewer_name' => 'Amir Chohan', 'city' => 'Chandigarh', 'review_text' => 'Very nice site to make your documents related to Punjab govt — Aadhaar card, Voter card, Ration card. I made my documents very easily here without going anywhere, do it from your home.'],
            ['reviewer_name' => 'Nijjar Saab', 'city' => 'Ludhiana', 'review_text' => 'Great experience.'],
            ['reviewer_name' => 'Jaspreet Singh', 'city' => 'Amritsar', 'review_text' => 'Very good service provider, they guide you through each and everything properly. I really recommend this.'],
            ['reviewer_name' => 'Jaspreet Singh', 'city' => 'Jalandhar', 'review_text' => 'Great experience! Friendly behavior, honest nature, and top-quality work. Thank you so much!'],
            ['reviewer_name' => 'Simranjit Kaur', 'city' => 'Chandigarh', 'review_text' => 'Good service.'],
        ];

        foreach ($reviews as $i => $review) {
            GoogleReview::create($review + [
                'rating'     => 5,
                'is_active'  => true,
                'sort_order' => $i + 1,
            ]);
        }
    }
}
