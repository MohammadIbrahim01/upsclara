<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'course_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'course_category_create',
            ],
            [
                'id'    => 19,
                'title' => 'course_category_edit',
            ],
            [
                'id'    => 20,
                'title' => 'course_category_show',
            ],
            [
                'id'    => 21,
                'title' => 'course_category_delete',
            ],
            [
                'id'    => 22,
                'title' => 'course_category_access',
            ],
            [
                'id'    => 23,
                'title' => 'course_create',
            ],
            [
                'id'    => 24,
                'title' => 'course_edit',
            ],
            [
                'id'    => 25,
                'title' => 'course_show',
            ],
            [
                'id'    => 26,
                'title' => 'course_delete',
            ],
            [
                'id'    => 27,
                'title' => 'course_access',
            ],
            [
                'id'    => 28,
                'title' => 'faculty_create',
            ],
            [
                'id'    => 29,
                'title' => 'faculty_edit',
            ],
            [
                'id'    => 30,
                'title' => 'faculty_show',
            ],
            [
                'id'    => 31,
                'title' => 'faculty_delete',
            ],
            [
                'id'    => 32,
                'title' => 'faculty_access',
            ],
            [
                'id'    => 33,
                'title' => 'course_content_create',
            ],
            [
                'id'    => 34,
                'title' => 'course_content_edit',
            ],
            [
                'id'    => 35,
                'title' => 'course_content_show',
            ],
            [
                'id'    => 36,
                'title' => 'course_content_delete',
            ],
            [
                'id'    => 37,
                'title' => 'course_content_access',
            ],
            [
                'id'    => 38,
                'title' => 'test_series_category_create',
            ],
            [
                'id'    => 39,
                'title' => 'test_series_category_edit',
            ],
            [
                'id'    => 40,
                'title' => 'test_series_category_show',
            ],
            [
                'id'    => 41,
                'title' => 'test_series_category_delete',
            ],
            [
                'id'    => 42,
                'title' => 'test_series_category_access',
            ],
            [
                'id'    => 43,
                'title' => 'test_series_create',
            ],
            [
                'id'    => 44,
                'title' => 'test_series_edit',
            ],
            [
                'id'    => 45,
                'title' => 'test_series_show',
            ],
            [
                'id'    => 46,
                'title' => 'test_series_delete',
            ],
            [
                'id'    => 47,
                'title' => 'test_series_access',
            ],
            [
                'id'    => 48,
                'title' => 'test_series_management_access',
            ],
            [
                'id'    => 49,
                'title' => 'blog_management_access',
            ],
            [
                'id'    => 50,
                'title' => 'blog_category_create',
            ],
            [
                'id'    => 51,
                'title' => 'blog_category_edit',
            ],
            [
                'id'    => 52,
                'title' => 'blog_category_show',
            ],
            [
                'id'    => 53,
                'title' => 'blog_category_delete',
            ],
            [
                'id'    => 54,
                'title' => 'blog_category_access',
            ],
            [
                'id'    => 55,
                'title' => 'blog_create',
            ],
            [
                'id'    => 56,
                'title' => 'blog_edit',
            ],
            [
                'id'    => 57,
                'title' => 'blog_show',
            ],
            [
                'id'    => 58,
                'title' => 'blog_delete',
            ],
            [
                'id'    => 59,
                'title' => 'blog_access',
            ],
            [
                'id'    => 60,
                'title' => 'enquiry_create',
            ],
            [
                'id'    => 61,
                'title' => 'enquiry_edit',
            ],
            [
                'id'    => 62,
                'title' => 'enquiry_show',
            ],
            [
                'id'    => 63,
                'title' => 'enquiry_delete',
            ],
            [
                'id'    => 64,
                'title' => 'enquiry_access',
            ],
            [
                'id'    => 65,
                'title' => 'job_opening_create',
            ],
            [
                'id'    => 66,
                'title' => 'job_opening_edit',
            ],
            [
                'id'    => 67,
                'title' => 'job_opening_show',
            ],
            [
                'id'    => 68,
                'title' => 'job_opening_delete',
            ],
            [
                'id'    => 69,
                'title' => 'job_opening_access',
            ],
            [
                'id'    => 70,
                'title' => 'career_application_create',
            ],
            [
                'id'    => 71,
                'title' => 'career_application_edit',
            ],
            [
                'id'    => 72,
                'title' => 'career_application_show',
            ],
            [
                'id'    => 73,
                'title' => 'career_application_delete',
            ],
            [
                'id'    => 74,
                'title' => 'career_application_access',
            ],
            [
                'id'    => 75,
                'title' => 'site_management_access',
            ],
            [
                'id'    => 76,
                'title' => 'page_create',
            ],
            [
                'id'    => 77,
                'title' => 'page_edit',
            ],
            [
                'id'    => 78,
                'title' => 'page_show',
            ],
            [
                'id'    => 79,
                'title' => 'page_delete',
            ],
            [
                'id'    => 80,
                'title' => 'page_access',
            ],
            [
                'id'    => 81,
                'title' => 'testimonial_create',
            ],
            [
                'id'    => 82,
                'title' => 'testimonial_edit',
            ],
            [
                'id'    => 83,
                'title' => 'testimonial_show',
            ],
            [
                'id'    => 84,
                'title' => 'testimonial_delete',
            ],
            [
                'id'    => 85,
                'title' => 'testimonial_access',
            ],
            [
                'id'    => 86,
                'title' => 'faq_create',
            ],
            [
                'id'    => 87,
                'title' => 'faq_edit',
            ],
            [
                'id'    => 88,
                'title' => 'faq_show',
            ],
            [
                'id'    => 89,
                'title' => 'faq_delete',
            ],
            [
                'id'    => 90,
                'title' => 'faq_access',
            ],
            [
                'id'    => 91,
                'title' => 'course_faq_create',
            ],
            [
                'id'    => 92,
                'title' => 'course_faq_edit',
            ],
            [
                'id'    => 93,
                'title' => 'course_faq_show',
            ],
            [
                'id'    => 94,
                'title' => 'course_faq_delete',
            ],
            [
                'id'    => 95,
                'title' => 'course_faq_access',
            ],
            [
                'id'    => 96,
                'title' => 'company_management_access',
            ],
            [
                'id'    => 97,
                'title' => 'company_edit',
            ],
            [
                'id'    => 98,
                'title' => 'company_show',
            ],
            [
                'id'    => 99,
                'title' => 'company_access',
            ],
            [
                'id'    => 100,
                'title' => 'email_create',
            ],
            [
                'id'    => 101,
                'title' => 'email_edit',
            ],
            [
                'id'    => 102,
                'title' => 'email_show',
            ],
            [
                'id'    => 103,
                'title' => 'email_delete',
            ],
            [
                'id'    => 104,
                'title' => 'email_access',
            ],
            [
                'id'    => 105,
                'title' => 'phone_create',
            ],
            [
                'id'    => 106,
                'title' => 'phone_edit',
            ],
            [
                'id'    => 107,
                'title' => 'phone_show',
            ],
            [
                'id'    => 108,
                'title' => 'phone_delete',
            ],
            [
                'id'    => 109,
                'title' => 'phone_access',
            ],
            [
                'id'    => 110,
                'title' => 'address_create',
            ],
            [
                'id'    => 111,
                'title' => 'address_edit',
            ],
            [
                'id'    => 112,
                'title' => 'address_show',
            ],
            [
                'id'    => 113,
                'title' => 'address_delete',
            ],
            [
                'id'    => 114,
                'title' => 'address_access',
            ],
            [
                'id'    => 115,
                'title' => 'social_medium_edit',
            ],
            [
                'id'    => 116,
                'title' => 'social_medium_show',
            ],
            [
                'id'    => 117,
                'title' => 'social_medium_access',
            ],
            [
                'id'    => 118,
                'title' => 'order_management_access',
            ],
            [
                'id'    => 119,
                'title' => 'order_create',
            ],
            [
                'id'    => 120,
                'title' => 'order_edit',
            ],
            [
                'id'    => 121,
                'title' => 'order_show',
            ],
            [
                'id'    => 122,
                'title' => 'order_delete',
            ],
            [
                'id'    => 123,
                'title' => 'order_access',
            ],
            [
                'id'    => 124,
                'title' => 'promo_create',
            ],
            [
                'id'    => 125,
                'title' => 'promo_edit',
            ],
            [
                'id'    => 126,
                'title' => 'promo_show',
            ],
            [
                'id'    => 127,
                'title' => 'promo_delete',
            ],
            [
                'id'    => 128,
                'title' => 'promo_access',
            ],
            [
                'id'    => 129,
                'title' => 'payment_create',
            ],
            [
                'id'    => 130,
                'title' => 'payment_edit',
            ],
            [
                'id'    => 131,
                'title' => 'payment_show',
            ],
            [
                'id'    => 132,
                'title' => 'payment_delete',
            ],
            [
                'id'    => 133,
                'title' => 'payment_access',
            ],
            [
                'id'    => 134,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
