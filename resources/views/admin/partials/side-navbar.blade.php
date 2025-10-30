@php
$default = \App\Models\Language::where('is_default', 1)->first();
$admin = Auth::guard('admin')->user();
if (!empty($admin->role)) {
    $permissions = $admin->role->permissions;
    $permissions = json_decode($permissions, true);
}

$data = \App\Models\BasicExtra::first();
@endphp

<div class="sidebar sidebar-style-2" data-background-color="dark2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    @if (!empty(Auth::guard('admin')->user()->image))
                    <img src="{{asset('assets/admin/img/propics/'.Auth::guard('admin')->user()->image)}}" alt="..."
                    class="avatar-img rounded">
                    @else
                    <img src="{{asset('assets/admin/img/propics/blank_user.jpg')}}" alt="..." class="avatar-img rounded">
                    @endif
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{Auth::guard('admin')->user()->first_name}}
                            @if (empty(Auth::guard('admin')->user()->role))
                            <span class="user-level">Owner</span>
                            @else
                            <span class="user-level">{{Auth::guard('admin')->user()->role->name}}</span>
                            @endif
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="{{route('admin.editProfile')}}">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.changePass')}}">
                                    <span class="link-collapse">Change Password</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.logout')}}">
                                    <span class="link-collapse">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary mt-0">
                <div class="row mb-2">
                    <div class="col-12">
                        <form action="">
                            <div class="form-group py-0">
                                <input name="term" type="text" style="border-color: #6d6d6d;" class="form-control sidebar-search" value="" placeholder="Search Menu Here...">
                            </div>
                        </form>
                    </div>
                </div>

                @if (empty($admin->role) || (!empty($permissions) && in_array('Dashboard', $permissions)))
                {{-- Dashboard --}}
                <li class="nav-item @if(request()->path() == 'admins/dashboard') active @endif">
                    <a href="{{route('admin.dashboard')}}">
                        <i class="la flaticon-paint-palette"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @endif


            @if (empty($admin->role) || (!empty($permissions) && in_array('Theme & Home', $permissions)))
                {{-- Dynamic Pages --}}
                <li class="nav-item
                    @if(request()->path() == 'admins/home-settings') active
                    @elseif(request()->path() == 'admins/home-page') active
                    @elseif(request()->path() == 'admins/blog/carousel-management') active
                    @endif">
                    <a data-toggle="collapse" href="#themeHome">
                    <i class="la flaticon-file"></i>
                    <p>Theme & Home
                        @if ($bex->home_page_pagebuilder == 1)
                        <span class="badge badge-danger p-1 sidenav-badge">Pagebuilder</span>
                        @endif
                    </p>
                    <span class="caret"></span>
                </a>
                    <div class="collapse
                        @if(request()->path() == 'admins/home-settings') show
                        @elseif(request()->path() == 'admins/home-page') show
                        @elseif(request()->path() == 'admins/blog/carousel-management') show
                        @endif" id="themeHome">
                        <ul class="nav nav-collapse">
                            <li class="@if(request()->path() == 'admins/home-settings') active @endif">
                                <a href="{{route('admin.homeSettings')}}">
                                    <span class="sub-item">Settings</span>
                                </a>
                            </li>
                            @if ($bex->home_page_pagebuilder == 1)

                            <li class="@if(request()->path() == 'admins/home-page') active @endif">
                                <a href="#" data-toggle="modal" data-target="#pbLangModal">
                                    <span class="sub-item">Home Page Content</span>
                                </a>
                            </li>
                            @endif
                            <li class="@if(request()->path() == 'admins/blog/carousel-management') active @endif">
                                <a href="{{route('admin.blog.carousel.management') . '?language=' . $default->code}}">
                                    <span class="sub-item">Blog Carousel Management</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif


        @if (empty($admin->role) || (!empty($permissions) && in_array('Menu Builder', $permissions)))
        {{-- Menu Builder--}}
        <li class="nav-item
        @if(request()->path() == 'admins/menu-builder') active
        @elseif(request()->path() == 'admins/megamenus') active
        @elseif(request()->path() == 'admins/megamenus/edit') active
        @elseif(request()->path() == 'admins/permalinks') active
        @endif">
        <a data-toggle="collapse" href="#websiteMenu">
            <i class="fas fa-ellipsis-v"></i>
            <p>Website Menu Builder</p>
            <span class="caret"></span>
        </a>
        <div class="collapse
        @if(request()->path() == 'admins/menu-builder') show
        @elseif(request()->path() == 'admins/megamenus') show
        @elseif(request()->path() == 'admins/permalinks') show
        @elseif(request()->path() == 'admins/megamenus/edit') show
        @endif" id="websiteMenu">
        <ul class="nav nav-collapse">
            <li class="@if(request()->path() == 'admins/megamenus') active
                @elseif(request()->path() == 'admins/megamenus/edit') active
                @endif">
                <a href="{{route('admin.megamenus') . '?language=' . $default->code}}">
                    <span class="sub-item">Mega Menus</span>
                </a>
            </li>
            <li class="@if(request()->path() == 'admins/menu-builder') active @endif">
                <a href="{{route('admin.menu_builder.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Main Menu</span>
                </a>
            </li>
            <li class="@if(request()->path() == 'admins/permalinks') active @endif">
                <a href="{{route('admin.permalinks.index')}}">
                    <span class="sub-item">Permalinks</span>
                </a>
            </li>
        </ul>
    </div>
