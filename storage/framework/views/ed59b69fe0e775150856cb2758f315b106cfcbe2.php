<?php $__env->startSection('main_content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('/css/handsontable.css')); ?>">
<script src="<?php echo e(asset('/js/handson/handsontable.full.min.js')); ?>"></script>

<h4 class="card-title mt-0 mb-2"><?php echo e($page_title ?? ''); ?></h4>
<div class="row">
	<div class="col-sm-12">
		<form method="post" action="<?php echo e(Route('purchase_request_store')); ?>" name="frmCreateRequest" id="frmCreateRequest">
		  <?php echo e(csrf_field()); ?>


            <input type="hidden" name="request_detail" value="">

			<div class="row">
				<div class="col-md-8 d-flex">
					<div class="card profile-box flex-fill">
						<div class="card-body">
							<h3 class="card-title border-bottom pb-2 mt-0 mb-3"><?php echo e(trans('admin.other_info')); ?></h3>

							<div class="row">
								
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.purchase_request')); ?> <?php echo e(trans('admin.name')); ?><span class="text-danger">*</span></label>
	            					<input type="text" class="form-control"  name="purchase_request_name" id="purchase_request_name" placeholder="<?php echo e(trans('admin.purchase_request')); ?> <?php echo e(trans('admin.name')); ?>" data-rule-required="true">
	            					<label class="error" id="purchase_request_name_error"></label>
								</div>
								
								<div class="form-group col-sm-12">
									<label><?php echo e(trans('admin.description')); ?></label>
									<textarea rows="5" cols="5" class="form-control" placeholder="<?php echo e(trans('admin.description')); ?>" name="description" id="description"></textarea>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="col-md-4 d-flex">
					<div class="card profile-box flex-fill">
						<div class="card-body">
							<h3 class="card-title border-bottom pb-2 mt-0 mb-3"><?php echo e(trans('admin.general_info')); ?></h3>
							<ul class="personal-info border">
								<li>
									<div class="title"><?php echo e(trans('admin.requester')); ?></div>
									<div class="text"><?php echo e($user->first_name ?? ''); ?> <?php echo e($user->last_name ?? ''); ?></div>
								</li>
								<li>
									<div class="title"><?php echo e(trans('admin.req')); ?> <?php echo e(trans('admin.date')); ?></div>
									<div class="text"><?php echo e(date('Y-m-d')); ?></div>
								</li>
							</ul>
							
						</div>
					</div>
				</div>
			</div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group d-flex">
                        <div class="input-group-append cursor-pointer">
                            <span class="border-0 btn btn-primary btn-gradient-primary btn-rounded" data-toggle="modal" data-target="#add_item"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.item')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

			<div id="example">
				<hr>
			</div>

			<div class="text-center py-3">
            	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
            	<a href="<?php echo e(Route('purchase_request')); ?>" class="btn btn-secondary btn-rounded closeForm"><?php echo e(trans('admin.cancel')); ?></a>
            </div>
		</form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog" role="document">
        <button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-center"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.item')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <form method="post" action="<?php echo e(Route('items_store')); ?>" id="frmAddItem" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="action" value="create">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="tab-pane show active">
                                <div class="row">
                                    
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label"><?php echo e(trans('admin.commodity_name')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"  name="commodity_name" id="commodity_name" placeholder="<?php echo e(trans('admin.commodity_name')); ?>" data-rule-required="true">
                                    </div>
                                    
                                    
                                    
                              
                            
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label"><?php echo e(trans('admin.commodity_group')); ?> </label>
                                        <select class="form-control select2" id="commodity_group" name="commodity_group">
                                            <option value=""><?php echo e(trans('admin.commodity_group')); ?> </option>
                                            <?php if(isset($arr_commodity_group) && sizeof($arr_commodity_group)>0): ?>
                                                <?php $__currentLoopData = $arr_commodity_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($group['id'] ?? ''); ?>"><?php echo e($group['name'] ?? ''); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    
                                
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label"><?php echo e(trans('admin.price')); ?><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="purchase_price" name="purchase_price" placeholder="<?php echo e(trans('admin.price')); ?>" data-rule-required="true" data-rule-number=true>
                                        <label class="error" id="purchase_price_error"></label>
                                    </div>
                                
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label"><?php echo e(trans('admin.unit')); ?><span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="units" name="units" data-rule-required="true">
                                            <option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.units')); ?></option>
                                            <?php if(isset($arr_units) && sizeof($arr_units)>0): ?>
                                                <?php $__currentLoopData = $arr_units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $units): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($units['id'] ?? ''); ?>"><?php echo e($units['unit_name'] ?? ''); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                        <label class="error" id="units_error"></label>
                                    </div>
                                            
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label"><?php echo e(trans('admin.taxes')); ?></label>
                                        <select class="form-control" id="tax_id" name="tax_id">
                                            <option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.tax')); ?></option>
                                            <?php if(isset($arr_taxes) && sizeof($arr_taxes)>0): ?>
                                                <?php $__currentLoopData = $arr_taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($tax['id'] ?? ''); ?>"><?php echo e($tax['name'] ?? ''); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label><?php echo e(trans('admin.description')); ?></label>
                                        <textarea rows="5" cols="5" class="form-control" placeholder="<?php echo e(trans('admin.description')); ?>" name="description" id="description"></textarea>
                                    </div>
                                    
                                </div>

                                <div class="user-box user-box-upload-section">
                                   
                                    <div class="main-abt-title">
                                        <label class="name-labell"><?php echo e(trans('admin.images')); ?></label>
                                    </div>
                                   
                                    <div class="add-busine-multi">
                                        <span data-multiupload="3">
                                            <span data-multiupload-holder></span>
                                            <span class="upload-photo">
                                                <img src="<?php echo e(asset('/images/plus-img.jpg')); ?>" alt="plus img">
                                                <input data-multiupload-src class="upload_pic_btn" type="file" multiple="" data-rule-required="false"> 
                                                <span data-multiupload-fileinputs></span>
                                            </span>
                                        </span>
                                        <div class="clerfix"></div>
                                    </div>
                                 
                                    <div class="clearfix"></div>   

                                    <div class="photo-gallery mt-4">
                                        <div class="row photos item_images">

                                            
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="text-center py-3">
                            <button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-secondary btn-rounded closeForm"><?php echo e(trans('admin.cancel')); ?></button>
                        </div> 
                    </div>
                </form>

            </div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
