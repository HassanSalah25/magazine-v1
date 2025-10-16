@extends('admin.layout')
@section('content')
@php
use Illuminate\Support\Str;
$admin = Auth::guard('admin')->user();
if (!empty($admin->role)) {
    $permissions = $admin->role->permissions;
    $permissions = json_decode($permissions, true);
}
@endphp
<div class="mt-2 mb-4">
    <h4 class="text-dark pb-2 mb-25">Welcome back, {{Auth::guard('admin')->user()->first_name}} {{Auth::guard('admin')->user()->last_name}}!</h4>
</div>
<div class="row">
    <div class="col-xxl-8">
        <div class="row">
         @if (empty($admin->role) || (!empty($permissions) && in_array('Package Management', $permissions)))
      <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.package.index') . '?language=' . $default->code}}" style="width: 100%;">    
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:cube-outline" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Packages</span>
                        <h6 class="fw-semibold">{{$default->packages()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
          </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.package.index') . '?language=' . $default->code}}" class="d-block">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Packages</p>
                                <h4 class="card-title">{{$default->packages()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->

    @if ($bex->recurring_billing == 1)
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.subscriptions', ['type' => 'active'])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:account-check-outline" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Active Subscriptions</span>
                        <h6 class="fw-semibold">{{\App\Models\Subscription::where('status', 1)->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Active Subscriptions calculation
                    $lastWeekSubscriptions = \App\Models\Subscription::where('status', 1)->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekSubscriptions = \App\Models\Subscription::where('status', 1)->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekSubscriptions - $previousWeekSubscriptions;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.subscriptions', ['type' => 'active'])}}" class="d-block">
            <div class="card card-stats card-secondary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="far fa-handshake"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Active Subscriptions</p>
                                <h4 class="card-title">{{\App\Models\Subscription::where('status', 1)->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif
    @if ($bex->recurring_billing == 0)
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.all.orders')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:package-variant-closed" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Package Orders</span>
                        <h6 class="fw-semibold">{{\App\Models\PackageOrder::count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Package Orders calculation
                    $lastWeekPackageOrders = \App\Models\PackageOrder::where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackageOrders = \App\Models\PackageOrder::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackageOrders - $previousWeekPackageOrders;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.all.orders')}}" class="d-block">
            <div class="card card-stats card-secondary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-box-open"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Package Orders</p>
                                <h4 class="card-title">{{\App\Models\PackageOrder::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif

    @endif


    @if (empty($admin->role) || (!empty($permissions) && in_array('Shop Management', $permissions)))
    @if ($bex->is_shop == 1)
    <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.product.index', ['language' => $default->code])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:shopping-outline" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Products</span>
                        <h6 class="fw-semibold">{{$default->products()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Products calculation
                    $lastWeekProducts = $default->products()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekProducts = $default->products()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekProducts - $previousWeekProducts;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.product.index', ['language' => $default->code])}}" class="d-block">
            <div class="card card-stats card-danger card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-boxes"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Products</p>
                                <h4 class="card-title">{{$default->products()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif
    @if ($bex->is_shop == 1)
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.all.product.orders')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:cart-outline" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Product Orders</span>
                        <h6 class="fw-semibold">{{\App\Models\ProductOrder::count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Product Orders calculation
                    $lastWeekProductOrders = \App\Models\ProductOrder::where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekProductOrders = \App\Models\ProductOrder::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekProductOrders - $previousWeekProductOrders;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.all.product.orders')}}" class="d-block">
            <div class="card card-stats card-warning card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-truck"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Product Orders</p>
                                <h4 class="card-title">{{\App\Models\ProductOrder::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif
    @endif


    @if (empty($admin->role) || (!empty($permissions) && in_array('Course Management', $permissions)))
    @if ($bex->is_course == 1)
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.course.index', ['language' => $default->code])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:book-open-variant" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Courses</span>
                        <h6 class="fw-semibold">{{$default->courses()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Courses calculation
                    $lastWeekCourses = $default->courses()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekCourses = $default->courses()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekCourses - $previousWeekCourses;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.course.index', ['language' => $default->code])}}" class="d-block">
            <div class="card card-stats card-success card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Courses</p>
                                <h4 class="card-title">{{$default->courses()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.course.purchaseLog')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:account-school-outline" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Course Enrolls</span>
                        <h6 class="fw-semibold">{{\App\Models\CoursePurchase::count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Course Enrolls calculation
                    $lastWeekCourseEnrolls = \App\Models\CoursePurchase::where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekCourseEnrolls = \App\Models\CoursePurchase::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekCourseEnrolls - $previousWeekCourseEnrolls;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.course.purchaseLog')}}" class="d-block">
            <div class="card card-stats card-dark card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Course Enrolls</p>
                                <h4 class="card-title">{{\App\Models\CoursePurchase::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif
    @endif


    @if (empty($admin->role) || (!empty($permissions) && in_array('Events Management', $permissions)))
    @if ($bex->is_event == 1)
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.event.index', ['language' => $default->code])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:calendar-month-outline" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Events</span>
                        <h6 class="fw-semibold">{{$default->events()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Events calculation
                    $lastWeekEvents = $default->events()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekEvents = $default->events()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekEvents - $previousWeekEvents;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.event.index', ['language' => $default->code])}}" class="d-block">
            <div class="card card-stats card-info card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Events</p>
                                <h4 class="card-title">{{$default->events()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.event.payment.log')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:ticket-outline" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Event Bookings</span>
                        <h6 class="fw-semibold">{{\App\Models\EventDetail::count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Event Bookings calculation
                    $lastWeekEventBookings = \App\Models\EventDetail::where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekEventBookings = \App\Models\EventDetail::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekEventBookings - $previousWeekEventBookings;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.event.payment.log')}}" class="d-block">
            <div class="card card-stats card-primary card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="far fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Event Bookings</p>
                                <h4 class="card-title">{{\App\Models\EventDetail::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif
    @endif

    @if (empty($admin->role) || (!empty($permissions) && in_array('Donation Management', $permissions)))
    @if ($bex->is_donation == 1)
    <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.donation.index', ['language' => $default->code])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:hand-heart" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Causes</span>
                        <h6 class="fw-semibold">{{$default->causes()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Causes calculation
                    $lastWeekCauses = $default->causes()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekCauses = $default->causes()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekCauses - $previousWeekCauses;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.donation.index', ['language' => $default->code])}}" class="d-block">
            <div class="card card-stats card-danger card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Causes</p>
                                <h4 class="card-title">{{$default->causes()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.donation.payment.log')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:hand-coin-outline" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Donations</span>
                        <h6 class="fw-semibold">{{\App\Models\DonationDetail::count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Donations calculation
                    $lastWeekDonations = \App\Models\DonationDetail::where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekDonations = \App\Models\DonationDetail::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekDonations - $previousWeekDonations;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.donation.payment.log')}}" class="d-block">
            <div class="card card-stats card-warning card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-donate"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Donations</p>
                                <h4 class="card-title">{{\App\Models\DonationDetail::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif
    @endif

    @if (empty($admin->role) || (!empty($permissions) && in_array('Tickets', $permissions)))
    @if ($bex->is_ticket == 1)
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.tickets.pending')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:headset" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Pending Support Tickets</span>
                        <h6 class="fw-semibold">{{\App\Models\Ticket::where('status', 'pending')->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Pending Support Tickets calculation
                    $lastWeekPendingTickets = \App\Models\Ticket::where('status', 'pending')->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPendingTickets = \App\Models\Ticket::where('status', 'pending')->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPendingTickets - $previousWeekPendingTickets;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.tickets.pending')}}" class="d-block">
            <div class="card card-stats card-success card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats pl-1">
                            <div class="numbers">
                                <p class="card-category">Pending Support Tickets</p>
                                <h4 class="card-title">{{\App\Models\Ticket::where('status', 'pending')->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.tickets.open')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mdi:headset" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Open Support Tickets</span>
                        <h6 class="fw-semibold">{{\App\Models\Ticket::where('status', 'open')->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                @php
                    // Open Support Tickets calculation
                    $lastWeekOpenTickets = \App\Models\Ticket::where('status', 'open')->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekOpenTickets = \App\Models\Ticket::where('status', 'open')->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekOpenTickets - $previousWeekOpenTickets;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.tickets.open')}}" class="d-block">
            <div class="card card-stats card-dark card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Open Support Tickets</p>
                                <h4 class="card-title">{{\App\Models\Ticket::where('status', 'open')->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif
    @endif

    @if (empty($admin->role) || (!empty($permissions) && in_array('Knowledgebase', $permissions)))
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.article.index', ['language' => $default->code])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Knowledgebase Articles</span>
                        <h6 class="fw-semibold">{{$default->articles()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <!-- static new -->
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.article.index', ['language' => $default->code])}}" class="d-block">
            <div class="card card-stats card-secondary card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats pl-1">
                            <div class="numbers">
                                <p class="card-category">Knowledgebase Articles</p>
                                <h4 class="card-title">{{$default->articles()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif

    @if (empty($admin->role) || (!empty($permissions) && in_array('Content Management', $permissions)))
    <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.job.index', ['language' => $default->code])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Jobs</span>
                        <h6 class="fw-semibold">{{$default->jobs()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <!-- static new -->
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.job.index', ['language' => $default->code])}}" class="d-block">
            <div class="card card-stats card-primary card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats pl-1">
                            <div class="numbers">
                                <p class="card-category">Jobs</p>
                                <h4 class="card-title">{{$default->jobs()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif

    @if (empty($admin->role) || (!empty($permissions) && in_array('Quote Management', $permissions)))
    <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.all.quotes')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Quote Requests</span>
                        <h6 class="fw-semibold">{{\App\Models\Quote::count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <!-- static new -->
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.all.quotes')}}" class="d-block">
            <div class="card card-stats card-danger card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats pl-1">
                            <div class="numbers">
                                <p class="card-category">Quote Requests</p>
                                <h4 class="card-title">{{\App\Models\Quote::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif

    @if (empty($admin->role) || (!empty($permissions) && in_array('Users Management', $permissions)))
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.subscriber.index')}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Subscribers</span>
                        <h6 class="fw-semibold">{{\App\Models\Subscriber::count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <!-- static new -->
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.subscriber.index')}}" class="d-block">
            <div class="card card-stats card-info card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-bell"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats pl-1">
                            <div class="numbers">
                                <p class="card-category">Subscribers</p>
                                <h4 class="card-title">{{\App\Models\Subscriber::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif


    @if (empty($admin->role) || (!empty($permissions) && in_array('RSS Feeds', $permissions)))
     <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.rss.feed', ['language' => $default->code])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">RSS Feeds</span>
                        <h6 class="fw-semibold">{{$default->feed()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <!-- static new -->
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.rss.feed', ['language' => $default->code])}}" class="d-block">
            <div class="card card-stats card-warning card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fas fa-rss"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats pl-1">
                            <div class="numbers">
                                <p class="card-category">RSS Feeds</p>
                                <h4 class="card-title">{{$default->feed()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
    @endif

    @if (empty($admin->role) || (!empty($permissions) && in_array('Content Management', $permissions)))
    <div class="col-xxl-4 col-sm-6">
        <a href="{{route('admin.blog.index', ['language' => $default->code])}}" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Blogs</span>
                        <h6 class="fw-semibold">{{$default->blogs()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <!-- static new -->
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <a href="{{route('admin.blog.index', ['language' => $default->code])}}" class="d-block">
            <div class="card card-stats card-dark card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="fab fa-blogger-b"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats pl-1">
                            <div class="numbers">
                                <p class="card-category">Blogs</p>
                                <h4 class="card-title">{{$default->blogs()->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
     <div class="col-xxl-4 col-sm-6">
        <a href="#" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Projects</span>
                        <h6 class="fw-semibold">{{$default->portfolios()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <!-- static new -->
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-success card-round">
            <div class="card-body ">
                <div class="row">
                    <div class="col-3">
                        <div class="icon-big text-center">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                    <div class="col-9 col-stats">
                        <div class="numbers">
                            <p class="card-category">Projects</p>
                            <h4 class="card-title">{{$default->portfolios()->count()}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
     <div class="col-xxl-4 col-sm-6">
        <a href="#" style="width: 100%;">
            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
              <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                  
                    <div class="d-flex align-items-center gap-2">
                      <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                      </span>
                      <div>
                        <!-- statin new -->
                        <span class="mb-2 fw-medium text-secondary-light text-sm">Services</span>
                        <h6 class="fw-semibold">{{$default->services()->count()}}</h6>
                      </div>
                    </div>
                  
                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <!-- static new -->
                @php
                    $currentPackages = $default->packages()->count();
                    $lastWeekPackages = $default->packages()->where('created_at', '>=', now()->subWeek())->count();
                    $previousWeekPackages = $default->packages()->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
                    $weeklyChange = $lastWeekPackages - $previousWeekPackages;
                    $isPositive = $weeklyChange >= 0;
                @endphp
                <p class="text-sm mb-0">Increase by  <span class="px-1 rounded-2 fw-medium text-sm {{ $isPositive ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">{{ $isPositive ? '+' : '' }}{{ $weeklyChange }}</span> this week</p>
              </div>
            </div>
        </a>    
    </div>
    <!-- <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-secondary card-round">
            <div class="card-body ">
                <div class="row">
                    <div class="col-3">
                        <div class="icon-big text-center">
                            <i class="far fa-users-cog"></i>
                        </div>
                    </div>
                    <div class="col-9 col-stats">
                        <div class="numbers">
                            <p class="card-category">Services</p>
                            <h4 class="card-title">{{$default->services()->count()}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    @endif
</div>

</div>
 <div class="col-xxl-4">
        <div class="row gy-4">
          <div class="col-xxl-12 col-sm-6">
            <div class="card h-100 radius-8 border-0">
              <div class="card-body p-24">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                  <h6 class="mb-2 fw-bold text-lg">Orders</h6>
                  <div class="">
                    <form method="GET">
                      <select name="campaign_range" class="form-select form-select-sm w-auto bg-base border text-secondary-light" onchange="this.form.submit()">
                        @php $__cr = request('campaign_range', 'Yearly'); @endphp
                        <option value="Yearly" {{ $__cr === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                        <option value="Monthly" {{ $__cr === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="Weekly" {{ $__cr === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="Today" {{ $__cr === 'Today' ? 'selected' : '' }}>Today</option>
                      </select>
                    </form>
                  </div>
                </div>
                @php
                  $campaignRange = request('campaign_range', 'Yearly');
                  switch ($campaignRange) {
                    case 'Today':
                      $fromDate = now()->startOfDay();
                      break;
                    case 'Weekly':
                      $fromDate = now()->subWeek();
                      break;
                    case 'Monthly':
                      $fromDate = now()->subMonth();
                      break;
                    case 'Yearly':
                    default:
                      $fromDate = now()->subYear();
                  }
                  // Map existing dashboard entities to the four campaign channels
                  $packageCount = \App\Models\PackageOrder::where('created_at', '>=', $fromDate)->count();
                  $porductCount = \App\Models\ProductOrder::where('created_at', '>=', $fromDate)->count();
                  $campaignTotal = max(0, ($packageCount + $porductCount));
                  $pct = function ($count, $total) { return $total > 0 ? (int) round(($count / $total) * 100) : 0; };
                  $packagePct = $pct($packageCount, $campaignTotal);
                  $porductPct = $pct($porductCount, $campaignTotal);
                @endphp
                
                <div class="mt-3">
                  
                  <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                    <div class="d-flex align-items-center">
                      <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-orange">
                        <iconify-icon icon="mdi:package-variant-closed" class="icon"></iconify-icon>
                      </span>
                      <span class="text-primary-light fw-medium text-sm ps-12">Packages</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 w-100">
                      <div class="w-100 max-w-66 ms-auto">
                        <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Email" aria-valuemin="0" aria-valuemax="100">
                          <div class="progress-bar bg-orange rounded-pill" style="width: {{ $packagePct }}%;"></div>
                        </div>
                      </div>
                      <span class="text-secondary-light font-xs fw-semibold">{{ $packagePct }}%</span>
                    </div>
                  </div>
                  
                  <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                    <div class="d-flex align-items-center">
                      <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-success-main">
                        <iconify-icon icon="mdi:cart-outline" class="icon"></iconify-icon>
                      </span>
                      <span class="text-primary-light fw-medium text-sm ps-12">Product Orders</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 w-100">
                      <div class="w-100 max-w-66 ms-auto">
                        <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Website" aria-valuemin="0" aria-valuemax="100">
                          <div class="progress-bar bg-success-main rounded-pill" style="width: {{ $porductPct }}%;"></div>
                        </div>
                      </div>
                      <span class="text-secondary-light font-xs fw-semibold">{{ $porductPct }}%</span>
                    </div>
                  </div>  

                </div>

              </div>
            </div>
          </div>
          <div class="col-xxl-12 col-sm-6">
            <div class="card h-100 radius-8 border-0 overflow-hidden">
              <div class="card-body p-24">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                  <h6 class="mb-2 fw-bold text-lg">Customer Overview</h6>
                  <div class="">
                    <form method="GET">
                      <select name="customer_range" class="form-select form-select-sm w-auto bg-base border text-secondary-light" onchange="this.form.submit()">
                        @php $__cr = request('customer_range', 'Yearly'); @endphp
                        <option value="Yearly" {{ $__cr === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                        <option value="Monthly" {{ $__cr === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="Weekly" {{ $__cr === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="Today" {{ $__cr === 'Today' ? 'selected' : '' }}>Today</option>
                      </select>
                    </form>
                  </div>
                </div>
                @php
                  $customerRange = request('customer_range', 'Yearly');
                  switch ($customerRange) {
                    case 'Today':
                      $fromDate = now()->startOfDay();
                      break;
                    case 'Weekly':
                      $fromDate = now()->subWeek();
                      break;
                    case 'Monthly':
                      $fromDate = now()->subMonth();
                      break;
                    case 'Yearly':
                    default:
                      $fromDate = now()->subYear();
                  }
                  // Customer metrics based on user registrations and activity
                  $totalCustomers = \App\Models\User::count();
                  $newCustomers = \App\Models\User::where('created_at', '>=', $fromDate)->count();
                  $activeCustomers = \App\Models\User::whereHas('orders', function($query) use ($fromDate) {
                    $query->where('created_at', '>=', $fromDate);
                  })->count();
                @endphp

                <div class="d-flex flex-wrap align-items-center mt-3"> 
                  <ul class="flex-shrink-0">
                    <li class="d-flex align-items-center gap-2 mb-28">
                      <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
                      <span class="text-secondary-light text-sm fw-medium">Total: {{ $totalCustomers }}</span>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-28">
                      <span class="w-12-px h-12-px rounded-circle bg-warning-main"></span>
                      <span class="text-secondary-light text-sm fw-medium">New: {{ $newCustomers }}</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                      <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                      <span class="text-secondary-light text-sm fw-medium">Active: {{ $activeCustomers }}</span>
                    </li>
                  </ul>
                  <div id="donutChart" class="flex-grow-1 apexcharts-tooltip-z-none title-style circle-none"></div>
                </div>
                
              </div>
            </div>
          </div>
          
        </div>
        
      </div> 
      <div class="col-xxl-6 col-xl-12">
        <!-- static new -->
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
              <h6 class="text-lg mb-0">Sales Statistic</h6>
              <form method="GET">
                <select name="sales_range" class="form-select bg-base form-select-sm w-auto" onchange="this.form.submit()">
                  @php $__sr = request('sales_range', 'Yearly'); @endphp
                  <option value="Yearly" {{ $__sr === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                  <option value="Monthly" {{ $__sr === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                  <option value="Weekly" {{ $__sr === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                  <option value="Today" {{ $__sr === 'Today' ? 'selected' : '' }}>Today</option>
                </select>
              </form>
            </div>
            @php
              $salesRange = request('sales_range', 'Yearly');
              switch ($salesRange) {
                case 'Today':
                  $fromDate = now()->startOfDay();
                  $prevFrom = now()->subDay()->startOfDay();
                  $prevTo = now()->startOfDay();
                  break;
                case 'Weekly':
                  $fromDate = now()->subWeek();
                  $prevFrom = now()->subWeeks(2);
                  $prevTo = now()->subWeek();
                  break;
                case 'Monthly':
                  $fromDate = now()->subMonth();
                  $prevFrom = now()->subMonths(2);
                  $prevTo = now()->subMonth();
                  break;
                case 'Yearly':
                default:
                  $fromDate = now()->subYear();
                  $prevFrom = now()->subYears(2);
                  $prevTo = now()->subYear();
              }
              // Calculate current period revenue
              $currentRevenue = \App\Models\PackageOrder::where('created_at', '>=', $fromDate)->sum('package_price') + 
                               \App\Models\ProductOrder::where('created_at', '>=', $fromDate)->sum('total') +
                               \App\Models\CoursePurchase::where('created_at', '>=', $fromDate)->sum('current_price') +
                               \App\Models\EventDetail::where('created_at', '>=', $fromDate)->sum('amount') +
                               \App\Models\DonationDetail::where('created_at', '>=', $fromDate)->sum('amount');
              
              // Calculate previous period revenue
              $previousRevenue = \App\Models\PackageOrder::whereBetween('created_at', [$prevFrom, $prevTo])->sum('package_price') + 
                                \App\Models\ProductOrder::whereBetween('created_at', [$prevFrom, $prevTo])->sum('total') +
                                \App\Models\CoursePurchase::whereBetween('created_at', [$prevFrom, $prevTo])->sum('current_price') +
                                \App\Models\EventDetail::whereBetween('created_at', [$prevFrom, $prevTo])->sum('amount') +
                                \App\Models\DonationDetail::whereBetween('created_at', [$prevFrom, $prevTo])->sum('amount');
              
              // Calculate percentage change
              $revenueChange = $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
              $isPositive = $revenueChange >= 0;
              
              // Calculate daily average
              $days = match($salesRange) {
                'Today' => 1,
                'Weekly' => 7,
                'Monthly' => 30,
                'Yearly' => 365,
                default => 365
              };
              $dailyAverage = $currentRevenue / $days;
            @endphp
            <div class="d-flex flex-wrap align-items-center gap-2 mt-8">
              <h6 class="mb-0">${{ number_format($currentRevenue, 0) }}</h6>
              <span class="text-sm fw-semibold rounded-pill {{ $isPositive ? 'bg-success-focus text-success-main border br-success' : 'bg-danger-focus text-danger-main border br-danger' }} px-8 py-4 line-height-1 d-flex align-items-center gap-1">
                {{ abs(round($revenueChange, 1)) }}% <iconify-icon icon="{{ $isPositive ? 'bxs:up-arrow' : 'bxs:down-arrow' }}" class="text-xs"></iconify-icon>
              </span>
              <span class="text-xs fw-medium">+ ${{ number_format($dailyAverage, 0) }} Per Day</span>
            </div>
            <div id="chart" class="pt-28 apexcharts-tooltip-style-1" style="min-height: 279px;"><div id="apexchartswk6md0gp" class="apexcharts-canvas apexchartswk6md0gp apexcharts-theme-light" style="width: 539px; height: 264px;"><svg id="SvgjsSvg1444" width="539" height="264" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="539" height="264"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 132px;"></div></foreignObject><g id="SvgjsG1535" class="apexcharts-yaxis" rel="0" transform="translate(28.3583984375, 0)"><g id="SvgjsG1536" class="apexcharts-yaxis-texts-g"><text id="SvgjsText1538" font-family="Helvetica, Arial, sans-serif" x="20" y="31.5" text-anchor="end" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1539">$36k</tspan><title>$36k</title></text><text id="SvgjsText1541" font-family="Helvetica, Arial, sans-serif" x="20" y="70.1224" text-anchor="end" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1542">$30k</tspan><title>$30k</title></text><text id="SvgjsText1544" font-family="Helvetica, Arial, sans-serif" x="20" y="108.7448" text-anchor="end" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1545">$24k</tspan><title>$24k</title></text><text id="SvgjsText1547" font-family="Helvetica, Arial, sans-serif" x="20" y="147.3672" text-anchor="end" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1548">$18k</tspan><title>$18k</title></text><text id="SvgjsText1550" font-family="Helvetica, Arial, sans-serif" x="20" y="185.9896" text-anchor="end" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1551">$12k</tspan><title>$12k</title></text><text id="SvgjsText1553" font-family="Helvetica, Arial, sans-serif" x="20" y="224.612" text-anchor="end" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1554">$6k</tspan><title>$6k</title></text></g></g><g id="SvgjsG1446" class="apexcharts-inner apexcharts-graphical" transform="translate(58.3583984375, 30)"><defs id="SvgjsDefs1445"><clipPath id="gridRectMaskwk6md0gp"><rect id="SvgjsRect1450" width="463.693359375" height="196.112" x="-3.5" y="-1.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskwk6md0gp"></clipPath><clipPath id="nonForecastMaskwk6md0gp"></clipPath><clipPath id="gridRectMarkerMaskwk6md0gp"><rect id="SvgjsRect1451" width="460.693359375" height="197.112" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><filter id="SvgjsFilter1457" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood1458" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood1458Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1459" in="SvgjsFeFlood1458Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1459Out"></feComposite><feOffset id="SvgjsFeOffset1460" dx="0" dy="6" result="SvgjsFeOffset1460Out" in="SvgjsFeComposite1459Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1461" stdDeviation="4 " result="SvgjsFeGaussianBlur1461Out" in="SvgjsFeOffset1460Out"></feGaussianBlur><feMerge id="SvgjsFeMerge1462" result="SvgjsFeMerge1462Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode1463" in="SvgjsFeGaussianBlur1461Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode1464" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend1465" in="SourceGraphic" in2="SvgjsFeMerge1462Out" mode="normal" result="SvgjsFeBlend1465Out"></feBlend></filter></defs><rect id="SvgjsRect1449" width="20" height="193.112" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="#487FFF40" class="apexcharts-xcrosshairs" y2="193.112" filter="none" fill-opacity="0.9"></rect><line id="SvgjsLine1470" x1="0" y1="194.112" x2="0" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1471" x1="41.517578125" y1="194.112" x2="41.517578125" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1472" x1="83.03515625" y1="194.112" x2="83.03515625" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1473" x1="124.552734375" y1="194.112" x2="124.552734375" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1474" x1="166.0703125" y1="194.112" x2="166.0703125" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1475" x1="207.587890625" y1="194.112" x2="207.587890625" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1476" x1="249.10546875" y1="194.112" x2="249.10546875" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1477" x1="290.623046875" y1="194.112" x2="290.623046875" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1478" x1="332.140625" y1="194.112" x2="332.140625" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1479" x1="373.658203125" y1="194.112" x2="373.658203125" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1480" x1="415.17578125" y1="194.112" x2="415.17578125" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1481" x1="456.693359375" y1="194.112" x2="456.693359375" y2="200.112" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><g id="SvgjsG1466" class="apexcharts-grid"><g id="SvgjsG1467" class="apexcharts-gridlines-horizontal"><line id="SvgjsLine1483" x1="0" y1="38.6224" x2="456.693359375" y2="38.6224" stroke="#d1d5db" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1484" x1="0" y1="77.2448" x2="456.693359375" y2="77.2448" stroke="#d1d5db" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1485" x1="0" y1="115.8672" x2="456.693359375" y2="115.8672" stroke="#d1d5db" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1486" x1="0" y1="154.4896" x2="456.693359375" y2="154.4896" stroke="#d1d5db" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1468" class="apexcharts-gridlines-vertical"></g><rect id="SvgjsRect1488" width="456.693359375" height="38.6224" x="0" y="0" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none" stroke-dasharray="0" fill="transparent" clip-path="url(#gridRectMaskwk6md0gp)" class="apexcharts-grid-row"></rect><rect id="SvgjsRect1489" width="456.693359375" height="38.6224" x="0" y="38.6224" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none" stroke-dasharray="0" fill="transparent" clip-path="url(#gridRectMaskwk6md0gp)" class="apexcharts-grid-row"></rect><rect id="SvgjsRect1490" width="456.693359375" height="38.6224" x="0" y="77.2448" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none" stroke-dasharray="0" fill="transparent" clip-path="url(#gridRectMaskwk6md0gp)" class="apexcharts-grid-row"></rect><rect id="SvgjsRect1491" width="456.693359375" height="38.6224" x="0" y="115.8672" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none" stroke-dasharray="0" fill="transparent" clip-path="url(#gridRectMaskwk6md0gp)" class="apexcharts-grid-row"></rect><rect id="SvgjsRect1492" width="456.693359375" height="38.6224" x="0" y="154.4896" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none" stroke-dasharray="0" fill="transparent" clip-path="url(#gridRectMaskwk6md0gp)" class="apexcharts-grid-row"></rect><line id="SvgjsLine1494" x1="0" y1="193.112" x2="456.693359375" y2="193.112" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1493" x1="0" y1="1" x2="0" y2="193.112" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1452" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1453" class="apexcharts-series" seriesName="Thisxmonth" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1456" d="M 0 167.36373333333333C 14.53115234375 167.36373333333333 26.98642578125 102.99306666666666 41.517578125 102.99306666666666C 56.04873046875 102.99306666666666 68.50400390625 154.4896 83.03515625 154.4896C 97.56630859375 154.4896 110.02158203124999 38.6224 124.55273437499999 38.6224C 139.08388671875 38.6224 151.53916015625 141.61546666666666 166.0703125 141.61546666666666C 180.60146484375 141.61546666666666 193.05673828124998 6.437066666666652 207.58789062499997 6.437066666666652C 222.11904296874997 6.437066666666652 234.57431640624998 128.74133333333333 249.10546874999997 128.74133333333333C 263.63662109374997 128.74133333333333 276.09189453125 25.748266666666666 290.623046875 25.748266666666666C 305.15419921875 25.748266666666666 317.60947265625 141.61546666666666 332.140625 141.61546666666666C 346.67177734375 141.61546666666666 359.12705078125 70.80773333333332 373.658203125 70.80773333333332C 388.18935546874997 70.80773333333332 400.64462890625 148.05253333333332 415.17578124999994 148.05253333333332C 429.70693359374997 148.05253333333332 442.1622070312499 51.49653333333333 456.69335937499994 51.49653333333333" fill="none" fill-opacity="1" stroke="rgba(72,127,255,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="3" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskwk6md0gp)" filter="url(#SvgjsFilter1457)" pathTo="M 0 167.36373333333333C 14.53115234375 167.36373333333333 26.98642578125 102.99306666666666 41.517578125 102.99306666666666C 56.04873046875 102.99306666666666 68.50400390625 154.4896 83.03515625 154.4896C 97.56630859375 154.4896 110.02158203124999 38.6224 124.55273437499999 38.6224C 139.08388671875 38.6224 151.53916015625 141.61546666666666 166.0703125 141.61546666666666C 180.60146484375 141.61546666666666 193.05673828124998 6.437066666666652 207.58789062499997 6.437066666666652C 222.11904296874997 6.437066666666652 234.57431640624998 128.74133333333333 249.10546874999997 128.74133333333333C 263.63662109374997 128.74133333333333 276.09189453125 25.748266666666666 290.623046875 25.748266666666666C 305.15419921875 25.748266666666666 317.60947265625 141.61546666666666 332.140625 141.61546666666666C 346.67177734375 141.61546666666666 359.12705078125 70.80773333333332 373.658203125 70.80773333333332C 388.18935546874997 70.80773333333332 400.64462890625 148.05253333333332 415.17578124999994 148.05253333333332C 429.70693359374997 148.05253333333332 442.1622070312499 51.49653333333333 456.69335937499994 51.49653333333333" pathFrom="M -1 231.7344 L -1 231.7344 L 41.517578125 231.7344 L 83.03515625 231.7344 L 124.55273437499999 231.7344 L 166.0703125 231.7344 L 207.58789062499997 231.7344 L 249.10546874999997 231.7344 L 290.623046875 231.7344 L 332.140625 231.7344 L 373.658203125 231.7344 L 415.17578124999994 231.7344 L 456.69335937499994 231.7344" fill-rule="evenodd"></path><g id="SvgjsG1454" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1558" r="0" cx="0" cy="0" class="apexcharts-marker w782chexp no-pointer-events" stroke="#ffffff" fill="#008ffb" fill-opacity="1" stroke-width="3" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1455" class="apexcharts-datalabels" data:realIndex="0"></g></g><g id="SvgjsG1469" class="apexcharts-grid-borders"><line id="SvgjsLine1482" x1="0" y1="0" x2="456.693359375" y2="0" stroke="#d1d5db" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1487" x1="0" y1="193.112" x2="456.693359375" y2="193.112" stroke="#d1d5db" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-gridline"></line></g><line id="SvgjsLine1495" x1="0" y1="0" x2="456.693359375" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1496" x1="0" y1="0" x2="456.693359375" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1497" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1498" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText1500" font-family="Helvetica, Arial, sans-serif" x="0" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1501">Jan</tspan><title>Jan</title></text><text id="SvgjsText1503" font-family="Helvetica, Arial, sans-serif" x="41.517578125" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1504">Feb</tspan><title>Feb</title></text><text id="SvgjsText1506" font-family="Helvetica, Arial, sans-serif" x="83.03515625" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1507">Mar</tspan><title>Mar</title></text><text id="SvgjsText1509" font-family="Helvetica, Arial, sans-serif" x="124.552734375" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1510">Apr</tspan><title>Apr</title></text><text id="SvgjsText1512" font-family="Helvetica, Arial, sans-serif" x="166.0703125" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1513">May</tspan><title>May</title></text><text id="SvgjsText1515" font-family="Helvetica, Arial, sans-serif" x="207.587890625" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1516">Jun</tspan><title>Jun</title></text><text id="SvgjsText1518" font-family="Helvetica, Arial, sans-serif" x="249.10546875" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1519">Jul</tspan><title>Jul</title></text><text id="SvgjsText1521" font-family="Helvetica, Arial, sans-serif" x="290.623046875" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1522">Aug</tspan><title>Aug</title></text><text id="SvgjsText1524" font-family="Helvetica, Arial, sans-serif" x="332.140625" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1525">Sep</tspan><title>Sep</title></text><text id="SvgjsText1527" font-family="Helvetica, Arial, sans-serif" x="373.658203125" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1528">Oct</tspan><title>Oct</title></text><text id="SvgjsText1530" font-family="Helvetica, Arial, sans-serif" x="415.17578125" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1531">Nov</tspan><title>Nov</title></text><text id="SvgjsText1533" font-family="Helvetica, Arial, sans-serif" x="456.693359375" y="222.112" text-anchor="middle" dominant-baseline="auto" font-size="14px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1534">Dec</tspan><title>Dec</title></text></g></g><g id="SvgjsG1555" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1556" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1557" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(0, 143, 251);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-xl-6">
        <!-- static new -->
        <div class="card h-100 radius-8 border">
          <div class="card-body p-24">
              <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h6 class="mb-12 fw-semibold text-lg mb-16">Total Subscriber</h6>
                <form method="GET">
                  <select name="subscriber_range" class="form-select bg-base form-select-sm w-auto" onchange="this.form.submit()">
                    @php $__subr = request('subscriber_range', 'Yearly'); @endphp
                    <option value="Yearly" {{ $__subr === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                    <option value="Monthly" {{ $__subr === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Weekly" {{ $__subr === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="Today" {{ $__subr === 'Today' ? 'selected' : '' }}>Today</option>
                  </select>
                </form>
              </div>
              @php
                $subscriberRange = request('subscriber_range', 'Yearly');
                switch ($subscriberRange) {
                  case 'Today':
                    $fromDate = now()->startOfDay();
                    $prevFrom = now()->subDay()->startOfDay();
                    $prevTo = now()->startOfDay();
                    break;
                  case 'Weekly':
                    $fromDate = now()->subWeek();
                    $prevFrom = now()->subWeeks(2);
                    $prevTo = now()->subWeek();
                    break;
                  case 'Monthly':
                    $fromDate = now()->subMonth();
                    $prevFrom = now()->subMonths(2);
                    $prevTo = now()->subMonth();
                    break;
                  case 'Yearly':
                  default:
                    $fromDate = now()->subYear();
                    $prevFrom = now()->subYears(2);
                    $prevTo = now()->subYear();
                }
                
                // Calculate current period subscribers (users with active subscriptions)
                $currentSubscribers = \App\Models\User::whereHas('subscription', function($query) use ($fromDate) {
                  $query->where('created_at', '>=', $fromDate);
                })->count();
                
                // Calculate previous period subscribers
                $previousSubscribers = \App\Models\User::whereHas('subscription', function($query) use ($prevFrom, $prevTo) {
                  $query->whereBetween('created_at', [$prevFrom, $prevTo]);
                })->count();
                
                // Calculate percentage change
                $subscriberChange = $previousSubscribers > 0 ? (($currentSubscribers - $previousSubscribers) / $previousSubscribers) * 100 : 0;
                $isPositive = $subscriberChange >= 0;
                
                // Calculate daily average
                $days = match($subscriberRange) {
                  'Today' => 1,
                  'Weekly' => 7,
                  'Monthly' => 30,
                  'Yearly' => 365,
                  default => 365
                };
                $dailyAverage = $currentSubscribers / $days;
              @endphp
              <div class="d-flex align-items-center gap-2 mb-20">
                  <h6 class="fw-semibold mb-0">{{ number_format($currentSubscribers) }}</h6>
                  <p class="text-sm mb-0">
                      <span class="{{ $isPositive ? 'bg-success-focus text-success-main border br-success' : 'bg-danger-focus text-danger-main border br-danger' }} px-8 py-2 rounded-pill fw-semibold text-sm d-inline-flex align-items-center gap-1">
                          {{ abs(round($subscriberChange, 1)) }}%
                          <iconify-icon icon="{{ $isPositive ? 'bxs:up-arrow' : 'bxs:down-arrow' }}" class="icon"></iconify-icon>  
                      </span> 
                    {{ $isPositive ? '+' : '-' }} {{ number_format($dailyAverage, 0) }} Per Day 
                  </p>
              </div>

              <div id="barChart" class="barChart" style="min-height: 250px;"><div id="apexchartsdmgg4q4m" class="apexcharts-canvas apexchartsdmgg4q4m apexcharts-theme-light" style="width: 232px; height: 235px;"><svg id="SvgjsSvg2355" width="232" height="235" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="232" height="235"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 117.5px;"></div></foreignObject><g id="SvgjsG2458" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2357" class="apexcharts-inner apexcharts-graphical" transform="translate(-10, 20)"><defs id="SvgjsDefs2356"><linearGradient id="SvgjsLinearGradient2359" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2360" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2361" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2362" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMaskdmgg4q4m"><rect id="SvgjsRect2364" width="256" height="187.99519938278198" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskdmgg4q4m"></clipPath><clipPath id="nonForecastMaskdmgg4q4m"></clipPath><clipPath id="gridRectMarkerMaskdmgg4q4m"><rect id="SvgjsRect2365" width="256" height="191.99519938278198" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient2371" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2372" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="0"></stop><stop id="SvgjsStop2373" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop><stop id="SvgjsStop2374" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient2377" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2378" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="0"></stop><stop id="SvgjsStop2379" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop><stop id="SvgjsStop2380" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient2383" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2384" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="0"></stop><stop id="SvgjsStop2385" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop><stop id="SvgjsStop2386" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient2389" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2390" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="0"></stop><stop id="SvgjsStop2391" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop><stop id="SvgjsStop2392" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient2395" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2396" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="0"></stop><stop id="SvgjsStop2397" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop><stop id="SvgjsStop2398" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient2401" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2402" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="0"></stop><stop id="SvgjsStop2403" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop><stop id="SvgjsStop2404" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient2407" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2408" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="0"></stop><stop id="SvgjsStop2409" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop><stop id="SvgjsStop2410" stop-opacity="1" stop-color="rgba(218,229,255,1)" offset="1"></stop></linearGradient></defs><rect id="SvgjsRect2363" width="18.72" height="187.99519938278198" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2359)" class="apexcharts-xcrosshairs" y2="187.99519938278198" filter="none" fill-opacity="0.9"></rect><line id="SvgjsLine2417" x1="0" y1="188.99519938278198" x2="0" y2="194.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine2418" x1="36" y1="188.99519938278198" x2="36" y2="194.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine2419" x1="72" y1="188.99519938278198" x2="72" y2="194.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine2420" x1="108" y1="188.99519938278198" x2="108" y2="194.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine2421" x1="144" y1="188.99519938278198" x2="144" y2="194.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine2422" x1="180" y1="188.99519938278198" x2="180" y2="194.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine2423" x1="216" y1="188.99519938278198" x2="216" y2="194.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine2424" x1="252" y1="188.99519938278198" x2="252" y2="194.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><g id="SvgjsG2413" class="apexcharts-grid"><g id="SvgjsG2414" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2425" x1="0" y1="0" x2="252" y2="0" stroke="#d1d5db" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2426" x1="0" y1="46.998799845695494" x2="252" y2="46.998799845695494" stroke="#d1d5db" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2427" x1="0" y1="93.99759969139099" x2="252" y2="93.99759969139099" stroke="#d1d5db" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2428" x1="0" y1="140.9963995370865" x2="252" y2="140.9963995370865" stroke="#d1d5db" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2429" x1="0" y1="187.99519938278198" x2="252" y2="187.99519938278198" stroke="#d1d5db" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG2415" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2431" x1="0" y1="187.99519938278198" x2="252" y2="187.99519938278198" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine2430" x1="0" y1="1" x2="0" y2="187.99519938278198" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG2366" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2367" class="apexcharts-series" rel="1" seriesName="Sales" data:realIndex="0"><path id="SvgjsPath2376" d="M 8.64 181.99619938278198 L 8.64 52.999799845695485 C 8.64 49.999799845695485 11.64 46.999799845695485 14.64 46.999799845695485 L 21.36 46.999799845695485 C 24.36 46.999799845695485 27.36 49.999799845695485 27.36 52.999799845695485 L 27.36 181.99619938278198 C 27.36 184.99619938278198 24.36 187.99619938278198 21.36 187.99619938278198 L 14.64 187.99619938278198 C 11.64 187.99619938278198 8.64 184.99619938278198 8.64 181.99619938278198 Z " fill="url(#SvgjsLinearGradient2371)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdmgg4q4m)" pathTo="M 8.64 181.99619938278198 L 8.64 52.999799845695485 C 8.64 49.999799845695485 11.64 46.999799845695485 14.64 46.999799845695485 L 21.36 46.999799845695485 C 24.36 46.999799845695485 27.36 49.999799845695485 27.36 52.999799845695485 L 27.36 181.99619938278198 C 27.36 184.99619938278198 24.36 187.99619938278198 21.36 187.99619938278198 L 14.64 187.99619938278198 C 11.64 187.99619938278198 8.64 184.99619938278198 8.64 181.99619938278198 Z " pathFrom="M 8.64 187.99619938278198 L 8.64 187.99619938278198 L 27.36 187.99619938278198 L 27.36 187.99619938278198 L 27.36 187.99619938278198 L 27.36 187.99619938278198 L 27.36 187.99619938278198 L 8.64 187.99619938278198 Z" cy="46.99879984569549" cx="44.64" j="0" val="15" barHeight="140.9963995370865" barWidth="18.72"></path><path id="SvgjsPath2382" d="M 44.64 181.99619938278198 L 44.64 81.1990797531128 C 44.64 78.1990797531128 47.64 75.1990797531128 50.64 75.1990797531128 L 57.36 75.1990797531128 C 60.36 75.1990797531128 63.36 78.1990797531128 63.36 81.1990797531128 L 63.36 181.99619938278198 C 63.36 184.99619938278198 60.36 187.99619938278198 57.36 187.99619938278198 L 50.64 187.99619938278198 C 47.64 187.99619938278198 44.64 184.99619938278198 44.64 181.99619938278198 Z " fill="url(#SvgjsLinearGradient2377)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdmgg4q4m)" pathTo="M 44.64 181.99619938278198 L 44.64 81.1990797531128 C 44.64 78.1990797531128 47.64 75.1990797531128 50.64 75.1990797531128 L 57.36 75.1990797531128 C 60.36 75.1990797531128 63.36 78.1990797531128 63.36 81.1990797531128 L 63.36 181.99619938278198 C 63.36 184.99619938278198 60.36 187.99619938278198 57.36 187.99619938278198 L 50.64 187.99619938278198 C 47.64 187.99619938278198 44.64 184.99619938278198 44.64 181.99619938278198 Z " pathFrom="M 44.64 187.99619938278198 L 44.64 187.99619938278198 L 63.36 187.99619938278198 L 63.36 187.99619938278198 L 63.36 187.99619938278198 L 63.36 187.99619938278198 L 63.36 187.99619938278198 L 44.64 187.99619938278198 Z" cy="75.1980797531128" cx="80.64" j="1" val="12" barHeight="112.79711962966918" barWidth="18.72"></path><path id="SvgjsPath2388" d="M 80.64 181.99619938278198 L 80.64 24.800519938278196 C 80.64 21.800519938278196 83.64 18.800519938278196 86.64 18.800519938278196 L 93.36 18.800519938278196 C 96.36 18.800519938278196 99.36 21.800519938278196 99.36 24.800519938278196 L 99.36 181.99619938278198 C 99.36 184.99619938278198 96.36 187.99619938278198 93.36 187.99619938278198 L 86.64 187.99619938278198 C 83.64 187.99619938278198 80.64 184.99619938278198 80.64 181.99619938278198 Z " fill="url(#SvgjsLinearGradient2383)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdmgg4q4m)" pathTo="M 80.64 181.99619938278198 L 80.64 24.800519938278196 C 80.64 21.800519938278196 83.64 18.800519938278196 86.64 18.800519938278196 L 93.36 18.800519938278196 C 96.36 18.800519938278196 99.36 21.800519938278196 99.36 24.800519938278196 L 99.36 181.99619938278198 C 99.36 184.99619938278198 96.36 187.99619938278198 93.36 187.99619938278198 L 86.64 187.99619938278198 C 83.64 187.99619938278198 80.64 184.99619938278198 80.64 181.99619938278198 Z " pathFrom="M 80.64 187.99619938278198 L 80.64 187.99619938278198 L 99.36 187.99619938278198 L 99.36 187.99619938278198 L 99.36 187.99619938278198 L 99.36 187.99619938278198 L 99.36 187.99619938278198 L 80.64 187.99619938278198 Z" cy="18.799519938278195" cx="116.64" j="2" val="18" barHeight="169.19567944450378" barWidth="18.72"></path><path id="SvgjsPath2394" d="M 116.64 181.99619938278198 L 116.64 6.001 C 116.64 3.0010000000000003 119.64 0.001 122.64 0.001 L 129.36 0.001 C 132.36 0.001 135.36 3.001 135.36 6.001 L 135.36 181.99619938278198 C 135.36 184.99619938278198 132.36 187.99619938278198 129.36 187.99619938278198 L 122.64 187.99619938278198 C 119.64 187.99619938278198 116.64 184.99619938278198 116.64 181.99619938278198 Z " fill="url(#SvgjsLinearGradient2389)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdmgg4q4m)" pathTo="M 116.64 181.99619938278198 L 116.64 6.001 C 116.64 3.0010000000000003 119.64 0.001 122.64 0.001 L 129.36 0.001 C 132.36 0.001 135.36 3.001 135.36 6.001 L 135.36 181.99619938278198 C 135.36 184.99619938278198 132.36 187.99619938278198 129.36 187.99619938278198 L 122.64 187.99619938278198 C 119.64 187.99619938278198 116.64 184.99619938278198 116.64 181.99619938278198 Z " pathFrom="M 116.64 187.99619938278198 L 116.64 187.99619938278198 L 135.36 187.99619938278198 L 135.36 187.99619938278198 L 135.36 187.99619938278198 L 135.36 187.99619938278198 L 135.36 187.99619938278198 L 116.64 187.99619938278198 Z" cy="0" cx="152.64" j="3" val="20" barHeight="187.99519938278198" barWidth="18.72"></path><path id="SvgjsPath2400" d="M 152.64 181.99619938278198 L 152.64 71.79931978397369 C 152.64 68.79931978397369 155.64 65.79931978397369 158.64 65.79931978397369 L 165.35999999999999 65.79931978397369 C 168.35999999999999 65.79931978397369 171.35999999999999 68.79931978397369 171.35999999999999 71.79931978397369 L 171.35999999999999 181.99619938278198 C 171.35999999999999 184.99619938278198 168.35999999999999 187.99619938278198 165.35999999999999 187.99619938278198 L 158.64 187.99619938278198 C 155.64 187.99619938278198 152.64 184.99619938278198 152.64 181.99619938278198 Z " fill="url(#SvgjsLinearGradient2395)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdmgg4q4m)" pathTo="M 152.64 181.99619938278198 L 152.64 71.79931978397369 C 152.64 68.79931978397369 155.64 65.79931978397369 158.64 65.79931978397369 L 165.35999999999999 65.79931978397369 C 168.35999999999999 65.79931978397369 171.35999999999999 68.79931978397369 171.35999999999999 71.79931978397369 L 171.35999999999999 181.99619938278198 C 171.35999999999999 184.99619938278198 168.35999999999999 187.99619938278198 165.35999999999999 187.99619938278198 L 158.64 187.99619938278198 C 155.64 187.99619938278198 152.64 184.99619938278198 152.64 181.99619938278198 Z " pathFrom="M 152.64 187.99619938278198 L 152.64 187.99619938278198 L 171.35999999999999 187.99619938278198 L 171.35999999999999 187.99619938278198 L 171.35999999999999 187.99619938278198 L 171.35999999999999 187.99619938278198 L 171.35999999999999 187.99619938278198 L 152.64 187.99619938278198 Z" cy="65.79831978397368" cx="188.64" j="4" val="13" barHeight="122.1968795988083" barWidth="18.72"></path><path id="SvgjsPath2406" d="M 188.64 181.99619938278198 L 188.64 43.60003987655639 C 188.64 40.60003987655639 191.64 37.60003987655639 194.64 37.60003987655639 L 201.35999999999999 37.60003987655639 C 204.35999999999999 37.60003987655639 207.35999999999999 40.60003987655639 207.35999999999999 43.60003987655639 L 207.35999999999999 181.99619938278198 C 207.35999999999999 184.99619938278198 204.35999999999999 187.99619938278198 201.35999999999999 187.99619938278198 L 194.64 187.99619938278198 C 191.64 187.99619938278198 188.64 184.99619938278198 188.64 181.99619938278198 Z " fill="url(#SvgjsLinearGradient2401)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdmgg4q4m)" pathTo="M 188.64 181.99619938278198 L 188.64 43.60003987655639 C 188.64 40.60003987655639 191.64 37.60003987655639 194.64 37.60003987655639 L 201.35999999999999 37.60003987655639 C 204.35999999999999 37.60003987655639 207.35999999999999 40.60003987655639 207.35999999999999 43.60003987655639 L 207.35999999999999 181.99619938278198 C 207.35999999999999 184.99619938278198 204.35999999999999 187.99619938278198 201.35999999999999 187.99619938278198 L 194.64 187.99619938278198 C 191.64 187.99619938278198 188.64 184.99619938278198 188.64 181.99619938278198 Z " pathFrom="M 188.64 187.99619938278198 L 188.64 187.99619938278198 L 207.35999999999999 187.99619938278198 L 207.35999999999999 187.99619938278198 L 207.35999999999999 187.99619938278198 L 207.35999999999999 187.99619938278198 L 207.35999999999999 187.99619938278198 L 188.64 187.99619938278198 Z" cy="37.59903987655639" cx="224.64" j="5" val="16" barHeight="150.3961595062256" barWidth="18.72"></path><path id="SvgjsPath2412" d="M 224.64 181.99619938278198 L 224.64 137.5976395679474 C 224.64 134.5976395679474 227.64 131.5976395679474 230.64 131.5976395679474 L 237.35999999999999 131.5976395679474 C 240.35999999999999 131.5976395679474 243.35999999999999 134.5976395679474 243.35999999999999 137.5976395679474 L 243.35999999999999 181.99619938278198 C 243.35999999999999 184.99619938278198 240.35999999999999 187.99619938278198 237.35999999999999 187.99619938278198 L 230.64 187.99619938278198 C 227.64 187.99619938278198 224.64 184.99619938278198 224.64 181.99619938278198 Z " fill="url(#SvgjsLinearGradient2407)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdmgg4q4m)" pathTo="M 224.64 181.99619938278198 L 224.64 137.5976395679474 C 224.64 134.5976395679474 227.64 131.5976395679474 230.64 131.5976395679474 L 237.35999999999999 131.5976395679474 C 240.35999999999999 131.5976395679474 243.35999999999999 134.5976395679474 243.35999999999999 137.5976395679474 L 243.35999999999999 181.99619938278198 C 243.35999999999999 184.99619938278198 240.35999999999999 187.99619938278198 237.35999999999999 187.99619938278198 L 230.64 187.99619938278198 C 227.64 187.99619938278198 224.64 184.99619938278198 224.64 181.99619938278198 Z " pathFrom="M 224.64 187.99619938278198 L 224.64 187.99619938278198 L 243.35999999999999 187.99619938278198 L 243.35999999999999 187.99619938278198 L 243.35999999999999 187.99619938278198 L 243.35999999999999 187.99619938278198 L 243.35999999999999 187.99619938278198 L 224.64 187.99619938278198 Z" cy="131.5966395679474" cx="260.64" j="6" val="6" barHeight="56.39855981483459" barWidth="18.72"></path><g id="SvgjsG2369" class="apexcharts-bar-goals-markers" style="pointer-events: none"><g id="SvgjsG2375" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskdmgg4q4m)"></g><g id="SvgjsG2381" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskdmgg4q4m)"></g><g id="SvgjsG2387" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskdmgg4q4m)"></g><g id="SvgjsG2393" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskdmgg4q4m)"></g><g id="SvgjsG2399" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskdmgg4q4m)"></g><g id="SvgjsG2405" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskdmgg4q4m)"></g><g id="SvgjsG2411" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskdmgg4q4m)"></g></g><g id="SvgjsG2370" class="apexcharts-bar-shadows apexcharts-hidden-element-shown" style="pointer-events: none"></g></g><g id="SvgjsG2368" class="apexcharts-datalabels apexcharts-hidden-element-shown" data:realIndex="0"></g></g><g id="SvgjsG2416" class="apexcharts-grid-borders" style="display: none;"></g><line id="SvgjsLine2432" x1="0" y1="0" x2="252" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2433" x1="0" y1="0" x2="252" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2434" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2435" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText2437" font-family="Helvetica, Arial, sans-serif" x="18" y="216.99519938278198" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2438">Sun</tspan><title>Sun</title></text><text id="SvgjsText2440" font-family="Helvetica, Arial, sans-serif" x="54" y="216.99519938278198" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2441">Mon</tspan><title>Mon</title></text><text id="SvgjsText2443" font-family="Helvetica, Arial, sans-serif" x="90" y="216.99519938278198" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2444">Tue</tspan><title>Tue</title></text><text id="SvgjsText2446" font-family="Helvetica, Arial, sans-serif" x="126" y="216.99519938278198" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2447">Wed</tspan><title>Wed</title></text><text id="SvgjsText2449" font-family="Helvetica, Arial, sans-serif" x="162" y="216.99519938278198" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2450">Thu</tspan><title>Thu</title></text><text id="SvgjsText2452" font-family="Helvetica, Arial, sans-serif" x="198" y="216.99519938278198" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2453">Fri</tspan><title>Fri</title></text><text id="SvgjsText2455" font-family="Helvetica, Arial, sans-serif" x="234" y="216.99519938278198" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2456">Sat</tspan><title>Sat</title></text></g><line id="SvgjsLine2457" x1="0" y1="188.99519938278198" x2="252" y2="188.99519938278198" stroke="#e0e0e0" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"></line></g><g id="SvgjsG2459" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2460" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2461" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(0, 143, 251);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
            
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-xl-6">
        <!-- static new -->
        <div class="card h-100 radius-8 border-0 overflow-hidden">
          <div class="card-body p-24">
            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
              <h6 class="mb-2 fw-bold text-lg">Users Overview</h6>
              <form method="GET">
                <select name="users_overview_range" class="form-select form-select-sm w-auto bg-base border text-secondary-light" onchange="this.form.submit()">
                  @php $__uor = request('users_overview_range', 'Yearly'); @endphp
                  <option value="Yearly" {{ $__uor === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                  <option value="Monthly" {{ $__uor === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                  <option value="Weekly" {{ $__uor === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                  <option value="Today" {{ $__uor === 'Today' ? 'selected' : '' }}>Today</option>
                </select>
              </form>
            </div>
            @php
              $usersOverviewRange = request('users_overview_range', 'Yearly');
              switch ($usersOverviewRange) {
                case 'Today':
                  $fromDate = now()->startOfDay();
                  break;
                case 'Weekly':
                  $fromDate = now()->subWeek();
                  break;
                case 'Monthly':
                  $fromDate = now()->subMonth();
                  break;
                case 'Yearly':
                default:
                  $fromDate = now()->subYear();
              }
              
              // Calculate user statistics
              $totalUsers = \App\Models\User::count();
              $newUsers = \App\Models\User::where('created_at', '>=', $fromDate)->count();
              $subscribedUsers = \App\Models\User::whereHas('subscription')->count();
              $activeUsers = \App\Models\User::whereHas('orders', function($query) use ($fromDate) {
                $query->where('created_at', '>=', $fromDate);
              })->orWhereHas('courseOrder', function($query) use ($fromDate) {
                $query->where('created_at', '>=', $fromDate);
              })->orWhereHas('donation_details', function($query) use ($fromDate) {
                $query->where('created_at', '>=', $fromDate);
              })->orWhereHas('event_details', function($query) use ($fromDate) {
                $query->where('created_at', '>=', $fromDate);
              })->count();
            @endphp


            <div id="userOverviewDonutChart" class="apexcharts-tooltip-z-none" style="min-height: 271px;"><div id="apexcharts315b2y8a" class="apexcharts-canvas apexcharts315b2y8a apexcharts-theme-light" style="width: 233px; height: 271px;"><svg id="SvgjsSvg2462" width="233" height="271" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="233" height="271"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"></div></foreignObject><g id="SvgjsG2464" class="apexcharts-inner apexcharts-graphical" transform="translate(-18.5, 0)"><defs id="SvgjsDefs2463"><clipPath id="gridRectMask315b2y8a"><rect id="SvgjsRect2465" width="274" height="270" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask315b2y8a"></clipPath><clipPath id="nonForecastMask315b2y8a"></clipPath><clipPath id="gridRectMarkerMask315b2y8a"><rect id="SvgjsRect2466" width="274" height="274" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG2467" class="apexcharts-pie"><g id="SvgjsG2468" transform="translate(0, 0) scale(1)"><circle id="SvgjsCircle2469" r="85.60975609756099" cx="135" cy="135" fill="transparent"></circle><g id="SvgjsG2470" class="apexcharts-slices"><g id="SvgjsG2471" class="apexcharts-series apexcharts-pie-series" seriesName="Active" rel="1" data:realIndex="0"><path id="SvgjsPath2472" d="M 135 3.292682926829258 A 131.70731707317074 131.70731707317074 0 0 1 249.0618824496578 200.85365853658536 L 209.14022359227755 177.8048780487805 A 85.60975609756099 85.60975609756099 0 0 0 135 49.39024390243901 L 135 3.292682926829258 z" fill="rgba(255,159,41,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-0" index="0" j="0" data:angle="120" data:startAngle="0" data:strokeWidth="0" data:value="500" data:pathOrig="M 135 3.292682926829258 A 131.70731707317074 131.70731707317074 0 0 1 249.0618824496578 200.85365853658536 L 209.14022359227755 177.8048780487805 A 85.60975609756099 85.60975609756099 0 0 0 135 49.39024390243901 L 135 3.292682926829258 z"></path></g><g id="SvgjsG2473" class="apexcharts-series apexcharts-pie-series" seriesName="New" rel="2" data:realIndex="1"><path id="SvgjsPath2474" d="M 249.0618824496578 200.85365853658536 A 131.70731707317074 131.70731707317074 0 0 1 20.938117550342213 200.85365853658536 L 60.859776407722435 177.8048780487805 A 85.60975609756099 85.60975609756099 0 0 0 209.14022359227755 177.8048780487805 L 249.0618824496578 200.85365853658536 z" fill="rgba(72,127,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-1" index="0" j="1" data:angle="120" data:startAngle="120" data:strokeWidth="0" data:value="500" data:pathOrig="M 249.0618824496578 200.85365853658536 A 131.70731707317074 131.70731707317074 0 0 1 20.938117550342213 200.85365853658536 L 60.859776407722435 177.8048780487805 A 85.60975609756099 85.60975609756099 0 0 0 209.14022359227755 177.8048780487805 L 249.0618824496578 200.85365853658536 z"></path></g><g id="SvgjsG2475" class="apexcharts-series apexcharts-pie-series" seriesName="Total" rel="3" data:realIndex="2"><path id="SvgjsPath2476" d="M 20.938117550342213 200.85365853658536 A 131.70731707317074 131.70731707317074 0 0 1 134.97701273679775 3.292684932846413 L 134.98505827891853 49.39024520635016 A 85.60975609756099 85.60975609756099 0 0 0 60.859776407722435 177.8048780487805 L 20.938117550342213 200.85365853658536 z" fill="rgba(228,241,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-2" index="0" j="2" data:angle="120" data:startAngle="240" data:strokeWidth="0" data:value="500" data:pathOrig="M 20.938117550342213 200.85365853658536 A 131.70731707317074 131.70731707317074 0 0 1 134.97701273679775 3.292684932846413 L 134.98505827891853 49.39024520635016 A 85.60975609756099 85.60975609756099 0 0 0 60.859776407722435 177.8048780487805 L 20.938117550342213 200.85365853658536 z"></path></g></g></g></g><line id="SvgjsLine2477" x1="0" y1="0" x2="270" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2478" x1="0" y1="0" x2="270" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g></svg><div class="apexcharts-tooltip apexcharts-theme-dark"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 41);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(72, 127, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 3;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(228, 241, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>

            <ul class="d-flex flex-wrap align-items-center justify-content-between mt-3 gap-3">
              <li class="d-flex align-items-center gap-2">
                  <span class="w-12-px h-12-px radius-2 bg-primary-600"></span>
                  <span class="text-secondary-light text-sm fw-normal">New: 
                      <span class="text-primary-light fw-semibold">{{ number_format($newUsers) }}</span>
                  </span>
              </li>
              <li class="d-flex align-items-center gap-2">
                  <span class="w-12-px h-12-px radius-2 bg-yellow"></span>
                  <span class="text-secondary-light text-sm fw-normal">Subscribed:  
                      <span class="text-primary-light fw-semibold">{{ number_format($subscribedUsers) }}</span>
                  </span>
              </li>
              <li class="d-flex align-items-center gap-2">
                  <span class="w-12-px h-12-px radius-2 bg-success"></span>
                  <span class="text-secondary-light text-sm fw-normal">Active:  
                      <span class="text-primary-light fw-semibold">{{ number_format($activeUsers) }}</span>
                  </span>
              </li>
              <li class="d-flex align-items-center gap-2">
                  <span class="w-12-px h-12-px radius-2 bg-secondary"></span>
                  <span class="text-secondary-light text-sm fw-normal">Total:  
                      <span class="text-primary-light fw-semibold">{{ number_format($totalUsers) }}</span>
                  </span>
              </li>
            </ul>
            
          </div>
        </div>
      </div>
      <div class="col-xxl-9 col-xl-12">
        <!-- static new -->
        <div class="card h-100 mt-3">
            <div class="card-body p-24">

              <div class="d-flex flex-wrap align-items-center gap-1 justify-content-between mb-16">
                <ul class="nav border-gradient-tab nav-pills mb-0" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center active" id="pills-to-do-list-tab" data-bs-toggle="pill" data-bs-target="#pills-to-do-list" type="button" role="tab" aria-controls="pills-to-do-list" aria-selected="true">
                      Quote Requests 
                      <span class="text-sm fw-semibold py-6 px-12 bg-neutral-500 rounded-pill text-white line-height-1 ms-12 notification-alert">{{ \App\Models\Quote::count() }}</span>
                    </button>
                  </li>
                </ul>
                <a href="{{ route('admin.all.quotes') }}" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                  View All
                  <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                </a>
              </div>

              <div class="tab-content" id="pills-tabContent">   
                <div class="tab-pane fade show active" id="pills-to-do-list" role="tabpanel" aria-labelledby="pills-to-do-list-tab" tabindex="0">
                  <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                      <thead>
                        <tr>
                          <th scope="col">Client</th>
                          <th scope="col">Requested On</th>
                          <th scope="col">Service</th>
                          <th scope="col" class="text-center">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $latestQuotes = \App\Models\Quote::orderBy('created_at', 'DESC')->limit(5)->get();
                        @endphp
                        @forelse($latestQuotes as $quote)
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">{{ $quote->name }}</h6>
                                <span class="text-sm text-secondary-light fw-medium">{{ $quote->email }}</span>
                              </div>
                            </div>
                          </td>
                          <td>{{ $quote->created_at->format('d M Y') }}</td>
                          <td>
                            @php
                              $fields = json_decode($quote->fields, true);
                              $serviceField = collect($fields)->first(function($field) {
                                return isset($field['value']) && !empty($field['value']);
                              });
                            @endphp
                            {{ $serviceField ? Str::limit($serviceField['value'], 20) : 'N/A' }}
                          </td>
                          <td class="text-center">
                            @if($quote->status == 0)
                              <span class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">Pending</span>
                            @elseif($quote->status == 1)
                              <span class="bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm">Processing</span>
                            @elseif($quote->status == 2)
                              <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Completed</span>
                            @elseif($quote->status == 3)
                              <span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Rejected</span>
                            @endif
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4" class="text-center py-4">
                            <span class="text-secondary">No quote requests found</span>
                          </td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-recent-leads" role="tabpanel" aria-labelledby="pills-recent-leads-tab" tabindex="0">
                  <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                      <thead>
                        <tr>
                          <th scope="col">Client</th>
                          <th scope="col">Requested On</th>
                          <th scope="col">Service</th>
                          <th scope="col" class="text-center">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $pendingQuotes = \App\Models\Quote::where('status', 0)->orderBy('created_at', 'DESC')->limit(5)->get();
                        @endphp
                        @forelse($pendingQuotes as $quote)
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">{{ $quote->name }}</h6>
                                <span class="text-sm text-secondary-light fw-medium">{{ $quote->email }}</span>
                              </div>
                            </div>
                          </td>
                          <td>{{ $quote->created_at->format('d M Y') }}</td>
                          <td>
                            @php
                              $fields = json_decode($quote->fields, true);
                              $serviceField = collect($fields)->first(function($field) {
                                return isset($field['value']) && !empty($field['value']);
                              });
                            @endphp
                            {{ $serviceField ? Str::limit($serviceField['value'], 20) : 'N/A' }}
                          </td>
                          <td class="text-center">
                            <span class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">Pending</span>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4" class="text-center py-4">
                            <span class="text-secondary">No pending quote requests found</span>
                          </td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>

    </div>
   <div class="row mt-3">
    <div class="col-lg-6 mt-3">
        <div class="row row-card-no-pd">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="padding: 15px !important;">
                        <div class="card-head-row">
                            <h4 class="card-title">Recent Quotations</h4>
                        </div>
                        <p class="card-category text-light ">
                            Top 10 latest quotation request
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                @if (count($quotes) == 0)
                                <h3 class="text-center">NO QUOTE REQUEST FOUND</h3>
                                @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Deatails</th>
                                                <th scope="col">Mail</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quotes as $key => $quote)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#detailsModal{{$quote->id}}"><i class="fas fa-eye"></i> View</button>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-primary btn-sm editbtn" data-target="#mailModal" data-toggle="modal" data-email="{{$quote->email}}"><i class="far fa-envelope"></i> Send</a>
                                                </td>
                                                <td>
                                                    <form class="deleteform d-inline-block" action="{{route('admin.quote.delete')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="quote_id" value="{{$quote->id}}">
                                                        <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                                        <span class="btn-label">
                                                        <i class="fas fa-trash"></i>
                                                        </span>
                                                        Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @includeif('admin.quote.quote-details')
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-6 mt-3">
        <div class="card h-100">
          <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
            <h6 class="text-lg fw-semibold mb-0">Top Packages</h6>
            <a href="{{ route('admin.package.index', ['language' => $default->code]) }}" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
              Top 10 packages by orders
              <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
            </a>
          </div>
          <div class="card-body p-24">
            <div class="table-responsive scroll-sm">
              <table class="table bordered-table mb-0">
                <thead>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Price</th>
                    <th scope="col">Orders</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $topPackages = \App\Models\Package::withCount('package_orders')
                      ->orderBy('package_orders_count', 'DESC')
                      ->limit(10)
                      ->get();
                  @endphp
                  @forelse($topPackages as $package)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="flex-grow-1">
                            <h6 class="text-md mb-0 fw-medium">{{ Str::limit($package->title, 25) }}</h6>
                            <span class="text-sm text-secondary-light fw-medium">{{ $package->packageCategory->name ?? 'No Category' }}</span>
                          </div>
                        </div>
                      </td>
                      <td>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} {{round($package->price,2)}} {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>
                      <td>
                        <span class="bg-primary-focus text-primary-main px-24 py-4 rounded-pill fw-medium text-sm">{{ $package->package_orders_count }}</span>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('admin.package.edit', ['id' => $package->id, 'language' => $package->language->code])}}" target="_blank">Edit</a>
                            <a class="dropdown-item" href="{{route('admin.all.orders')}}?package={{$package->id}}" target="_blank">View Orders</a>
                            <form class="deleteform d-block" action="{{route('admin.package.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="package_id" value="{{$package->id}}">
                              <button type="submit" class="deletebtn">
                                Delete
                              </button>
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center py-4">
                        <span class="text-secondary">No packages found</span>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    <!-- <div class="col-lg-6">
        <div class="row row-card-no-pd">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <h4 class="card-title">Product Orders</h4>
                        </div>
                        <p class="card-category">
                            Top 10 latest orders
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($porders as $key => $porder)
                                            <tr>
                                                <td>#{{$porder->order_number}}</td>
                                                <td>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} {{round($porder->total,2)}} {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>

                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="{{route('admin.product.details', $porder->id)}}" target="_blank">Details</a>
                                                            <a class="dropdown-item" href="{{asset('assets/front/invoices/product/'.$porder->invoice_number)}}" target="_blank">Invoice</a>
                                                            <form class="deleteform d-block" action="{{route('admin.product.order.delete')}}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="order_id" value="{{$porder->id}}">
                                                                <button type="submit" class="deletebtn">
                                                                Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
<!-- Send Mail Modal -->
<div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Send Mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ajaxEditForm" class="" action="{{route('admin.quotes.mail')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Client Mail **</label>
                        <input id="inemail" type="text" class="form-control" name="email" value="" placeholder="Enter email">
                        <p id="eerremail" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                        <label for="">Subject **</label>
                        <input id="insubject" type="text" class="form-control" name="subject" value="" placeholder="Enter subject">
                        <p id="eerrsubject" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                        <label for="">Message **</label>
                        <textarea id="inmessage" class="form-control nic-edit" name="message" rows="5" cols="80" placeholder="Enter message"></textarea>
                        <p id="eerrmessage" class="mb-0 text-danger em"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="updateBtn" type="button" class="btn btn-primary">Send Mail</button>
            </div>
        </div>
    </div>
</div>
@endsection
