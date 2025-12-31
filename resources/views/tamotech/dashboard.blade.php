@extends('tamotech.layout.index')
@section('title')
    {{__('main.home')}}
@endsection
@section('content')
    <div class="card p-3">
        <div class="row">
            <!-- sliders -->


            <!-- Governorates -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-warning">
                        <i class="ti ti-map-pin ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['governorates'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.governorates") }}</p>
                    </div>
                </div>
            </div>

            <!-- Areas -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-warning">
                        <i class="ti ti-map-search ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['areas'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.areas") }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-slideshow ti-md"></i>
                            </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['sliders'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.sliders") }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-warning">
                        <i class="ti ti-help-circle ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['faqs'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.faqs") }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-warning">
                        <i class="ti ti-alert-circle ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['reasons'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.reason_cancellations") }}</p>
                    </div>
                </div>
            </div>
            <!-- Main Categories -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-orange">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-orange">
                        <i class="ti ti-category ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['main_categories'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.main_categories") }}</p>
                    </div>
                </div>
            </div>

            <!-- Sub Categories -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-orange">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-orange">
                        <i class="ti ti-layout-grid ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['sub_categories'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.sub_categories") }}</p>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="ti ti-shopping-bag ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['products'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.products") }}</p>
                    </div>
                </div>
            </div>

            <!-- Coupons -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-info">
                        <i class="ti ti-discount-2 ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['coupons'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.coupons") }}</p>
                    </div>
                </div>
            </div>

            <!-- Users -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-info">
                        <i class="ti ti-users ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['clients'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.users") }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-info">
                        <i class="ti ti-truck-delivery ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['drivers'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.drivers") }}</p>
                    </div>
                </div>
            </div>

            <!-- New Orders -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-purple">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-purple">
                        <i class="ti ti-shopping-cart-plus ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['new_orders'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.new_orders") }}</p>
                    </div>
                </div>
            </div>

            <!-- Current Orders -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-purple">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-purple">
                        <i class="ti ti-truck-delivery ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['current_orders'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.current_orders") }}</p>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-purple">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-purple">
                        <i class="ti ti-check ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['complete_orders'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.complete_orders") }}</p>
                    </div>
                </div>
            </div>

            <!-- Canceled Orders -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-danger">
                        <i class="ti ti-circle-x ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['canceled_orders'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.canceled_orders") }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Profits -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="ti ti-cash ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['total_profits'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.total_profits") }}</p>
                    </div>
                </div>
            </div>

            <!-- Daily Profits -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="ti ti-calendar-day ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['total_profits_daily'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.total_profits_daily") }}</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Profits -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="ti ti-calendar-month ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['total_profits_monthly'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.total_profits_monthly") }}</p>
                    </div>
                </div>
            </div>

            <!-- Yearly Profits -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="ti ti-calendar ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['total_profits_yearly'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.total_profits_yearly") }}</p>
                    </div>
                </div>
            </div>

            <!-- App Commissions -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-dark">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-dark">
                        <i class="ti ti-percentage ti-md"></i>
                    </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $counts['total_app_commissions'] }}</h4>
                        </div>
                        <p class="mb-1">{{ __("banha.total_app_commissions") }}</p>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('js')

@endsection