</li>
@endif



{{-- Content Management --}}
@if (empty($admin->role) || (!empty($permissions) && in_array('Content Management', $permissions)))
@includeIf('admin.partials.content-management')
@endif

{{-- Blog Management --}}
@if (empty($admin->role) || (!empty($permissions) && in_array('Content Management', $permissions)))
<li class="nav-item
@if(request()->path() == 'admins/bcategorys') active
@elseif(request()->path() == 'admins/blogs') active
@elseif(request()->path() == 'admins/archives') active
@elseif(request()->is('admins/blog/*/edit')) active
@endif">
<a data-toggle="collapse" href="#blogManagement">
    <i class="la flaticon-edit"></i>
    <p>Blog Management</p>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/bcategorys') show
@elseif(request()->path() == 'admins/blogs') show
@elseif(request()->path() == 'admins/archives') show
@elseif(request()->is('admins/blog/*/edit')) show
@endif" id="blogManagement">
<ul class="nav nav-collapse">
    <li class="@if(request()->path() == 'admins/bcategorys') active @endif">
        <a href="{{route('admin.bcategory.index') . '?language=' . $default->code}}">
            <span class="sub-item">Category</span>
        </a>
    </li>
    <li class="
        @if(request()->path() == 'admins/blogs') active
        @elseif(request()->is('admins/blog/*/edit')) active
        @endif">
        <a href="{{route('admin.blog.index') . '?language=' . $default->code}}">
            <span class="sub-item">Blogs</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/archives') active @endif">
        <a href="{{route('admin.archive.index')}}">
            <span class="sub-item">Archives</span>
        </a>
    </li>
</ul>
</div>
</li>
@endif


@if (empty($admin->role) || (!empty($permissions) && in_array('Pages', $permissions)))
{{-- Dynamic Pages --}}
<li class="nav-item
@if(request()->path() == 'admins/page/create') active
@elseif(request()->path() == 'admins/page/settings') active
@elseif(request()->path() == 'admins/pages') active
@elseif(request()->is('admins/page/*/edit')) active
@endif">
<a data-toggle="collapse" href="#pages">
    <i class="la flaticon-file"></i>
    <p>Custom Pages <span class="badge badge-danger p-1 sidenav-badge">Pagebuilder</span></p>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/page/create') show
