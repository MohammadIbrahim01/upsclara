<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('company_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/companies*") ? "c-show" : "" }} {{ request()->is("admin/emails*") ? "c-show" : "" }} {{ request()->is("admin/phones*") ? "c-show" : "" }} {{ request()->is("admin/addresses*") ? "c-show" : "" }} {{ request()->is("admin/social-media*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-building c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.companyManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('company_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.companies.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/companies") || request()->is("admin/companies/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-pen-nib c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.company.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('email_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.emails.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/emails") || request()->is("admin/emails/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-envelope c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.email.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('phone_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.phones.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/phones") || request()->is("admin/phones/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-mobile-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.phone.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('address_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.addresses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/addresses") || request()->is("admin/addresses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-map-marked c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.address.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('social_medium_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.social-media.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/social-media") || request()->is("admin/social-media/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-bullhorn c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.socialMedium.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('site_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/pages*") ? "c-show" : "" }} {{ request()->is("admin/testimonials*") ? "c-show" : "" }} {{ request()->is("admin/faqs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.siteManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('page_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pages") || request()->is("admin/pages/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-atlas c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.page.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('testimonial_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.testimonials.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/testimonials") || request()->is("admin/testimonials/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-comment c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.testimonial.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('faq_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faqs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faqs") || request()->is("admin/faqs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-question-circle c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.faq.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('blog_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/blog-categories*") ? "c-show" : "" }} {{ request()->is("admin/blogs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-newspaper c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.blogManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('blog_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.blog-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/blog-categories") || request()->is("admin/blog-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.blogCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('blog_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.blogs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/blogs") || request()->is("admin/blogs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-book c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.blog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('faculty_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.faculties.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faculties") || request()->is("admin/faculties/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-user-graduate c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.faculty.title') }}
                </a>
            </li>
        @endcan
        @can('course_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/course-categories*") ? "c-show" : "" }} {{ request()->is("admin/courses*") ? "c-show" : "" }} {{ request()->is("admin/course-contents*") ? "c-show" : "" }} {{ request()->is("admin/course-faqs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-atlas c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.courseManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('course_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.course-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/course-categories") || request()->is("admin/course-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.courseCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('course_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.courses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/courses") || request()->is("admin/courses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-th c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.course.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('course_content_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.course-contents.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/course-contents") || request()->is("admin/course-contents/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-book c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.courseContent.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('course_faq_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.course-faqs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/course-faqs") || request()->is("admin/course-faqs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-question-circle c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.courseFaq.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('test_series_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/test-series-categories*") ? "c-show" : "" }} {{ request()->is("admin/test-seriess*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.testSeriesManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('test_series_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.test-series-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/test-series-categories") || request()->is("admin/test-series-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.testSeriesCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('test_series_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.test-seriess.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/test-seriess") || request()->is("admin/test-seriess/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-th c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.testSeries.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('order_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/orders*") ? "c-show" : "" }} {{ request()->is("admin/promos*") ? "c-show" : "" }} {{ request()->is("admin/payments*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-hand-holding-usd c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.orderManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('order_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-dollar-sign c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.order.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('promo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.promos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/promos") || request()->is("admin/promos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-money-bill-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.promo.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('payment_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.payments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/payments") || request()->is("admin/payments/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-shopping-cart c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.payment.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('job_opening_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.job-openings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/job-openings") || request()->is("admin/job-openings/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-user-plus c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.jobOpening.title') }}
                </a>
            </li>
        @endcan
        @can('career_application_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.career-applications.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/career-applications") || request()->is("admin/career-applications/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.careerApplication.title') }}
                </a>
            </li>
        @endcan
        @can('enquiry_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.enquiries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/enquiries") || request()->is("admin/enquiries/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-comments c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.enquiry.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>