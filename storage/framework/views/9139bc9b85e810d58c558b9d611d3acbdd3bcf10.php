<?php $__env->startSection('main_content'); ?>

<script src="<?php echo e(asset('/js/print.min.js')); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('/css/print.min.css')); ?>">



<button type="button" id="printBtn">
Print PDF
</button>

<script type="text/javascript">
	
	function myPrint(){
	  printJS("<?php echo e(url('public/assets/sample.pdf')); ?>");

	  (function () {

        var beforePrint = function () {
            alert('Functionality to run before printing.');
        };

        var afterPrint = function () {
            alert('Functionality to run after printing');
        };

        if (window.matchMedia) {
            var mediaQueryList = window.matchMedia('print');

            mediaQueryList.addListener(function (mql) {
                //alert($(mediaQueryList).html());
                if (mql.matches) {
                    beforePrint();
                } else {
                    afterPrint();
                }
            });
        }

        window.onbeforeprint = beforePrint;
        window.onafterprint = afterPrint;

    }());


	}
	$('#printBtn').click(myPrint);


</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sample_pages/payroll.blade.php ENDPATH**/ ?>