@elseif(request()->path() == 'admins/page/settings') show
@elseif(request()->path() == 'admins/pages') show
@elseif(request()->is('admins/page/*/edit')) show
@endif" id="pages">
<ul class="nav nav-collapse">
    <li class="@if(request()->path() == 'admins/page/settings') active @endif">
        <a href="{{route('admin.page.settings')}}">
            <span class="sub-item">Settings</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/page/create') active @endif">
        <a href="{{route('admin.page.create') . '?language=' . $default->code}}">
            <span class="sub-item">Create Page</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/pages') active @endif">
        <a href="{{route('admin.page.index') . '?language=' . $default->code}}">
            <span class="sub-item">Pages</span>
        </a>
    </li>
</ul>
</div>
</li>
@endif

@if (empty($admin->role) || (!empty($permissions) && in_array('Tickets', $permissions)))
{{-- Tickets --}}
<li class="nav-item
@if(request()->path() == 'admins/all/tickets') active
@elseif(request()->path() == 'admins/pending/tickets') active
@elseif(request()->path() == 'admins/open/tickets') active
@elseif(request()->path() == 'admins/closed/tickets') active
@elseif(request()->routeIs('admin.ticket.messages')) active
@elseif(request()->routeIs('admin.ticket.settings')) active
@endif">
<a data-toggle="collapse" href="#tickets">
    <i class="la flaticon-web-1"></i>
    <p>Support Tickets</p>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/all/tickets') show
@elseif(request()->path() == 'admins/pending/tickets') show
@elseif(request()->path() == 'admins/open/tickets') show
@elseif(request()->path() == 'admins/closed/tickets') show
@elseif(request()->routeIs('admin.ticket.messages')) show
@elseif(request()->routeIs('admin.ticket.settings')) show
@endif" id="tickets">
<ul class="nav nav-collapse">
    <li class="@if(request()->path() == 'admins/ticket/settings') active @endif">
        <a href="{{route('admin.ticket.settings')}}">
            <span class="sub-item">Settings</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/all/tickets') active @endif">
        <a href="{{route('admin.tickets.all')}}">
            <span class="sub-item">All Tickets</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/pending/tickets') active @endif">
        <a href="{{route('admin.tickets.pending')}}">
            <span class="sub-item">Pending Tickets</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/open/tickets') active @endif">
        <a href="{{route('admin.tickets.open')}}">
            <span class="sub-item">Open Tickets</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/closed/tickets') active @endif">
        <a href="{{route('admin.tickets.closed')}}">
            <span class="sub-item">Closed Tickets</span>
        </a>
    </li>
</ul>
</div>
</li>
@endif


@if (empty($admin->role) || (!empty($permissions) && in_array('RSS Feeds', $permissions)))
{{-- RSS --}}
<li class="nav-item
@if(request()->path() == 'admins/rss/create') active
@elseif(request()->path() == 'admins/rss/feeds') active
@elseif(request()->path() == 'admins/rss') active
@elseif(request()->is('admins/rss/edit/*')) active
@endif">
<a data-toggle="collapse" href="#rss">
    <i class="fa fa-rss"></i>
    <p>RSS Feeds</p>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/rss/create') show
@elseif(request()->path() == 'admins/rss/feeds') show
@elseif(request()->path() == 'admins/rss') show
@elseif(request()->is('admins/rss/edit/*')) show
@endif" id="rss">
<ul class="nav nav-collapse">
    <li class="@if(request()->path() == 'admins/rss/create') active @endif">
        <a href="{{route('admin.rss.create')}}">
            <span class="sub-item">Import RSS Feeds</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/rss/feeds') active @endif">
        <a href="{{route('admin.rss.feed'). '?language=' . $default->code}}">
            <span class="sub-item">RSS Feeds</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/rss') active @endif">
        <a href="{{route('admin.rss.index'). '?language=' . $default->code}}">
            <span class="sub-item">RSS Posts</span>
        </a>
    </li>
</ul>
</div>
</li>
@endif


