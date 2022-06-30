<?php
    $admin     = config('app.roles_id.admin');
    $sales     = config('app.roles_id.sales');
    $driver    = config('app.roles_id.driver');
    $delivery  = config('app.roles_id.delivery');
    $purchase  = config('app.roles_id.purchase');
    $inventory = config('app.roles_id.inventory');
 //   dd($obj_user->roles);
?>
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
                            <img src="<?php echo e(asset('/')); ?>images/default.png" alt="profile">
                        </div>
                        <div class="nav-profile-text d-flex flex-column">
                            <span class="font-weight-bold mb-2"><?php echo e($arr_login_user['first_name'] ?? ''); ?> <?php echo e($arr_login_user['last_name'] ?? ''); ?></span>
                            
                        </div>
                        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li>
                    <a href="<?php echo e(url('/')); ?>" class="<?php echo e(Route::getCurrentRoute()->uri() == '/' ? 'active' : ''); ?>" ><i class="fal fa-tachometer" aria-hidden="true"></i> <span> <?php echo e(trans('admin.dashboard')); ?></span></a>
                </li>

                
                <?php if($obj_user->hasPermissionTo('roles-list')): ?>
                    <li>
                        <a href="<?php echo e(Route('roles')); ?>" class="<?php echo e(Request::segment('1') == 'roles' ? 'active' : ''); ?>" ><i class="fal fa-tasks" aria-hidden="true"></i> <span><?php echo e(trans('admin.roles')); ?></span></a>
                    </li>
                <?php endif; ?>
                <?php if($obj_user->hasPermissionTo('main-department-list')): ?>
                    <li>
                            <a href="<?php echo e(Route('main_department')); ?>" class="<?php echo e(Request::segment('1') == 'main_department' ? 'active' : ''); ?>" ><i class="fal fa-tasks" aria-hidden="true"></i> <span><?php echo e(trans('admin.parent_department')); ?></span></a>
                    </li>
                <?php endif; ?>
                <?php if($obj_user->hasPermissionTo('department-list')): ?>
                    <li>
                            <a href="<?php echo e(Route('department')); ?>" class="<?php echo e(Request::segment('1') == 'department' ? 'active' : ''); ?>" ><i class="fal fa-tasks" aria-hidden="true"></i> <span><?php echo e(trans('admin.department')); ?></span></a>
                    </li>
                <?php endif; ?>
                <?php if($obj_user->hasPermissionTo('employee-list')): ?>
                    <li>
                        <a href="<?php echo e(Route('employee')); ?>" class="<?php echo e(Request::segment('1') == 'employee' ? 'active' : ''); ?>" ><i class="fa fa-users" aria-hidden="true"></i> <span> <?php echo e(trans('admin.employee')); ?></span></a>
                    </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('customers-list')): ?>
                    <li>
                        <a href="<?php echo e(Route('customer')); ?>" class="<?php echo e(Request::segment('1') == 'customer' ? 'active' : ''); ?>" ><i class="fa fa-address-card" aria-hidden="true"></i> <span><?php echo e(trans('admin.customer')); ?></span></a>
                    </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('site-setting-list')): ?>
                    <li>
                        <a href="<?php echo e(Route('site_setting')); ?>" class="<?php echo e(Request::segment('1') == 'site_setting' ? 'active' : ''); ?>" ><i class="fal fa-cog" aria-hidden="true"></i> <span><?php echo e(trans('admin.site_setting')); ?></span></a>
                    </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('taxes-list') || $obj_user->hasPermissionTo('units-list') || $obj_user->hasPermissionTo('payment-methods-list')): ?>
                    <li class="submenu">
                        <a href="#"><i class="fal fa-cogs" aria-hidden="true"></i> <span> <?php echo e(trans('admin.setup')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            <?php if($obj_user->hasPermissionTo('taxes-list')): ?>
                                <li><a href="<?php echo e(Route('taxes')); ?>" class="<?php echo e(Request::segment('1') == 'taxes' ? 'active' : ''); ?>"><?php echo e(trans('admin.taxes')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('units-list')): ?>
                                <li><a href="<?php echo e(Route('units')); ?>" class="<?php echo e(Request::segment('1') == 'units' ? 'active' : ''); ?>"><?php echo e(trans('admin.units')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('payment-methods-list')): ?>
                                <li><a href="<?php echo e(Route('payment_methods')); ?>" class="<?php echo e(Request::segment('1') == 'payment_methods' ? 'active' : ''); ?>"><?php echo e(trans('admin.payment_method')); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('pumps-list') || $obj_user->hasPermissionTo('pump-helper-list') || $obj_user->hasPermissionTo('pump-operator-list')): ?>
                <li class="submenu">
                    <a href="#"><i class="fas fa-gas-pump"></i><span> <?php echo e(trans('admin.pumps')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <?php if($obj_user->hasPermissionTo('pumps-list')): ?>
                            <li><a href="<?php echo e(Route('pumps')); ?>" class="<?php echo e(Request::segment('1') == 'pumps' ? 'active' : ''); ?>"><?php echo e(trans('admin.pumps')); ?></a></li>
                        <?php endif; ?>

                        <!-- <?php if($obj_user->hasPermissionTo('pump-helper-list')): ?>
                            <li>
                                <a href="<?php echo e(Route('pump_helper')); ?>" class="<?php echo e(Request::segment('1') == 'pump_helper' ? 'active' : ''); ?>" ><span><?php echo e(trans('admin.pump_helper')); ?></span></a>
                            </li>
                        <?php endif; ?>

                        <?php if($obj_user->hasPermissionTo('pump-operator-list')): ?>
                            <li>
                                <a href="<?php echo e(Route('pump_op')); ?>" class="<?php echo e(Request::segment('1') == 'pump_op' ? 'active' : ''); ?>" ><span><?php echo e(trans('admin.pump_op')); ?></span></a>
                            </li>
                        <?php endif; ?> -->
                    </ul>
                </li>
                <?php endif; ?>


                <?php if($obj_user->hasPermissionTo('product-list')): ?>
                <li> 
                    <a href="<?php echo e(Route('product')); ?>" class="<?php echo e(Request::segment('1') == 'product' ? 'active' : ''); ?>"><i class="fal fa-podcast" aria-hidden="true"></i> <span><?php echo e(trans('admin.product')); ?></span></a>
                </li>
                <?php endif; ?>

                <?php if(isset($arr_site_setting['sales_with_workflow'])&&$arr_site_setting['sales_with_workflow'] != '0' ): ?>
                    <?php if($obj_user->hasPermissionTo('leads-list')): ?>
                        <li>
                            <a href="<?php echo e(Route('leads')); ?>" class="<?php echo e(Request::segment('1') == 'leads' ? 'active' : ''); ?>" ><i class="fal fa-user " aria-hidden="true"></i> <span><?php echo e(trans('admin.leads')); ?></span></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('sales-inquirie-list') || $obj_user->hasPermissionTo('sales-estimates-list') || $obj_user->hasPermissionTo('sales-proposals-list') || $obj_user->hasPermissionTo('sales-bookings-list') || $obj_user->hasPermissionTo('sales-invoice-list') || $obj_user->hasPermissionTo('sales-payments-list') || $obj_user->hasPermissionTo('sales-account-list')): ?>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-university menu-icon" aria-hidden="true"></i> <span> <?php echo e(trans('admin.sales')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            <?php if(isset($arr_site_setting['sales_with_workflow'])&&$arr_site_setting['sales_with_workflow'] != '0' ): ?>
                                <?php if($obj_user->hasPermissionTo('sales-inquirie-list')): ?>
                                <li><a href="<?php echo e(Route('inquiries')); ?>" class="<?php echo e(Request::segment('1') == 'inquiries' ? 'active' : ''); ?>"><?php echo e(trans('admin.inquirie')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('sales-estimates-list')): ?>
                                <li><a href="<?php echo e(Route('estimates')); ?>" class="<?php echo e(Request::segment('1') == 'estimates' ? 'active' : ''); ?>"><?php echo e(trans('admin.estimates')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('sales-proposals-list')): ?>
                                    <li><a href="<?php echo e(Route('proposals')); ?>" class="<?php echo e(Request::segment('1') == 'proposals' ? 'active' : ''); ?>"><?php echo e(trans('admin.proposals')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('sales-bookings-list')): ?>
                                    <li><a href="<?php echo e(Route('booking')); ?>" class="<?php echo e(Request::segment('1') == 'booking' ? 'active' : ''); ?>"><?php echo e(trans('admin.bookings')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('sales-invoice-list')): ?>
                                    <li><a href="<?php echo e(Route('invoices')); ?>" class="<?php echo e(Request::segment('1') == 'invoices' ? 'active' : ''); ?>"><?php echo e(trans('admin.invoices')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('sales-payments-list')): ?>
                                    <li><a href="<?php echo e(Route('payments')); ?>" class="<?php echo e(Request::segment('1') == 'payments' ? 'active' : ''); ?>"><?php echo e(trans('admin.payments')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('sales-account-list')): ?>
                                    <li><a href="<?php echo e(Route('cust_contract')); ?>" class="<?php echo e(Request::segment('1') == 'cust_contract' ? 'active' : ''); ?>"><?php echo e(trans('admin.account')); ?></a></li>
                                <?php endif; ?>
                            <?php else: ?>
                               
                                <li><a href="<?php echo e(Route('proposals')); ?>" class="<?php echo e(Request::segment('1') == 'proposals' ? 'active' : ''); ?>"><?php echo e(trans('admin.proposals')); ?></a></li>

                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('sales-account-statement-list')): ?>
                                <li><a href="<?php echo e(Route('account_statement')); ?>" class="<?php echo e(Request::segment('1') == 'account_statement' ? 'active' : ''); ?>"><?php echo e(trans('admin.account_statement')); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('sales-rservations-list')): ?>
                <li class="submenu">
                    <a href="#"><i class="fal fa-check-square" aria-hidden="true"></i> <span> <?php echo e(trans('admin.reservations')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="<?php echo e(Route('booking')); ?>" class="<?php echo e(Request::segment('1') == 'booking' ? 'active' : ''); ?>"><?php echo e(trans('admin.bookings')); ?></a></li>
                        <li><a href="<?php echo e(Route('differential')); ?>" class="<?php echo e(Request::segment('1') == 'differential' ? 'active' : ''); ?>"><?php echo e(trans('admin.differential')); ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('dispatch-order-list') || $obj_user->hasPermissionTo('dispatch-driver-list') || $obj_user->hasPermissionTo('dispatch-vechicle-list')): ?>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-truck menu-icon" aria-hidden="true"></i> <span><?php echo e(trans('admin.dispatch')); ?>  </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            <?php if($obj_user->hasPermissionTo('dispatch-order-list')): ?>
                                <li><a href="<?php echo e(Route('delivery_orders')); ?>" class="<?php echo e(Request::segment('1') == 'delivery_orders' && Request::segment('2') != 'all_delivered' ? 'active' : ''); ?>"><?php echo e(trans('admin.orders')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('dispatch-order-list')): ?>
                                <li><a href="<?php echo e(Route('all_delivered')); ?>" class="<?php echo e(Request::segment('1') == 'delivery_orders' && Request::segment('2') == 'all_delivered' ? 'active' : ''); ?>"><?php echo e(trans('admin.all_delivered')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('dispatch-driver-list')): ?>
                                <li><a href="<?php echo e(Route('driver')); ?>" class="<?php echo e(Request::segment('1') == 'driver' ? 'active' : ''); ?>"><?php echo e(trans('admin.trip_report')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('dispatch-vechicle-list')): ?>
                                <li><a href="<?php echo e(Route('vehicle')); ?>" class="<?php echo e(Request::segment('1') == 'vehicle' ? 'active' : ''); ?>"><?php echo e(trans('admin.vehicle')); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo e(Route('rejected_del')); ?>" class="<?php echo e(Request::segment('1') == 'rejected_del' ? 'active' : ''); ?>">Rejected</a></li>

                        </ul>
                    </li>
                <?php endif; ?>
                
                <?php if($obj_user->hasPermissionTo('finance-delivery-invoice-list') || $obj_user->hasPermissionTo('finance-confirmed-invoice-list')): ?>
                    <li class="submenu"> 
                         <a href="#"><i class="fa fa-university menu-icon" aria-hidden="true"></i> <span> Finance </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>

                        <ul class="sub-menus">
                            <?php if($obj_user->hasPermissionTo('finance-delivery-invoice-list')): ?>
                                <li><a href="<?php echo e(Route('delivery_invoice')); ?>"><?php echo e(trans('admin.delivery_invoice')); ?></a></li>
                            <?php endif; ?>
                            
                            <?php if($obj_user->hasPermissionTo('finance-confirmed-invoice-list')): ?>
                                <li><a href="<?php echo e(Route('confirmed_invoice')); ?>"><?php echo e(trans('admin.confirmed_invoice')); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('booking-statement-list')): ?>
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-file"></i> <span> <?php echo e(trans('admin.account_statement')); ?></span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="<?php echo e(Route('booking_statement')); ?>" ><?php echo e(trans('admin.booking_statement')); ?></a></li>
                        <li><a href="<?php echo e(Route('non_booking_statement')); ?>" ><?php echo e(trans('admin.non_booking_statement')); ?></a></li>
                        <li><a href="<?php echo e(Route('monthly_booking_statement')); ?>" ><?php echo e(trans('admin.monthly_statement')); ?></a></li>
                        
                    </ul>
                </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('purchase-commodity-group-list') || $obj_user->hasPermissionTo('purchase-item-list') || $obj_user->hasPermissionTo('purchase-vendor-list') || $obj_user->hasPermissionTo('purchase-request-list') || $obj_user->hasPermissionTo('purchase-estimates-list') || $obj_user->hasPermissionTo('purchase-orders-list')): ?>
                    <li class="submenu">
                        <a href="#"><i class="fal fa-shopping-cart" aria-hidden="true"></i> <span> <?php echo e(trans('admin.purchase')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            <?php if(isset($arr_site_setting['purchase_with_workflow'])&&$arr_site_setting['purchase_with_workflow'] != '0' ): ?>
                                <?php if($obj_user->hasPermissionTo('purchase-commodity-group-list')): ?>
                                    <li><a href="<?php echo e(Route('commodity_groups')); ?>" class="<?php echo e(Request::segment('1') == 'commodity_groups' ? 'active' : ''); ?>"><?php echo e(trans('admin.commodity_group')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('purchase-item-list')): ?>
                                    <li><a href="<?php echo e(Route('items')); ?>" class="<?php echo e(Request::segment('1') == 'items' ? 'active' : ''); ?>"><?php echo e(trans('admin.items')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('purchase-vendor-list')): ?>
                                    <li><a href="<?php echo e(Route('vendors')); ?>" class="<?php echo e(Request::segment('1') == 'vendors' ? 'active' : ''); ?>"><?php echo e(trans('admin.vendor')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('purchase-request-list')): ?>
                                    <li><a href="<?php echo e(Route('purchase_request')); ?>" class="<?php echo e(Request::segment('1') == 'purchase_request' ? 'active' : ''); ?>"><?php echo e(trans('admin.purchase_request')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('purchase-estimates-list')): ?>
                                    <li><a href="<?php echo e(Route('estimate')); ?>" class="<?php echo e(Request::segment('1') == 'estimate' ? 'active' : ''); ?>"><?php echo e(trans('admin.estimate')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('purchase-orders-list')): ?>
                                    <li><a href="<?php echo e(Route('purchase_order')); ?>" class="<?php echo e(Request::segment('1') == 'purchase_order' ? 'active' : ''); ?>"><?php echo e(trans('admin.purchase_orders')); ?></a></li>
                                <?php endif; ?>
                                
                            <?php else: ?>
                                <?php if($obj_user->hasPermissionTo('purchase-orders-list')): ?>
                                    <li><a href="<?php echo e(Route('purchase_order')); ?>" class="<?php echo e(Request::segment('1') == 'purchase_order' ? 'active' : ''); ?>"><?php echo e(trans('admin.purchase_orders')); ?></a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('parts-list') || $obj_user->hasPermissionTo('supplier-list') || $obj_user->hasPermissionTo('manufacturer-list') || $obj_user->hasPermissionTo('make/model/year-list') || $obj_user->hasPermissionTo('parts-stock-list') || $obj_user->hasPermissionTo('purchase-parts-list') || $obj_user->hasPermissionTo('repair-list') || $obj_user->hasPermissionTo('print-labels-list')): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);" ><i class="fa fa-car-mechanic"></i> <span><?php echo e(trans('admin.vechicle_maintance')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                        <ul class="sub-menus">
                            <?php if($obj_user->hasPermissionTo('maintenance-category-list')): ?>
                            <li><a href="<?php echo e(Route('maintenance_category_list')); ?>" class="<?php echo e(Request::segment('1') == 'maintenance_category' ? 'active' : ''); ?>"><?php echo e(trans('admin.maintenance_category')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('parts-list')): ?>
                                <li><a href="<?php echo e(Route('vc_part')); ?>" class="<?php echo e(Request::segment('1') == 'vc_part' ? 'active' : ''); ?>"><?php echo e(trans('admin.parts')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('supplier-list')): ?>
                                <li><a href="<?php echo e(Route('vc_part_suppy')); ?>" class="<?php echo e(Request::segment('1') == 'vc_part_suppy' ? 'active' : ''); ?>"><?php echo e(trans('admin.supplier')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('manufacturer-list')): ?>
                                <li><a href="<?php echo e(Route('manufacturer')); ?>" class="<?php echo e(Request::segment('1') == 'manufacturer' ? 'active' : ''); ?>"><?php echo e(trans('admin.manufacturer')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('make/model/year-list')): ?>
                                <li><a href="<?php echo e(Route('vechicle_mym')); ?>" class="<?php echo e(Request::segment('1') == 'vechicle_mym' ? 'active' : ''); ?>"><?php echo e(trans('admin.make_model_year')); ?></a></li>
                            <?php endif; ?>
                            <li>
                                <a href="javascript:void(0);"><?php echo e(trans('admin.parts_stock')); ?></a>
                                <ul class="sub-menus">
                                    <?php if($obj_user->hasPermissionTo('parts-stock-list')): ?>
                                        <li><a href="<?php echo e(Route('vhc_purchase_parts')); ?>" class="<?php echo e(Request::segment('1') == 'vhc_purchase_parts' ? 'active' : ''); ?>"><?php echo e(trans('admin.purchase_parts')); ?></a></li>
                                    <?php endif; ?>
                                        <li><a href="<?php echo e(Route('invoice_receiving_create')); ?>" class="<?php echo e(Request::segment('1') == 'invoice_receiving' ? 'active' : ''); ?>"><?php echo e(trans('admin.invoice_receiving')); ?></a></li>
                                    <?php if($obj_user->hasPermissionTo('purchase-parts-list')): ?>
                                        <li><a href="<?php echo e(Route('vhc_parts_stocks')); ?>" class="<?php echo e(Request::segment('1') == 'vhc_parts_stocks' ? 'active' : ''); ?>"><?php echo e(trans('admin.parts_stock')); ?></a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php if($obj_user->hasPermissionTo('repair-list')): ?>
                                <li><a href="<?php echo e(Route('vhc_repair')); ?>" class="<?php echo e(Request::segment('1') == 'vhc_repair' ? 'active' : ''); ?>"><?php echo e(trans('admin.repair')); ?></a></li>
                            <?php endif; ?>
                            <?php if($obj_user->hasPermissionTo('print-labels-list')): ?>
                                <li><a href="<?php echo e(Route('print_labels')); ?>" class="<?php echo e(Request::segment('1') == 'print_labels' ? 'active' : ''); ?>"><?php echo e(trans('admin.print_labels')); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                

                

                <?php if($obj_user->hasPermissionTo('hr') || $obj_user->hasPermissionTo('attendance-list') || $obj_user->hasPermissionTo('leave-tracker-list') || $obj_user->hasPermissionTo('payroll')): ?>
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> <?php echo e(trans('admin.hr')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">

                        <?php if($obj_user->hasPermissionTo('attendance-list')): ?>
                            <li class="submenu">
                                <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> <?php echo e(trans('admin.attendance')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                                <ul class="sub-menus">
                                    <li>
                                        <a href="javascript:void(0);" > <span><?php echo e(trans('admin.shift_schedule')); ?></span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                                        <ul class="sub-menus">
                                            <li><a href="<?php echo e(Route('shifts')); ?>" ><?php echo e(trans('admin.shifts')); ?></a></li>
                                            <li><a href="<?php echo e(Route('shift_calender')); ?>" ><?php echo e(trans('admin.shift_calender')); ?></a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo e(Route('break')); ?>" ><?php echo e(trans('admin.break')); ?></a></li>
                                    <li><a href="<?php echo e(Route('attend_calender_view')); ?>" ><?php echo e(trans('admin.calender_view')); ?></a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if($obj_user->hasPermissionTo('leave-tracker-list')): ?>
                            <li class="submenu">
                                <a href="javascript:void(0);" <?php if(Request::segment('2') == 'leaves' || Request::segment('2') == 'leave_application' || Request::segment('3') == 'leave_balance'): ?>  class="active subdrop" <?php endif; ?>><i class="fa fa-calendar-minus"></i> <span> <?php echo e(trans('admin.leave_tracker')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                                <ul class="sub-menus" <?php if(Request::segment('2') == 'leaves' || Request::segment('2') == 'leave_application' || Request::segment('3') == 'leave_balance'): ?>  style="display: block;" <?php endif; ?>>
                                    <li><a href="<?php echo e(Route('leaves')); ?>" class="<?php echo e(Request::segment('2') == 'leaves' ? 'active' : ''); ?>"><?php echo e(trans('admin.leave_type')); ?></a></li>
                                    <li><a href="<?php echo e(Route('leave_application')); ?>" class="<?php echo e(Request::segment('2') == 'leave_application' ? 'active' : ''); ?>"><?php echo e(trans('admin.applications')); ?></a></li>
                                    <li><a href="<?php echo e(Route('leave_balance')); ?>" class="<?php echo e(Request::segment('3') == 'leave_balance' ? 'active' : ''); ?>"><?php echo e(trans('admin.balance')); ?></a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if($obj_user->hasPermissionTo('payroll')): ?>
                        <li class="submenu">
                            <a href="javascript:void(0);" <?php if(Request::segment('2') == 'earning' || Request::segment('2') == 'reimbursement' || Request::segment('1') == 'pay_schedule' || Request::segment('1') == 'pay_employees'  || Request::segment('1') == 'pay_run' ): ?>  class="active subdrop" <?php endif; ?>><i class="fa fa-calendar-minus"></i> <span> <?php echo e(trans('admin.payroll')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                            <ul class="sub-menus" <?php if(Request::segment('2') == 'earning' || Request::segment('2') == 'reimbursement' || Request::segment('1') == 'pay_schedule' || Request::segment('1') == 'pay_employees'  || Request::segment('1') == 'pay_run' ): ?> style="display: block;" <?php endif; ?>>
                                <li>
                                    <a href="javascript:void(0);" ><span><?php echo e(trans('admin.salary_component')); ?></span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>

                                    <ul class="sub-menus">
                                        <?php if($obj_user->hasPermissionTo('earning-list')): ?>
                                            <li><a href="<?php echo e(Route('earning')); ?>" class="<?php echo e(Request::segment('2') == 'earning' ? 'active' : ''); ?>"><?php echo e(trans('admin.earning')); ?></a></li>
                                        <?php endif; ?>
                                        
                                    </ul>
                                </li>

                                
                                <?php if($obj_user->hasPermissionTo('overhead-expances-list')): ?>
                                    <li><a href="<?php echo e(Route('overhead_expances')); ?>" class="<?php echo e(Request::segment('1') == 'overhead_expances' ? 'active' : ''); ?>"><?php echo e(trans('admin.overhead_expances')); ?></a></li>
                                <?php endif; ?>

                                <?php if($obj_user->hasPermissionTo('pay-schedule')): ?>
                                    <li><a href="<?php echo e(Route('pay_schedule')); ?>" class="<?php echo e(Request::segment('1') == 'pay_schedule' ? 'active' : ''); ?>"><?php echo e(trans('admin.pay_schedule')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('payroll-employee-list')): ?>
                                    <li><a href="<?php echo e(Route('pay_employees')); ?>" class="<?php echo e(Request::segment('1') == 'pay_employees' ? 'active' : ''); ?>"><?php echo e(trans('admin.empolyees')); ?></a></li>
                                <?php endif; ?>
                                <?php if($obj_user->hasPermissionTo('pay-run')): ?>
                                    <li><a href="<?php echo e(Route('pay_run')); ?>" class="<?php echo e(Request::segment('1') == 'pay_run' ? 'active' : ''); ?>"><?php echo e(trans('admin.pay_run')); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        
                        <li><a href="<?php echo e(Route('weekends')); ?>" >Weekends</a></li>

                    </ul>

                    
                </li>
                <?php endif; ?>

                <?php if($obj_user->hasPermissionTo('reports')): ?>
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> <?php echo e(trans('admin.reports')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="<?php echo e(Route('daliv_output_mix_rpt')); ?>" ><?php echo e(trans('admin.daliv_out_put_mix_report')); ?></a></li>
                        <li><a href="<?php echo e(Route('resrv_progressive_rpt')); ?>" ><?php echo e(trans('admin.reservations_progressive_report')); ?></a></li>
                        <li><a href="<?php echo e(Route('excess_rpt')); ?>" ><?php echo e(trans('admin.excess_resell_report')); ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                 <?php if($obj_user->hasPermissionTo('qc-cube-create') || $obj_user->hasPermissionTo('qc-cylinder-create')): ?>
                <li class="submenu">
                    <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> <?php echo e(trans('admin.qc')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">

                        <li class="submenu">
                            <a href="javascript:void(0);" ><i class="fa fa-calendar-minus"></i> <span> <?php echo e(trans('admin.customer_report')); ?> </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                            <ul class="sub-menus">
                                <li><a href="<?php echo e(Route('delivery_report','new')); ?>"><?php echo e(trans('admin.input_new_report')); ?></a></li>
                                <li><a href="<?php echo e(Route('cube_cylinder_report')); ?>"><?php echo e(trans('admin.shown_report')); ?></a></li>
                                <li><a href="<?php echo e(Route('customer_summery_report')); ?>"><?php echo e(trans('admin.summary_report')); ?></a></li>
                            </ul>
                        </li>

                       
                    </ul>
                </li>
                <?php endif; ?>
                 <?php if($obj_user->hasPermissionTo('inventory')): ?>
                <li class="submenu">
                    <a href="#"><i class="fal fa-snowflake" aria-hidden="true"></i> <span> Inventory </span> <span class="menu-arrow"><i class="far fa-chevron-right"></i></span></a>
                    <ul class="sub-menus">
                        <li><a href="<?php echo e(Route('item_index')); ?>"><?php echo e(trans('admin.items')); ?></a></li>
                        <li><a href="<?php echo e(Route('stock_import_list')); ?>"><?php echo e(trans('admin.stock_import')); ?></a></li>
                        <li><a href="<?php echo e(Route('stock_export')); ?>"><?php echo e(trans('admin.stock_export')); ?></a></li>
                        <li><a href="<?php echo e(Route('loss_adjustment')); ?>"><?php echo e(trans('admin.loss_&_adjustment')); ?></a></li>
                        <li><a href="<?php echo e(Route('warehouse_history')); ?>"><?php echo e(trans('admin.warehouse_history')); ?></a></li>
                        <li><a href="<?php echo e(Route('vendor_setting')); ?>"><?php echo e(trans('admin.setting')); ?></a></li>
                        
                        <li><a href="<?php echo e(Route('payroll')); ?>">payroll</a></li>
                        <li><a href="<?php echo e(Route('payroll1')); ?>">payroll1</a></li>
                        <li><a href="<?php echo e(Route('payroll2')); ?>">payroll2</a></li>
                        <li><a href="<?php echo e(Route('payroll3')); ?>">payroll3</a></li>
                        <li><a href="<?php echo e(Route('payroll4')); ?>">payroll4</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/layout/_sidebar.blade.php ENDPATH**/ ?>