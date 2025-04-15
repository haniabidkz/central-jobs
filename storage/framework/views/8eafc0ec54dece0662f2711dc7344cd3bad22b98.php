
    <?php echo $__env->make('frontend.includes.header_after_login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>


    <?php echo $__env->make('frontend.includes.footer_after_login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /var/www/html/centralJobs/resources/views/layouts/app_after_login_layout.blade.php ENDPATH**/ ?>