{{-- Users Management --}}
@if (empty($admin->role) || (!empty($permissions) && in_array('Users Management', $permissions)))
<li class="nav-item
@if(request()->routeIs('admin.register.user')) active
@elseif(request()->routeIs('register.user.view')) active
@elseif(request()->routeIs('register.user.changePass')) active

@elseif(request()->path() == 'admins/pushnotification/settings') active
@elseif(request()->path() == 'admins/pushnotification/send') active

@elseif(request()->path() == 'admins/subscribers') active
@elseif(request()->path() == 'admins/mailsubscriber') active
@endif">
<a data-toggle="collapse" href="#usersManagement">
    <i class="la flaticon-users"></i>
    <p>Users Management</p>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->routeIs('admin.register.user')) show
@elseif(request()->routeIs('register.user.view')) show
@elseif(request()->routeIs('register.user.changePass')) show

@elseif(request()->path() == 'admins/pushnotification/settings') show
@elseif(request()->path() == 'admins/pushnotification/send') show

@elseif(request()->path() == 'admins/subscribers') show
@elseif(request()->path() == 'admins/mailsubscriber') show
@endif" id="usersManagement">
<ul class="nav nav-collapse">

    {{-- Registered Users --}}
    <li class="
    @if(request()->routeIs('admin.register.user')) active
    @elseif(request()->routeIs('register.user.view')) active
    @elseif(request()->routeIs('register.user.changePass')) active
    @endif">
    <a href="{{route('admin.register.user')}}">
        <span class="sub-item">Registered Users</span>
    </a>
</li>

{{-- Push Notification --}}
<li class="
@if(request()->path() == 'admins/pushnotification/settings') selected
@elseif(request()->path() == 'admins/pushnotification/send') selected
@endif">
<a data-toggle="collapse" href="#pushNotification">
    <span class="sub-item">Push Notification</span>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/pushnotification/settings') show
@elseif(request()->path() == 'admins/pushnotification/send') show
@endif" id="pushNotification">
<ul class="nav nav-collapse subnav">
    <li class="@if(request()->path() == 'admins/pushnotification/settings') active @endif">
        <a href="{{route('admin.pushnotification.settings')}}">
            <span class="sub-item">Settings</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/pushnotification/send') active @endif">
        <a href="{{route('admin.pushnotification.send')}}">
            <span class="sub-item">Send Notification</span>
        </a>
    </li>
</ul>
</div>
</li>

{{-- Subscribers --}}
<li class="
@if(request()->path() == 'admins/subscribers') selected
@elseif(request()->path() == 'admins/mailsubscriber') selected
@endif">
<a data-toggle="collapse" href="#subscribers">
    <span class="sub-item">Subscribers</span>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/subscribers') show
@elseif(request()->path() == 'admins/mailsubscriber') show
@endif" id="subscribers">
<ul class="nav nav-collapse subnav">
    <li class="@if(request()->path() == 'admins/subscribers') active @endif">
        <a href="{{route('admin.subscriber.index')}}">
            <span class="sub-item">Subscribers</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/mailsubscriber') active @endif">
        <a href="{{route('admin.mailsubscriber')}}">
            <span class="sub-item">Mail to Subscribers</span>
        </a>
    </li>
</ul>
</div>
</li>
</ul>
</div>
</li>
@endif


{{-- Announcement Popup--}}
@if (empty($admin->role) || (!empty($permissions) && in_array('Announcement Popup', $permissions)))
<li class="nav-item
@if(request()->path() == 'admins/popup/create') active
@elseif(request()->path() == 'admins/popup/types') active
@elseif(request()->is('admins/popup/*/edit')) active
@elseif(request()->path() == 'admins/popups') active
@endif">
<a data-toggle="collapse" href="#announcementPopup">
    <i class="fas fa-bullhorn"></i>
    <p>Announcement Popup</p>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/popup/create') show
