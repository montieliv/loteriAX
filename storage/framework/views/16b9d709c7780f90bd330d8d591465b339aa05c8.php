<!DOCTYPE html>
<html>
<head>
    <!-- ... other head elements ... -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH /Applications/MAMP/htdocs/loteriAX/resources/views/layouts/app.blade.php ENDPATH**/ ?>