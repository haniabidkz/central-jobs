<!-- include Header -->
    <?php echo $__env->make('frontend.includes.header_after_login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- End include Header -->
    <?php echo $__env->yieldContent('content'); ?>
   <!-- main End -->
<!-- include footer -->
    <?php echo $__env->make('frontend.includes.footer_after_login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- include footer -->
<?php /**PATH /var/www/html/centralJobs/resources/views/layouts/app_before_login_layout.blade.php ENDPATH**/ ?>