@elseif(request()->path() == 'admins/popup/types') show
@elseif(request()->path() == 'admins/popups') show
@elseif(request()->is('admins/popup/*/edit')) show
@endif" id="announcementPopup">
<ul class="nav nav-collapse">
    <li class="@if(request()->path() == 'admins/popup/types') active
        @elseif(request()->path() == 'admins/popup/create') active
        @endif">
        <a href="{{route('admin.popup.types')}}">
            <span class="sub-item">Add Popup</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/popups') active
        @elseif(request()->is('admins/popup/*/edit')) active
        @endif">
        <a href="{{route('admin.popup.index') . '?language=' . $default->code}}">
            <span class="sub-item">Popups</span>
        </a>
    </li>
</ul>
</div>
</li>
@endif


@if (empty($admin->role) || (!empty($permissions) && in_array('Basic Settings', $permissions)))
{{-- Basic Settings --}}
<li class="nav-item
@if(request()->path() == 'admins/logo') active
@elseif(request()->path() == 'admins/file-manager') active
@elseif(request()->path() == 'admins/preloader') active
@elseif(request()->path() == 'admins/basicinfo') active
@elseif(request()->path() == 'admins/support') active
@elseif(request()->path() == 'admins/social') active
@elseif(request()->is('admins/social/*')) active
@elseif(request()->path() == 'admins/heading') active
@elseif(request()->path() == 'admins/script') active
@elseif(request()->path() == 'admins/seo') active
@elseif(request()->path() == 'admins/maintainance') active
@elseif(request()->path() == 'admins/cookie-alert') active
@elseif(request()->path() == 'admins/mail-from-admin') active
@elseif(request()->path() == 'admins/mail-to-admin') active
@elseif(request()->routeIs('admin.featuresettings')) active
@elseif(request()->path() == 'admins/email-templates') active
@elseif(request()->routeIs('admin.email.editTemplate')) active
@elseif(request()->path() == 'admins/languages') active
@elseif(request()->is('admins/language/*/edit')) active
@elseif(request()->is('admins/language/*/edit/keyword')) active
@elseif(request()->path() == 'admins/gateways') active
@elseif(request()->path() == 'admins/offline/gateways') active
@elseif(request()->path() == 'admins/backup') active
@elseif(request()->path() == 'admins/sitemap') active
@elseif(request()->path() == 'admins/free-analysis') active
@endif">
<a data-toggle="collapse" href="#basic">
    <i class="la flaticon-settings"></i>
    <p>Settings</p>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/logo') show
