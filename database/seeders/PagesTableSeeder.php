<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'id'                    =>  1,
                'slug'                  =>  'terms-and-conditions',
                'name'                  =>  'Terms and Conditions',
                'created_at'    		=> \Carbon\Carbon::now()->toDateTimeString(),
			    'updated_at'    		=> \Carbon\Carbon::now()->toDateTimeString(),
            ],
            [
                'id'                    =>  2,
                'slug'                  =>  'privacy-policy',
                'name'                  =>  'Privacy Policy',
                'created_at'    		=> \Carbon\Carbon::now()->toDateTimeString(),
			    'updated_at'    		=> \Carbon\Carbon::now()->toDateTimeString(),
            ],
            [
                'id'                    =>  3,
                'slug'                  =>  'refund-policy',
                'name'                  =>  'Refund Policy',
                'created_at'    		=> \Carbon\Carbon::now()->toDateTimeString(),
			    'updated_at'    		=> \Carbon\Carbon::now()->toDateTimeString(),
            ],
            [
                'id'                    =>  4,
                'slug'                  =>  'faq',
                'name'                  =>  'Frequently Asked Questions',
                'created_at'    		=> \Carbon\Carbon::now()->toDateTimeString(),
			    'updated_at'    		=> \Carbon\Carbon::now()->toDateTimeString(),
            ],
            
        ];
        
        Page::insert($pages);
    }
}