<!-- modal -->


<script src="<?php echo e(asset('/js/handson/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/handson/common.js')); ?>"></script>
<script src="<?php echo e(asset('/js/handson/chosen.jquery.js')); ?>"></script>
<script src="<?php echo e(asset('/js/handson/handsontable-chosen-editor.js')); ?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
        $("#frmCreateRequest").validate();
		$("#frmAddItem").validate();


        var createUrl = "<?php echo e(Route('items_store')); ?>";
        $("#frmAddItem").submit(function(e) {
            e.preventDefault();
            if($(this).valid()) {

                actionUrl = createUrl;
                if($('input[name=action]').val() == 'update') {
                    actionUrl = updateUrl;
                }
                actionUrl = $(this).attr('action');

                $.ajax({
                    url: actionUrl,
                    type:'POST',
                    data : $(this).serialize(),
                    dataType:'json',
                    success:function(response)
                    {
                        common_ajax_store_action(response);
                    }
                });
            }
        });

	})
</script>

<script type="text/javascript">
(function($) {
"use strict";  

//appValidateForm($('#add_edit_pur_request-form'),{pur_rq_code:'required', pur_rq_name:'required', department:'required'});
var dataObject = [

];
var hotElement = document.querySelector('#example');
var hotElementContainer = hotElement.parentNode;
var hotSettings = {
    data: dataObject,
    columns: [
        {
            data: 'item_code',
            renderer: customDropdownRenderer,
            editor: "chosen",
            width: 150,
            chosenOptions: {
                data: [
                    <?php if(isset($arr_items) && !empty($arr_items)): ?>
                    <?php $__currentLoopData = $arr_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    {"id":"<?php echo e($item['id']); ?>","label":"<?php echo e($item['commodity_code'].' - '.$item['commodity_name']); ?>"},
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    ]          
            }
        },
        {
            data: 'unit_id',
            renderer: customDropdownRenderer,
            editor: "chosen",
            width: 150,
            chosenOptions: {
                data: [
                    <?php if(isset($arr_units) && !empty($arr_units)): ?>
                    <?php $__currentLoopData = $arr_units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    {"id":"<?php echo e($unit['id']); ?>","label":"<?php echo e($unit['unit_name']); ?>"},
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    ]
            },
            readOnly: true
        },
        {
            data: 'unit_price',
            type: 'numeric',
            numericFormat: {
                pattern: '0,0'
            },

        },
        {
            data: 'quantity',
            type: 'numeric',

        },
        {
            data: 'into_money',
            type: 'numeric',
            numericFormat: {
                pattern: '0,0'
            },
            readOnly: true
        },
        {
            data: 'inventory_quantity',
            type: 'numeric',
            readOnly: true
        },
    ],

    licenseKey: 'non-commercial-and-evaluation',
    stretchH: 'all',
    width: '100%',
    autoWrapRow: true,
    rowHeights: 30,
    columnHeaderHeight: 40,
    minRows: 10,
    maxRows: 22,
    rowHeaders: true,

    colHeaders: [
                'Items',
                'Unit',
                'Unit price',
                'Quantity',
                'Total'
                ],
    columnSorting: {
        indicator: true
    },
    autoColumnSize: {
        samplingRatio: 23
    },
    dropdownMenu: true,
    mergeCells: true,
    contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    multiColumnSorting: {
        indicator: true
    },
    hiddenColumns: {
        columns: [5],
        indicators: true
    },
    filters: true,
    manualRowResize: true,
    manualColumnResize: true
};

var hot = new Handsontable(hotElement, hotSettings);
hot.addHook('afterChange', function(changes, src) {
    changes.forEach(([row, prop, oldValue, newValue]) => {
        if(prop == 'item_code'){

            if(newValue) {
                $.ajax({
                    url: "<?php echo e(Route('get_item_details','')); ?>/"+btoa(newValue),
                    data : {
                        _token : "<?php echo e(csrf_token()); ?>"
                    },
                    method : 'POST',
                    success: function (response) {
                        console.clear();
                        hot.setDataAtCell(row,1, response.data.unit_id);
                        hot.setDataAtCell(row,2, response.data.purchase_price);
                        hot.setDataAtCell(row,3, response.data.purchase_price*hot.getDataAtCell(row,3));
                        hot.setDataAtCell(row,5, response.data.inventory);
                        //console.log(hot.getDataAtCell(row,0));

                    }
                });
            }

        }else if(prop == 'quantity'){
            hot.setDataAtCell(row,4, newValue*hot.getDataAtCell(row,2));
        }else if(prop == 'unit_price'){
            hot.setDataAtCell(row,4, newValue*hot.getDataAtCell(row,3));
        }

    });
});

$('#frmCreateRequest').submit(function(e){
    $('input[name="request_detail"]').val(JSON.stringify(hot.getData()));
});

})(jQuery);    

function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties) {
    "use strict";  
    var selectedId;
    var optionsList = cellProperties.chosenOptions.data;

    if(typeof optionsList === "undefined" || typeof optionsList.length === "undefined" || !optionsList.length) {
        Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
        return td;
    }

    var values = (value + "").split("|");
    value = [];
    for (var index = 0; index < optionsList.length; index++) {

        if (values.indexOf(optionsList[index].id + "") > -1) {
            selectedId = optionsList[index].id;
            value.push(optionsList[index].label);
        }
    }
    value = value.join(", ");

    Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
    return td;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/purchase/purchase_request/create.blade.php ENDPATH**/ ?>