@elseif(request()->path() == 'admins/file-manager') show
@elseif(request()->path() == 'admins/preloader') show
@elseif(request()->path() == 'admins/basicinfo') show
@elseif(request()->path() == 'admins/support') show
@elseif(request()->path() == 'admins/social') show
@elseif(request()->is('admins/social/*')) show
@elseif(request()->path() == 'admins/heading') show
@elseif(request()->path() == 'admins/script') show
@elseif(request()->path() == 'admins/seo') show
@elseif(request()->path() == 'admins/maintainance') show
@elseif(request()->path() == 'admins/cookie-alert') show
@elseif(request()->path() == 'admins/mail-from-admin') show
@elseif(request()->path() == 'admins/mail-to-admin') show
@elseif(request()->routeIs('admin.featuresettings')) show
@elseif(request()->path() == 'admins/email-templates') show
@elseif(request()->routeIs('admin.email.editTemplate')) show
@elseif(request()->path() == 'admins/languages') show
@elseif(request()->is('admins/language/*/edit')) show
@elseif(request()->is('admins/language/*/edit/keyword')) show
@elseif(request()->path() == 'admins/gateways') show
@elseif(request()->path() == 'admins/offline/gateways') show
@elseif(request()->path() == 'admins/backup') show
@elseif(request()->path() == 'admins/sitemap') show
@elseif(request()->path() == 'admins/free-analysis') show
@endif" id="basic">
<ul class="nav nav-collapse">
    <li class="@if(request()->path() == 'admins/basicinfo') active @endif">
        <a href="{{route('admin.basicinfo')}}">
            <span class="sub-item">General Settings</span>
        </a>
    </li>
    <li class="submenu">
        <a data-toggle="collapse" href="#emailset" aria-expanded="{{(request()->path() == 'admins/mail-from-admin' || request()->path() == 'admins/mail-to-admin' || request()->path() == 'admins/email-templates' || request()->routeIs('admin.email.editTemplate')) ? 'true' : 'false' }}">
            <span class="sub-item">Email Settings</span>
            <span class="caret"></span>
        </a>
        <div class="collapse {{(request()->path() == 'admins/mail-from-admin' || request()->path() == 'admins/mail-to-admin' || request()->path() == 'admins/email-templates' || request()->routeIs('admin.email.editTemplate')) ? 'show' : '' }}" id="emailset" style="">
            <ul class="nav nav-collapse subnav">
                <li class="@if(request()->path() == 'admins/mail-from-admin') active @endif">
                    <a href="{{route('admin.mailFromAdmin')}}">
                        <span class="sub-item">Mail from Admin</span>
                    </a>
                </li>
                <li class="@if(request()->path() == 'admins/mail-to-admin') active @endif">
                    <a href="{{route('admin.mailToAdmin')}}">
                        <span class="sub-item">Mail to Admin</span>
                    </a>
                </li>
                <li class="@if(request()->path() == 'admins/email-templates') active
                    @elseif(request()->routeIs('admin.email.editTemplate')) active
                    @endif">
                    <a href="{{route('admin.email.templates')}}">
                        <span class="sub-item">Email Templates</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="@if(request()->path() == 'admins/file-manager') active @endif">
        <a href="{{route('admin.file-manager')}}">
            <span class="sub-item">File Manager</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/logo') active @endif">
        <a href="{{route('admin.logo')}}">
            <span class="sub-item">Logo & Images</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/preloader') active @endif">
        <a href="{{route('admin.preloader')}}">
            <span class="sub-item">Preloader</span>
        </a>
    </li>
    <li class="@if(request()->routeIs('admin.featuresettings')) active @endif">
        <a href="{{route('admin.featuresettings') . '?language=' . $default->code}}">
            <span class="sub-item">Preferences</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/support') active @endif">
        <a href="{{route('admin.support') . '?language=' . $default->code}}">
            <span class="sub-item">Support Informations</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/social') active
        @elseif(request()->is('admins/social/*')) active @endif">
        <a href="{{route('admin.social.index')}}">
            <span class="sub-item">Social Links</span>
        </a>
    </li>
    <li class="@if(request()->path() == 'admins/heading') active @endif">
        <a href="{{route('admin.heading') . '?language=' . $default->code}}">
            <span class="sub-item">Page Headings</span>
        </a>
    </li>
    <li class="
    @if(request()->path() == 'admins/gateways') selected
    @elseif(request()->path() == 'admins/offline/gateways') selected
    @endif">
    <a data-toggle="collapse" href="#gateways">
        <span class="sub-item">Payment Gateways</span>
        <span class="caret"></span>
    </a>
    <div class="collapse
    @if(request()->path() == 'admins/gateways') show
    @elseif(request()->path() == 'admins/offline/gateways') show
    @endif" id="gateways">
    <ul class="nav nav-collapse subnav">
        <li class="@if(request()->path() == 'admins/gateways') active @endif">
            <a href="{{route('admin.gateway.index')}}">
                <span class="sub-item">Online Gateways</span>
            </a>
        </li>
        <li class="@if(request()->path() == 'admins/offline/gateways') active @endif">
            <a href="{{route('admin.gateway.offline') . '?language=' . $default->code}}">
                <span class="sub-item">Offline Gateways</span>
            </a>
        </li>
    </ul>
</div>
</li>
<li class="
@if(request()->path() == 'admins/languages') active
@elseif(request()->is('admins/language/*/edit')) active
@elseif(request()->is('admins/language/*/edit/keyword')) active
@endif">
<a href="{{route('admin.language.index')}}">
    <span class="sub-item">Language</span>
