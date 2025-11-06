<li class="nav-item
@if(request()->path() == 'admins/features') active
@elseif(request()->path() == 'admins/introsection') active
@elseif(request()->path() == 'admins/servicesection') active
@elseif(request()->path() == 'admins/herosection/static') active
@elseif(request()->path() == 'admins/herosection/video') active
@elseif(request()->path() == 'admins/herosection/sliders') active
@elseif(request()->is('admins/herosection/slider/*/edit')) active
@elseif(request()->path() == 'admins/approach') active
@elseif(request()->is('admins/approach/*/pointedit')) active
@elseif(request()->path() == 'admins/statistics') active
@elseif(request()->is('admins/statistics/*/edit')) active
@elseif(request()->path() == 'admins/members') active
@elseif(request()->is('admins/member/*/edit')) active
@elseif(request()->is('admins/approach/*/pointedit')) active
@elseif(request()->path() == 'admins/cta') active
@elseif(request()->is('admins/feature/*/edit')) active
@elseif(request()->path() == 'admins/testimonials') active
@elseif(request()->is('admins/testimonial/*/edit')) active
@elseif(request()->path() == 'admins/invitation') active
@elseif(request()->path() == 'admins/partners') active
@elseif(request()->is('admins/partner/*/edit')) active
@elseif(request()->path() == 'admins/portfoliosection') active
@elseif(request()->path() == 'admins/blogsection') active
@elseif(request()->path() == 'admins/member/create') active
@elseif(request()->path() == 'admins/package/background') active
@elseif(request()->path() == 'admins/sections') active

@elseif(request()->path() == 'admins/scategorys') active
@elseif(request()->is('admins/service/settings')) active
@elseif(request()->is('admins/scategory/*/edit')) active
@elseif(request()->path() == 'admins/services') active
@elseif(request()->is('admins/service/*/edit')) active


@elseif(request()->path() == 'admins/portfolios') active
@elseif(request()->path() == 'admins/portfolio/create') active
@elseif(request()->is('admins/portfolio/*/edit')) active


@elseif(request()->path() == 'admins/footers') active
@elseif(request()->path() == 'admins/ulinks') active

@elseif(request()->path() == 'admins/gallery/settings') active
@elseif(request()->path() == 'admins/gallery/categories') active
@elseif(request()->path() == 'admins/gallery') active
@elseif(request()->path() == 'admins/gallery/create') active
@elseif(request()->is('admins/gallery/*/edit')) active

@elseif(request()->path() == 'admins/faq/settings') active
@elseif(request()->path() == 'admins/faq/categories') active
@elseif(request()->path() == 'admins/faqs') active

@elseif(request()->path() == 'admins/jcategorys') active
@elseif(request()->path() == 'admins/job/create') active
@elseif(request()->is('admins/jcategory/*/edit')) active
@elseif(request()->path() == 'admins/jobs') active
@elseif(request()->is('admins/job/*/edit')) active

