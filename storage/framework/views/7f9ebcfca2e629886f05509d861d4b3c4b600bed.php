<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Card</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            border-spacing: 30px;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        #parts_table {
            margin-top: 30px;
        }
        .bold{font-weight: bold;}
    </style>
</head>

<body style="max-width: 700px;margin:auto">
    <h2 style="text-align: center;">JOB CARD</h2>
    <table>
        <tr>
            <td>Job Card No.</td>
            <td>Door No.</td>
            <td>Hour Meter</td>
            <td>Date</td>
        </tr>
        <tr>
            <td><?php echo e($arr_data['jobcard_no']?? ''); ?></td>
            <td><?php echo e($arr_data['door_no']?? ''); ?></td>
            <td><?php echo e($arr_data['hours_meter']?? ''); ?></td>
            <td><?php echo e($arr_data['delivery_date']?? ''); ?></td>
        </tr>
        <tr>
            <td>Model</td>
            <td colspan="2">Chassis No.</td>
            <td>Time</td>
        </tr>
        <tr>
            <td>
            <?php if(isset($arr_data['vechicle_details']) && sizeof($arr_data['vechicle_details'])>0): ?>
                <?php if(isset($arr_model) && sizeof($arr_model)>0): ?>
                    <?php $__currentLoopData = $arr_model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($model['id'] == $arr_data['vechicle_details']['model']): ?>
                            <span><?php echo e($model['model_name'] ?? 0); ?></span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <?php endif; ?>
            </td>
            <td colspan="2" rowspan="3"><?php echo e($arr_data['vechicle_details']['chasis_no']?? ''); ?></td>
            <td><?php echo e($arr_data['time']?? ''); ?></td>
        </tr>
        <tr>
            <td>Plate No.</td>
            <td>KM Count</td>
        </tr>
        <tr>
            <td><?php echo e($arr_data['vechicle_details']['plate_no']?? ''); ?></td>
            <td><?php echo e($arr_data['km_count']?? ''); ?></td>
        </tr>
        <tr>
            <td colspan="4"><span class="bold">Complaint:</span> <br/> <?php echo e($arr_data['complaint']?? ''); ?></td>
        </tr>
        <tr>
            <td colspan="4"><span class="bold">Diagnosis:</span> <br/> <?php echo e($arr_data['diagnosis']?? ''); ?></td>
        </tr>
        <tr>
            <td colspan="4"><span class="bold">Action:</span> <br/> <?php echo e($arr_data['action']?? ''); ?></td>
        </tr>
    </table>
    <!-- parts table -->
    <table id="parts_table">
        <tr>
            <td colspan="5">Parts Used:-</td>
        </tr>
        <tr>
            <td>SN</td>
            <td>Part No.</td>
            <td>Part Name</td>
            <td>Qyt.</td>
            <td>Cost</td>
        </tr>
        <?php if(isset($arr_data['vhc_part_detail']) && sizeof($arr_data['vhc_part_detail'])>0): ?>
        <?php $index = 0;  ?>
        <?php $__currentLoopData = $arr_data['vhc_part_detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p_key => $p_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $index +=1;
        ?>
        <tr>
            <td><?php echo e($index); ?></td>
            <?php if(isset($arr_parts) && sizeof($arr_parts)>0): ?>
                <?php $__currentLoopData = $arr_parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($p_val['part_id'] == $part['part']['id']): ?>
                        <td><?php echo e($p_val['part_id'] ?? ''); ?></td>
                        <td><?php echo e($part['part']['commodity_name'] ?? 0); ?></td>
                        <td><?php echo e($p_val['quantity']); ?></td>
                        <td><?php echo e($part['purchase_order'][0]['total'] ?? 0); ?></td>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
        <?php endif; ?>
        </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <!-- <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr> -->
    </table>
</body>

</html><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/vechicle_maintance/repair/show.blade.php ENDPATH**/ ?>