</a>
</li>
<li class="@if(request()->path() == 'admins/script') active @endif">
    <a href="{{route('admin.script')}}">
        <span class="sub-item">Plugins</span>
    </a>
</li>
<li class="@if(request()->path() == 'admins/seo') active @endif">
    <a href="{{route('admin.seo') . '?language=' . $default->code}}">
        <span class="sub-item">SEO Information</span>
    </a>
</li>
<li class="@if(request()->path() == 'admins/maintainance') active @endif">
    <a href="{{route('admin.maintainance')}}">
        <span class="sub-item">Maintenance Mode</span>
    </a>
</li>

<li class="@if(request()->path() == 'admins/cookie-alert') active @endif">
    <a href="{{route('admin.cookie.alert') . '?language=' . $default->code}}">
        <span class="sub-item">Cookie Alert</span>
    </a>
</li>

<li class="@if(request()->path() == 'admins/free-analysis') active @endif">
    <a href="{{route('admin.free-analysis.index') . '?language=' . $default->code}}">
        <span class="sub-item">Free Analysis</span>
    </a>
</li>

<li class="
@if(request()->path() == 'admins/backup') selected
@elseif(request()->path() == 'admins/sitemap') selected
@endif">
<a data-toggle="collapse" href="#misc">
    <span class="sub-item">MISC</span>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/backup') show
@elseif(request()->path() == 'admins/sitemap') show
@endif" id="misc">
<ul class="nav nav-collapse subnav">
    <li class="
    @if(request()->path() == 'admins/sitemap') selected
    @endif">
    <a href="{{route('admin.sitemap.index') . '?language=' . $default->code}}">
        <span class="sub-item">Sitemap</span>
    </a>
</li>
<li class="
@if(request()->path() == 'admins/backup') selected
@endif">
<a href="{{route('admin.backup.index')}}">
    <span class="sub-item">Database Backup</span>
</a>
</li>
<li>
    <a href="{{route('admin.cache.clear')}}">
        <span class="sub-item">Clear Cache</span>
    </a>
</li>
</ul>
</div>
</li>
</ul>
</div>
</li>
@endif


@if (empty($admin->role) || (!empty($permissions) && in_array('Admins Management', $permissions)))
{{-- Admins Management --}}
<li class="nav-item
@if(request()->path() == 'admins/roles') active
@elseif(request()->is('admins/role/*/permissions/manage')) active
@elseif(request()->path() == 'admins/users') active
@elseif(request()->is('admins/user/*/edit')) active
@endif">
<a data-toggle="collapse" href="#adminsManagement">
    <i class="fas fa-users-cog"></i>
    <p>Admins Management</p>
    <span class="caret"></span>
</a>
<div class="collapse
@if(request()->path() == 'admins/roles') show
@elseif(request()->is('admins/role/*/permissions/manage')) show
@elseif(request()->path() == 'admins/users') show
@elseif(request()->is('admins/user/*/edit')) show
@endif" id="adminsManagement">
<ul class="nav nav-collapse">
    <li class="
    @if(request()->path() == 'admins/roles') active
    @elseif(request()->is('admins/role/*/permissions/manage')) active
    @endif">
    <a href="{{route('admin.role.index')}}">
        <span class="sub-item">Role Management</span>
    </a>
</li>
<li class="
@if(request()->path() == 'admins/users') active
@elseif(request()->is('admins/user/*/edit')) active
@endif">
<a href="{{route('admin.user.index')}}">
    <span class="sub-item">Admins</span>
</a>
</li>
</ul>
</div>
</li>
@endif



@if (empty($admin->role) || (!empty($permissions) && in_array('Client Feedbacks', $permissions)))
{{-- Client Feedbacks --}}
<li class="nav-item @if(request()->path() == 'admins/feedbacks') active @endif">
    <a href="{{route('admin.client_feedbacks')}}">
        <i class="fas fa-pen-fancy"></i>
        <p>Client Feedbacks</p>
    </a>
</li>
@endif
</ul>
</div>
</div>
</div>