@elseif(request()->path() == 'admins/contact') active
@endif">
    <a data-toggle="collapse" href="#webContents">
        <i class="la flaticon-imac"></i>
        <p>Content Management</p>
        <span class="caret"></span>
    </a>
    <div class="collapse
    @if(request()->path() == 'admins/features') show
    @elseif(request()->path() == 'admins/introsection') show
    @elseif(request()->path() == 'admins/servicesection') show
    @elseif(request()->path() == 'admins/herosection/static') show
    @elseif(request()->path() == 'admins/herosection/video') show
    @elseif(request()->path() == 'admins/herosection/sliders') show
    @elseif(request()->is('admins/herosection/slider/*/edit')) show
    @elseif(request()->path() == 'admins/approach') show
    @elseif(request()->is('admins/approach/*/pointedit')) show
    @elseif(request()->path() == 'admins/statistics') show
    @elseif(request()->is('admins/statistics/*/edit')) show
    @elseif(request()->path() == 'admins/members') show
    @elseif(request()->is('admins/member/*/edit')) show
    @elseif(request()->is('admins/approach/*/pointedit')) show
    @elseif(request()->path() == 'admins/cta') show
    @elseif(request()->is('admins/feature/*/edit')) show
    @elseif(request()->path() == 'admins/testimonials') show
    @elseif(request()->is('admins/testimonial/*/edit')) show
    @elseif(request()->path() == 'admins/invitation') show
    @elseif(request()->path() == 'admins/partners') show
    @elseif(request()->is('admins/partner/*/edit')) show
    @elseif(request()->path() == 'admins/portfoliosection') show
    @elseif(request()->path() == 'admins/blogsection') show
    @elseif(request()->path() == 'admins/member/create') show
    @elseif(request()->path() == 'admins/package/background') show
    @elseif(request()->path() == 'admins/sections') show

    @elseif(request()->path() == 'admins/scategorys') show
    @elseif(request()->is('admins/service/settings')) show
    @elseif(request()->is('admins/scategory/*/edit')) show
    @elseif(request()->path() == 'admins/services') show
    @elseif(request()->is('admins/service/*/edit')) show


    @elseif(request()->path() == 'admins/portfolios') show
    @elseif(request()->path() == 'admins/portfolio/create') show
    @elseif(request()->is('admins/portfolio/*/edit')) show


    @elseif(request()->path() == 'admins/footers') show
    @elseif(request()->path() == 'admins/ulinks') show

    @elseif(request()->path() == 'admins/gallery/settings') show
    @elseif(request()->path() == 'admins/gallery/categories') show
    @elseif(request()->path() == 'admins/gallery') show
    @elseif(request()->path() == 'admins/gallery/create') show
    @elseif(request()->is('admins/gallery/*/edit')) show

    @elseif(request()->path() == 'admins/faq/settings') show
    @elseif(request()->path() == 'admins/faq/categories') show
    @elseif(request()->path() == 'admins/faqs') show

    @elseif(request()->path() == 'admins/jcategorys') show
    @elseif(request()->path() == 'admins/job/create') show
    @elseif(request()->is('admins/jcategory/*/edit')) show
    @elseif(request()->path() == 'admins/jobs') show
    @elseif(request()->is('admins/job/*/edit')) show

    @elseif(request()->path() == 'admins/contact') show
    @endif" id="webContents">
        <ul class="nav nav-collapse">

            {{-- Home Page Sections --}}
            <li class="
            @if(request()->path() == 'admins/features') selected
            @elseif(request()->path() == 'admins/introsection') selected
            @elseif(request()->path() == 'admins/servicesection') selected
            @elseif(request()->path() == 'admins/herosection/static') selected
            @elseif(request()->path() == 'admins/herosection/video') selected
            @elseif(request()->path() == 'admins/herosection/sliders') selected
            @elseif(request()->is('admins/herosection/slider/*/edit')) selected
            @elseif(request()->path() == 'admins/approach') selected
            @elseif(request()->is('admins/approach/*/pointedit')) selected
            @elseif(request()->path() == 'admins/statistics') selected
            @elseif(request()->is('admins/statistics/*/edit')) selected
            @elseif(request()->path() == 'admins/members') selected
            @elseif(request()->is('admins/member/*/edit')) selected
            @elseif(request()->is('admins/approach/*/pointedit')) selected
            @elseif(request()->path() == 'admins/cta') selected
            @elseif(request()->is('admins/feature/*/edit')) selected
            @elseif(request()->path() == 'admins/testimonials') selected
            @elseif(request()->is('admins/testimonial/*/edit')) selected
            @elseif(request()->path() == 'admins/invitation') selected
            @elseif(request()->path() == 'admins/partners') selected
            @elseif(request()->is('admins/partner/*/edit')) selected
            @elseif(request()->path() == 'admins/portfoliosection') selected
            @elseif(request()->path() == 'admins/blogsection') selected
            @elseif(request()->path() == 'admins/member/create') selected
            @elseif(request()->path() == 'admins/package/background') selected
            @endif">
                <a  href="{{ route('admin.homepagesection.index', ['language' => $default->code]) }}">
                    <span class="sub-item">Home Page Sections</span>
                </a>
                <div class="collapse
                @if(request()->path() == 'admins/features') show
                @elseif(request()->path() == 'admins/introsection') show
                @elseif(request()->path() == 'admins/servicesection') show
                @elseif(request()->path() == 'admins/herosection/static') show
                @elseif(request()->path() == 'admins/herosection/video') show
                @elseif(request()->path() == 'admins/herosection/sliders') show
                @elseif(request()->is('admins/herosection/slider/*/edit')) show
                @elseif(request()->path() == 'admins/approach') show
                @elseif(request()->is('admins/approach/*/pointedit')) show
                @elseif(request()->path() == 'admins/statistics') show
                @elseif(request()->is('admins/statistics/*/edit')) show
                @elseif(request()->path() == 'admins/members') show
                @elseif(request()->is('admins/member/*/edit')) show
                @elseif(request()->is('admins/approach/*/pointedit')) show
                @elseif(request()->path() == 'admins/cta') show
                @elseif(request()->is('admins/feature/*/edit')) show
                @elseif(request()->path() == 'admins/testimonials') show
                @elseif(request()->is('admins/testimonial/*/edit')) show
                @elseif(request()->path() == 'admins/invitation') show
                @elseif(request()->path() == 'admins/partners') show
                @elseif(request()->is('admins/partner/*/edit')) show
                @elseif(request()->path() == 'admins/portfoliosection') show
                @elseif(request()->path() == 'admins/blogsection') show
                @elseif(request()->path() == 'admins/member/create') show
                @elseif(request()->path() == 'admins/package/background') show
                @endif" id="home">
                </div>
            </li>
            @if ($bex->home_page_pagebuilder == 0)
                <li class="
                    @if(request()->path() == 'admins/sections') active
                    @endif">
                    <a href="{{route('admin.sections.index') . '?language=' . $default->code}}">
                        <span class="sub-item">Section Customization</span>
                    </a>
                </li>
            @endif


            {{-- Footer --}}
            <li class="
            @if(request()->path() == 'admins/footers') selected
            @elseif(request()->path() == 'admins/ulinks') selected
            @endif">
                <a data-toggle="collapse" href="#footer">
                    <span class="sub-item">Footer</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse
                @if(request()->path() == 'admins/footers') show
                @elseif(request()->path() == 'admins/ulinks') show
                @endif" id="footer">
                    <ul class="nav nav-collapse subnav">
                        <li class="@if(request()->path() == 'admins/footers') active @endif">
                            <a href="{{route('admin.footer.index') . '?language=' . $default->code}}">
                                <span class="sub-item">Logo & Text</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'admins/ulinks') active @endif">
                            <a href="{{route('admin.ulink.index') . '?language=' . $default->code}}">
                                <span class="sub-item">Useful Links</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            {{-- Tags Management --}}
            <li class="
            @if(request()->path() == 'admins/tags') selected
            @elseif(request()->path() == 'admins/tags/create') selected
            @elseif(request()->is('admins/tags/*/edit')) selected
            @endif">
                <a data-toggle="collapse" href="#tags">
                    <span class="sub-item">Tags</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse
                @if(request()->path() == 'admins/tags') show
                @elseif(request()->path() == 'admins/tags/create') show
                @elseif(request()->is('admins/tags/*/edit')) show
                @endif" id="tags">
                    <ul class="nav nav-collapse subnav">
                        <li class="
                        @if(request()->path() == 'admins/tags/create') active
                        @endif">
                            <a href="{{route('admin.tag.create')}}">
                                <span class="sub-item">Add Tag</span>
                            </a>
                        </li>
                        <li class="
                        @if(request()->path() == 'admins/tags') active
                        @elseif(request()->is('admins/tags/*/edit')) active
                        @endif">
                            <a href="{{route('admin.tag.index') . '?language=' . $default->code}}">
                                <span class="sub-item">Tags</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>



            {{-- FAQ Management --}}
            <li class="
            @if(request()->path() == 'admins/faq/settings') selected
            @elseif(request()->path() == 'admins/faq/categories') selected
            @elseif(request()->path() == 'admins/faqs') selected
            @endif">
                <a data-toggle="collapse" href="#faq">
                    <span class="sub-item">FAQ</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse
                @if(request()->path() == 'admins/faq/settings') show
                @elseif(request()->path() == 'admins/faq/categories') show
                @elseif(request()->path() == 'admins/faqs') show
                @endif" id="faq">
                    <ul class="nav nav-collapse subnav">
                        <li class="@if(request()->path() == 'admins/faq/settings') active @endif">
                            <a href="{{route('admin.faq.settings')}}">
                                <span class="sub-item">Settings</span>
                            </a>
                        </li>
                        @if ($data->faq_category_status == 1)
                        <li class="@if(request()->path() == 'admins/faq/categories') active @endif">
                            <a href="{{route('admin.faq.categories') . '?language=' . $default->code}}">
                                <span class="sub-item">Categories</span>
                            </a>
                        </li>
                        @endif
                        <li class="@if(request()->path() == 'admins/faqs') active @endif">
                            <a href="{{route('admin.faq.index') . '?language=' . $default->code}}">
                                <span class="sub-item">FAQs</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            {{-- Our Story Page --}}
            <li class="
            @if(request()->path() == 'admins/our_story') active @endif">
                <a href="{{route('admin.our_story.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Our Story Page</span>
                </a>
            </li>


            {{-- Contact Page --}}
            <li class="
            @if(request()->path() == 'admins/contact') active @endif">
                <a href="{{route('admin.contact.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Contact Page</span>
                </a>
            </li>

        </ul>
    </div>

</li>
