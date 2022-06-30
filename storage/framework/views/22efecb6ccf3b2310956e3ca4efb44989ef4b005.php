<?php if(isset($arr_parts_data) && sizeof($arr_parts_data)>0): ?>
<?php $__empty_1 = true; $__currentLoopData = $arr_parts_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td>
            <?php echo e($product['part']['commodity_name'] ?? ''); ?> - <?php echo e($product['part_no'] ?? 0); ?>


            <input type="hidden" name="products[<?php echo e($loop->index + $index); ?>][part_id]" value="<?php echo e($product['part_id'] ?? 0); ?>">
            <input type="hidden" name="products[<?php echo e($loop->index + $index); ?>][part_no]" value="<?php echo e($product['part_no'] ?? 0); ?>">
        </td>
        <td>
            <input style="width:100px;" type="number" class="form-control" min=1
            name="products[<?php echo e($loop->index + $index); ?>][quantity]" value="<?php if(isset($product->quantity)): ?><?php echo e($product->quantity); ?><?php else: ?><?php echo e(1); ?><?php endif; ?>">
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


<?php endif; ?>
<?php endif; ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/vechicle_maintance/print_labels/show_table_rows.blade.php ENDPATH**/ ?>