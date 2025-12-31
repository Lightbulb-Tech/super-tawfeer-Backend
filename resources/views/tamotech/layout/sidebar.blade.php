<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="#" class="app-brand-link">
      <span class="app-brand-logo demo">
<svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
  <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
  <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
  <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
</svg>
</span>
            <span class="app-brand-text demo menu-text fw-bold">{{__('main.dashboard')}}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{\Illuminate\Support\Facades\Route::currentRouteName() == 'dashboard.index' ? 'active' : ''}}">
            <a href="{{route('dashboard.index')}}" class="menu-link">
                <i class="ti ti-home me-2 ti-sm" style="color: #8454dc;"></i>
                <div>{{__('main.main')}}</div>
            </a>
        </li>
        @if(checkIfHasPermission('app-settings-read'))
            <li class="menu-item {{\Illuminate\Support\Facades\Route::currentRouteName() == 'app-settings.index' ? 'active' : ''}}">
                <a href="{{route('app-settings.index')}}" class="menu-link">
                    <i class="ti ti-settings me-2 ti-sm" style="color: #810628;"></i>
                    <div>{{__('banha.app_settings')}}</div>
                </a>
            </li>
        @endif
        <li class="menu-item {{in_array(\Illuminate\Support\Facades\Route::currentRouteName() ,['permissions.index','roles.index','admins.index']) ? 'active open' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="ti ti-users me-2 ti-sm" style="color: #4CAF50;"></i>
                {{__('main.admins')}}
            </a>
            <ul class="menu-sub">
                @if(Auth::guard('admin')->user()->admin_type == \App\Enums\AdminTypeisEnum::Developer->value)
                    @if(checkIfHasPermission('permissions-read'))
                        <li class="menu-item {{\Illuminate\Support\Facades\Route::currentRouteName() == 'permissions.index' ? 'active' : ''}}">
                            <a href="{{route('permissions.index')}}" class="menu-link">
                                <i class="ti ti-lock-access me-2 ti-sm" style="color: #810628;"></i>
                                <div>{{__('main.permissions')}}</div>
                            </a>
                        </li>
                    @endif
                @endif
                @if(checkIfHasPermission('roles-read'))
                    <li class="menu-item {{\Illuminate\Support\Facades\Route::currentRouteName() == 'roles.index' ? 'active' : ''}}">
                        <a href="{{route('roles.index')}}" class="menu-link">
                            <i class="ti ti-shield-lock me-2 ti-sm" style="color: #b9a008;"></i>
                            <div>{{__('main.roles')}}</div>
                        </a>
                    </li>
                @endif
                @if(checkIfHasPermission('admins-read'))
                    <li class="menu-item {{\Illuminate\Support\Facades\Route::currentRouteName() == 'admins.index' ? 'active' : ''}}">
                        <a href="{{route('admins.index')}}" class="menu-link">
                            <i class="ti ti-user-circle me-2 ti-sm" style="color: #1610d0;"></i>
                            <div>{{__('main.admins')}}</div>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        @if(auth('admin')->user()->admin_type == \App\Enums\AdminTypeisEnum::Developer->value)
            <li class="menu-item {{in_array(\Illuminate\Support\Facades\Route::currentRouteName() ,['commands.index','terminal.index','file-manager.index','env.index']) ? 'active open' : ''}}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="ti ti-settings me-2 ti-sm" style="color: #4CAF50;"></i>
                    {{__('main.system_settings')}}
                </a>
                <ul class="menu-sub">
                    @if(checkIfHasPermission('settings-read'))
                        <li class="menu-item {{\Illuminate\Support\Facades\Route::currentRouteName() == 'settings.index' ? 'active' : ''}}">
                            <a href="{{route('settings.index')}}" class="menu-link">
                                <i class="ti ti-settings me-2 ti-sm" style="color: #810628;"></i>
                                <div>{{__('main.settings')}}</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item {{\Illuminate\Support\Facades\Route::currentRouteName() == 'env.index' ? 'active' : ''}}">
                        <a href="{{route('env.index')}}" class="menu-link">
                            <i class="ti ti-settings-bolt  me-2 ti-sm" style="color: #810628;"></i>
                            <div>Env</div>
                        </a>
                    </li>
                    @if(checkIfHasPermission('commands-read'))
                        <li class="menu-item {{\Illuminate\Support\Facades\Route::currentRouteName() == 'commands.index' ? 'active' : ''}}">
                            <a href="{{route('commands.index')}}" class="menu-link">
                                <i class="ti ti-command me-2 ti-sm" style="color: #6b69ce;"></i>
                                <div>{{__("main.commands")}}</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item  {{\Illuminate\Support\Facades\Route::currentRouteName() == 'terminal.index' ? 'active' : ''}}">
                        <a href="{{route('terminal.index')}}" class="menu-link" target="_blank">
                            <i class="ti ti-terminal  me-2 ti-sm" style="color: #810628;"></i>
                            <div>{{__("main.terminal")}}</div>
                        </a>
                    </li>
                    <li class="menu-item  {{\Illuminate\Support\Facades\Route::currentRouteName() == 'file-manager.index' ? 'active' : ''}}">
                        <a href="{{route('file-manager.index')}}" class="menu-link" target="_blank">
                            <i class="ti ti-folder me-2 ti-sm" style="color: #810628;"></i>
                            <div>{{__("main.file_manager")}}</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('backup')}}" class="menu-link">
                            <i class="ti ti-database-export me-2 ti-sm" style="color: #810628;"></i>
                            <div>{{__("main.backup_database")}}</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{url('/log-viewer')}}" class="menu-link" target="_blank">
                            <i class="ti ti-file-search me-2 ti-sm" style="color: #810628;"></i>
                            <div>Log Viewer</div>
                        </a>
                    </li>
                    @if(env('TELESCOPE_ENABLED') == true)
                        <li class="menu-item">
                            <a href="{{url('/telescope')}}" class="menu-link" target="_blank">
                                <i class="ti ti-telescope me-2 ti-sm" style="color: #810628;"></i>
                                <div>Telescope</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- Countries --}}
        @if(checkIfHasPermission('general-notifications-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'general-notifications.index' ? 'active' : '' }}">
                <a href="{{ route('general-notifications.index') }}" class="menu-link">
                    <i class="ti ti-bell me-2 ti-sm" style="color:#1e90ff;"></i>
                    <div>{{ __('banha.general_notifications') }}</div>
                </a>
            </li>
        @endif
        {{-- Countries --}}
        @if(checkIfHasPermission('countries-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'countries.index' ? 'active' : '' }}">
                <a href="{{ route('countries.index') }}" class="menu-link">
                    <i class="ti ti-flag me-2 ti-sm" style="color:#1e90ff;"></i>
                    <div>{{ __('banha.countries') }}</div>
                </a>
            </li>
        @endif

        {{-- Governorates --}}
        @if(checkIfHasPermission('governorates-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'governorates.index' ? 'active' : '' }}">
                <a href="{{ route('governorates.index') }}" class="menu-link">
                    <i class="ti ti-map me-2 ti-sm" style="color:#3cb371;"></i>
                    <div>{{ __('banha.governorates') }}</div>
                </a>
            </li>
        @endif

        {{-- Areas --}}
        @if(checkIfHasPermission('areas-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'areas.index' ? 'active' : '' }}">
                <a href="{{ route('areas.index') }}" class="menu-link">
                    <i class="ti ti-map-pin me-2 ti-sm" style="color:#e67e22;"></i>
                    <div>{{ __('banha.areas') }}</div>
                </a>
            </li>
        @endif

        {{-- FAQs --}}
        @if(checkIfHasPermission('faqs-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'faqs.index' ? 'active' : '' }}">
                <a href="{{ route('faqs.index') }}" class="menu-link">
                    <i class="ti ti-help-circle me-2 ti-sm" style="color:#8e44ad;"></i>
                    <div>{{ __('banha.faqs') }}</div>
                </a>
            </li>
        @endif
        @if(checkIfHasPermission('sliders-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'sliders.index' ? 'active' : '' }}">
                <a href="{{ route('sliders.index') }}" class="menu-link">
                    <i class="ti ti-slideshow me-2 ti-sm" style="color:#8e44ad;"></i>
                    <div>{{ __('banha.sliders') }}</div>
                </a>
            </li>
        @endif
        @if(checkIfHasPermission('reason-cancellation-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'reason-cancellation.index' ? 'active' : '' }}">
                <a href="{{ route('reason-cancellation.index') }}" class="menu-link">
                    <i class="ti ti-alert-circle me-2 ti-sm" style="color:#8e44ad;"></i>
                    <div>{{ __('banha.reason_cancellation') }}</div>
                </a>
            </li>
        @endif

        {{-- Coupons --}}
        @if(checkIfHasPermission('coupons-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'coupons.index' ? 'active' : '' }}">
                <a href="{{ route('coupons.index') }}" class="menu-link">
                    <i class="ti ti-ticket me-2 ti-sm" style="color:#d35400;"></i>
                    <div>{{ __('banha.coupons') }}</div>
                </a>
            </li>
        @endif

        {{-- Users --}}
        @if(checkIfHasPermission('users-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class="ti ti-users me-2 ti-sm" style="color:#2980b9;"></i>
                    <div>{{ __('banha.users') }}</div>
                </a>
            </li>
        @endif

        {{-- Users Address --}}
        @if(checkIfHasPermission('users-address-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'users-address.index' ? 'active' : '' }}">
                <a href="{{ route('users-address.index') }}" class="menu-link">
                    <i class="ti ti-home me-2 ti-sm" style="color:#16a085;"></i>
                    <div>{{ __('banha.users_address') }}</div>
                </a>
            </li>
        @endif

        {{-- Stores --}}
        {{--        @if(checkIfHasPermission('stores-read'))--}}
        {{--            <li class="menu-item {{ Route::currentRouteName() == 'stores.index' ? 'active' : '' }}">--}}
        {{--                <a href="{{ route('stores.index') }}" class="menu-link">--}}
        {{--                    <i class="ti ti-building-store me-2 ti-sm" style="color:#c0392b;"></i>--}}
        {{--                    <div>{{ __('banha.stores') }}</div>--}}
        {{--                </a>--}}
        {{--            </li>--}}
        {{--        @endif --}}
        @if(checkIfHasPermission('drivers-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'drivers.index' ? 'active' : '' }}">
                <a href="{{ route('drivers.index') }}" class="menu-link">
                    <i class="ti ti-building-store me-2 ti-sm" style="color:#c0392b;"></i>
                    <div>{{ __('banha.drivers') }}</div>
                </a>
            </li>
        @endif

        {{-- Main Categories --}}
        @if(checkIfHasPermission('main-categories-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'main-categories.index' ? 'active' : '' }}">
                <a href="{{ route('main-categories.index') }}" class="menu-link">
                    <i class="ti ti-category me-2 ti-sm" style="color:#27ae60;"></i>
                    <div>{{ __('banha.main_categories') }}</div>
                </a>
            </li>
        @endif

        {{-- Sub Categories --}}
        @if(checkIfHasPermission('sub-categories-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'sub-categories.index' ? 'active' : '' }}">
                <a href="{{ route('sub-categories.index') }}" class="menu-link">
                    <i class="ti ti-tags me-2 ti-sm" style="color:#8e44ad;"></i>
                    <div>{{ __('banha.sub_categories') }}</div>
                </a>
            </li>
        @endif
        @if(checkIfHasPermission('brands-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'brands.index' ? 'active' : '' }}">
                <a href="{{ route('brands.index') }}" class="menu-link">
                    <i class="ti ti-tags me-2 ti-sm" style="color:#8e44ad;"></i>
                    <div>{{ __('banha.brands') }}</div>
                </a>
            </li>
        @endif

        {{-- Products --}}
        @if(checkIfHasPermission('products-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'products.index' ? 'active' : '' }}">
                <a href="{{ route('products.index') }}" class="menu-link">
                    <i class="ti ti-package me-2 ti-sm" style="color:#f39c12;"></i>
                    <div>{{ __('banha.products') }}</div>
                </a>
            </li>
        @endif

        @if(checkIfHasPermission('products-with-zero-quantity-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'products-with-zero-quantity.index' ? 'active' : '' }}">
                <a href="{{ route('products-with-zero-quantity.index') }}" class="menu-link">
                    <i class="ti ti-package me-2 ti-sm" style="color:#f39c12;"></i>
                    <div>{{ __('banha.products_with_zero_quantity') }}</div>
                </a>
            </li>
        @endif

        {{-- Points Transfer Requests --}}
        @if(checkIfHasPermission('points-histories-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'points-histories.index' ? 'active' : '' }}">
                <a href="{{ route('points-histories.index') }}" class="menu-link">
                    <i class="ti ti-coin me-2 ti-sm" style="color:#f1c40f;"></i>
                    <div>{{ __('banha.points_histories') }}</div>
                </a>
            </li>
        @endif

        @if(checkIfHasPermission('wallet-histories-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'wallet-histories.index' ? 'active' : '' }}">
                <a href="{{ route('wallet-histories.index') }}" class="menu-link">
                    <i class="ti ti-wallet me-2 ti-sm" style="color:#2ecc71;"></i>
                    <div>{{ __('banha.wallet_histories') }}</div>
                </a>
            </li>
        @endif

        @if(checkIfHasPermission('points-transfer-requests-read'))
            <li class="menu-item {{ Route::currentRouteName() == 'points-transfer-requests.index' ? 'active' : '' }}">
                <a href="{{ route('points-transfer-requests.index') }}" class="menu-link">
                    <i class="ti ti-arrows-transfer-up me-2 ti-sm" style="color:#3498db;"></i>
                    <div>{{ __('banha.points_transfer_requests') }}</div>
                </a>
            </li>
        @endif
        @if(checkIfHasPermission('vehicles-read'))
            <li class="menu-item {{in_array(\Illuminate\Support\Facades\Route::currentRouteName() ,['vehicles.index' ,'new-reservations.index' ,'current-reservations.index','complete-reservations.index','cancel-reservations.index']) ? 'active open' : ''}}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="ti ti-truck me-2 ti-sm" style="color:#3498db;"></i>
                    {{ __('banha.vehicles_rental') }}
                </a>
                <ul class="menu-sub">
                    @if(checkIfHasPermission('vehicles-read'))
                        <li class="menu-item {{ Route::currentRouteName() == 'vehicles.index' ? 'active' : '' }}">
                            <a href="{{ route('vehicles.index') }}" class="menu-link">
                                <i class="ti ti-truck me-2 ti-sm" style="color:#3498db;"></i>
                                <div>{{ __('banha.vehicles') }}</div>
                            </a>
                        </li>
                    @endif
                    @if(checkIfHasPermission('new-reservations-read'))
                        <li class="menu-item {{ Route::currentRouteName() == 'new-reservations.index' ? 'active' : '' }}">
                            <a href="{{ route('new-reservations.index') }}" class="menu-link">
                                <i class="ti ti-clock me-2 ti-sm" style="color:#3498db;"></i>
                                <div>{{ __('banha.new_reservations') }}</div>
                            </a>
                        </li>
                    @endif
                    @if(checkIfHasPermission('current-reservations-read'))
                        <li class="menu-item {{ Route::currentRouteName() == 'current-reservations.index' ? 'active' : '' }}">
                            <a href="{{ route('current-reservations.index') }}" class="menu-link">
                                <i class="ti ti-loader me-2 ti-sm" style="color:#3498db;"></i>
                                <div>{{ __('banha.current_reservations') }}</div>
                            </a>
                        </li>
                    @endif
                    @if(checkIfHasPermission('complete-reservations-read'))
                        <li class="menu-item {{ Route::currentRouteName() == 'complete-reservations.index' ? 'active' : '' }}">
                            <a href="{{ route('complete-reservations.index') }}" class="menu-link">
                                <i class="ti ti-check me-2 ti-sm" style="color:#3498db;"></i>
                                <div>{{ __('banha.complete_reservations') }}</div>
                            </a>
                        </li>
                    @endif
                    @if(checkIfHasPermission('cancel-reservations-read'))
                        <li class="menu-item {{ Route::currentRouteName() == 'cancel-reservations.index' ? 'active' : '' }}">
                            <a href="{{ route('cancel-reservations.index') }}" class="menu-link">
                                <i class="ti ti-x me-2 ti-sm" style="color:#3498db;"></i>
                                <div>{{ __('banha.cancel_reservations') }}</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if(checkIfHasPermission('order-categories-read'))

            <li class="menu-item {{ in_array(Route::currentRouteName(), ['order-categories.index','new-external-orders.index','current-external-orders.index','complete-external-orders.index','cancel-external-orders.index',]) ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="ti ti-shopping-bag me-2 ti-sm" style="color: #4CAF50;"></i>
                    {{ __('banha.external_orders') }}
                </a>
                <ul class="menu-sub">
                    @if(checkIfHasPermission('order-categories-read'))
                        <li class="menu-item {{ Route::currentRouteName() == 'order-categories.index' ? 'active' : '' }}">
                            <a href="{{ route('order-categories.index') }}" class="menu-link">
                                <i class="ti ti-category me-2 ti-sm" style="color:#3498db;"></i>
                                <div>{{ __('banha.order_categories') }}</div>
                            </a>
                        </li>
                    @endif
                        @if(checkIfHasPermission('new-external-orders-read'))
                            <li class="menu-item {{ Route::currentRouteName() == 'new-external-orders.index' ? 'active' : '' }}">
                                <a href="{{ route('new-external-orders.index') }}" class="menu-link">
                                    <i class="ti ti-shopping-cart-plus me-2 ti-sm" style="color:#3498db;"></i>
                                    <div>{{ __('banha.new_external_orders') }}</div>
                                </a>
                            </li>
                        @endif

                        @if(checkIfHasPermission('current-external-orders-read'))
                            <li class="menu-item {{ Route::currentRouteName() == 'current-external-orders.index' ? 'active' : '' }}">
                                <a href="{{ route('current-external-orders.index') }}" class="menu-link">
                                    <i class="ti ti-refresh me-2 ti-sm" style="color:#f39c12;"></i>
                                    <div>{{ __('banha.current_external_orders') }}</div>
                                </a>
                            </li>
                        @endif

                        @if(checkIfHasPermission('complete-external-orders-read'))
                            <li class="menu-item {{ Route::currentRouteName() == 'complete-external-orders.index' ? 'active' : '' }}">
                                <a href="{{ route('complete-external-orders.index') }}" class="menu-link">
                                    <i class="ti ti-circle-check me-2 ti-sm" style="color:#2ecc71;"></i>
                                    <div>{{ __('banha.complete_external_orders') }}</div>
                                </a>
                            </li>
                        @endif

                        @if(checkIfHasPermission('cancel-external-orders-read'))
                            <li class="menu-item {{ Route::currentRouteName() == 'cancel-external-orders.index' ? 'active' : '' }}">
                                <a href="{{ route('cancel-external-orders.index') }}" class="menu-link">
                                    <i class="ti ti-circle-x me-2 ti-sm" style="color:#e74c3c;"></i>
                                    <div>{{ __('banha.cancel_external_orders') }}</div>
                                </a>
                            </li>
                        @endif

                </ul>
            </li>
        @endif
        <li class="menu-item {{in_array(\Illuminate\Support\Facades\Route::currentRouteName() ,['new-orders.index','current-orders.index','complete-orders.index','canceled-orders.index']) ? 'active open' : ''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="ti ti-shopping-cart me-2 ti-sm" style="color: #4CAF50;"></i>
                {{ __('banha.orders') }}
            </a>
            <ul class="menu-sub">
                @if(checkIfHasPermission('new-orders-read'))
                    <li class="menu-item {{ Route::currentRouteName() == 'new-orders.index' ? 'active' : '' }}">
                        <a href="{{ route('new-orders.index') }}" class="menu-link">
                            <i class="ti ti-bell-ringing me-2 ti-sm" style="color:#f39c12;"></i>
                            <div>{{ __('banha.new_orders') }}</div>
                        </a>
                    </li>
                @endif
                @if(checkIfHasPermission('current-orders-read'))
                    <li class="menu-item {{ Route::currentRouteName() == 'current-orders.index' ? 'active' : '' }}">
                        <a href="{{ route('current-orders.index') }}" class="menu-link">
                            <i class="ti ti-clock me-2 ti-sm" style="color:#3498db;"></i>
                            <div>{{ __('banha.current_orders') }}</div>
                        </a>
                    </li>
                @endif
                @if(checkIfHasPermission('complete-orders-read'))
                    <li class="menu-item {{ Route::currentRouteName() == 'complete-orders.index' ? 'active' : '' }}">
                        <a href="{{ route('complete-orders.index') }}" class="menu-link">
                            <i class="ti ti-circle-check me-2 ti-sm" style="color:#2ecc71;"></i>
                            <div>{{ __('banha.complete_orders') }}</div>
                        </a>
                    </li>
                @endif
                @if(checkIfHasPermission('canceled-orders-read'))
                    <li class="menu-item {{ Route::currentRouteName() == 'canceled-orders.index' ? 'active' : '' }}">
                        <a href="{{ route('canceled-orders.index') }}" class="menu-link">
                            <i class="ti ti-circle-x me-2 ti-sm" style="color:#e74c3c;"></i>
                            <div>{{ __('banha.cancel_orders') }}</div>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="menu-item {{ in_array(Route::currentRouteName(), ['most-products-ordered.index','most-products-sold.index','most-drivers-deliveries.index']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="ti ti-report-analytics me-2 ti-sm" style="color: #4CAF50;"></i>
                {{ __('banha.reports') }}
            </a>
            <ul class="menu-sub">

                {{-- 🔸 المنتجات الأكثر مبيعًا --}}
                @if(checkIfHasPermission('most-products-sold-read'))
                    <li class="menu-item {{ Route::currentRouteName() == 'most-products-sold.index' ? 'active' : '' }}">
                        <a href="{{ route('most-products-sold.index') }}" class="menu-link">
                            <i class="ti ti-trending-up me-2 ti-sm" style="color:#ff9800;"></i>
                            <div>{{ __('banha.most_products_sold') }}</div>
                        </a>
                    </li>

                @endif

                {{-- 🔸 المنتجات الأكثر طلبًا --}}
                @if(checkIfHasPermission('most-products-ordered-read'))
                    <li class="menu-item {{ Route::currentRouteName() == 'most-products-ordered.index' ? 'active' : '' }}">
                        <a href="{{ route('most-products-ordered.index') }}" class="menu-link">
                            <i class="ti ti-shopping-bag me-2 ti-sm" style="color:#03a9f4;"></i>
                            <div>{{ __('banha.most_products_orders') }}</div>
                        </a>
                    </li>
                @endif

                {{-- 🔸 السائقون الأكثر توصيلًا --}}
                @if(checkIfHasPermission('most-drivers-deliveries-read'))
                    <li class="menu-item {{ Route::currentRouteName() == 'most-drivers-deliveries.index' ? 'active' : '' }}">
                        <a href="{{ route('most-drivers-deliveries.index') }}" class="menu-link">
                            <i class="ti ti-truck-delivery me-2 ti-sm" style="color:#8e44ad;"></i>
                            <div>{{ __('banha.most_drivers_deliveries') }}</div>
                        </a>
                    </li>
                @endif

            </ul>
        </li>

        <li class="menu-item ">
            <a href="{{route('logout')}}" class="menu-link">
                <i class="ti ti-logout me-2 ti-sm" style="color: #4CAF50;"></i>
                <div>{{__('main.logout')}}</div>
            </a>
        </li>
    </ul>
</aside>
