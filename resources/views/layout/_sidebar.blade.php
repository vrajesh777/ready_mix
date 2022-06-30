@php
    $admin     = config('app.roles_id.admin');
    $sales     = config('app.roles_id.sales');
    $driver    = config('app.roles_id.driver');
    $delivery  = config('app.roles_id.delivery');
    $purchase  = config('app.roles_id.purchase');
    $inventory = config('app.roles_id.inventory');
 //   dd($obj_user->roles);
@endphp
<div class="sidebar main-sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <form action="https://crms-html.dreamguystech.com/light/search.html" class="mobile-view">
            <input class="form-control" type="text" placeholder="Search here">
            <button class="btn" type="button"><i class="fal fa-search"></i></button>
        </form>
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
            
                <li class="nav-item nav-profile">
                    <a href="#" class="nav-link">
                        <div class="nav-profile-image">
                            <img src="{{ asset('/') }}images/default.png" alt="profile">
                        </div>
                        <div class="nav-profile-text d-flex flex-column">
                            <span class="font-weight-bold mb-2">{{ $arr_login_user['first_name'] ?? '' }} {{ $arr_login_user['last_name'] ?? '' }}</span>
                            {{-- <span class="text-white text-small">Project Manager</span> --}}
                        </div>
                        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li>
                    <a href="{{ url('/') }}" class="{{ Route::getCurrentRoute()->uri() == '/' ? 'active' : '' }}" ><i class="fal fa-tachometer" aria-hidden="true"></i> <span> {{trans('admin.dashboard')}}</span></a>
                </li>

                
                @if($obj_user->hasPermissionTo('roles-list'))
                    <li>
                        <a href="{{ Route('roles') }}" class="{{ Request::segment('1') == 'roles' ? 'active' : '' }}" ><i class="fal fa-tasks" aria-hidden="true"></i> <span>{{trans('admin.roles')}}</span></a>
                    </li>
                @endif
                @if($obj_user->hasPermissionTo('main-department-list'))
                    <li>
                            <a href="{{ Route('main_department') }}" class="{{ Request::segment('1') == 'main_department' ? 'active' : '' }}" ><i class="fal fa-tasks" aria-hidden="true"></i> <span>{{ trans('admin.parent_department') }}</span></a>
                    </li>
                @endif
                @if($obj_user->hasPermissionTo('department-list'))
                    <li>
                            <a href="{{ Route('department') }}" class="{{ Request::segment('1') == 'department' ? 'active' : '' }}" ><i class="fal fa-tasks" aria-hidden="true"></i> <span>{{trans('admin.department')}}</span></a>
                    </li>
                @endif
                @if($obj_user->hasPermissionTo('employee-list'))
                    <li>
                        <a href="{{ Route('employee') }}" class="{{ Request::segment('1') == 'employee' ? 'active' : '' }}" ><i class="fa fa-users" aria-hidden="true"></i> <span> {{trans('admin.employee')}}</span></a>
                    </li>
                @endif

                @if($obj_user->hasPermissionTo('customers-list'))
                    <li>
                        <a href="{{ Route('customer') }}" class="{{ Request::segment('1') == 'customer' ? 'active' : '' }}" ><i class="fa fa-address-card" aria-hidden="true"></i> <span>{{trans('admin.customer')}}</span></a>
                    </li>
                @endif

                @if($obj_user->hasPermissionTo('site-setting-list'))
                    <li>
                        <a href="{{ Route('site_setting') }}" class="{{ Request::segment('1') == 'site_setting' ? 'active' : '' }}" ><i class="fal fa-cog" aria-hidden="true"></i> <span>{{trans('admin.site_setting')}}</span></a>
                    </li>
                @endif

                @if($obj_user->hasPermissionTo('taxes-list') || $obj_user->hasPermissionTo('units-list') || $obj_user->hasPermissionTo('payment-methods-list'))
                    <li class="submenu">
                        <a href="#"><i class="fal fa-cogs" aria-hidden="true"></i> <span> {{trans('admin.setup')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            @if($obj_user->hasPermissionTo('taxes-list'))
                                <li><a href="{{ Route('taxes') }}" class="{{ Request::segment('1') == 'taxes' ? 'active' : '' }}">{{trans('admin.taxes')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('units-list'))
                                <li><a href="{{ Route('units') }}" class="{{ Request::segment('1') == 'units' ? 'active' : '' }}">{{trans('admin.units')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('payment-methods-list'))
                                <li><a href="{{ Route('payment_methods') }}" class="{{ Request::segment('1') == 'payment_methods' ? 'active' : '' }}">{{trans('admin.payment_method')}}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if($obj_user->hasPermissionTo('pumps-list') || $obj_user->hasPermissionTo('pump-helper-list') || $obj_user->hasPermissionTo('pump-operator-list'))
                <li class="submenu">
                    <a href="#"><i class="fas fa-gas-pump"></i><span> {{trans('admin.pumps')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        @if($obj_user->hasPermissionTo('pumps-list'))
                            <li><a href="{{ Route('pumps') }}" class="{{ Request::segment('1') == 'pumps' ? 'active' : '' }}">{{trans('admin.pumps')}}</a></li>
                        @endif

                        <!-- @if($obj_user->hasPermissionTo('pump-helper-list'))
                            <li>
                                <a href="{{ Route('pump_helper') }}" class="{{ Request::segment('1') == 'pump_helper' ? 'active' : '' }}" ><span>{{trans('admin.pump_helper')}}</span></a>
                            </li>
                        @endif

                        @if($obj_user->hasPermissionTo('pump-operator-list'))
                            <li>
                                <a href="{{ Route('pump_op') }}" class="{{ Request::segment('1') == 'pump_op' ? 'active' : '' }}" ><span>{{trans('admin.pump_op')}}</span></a>
                            </li>
                        @endif -->
                    </ul>
                </li>
                @endif


                @if($obj_user->hasPermissionTo('product-list'))
                <li> 
                    <a href="{{ Route('product') }}" class="{{ Request::segment('1') == 'product' ? 'active' : '' }}"><i class="fal fa-podcast" aria-hidden="true"></i> <span>{{trans('admin.product')}}</span></a>
                </li>
                @endif

                @if(isset($arr_site_setting['sales_with_workflow'])&&$arr_site_setting['sales_with_workflow'] != '0' )
                    @if($obj_user->hasPermissionTo('leads-list'))
                        <li>
                            <a href="{{ Route('leads') }}" class="{{ Request::segment('1') == 'leads' ? 'active' : '' }}" ><i class="fal fa-user " aria-hidden="true"></i> <span>{{trans('admin.leads')}}</span></a>
                        </li>
                    @endif
                @endif

                @if($obj_user->hasPermissionTo('sales-inquirie-list') || $obj_user->hasPermissionTo('sales-estimates-list') || $obj_user->hasPermissionTo('sales-proposals-list') || $obj_user->hasPermissionTo('sales-bookings-list') || $obj_user->hasPermissionTo('sales-invoice-list') || $obj_user->hasPermissionTo('sales-payments-list') || $obj_user->hasPermissionTo('sales-account-list'))
                    <li class="submenu">
                        <a href="#"><i class="fa fa-university menu-icon" aria-hidden="true"></i> <span> {{trans('admin.sales')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            @if(isset($arr_site_setting['sales_with_workflow'])&&$arr_site_setting['sales_with_workflow'] != '0' )
                                @if($obj_user->hasPermissionTo('sales-inquirie-list'))
                                <li><a href="{{ Route('inquiries') }}" class="{{ Request::segment('1') == 'inquiries' ? 'active' : '' }}">{{trans('admin.inquirie')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('sales-estimates-list'))
                                <li><a href="{{ Route('estimates') }}" class="{{ Request::segment('1') == 'estimates' ? 'active' : '' }}">{{trans('admin.estimates')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('sales-proposals-list'))
                                    <li><a href="{{ Route('proposals') }}" class="{{ Request::segment('1') == 'proposals' ? 'active' : '' }}">{{trans('admin.proposals')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('sales-bookings-list'))
                                    <li><a href="{{ Route('booking') }}" class="{{ Request::segment('1') == 'booking' ? 'active' : '' }}">{{trans('admin.bookings')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('sales-invoice-list'))
                                    <li><a href="{{ Route('invoices') }}" class="{{ Request::segment('1') == 'invoices' ? 'active' : '' }}">{{trans('admin.invoices')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('sales-payments-list'))
                                    <li><a href="{{ Route('payments') }}" class="{{ Request::segment('1') == 'payments' ? 'active' : '' }}">{{trans('admin.payments')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('sales-account-list'))
                                    <li><a href="{{ Route('cust_contract') }}" class="{{ Request::segment('1') == 'cust_contract' ? 'active' : '' }}">{{trans('admin.account')}}</a></li>
                                @endif
                            @else
                               
                                <li><a href="{{ Route('proposals') }}" class="{{ Request::segment('1') == 'proposals' ? 'active' : '' }}">{{trans('admin.proposals')}}</a></li>

                            @endif
                            @if($obj_user->hasPermissionTo('sales-account-statement-list'))
                                <li><a href="{{ Route('account_statement') }}" class="{{ Request::segment('1') == 'account_statement' ? 'active' : '' }}">{{trans('admin.account_statement')}}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if($obj_user->hasPermissionTo('sales-rservations-list'))
                <li class="submenu">
                    <a href="#"><i class="fal fa-check-square" aria-hidden="true"></i> <span> {{trans('admin.reservations')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="{{ Route('booking') }}" class="{{ Request::segment('1') == 'booking' ? 'active' : '' }}">{{trans('admin.bookings')}}</a></li>
                        <li><a href="{{ Route('differential') }}" class="{{ Request::segment('1') == 'differential' ? 'active' : '' }}">{{ trans('admin.differential') }}</a></li>
                    </ul>
                </li>
                @endif

                @if($obj_user->hasPermissionTo('dispatch-order-list') || $obj_user->hasPermissionTo('dispatch-driver-list') || $obj_user->hasPermissionTo('dispatch-vechicle-list'))
                    <li class="submenu">
                        <a href="#"><i class="fa fa-truck menu-icon" aria-hidden="true"></i> <span>{{trans('admin.dispatch')}}  </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            @if($obj_user->hasPermissionTo('dispatch-order-list'))
                                <li><a href="{{ Route('delivery_orders') }}" class="{{ Request::segment('1') == 'delivery_orders' && Request::segment('2') != 'all_delivered' ? 'active' : '' }}">{{trans('admin.orders')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('dispatch-order-list'))
                                <li><a href="{{ Route('all_delivered') }}" class="{{ Request::segment('1') == 'delivery_orders' && Request::segment('2') == 'all_delivered' ? 'active' : '' }}">{{trans('admin.all_delivered')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('dispatch-driver-list'))
                                <li><a href="{{ Route('driver') }}" class="{{ Request::segment('1') == 'driver' ? 'active' : '' }}">{{trans('admin.trip_report')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('dispatch-vechicle-list'))
                                <li><a href="{{ Route('vehicle') }}" class="{{ Request::segment('1') == 'vehicle' ? 'active' : '' }}">{{trans('admin.vehicle')}}</a></li>
                            @endif
                            <li><a href="{{ Route('rejected_del') }}" class="{{ Request::segment('1') == 'rejected_del' ? 'active' : '' }}">Rejected</a></li>

                        </ul>
                    </li>
                @endif
                
                @if($obj_user->hasPermissionTo('finance-delivery-invoice-list') || $obj_user->hasPermissionTo('finance-confirmed-invoice-list'))
                    <li class="submenu"> 
                         <a href="#"><i class="fa fa-university menu-icon" aria-hidden="true"></i> <span> Finance </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>

                        <ul class="sub-menus">
                            @if($obj_user->hasPermissionTo('finance-delivery-invoice-list'))
                                <li><a href="{{ Route('delivery_invoice') }}">{{ trans('admin.delivery_invoice') }}</a></li>
                            @endif
                            
                            @if($obj_user->hasPermissionTo('finance-confirmed-invoice-list'))
                                <li><a href="{{ Route('confirmed_invoice') }}">{{ trans('admin.confirmed_invoice') }}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if($obj_user->hasPermissionTo('booking-statement-list'))
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-file"></i> <span> {{trans('admin.account_statement')}}</span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="{{ Route('booking_statement') }}" >{{trans('admin.booking_statement')}}</a></li>
                        <li><a href="{{ Route('non_booking_statement') }}" >{{trans('admin.non_booking_statement')}}</a></li>
                        <li><a href="{{ Route('monthly_booking_statement') }}" >{{ trans('admin.monthly_statement') }}</a></li>
                        {{-- <li><a href="{{ Route('account_statement') }}" >{{trans('admin.account_statement')}}</a></li> --}}
                    </ul>
                </li>
                @endif

                @if($obj_user->hasPermissionTo('purchase-commodity-group-list') || $obj_user->hasPermissionTo('purchase-item-list') || $obj_user->hasPermissionTo('purchase-vendor-list') || $obj_user->hasPermissionTo('purchase-request-list') || $obj_user->hasPermissionTo('purchase-estimates-list') || $obj_user->hasPermissionTo('purchase-orders-list'))
                    <li class="submenu">
                        <a href="#"><i class="fal fa-shopping-cart" aria-hidden="true"></i> <span> {{trans('admin.purchase')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            @if(isset($arr_site_setting['purchase_with_workflow'])&&$arr_site_setting['purchase_with_workflow'] != '0' )
                                @if($obj_user->hasPermissionTo('purchase-commodity-group-list'))
                                    <li><a href="{{ Route('commodity_groups') }}" class="{{ Request::segment('1') == 'commodity_groups' ? 'active' : '' }}">{{trans('admin.commodity_group')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('purchase-item-list'))
                                    <li><a href="{{ Route('items') }}" class="{{ Request::segment('1') == 'items' ? 'active' : '' }}">{{trans('admin.items')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('purchase-vendor-list'))
                                    <li><a href="{{ Route('vendors') }}" class="{{ Request::segment('1') == 'vendors' ? 'active' : '' }}">{{trans('admin.vendor')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('purchase-request-list'))
                                    <li><a href="{{ Route('purchase_request') }}" class="{{ Request::segment('1') == 'purchase_request' ? 'active' : '' }}">{{trans('admin.purchase_request')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('purchase-estimates-list'))
                                    <li><a href="{{ Route('estimate') }}" class="{{ Request::segment('1') == 'estimate' ? 'active' : '' }}">{{trans('admin.estimate')}}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('purchase-orders-list'))
                                    <li><a href="{{ Route('purchase_order') }}" class="{{ Request::segment('1') == 'purchase_order' ? 'active' : '' }}">{{trans('admin.purchase_orders')}}</a></li>
                                @endif
                                {{-- <li><a href="{{ Route('contract') }}" class="{{ Request::segment('1') == 'contract' ? 'active' : '' }}">{{trans('admin.contracts')}}</a></li> --}}
                            @else
                                @if($obj_user->hasPermissionTo('purchase-orders-list'))
                                    <li><a href="{{ Route('purchase_order') }}" class="{{ Request::segment('1') == 'purchase_order' ? 'active' : '' }}">{{trans('admin.purchase_orders')}}</a></li>
                                @endif
                            @endif
                        </ul>
                    </li>
                @endif

                @if($obj_user->hasPermissionTo('parts-list') || $obj_user->hasPermissionTo('supplier-list') || $obj_user->hasPermissionTo('manufacturer-list') || $obj_user->hasPermissionTo('make/model/year-list') || $obj_user->hasPermissionTo('parts-stock-list') || $obj_user->hasPermissionTo('purchase-parts-list') || $obj_user->hasPermissionTo('repair-list') || $obj_user->hasPermissionTo('print-labels-list'))
                    <li class="submenu">
                        <a href="javascript:void(0);" ><i class="fa fa-car-mechanic"></i> <span>{{trans('admin.vechicle_maintance')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            @if($obj_user->hasPermissionTo('maintenance-category-list'))
                            <li><a href="{{ Route('maintenance_category_list') }}" class="{{ Request::segment('1') == 'maintenance_category' ? 'active' : '' }}">{{trans('admin.maintenance_category')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('parts-list'))
                                <li><a href="{{ Route('vc_part') }}" class="{{ Request::segment('1') == 'vc_part' ? 'active' : '' }}">{{trans('admin.parts')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('supplier-list'))
                                <li><a href="{{ Route('vc_part_suppy') }}" class="{{ Request::segment('1') == 'vc_part_suppy' ? 'active' : '' }}">{{trans('admin.supplier')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('manufacturer-list'))
                                <li><a href="{{ Route('manufacturer') }}" class="{{ Request::segment('1') == 'manufacturer' ? 'active' : '' }}">{{trans('admin.manufacturer')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('make/model/year-list'))
                                <li><a href="{{ Route('vechicle_mym') }}" class="{{ Request::segment('1') == 'vechicle_mym' ? 'active' : '' }}">{{trans('admin.make_model_year')}}</a></li>
                            @endif
                            <li>
                                <a href="javascript:void(0);">{{trans('admin.parts_stock')}}</a>
                                <ul class="sub-menus">
                                    @if($obj_user->hasPermissionTo('parts-stock-list'))
                                        <li><a href="{{ Route('vhc_purchase_parts') }}" class="{{ Request::segment('1') == 'vhc_purchase_parts' ? 'active' : '' }}">{{trans('admin.purchase_parts')}}</a></li>
                                    @endif
                                        <li><a href="{{ Route('invoice_receiving_create') }}" class="{{ Request::segment('1') == 'invoice_receiving' ? 'active' : '' }}">{{trans('admin.invoice_receiving')}}</a></li>
                                    @if($obj_user->hasPermissionTo('purchase-parts-list'))
                                        <li><a href="{{ Route('vhc_parts_stocks') }}" class="{{ Request::segment('1') == 'vhc_parts_stocks' ? 'active' : '' }}">{{trans('admin.parts_stock')}}</a></li>
                                    @endif
                                </ul>
                            </li>
                            @if($obj_user->hasPermissionTo('repair-list'))
                                <li><a href="{{ Route('vhc_repair') }}" class="{{ Request::segment('1') == 'vhc_repair' ? 'active' : '' }}">{{trans('admin.repair')}}</a></li>
                            @endif
                            @if($obj_user->hasPermissionTo('print-labels-list'))
                                <li><a href="{{ Route('print_labels') }}" class="{{ Request::segment('1') == 'print_labels' ? 'active' : '' }}">{{trans('admin.print_labels')}}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                

                {{-- @if($obj_user->hasPermissionTo('attendance-list'))
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-calendar-check"></i> <span> {{trans('admin.attendance')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li>
                            <a href="javascript:void(0);" ><span>{{trans('admin.shift_schedule')}}</span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                            <ul class="sub-menus">
                                <li><a href="{{ Route('shifts') }}" >{{trans('admin.shifts')}}</a></li>
                                <li><a href="{{ Route('shift_calender') }}" >{{trans('admin.shift_calender')}}</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ Route('break') }}" >{{trans('admin.break')}}</a></li>
                        <li><a href="{{ Route('attend_calender_view') }}" >{{trans('admin.calender_view')}}</a></li>
                    </ul>
                </li>
                @endif

                @if($obj_user->hasPermissionTo('leave-tracker-list'))
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> {{trans('admin.leave_tracker')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="{{ Route('leaves') }}" >{{trans('admin.leave_type')}}</a></li>
                        <li><a href="{{ Route('leave_application') }}" >{{trans('admin.applications')}}</a></li>
                        <li><a href="{{ Route('leave_balance') }}" >{{trans('admin.balance')}}</a></li>
                    </ul>
                </li>
                @endif --}}

                @if($obj_user->hasPermissionTo('hr') || $obj_user->hasPermissionTo('attendance-list') || $obj_user->hasPermissionTo('leave-tracker-list') || $obj_user->hasPermissionTo('payroll'))
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> {{ trans('admin.hr') }} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">

                        @if($obj_user->hasPermissionTo('attendance-list'))
                            <li class="submenu">
                                <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> {{trans('admin.attendance')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                                <ul class="sub-menus">
                                    <li>
                                        <a href="javascript:void(0);" >{{-- <i class="fa fa-clock" aria-hidden="true"></i> --}} <span>{{trans('admin.shift_schedule')}}</span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                                        <ul class="sub-menus">
                                            <li><a href="{{ Route('shifts') }}" >{{trans('admin.shifts')}}</a></li>
                                            <li><a href="{{ Route('shift_calender') }}" >{{trans('admin.shift_calender')}}</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ Route('break') }}" >{{trans('admin.break')}}</a></li>
                                    <li><a href="{{ Route('attend_calender_view') }}" >{{trans('admin.calender_view')}}</a></li>
                                </ul>
                            </li>
                        @endif

                        @if($obj_user->hasPermissionTo('leave-tracker-list'))
                            <li class="submenu">
                                <a href="javascript:void(0);" @if(Request::segment('2') == 'leaves' || Request::segment('2') == 'leave_application' || Request::segment('3') == 'leave_balance')  class="active subdrop" @endif><i class="fa fa-calendar-minus"></i> <span> {{trans('admin.leave_tracker')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                                <ul class="sub-menus" @if(Request::segment('2') == 'leaves' || Request::segment('2') == 'leave_application' || Request::segment('3') == 'leave_balance')  style="display: block;" @endif>
                                    <li><a href="{{ Route('leaves') }}" class="{{ Request::segment('2') == 'leaves' ? 'active' : '' }}">{{trans('admin.leave_type')}}</a></li>
                                    <li><a href="{{ Route('leave_application') }}" class="{{ Request::segment('2') == 'leave_application' ? 'active' : '' }}">{{trans('admin.applications')}}</a></li>
                                    <li><a href="{{ Route('leave_balance') }}" class="{{ Request::segment('3') == 'leave_balance' ? 'active' : '' }}">{{trans('admin.balance')}}</a></li>
                                </ul>
                            </li>
                        @endif

                        @if($obj_user->hasPermissionTo('payroll'))
                        <li class="submenu">
                            <a href="javascript:void(0);" @if(Request::segment('2') == 'earning' || Request::segment('2') == 'reimbursement' || Request::segment('1') == 'pay_schedule' || Request::segment('1') == 'pay_employees'  || Request::segment('1') == 'pay_run' )  class="active subdrop" @endif><i class="fa fa-calendar-minus"></i> <span> {{ trans('admin.payroll') }} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                            <ul class="sub-menus" @if(Request::segment('2') == 'earning' || Request::segment('2') == 'reimbursement' || Request::segment('1') == 'pay_schedule' || Request::segment('1') == 'pay_employees'  || Request::segment('1') == 'pay_run' ) style="display: block;" @endif>
                                <li>
                                    <a href="javascript:void(0);" ><span>{{ trans('admin.salary_component') }}</span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>

                                    <ul class="sub-menus">
                                        @if($obj_user->hasPermissionTo('earning-list'))
                                            <li><a href="{{ Route('earning') }}" class="{{ Request::segment('2') == 'earning' ? 'active' : '' }}">{{ trans('admin.earning') }}</a></li>
                                        @endif
                                        {{-- <li><a href="{{ Route('reimbursement') }}" class="{{ Request::segment('2') == 'reimbursement' ? 'active' : '' }}">{{ trans('admin.reimbursement') }}</a></li> --}}
                                    </ul>
                                </li>

                                
                                @if($obj_user->hasPermissionTo('overhead-expances-list'))
                                    <li><a href="{{ Route('overhead_expances') }}" class="{{ Request::segment('1') == 'overhead_expances' ? 'active' : '' }}">{{ trans('admin.overhead_expances') }}</a></li>
                                @endif

                                @if($obj_user->hasPermissionTo('pay-schedule'))
                                    <li><a href="{{ Route('pay_schedule') }}" class="{{ Request::segment('1') == 'pay_schedule' ? 'active' : '' }}">{{ trans('admin.pay_schedule') }}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('payroll-employee-list'))
                                    <li><a href="{{ Route('pay_employees') }}" class="{{ Request::segment('1') == 'pay_employees' ? 'active' : '' }}">{{ trans('admin.empolyees') }}</a></li>
                                @endif
                                @if($obj_user->hasPermissionTo('pay-run'))
                                    <li><a href="{{ Route('pay_run') }}" class="{{ Request::segment('1') == 'pay_run' ? 'active' : '' }}">{{ trans('admin.pay_run') }}</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        
                        <li><a href="{{ Route('weekends') }}" >Weekends</a></li>

                    </ul>

                    
                </li>
                @endif

                @if($obj_user->hasPermissionTo('reports'))
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> {{ trans('admin.reports') }} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="{{ Route('daliv_output_mix_rpt') }}" >{{ trans('admin.daliv_out_put_mix_report') }}</a></li>
                        <li><a href="{{ Route('resrv_progressive_rpt') }}" >{{ trans('admin.reservations_progressive_report') }}</a></li>
                        <li><a href="{{ Route('excess_rpt') }}" >{{ trans('admin.excess_resell_report') }}</a></li>
                    </ul>
                </li>
                @endif
                 @if($obj_user->hasPermissionTo('qc-cube-create') || $obj_user->hasPermissionTo('qc-cylinder-create'))
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> {{trans('admin.qc')}} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">

                        <li class="submenu">
                            <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> {{ trans('admin.customer_report') }} </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                            <ul class="sub-menus">
                                <li><a href="{{ Route('delivery_report','new') }}">{{ trans('admin.input_new_report') }}</a></li>
                                <li><a href="{{ Route('cube_cylinder_report') }}">{{ trans('admin.shown_report') }}</a></li>
                                <li><a href="{{ Route('customer_summery_report') }}">{{ trans('admin.summary_report') }}</a></li>
                            </ul>
                        </li>

                       
                    </ul>
                </li>
                @endif
                 @if($obj_user->hasPermissionTo('inventory'))
                <li class="submenu">
                    <a href="#"><i class="fal fa-snowflake" aria-hidden="true"></i> <span> Inventory </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="{{ Route('item_index') }}">{{trans('admin.items')}}</a></li>
                        <li><a href="{{ Route('stock_import_list') }}">{{trans('admin.stock_import')}}</a></li>
                        <li><a href="{{ Route('stock_export') }}">{{trans('admin.stock_export')}}</a></li>
                        <li><a href="{{ Route('loss_adjustment') }}">{{trans('admin.loss_&_adjustment')}}</a></li>
                        <li><a href="{{ Route('warehouse_history') }}">{{trans('admin.warehouse_history')}}</a></li>
                        <li><a href="{{ Route('vendor_setting') }}">{{trans('admin.setting')}}</a></li>
                        
                        <li><a href="{{ Route('payroll') }}">payroll</a></li>
                        <li><a href="{{ Route('payroll1') }}">payroll1</a></li>
                        <li><a href="{{ Route('payroll2') }}">payroll2</a></li>
                        <li><a href="{{ Route('payroll3') }}">payroll3</a></li>
                        <li><a href="{{ Route('payroll4') }}">payroll4</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>