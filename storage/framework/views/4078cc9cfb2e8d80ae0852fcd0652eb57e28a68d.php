<?php $__env->startSection('content'); ?>
<div class="row">
    <h1>Bienvenido! 
    <a href="<?php echo e(route('lotteries.create')); ?>" class="btn btn-primary mb-3">Crear Nuevo Sorteo</a>
    <a href="/" class="btn btn-danger mb-3">Inicio</a></h1>
    <div class="table table-bordered">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Orden de las Cartas</th>
                    <th>Costos</th>
                    <th>Premios</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $lotteries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lottery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($lottery->date->format('d-m-Y')); ?></td>
                    <td> <textarea rows="4" cols="35" readonly><?php echo e($lottery->order_cards); ?></textarea></td>
                    <td> <textarea rows="4" cols="35" readonly><?php echo e($lottery->cost_cards); ?></textarea></td>
                    <td> <textarea rows="4" cols="35" readonly><?php echo e($lottery->prize_cards); ?></textarea> 
                    <td><?php echo e(ucfirst($lottery->status)); ?><br> Sorteo #<?php echo e($lottery->id); ?></td>
                    <td>
                        <a href="<?php echo e(route('lotteries.show', $lottery)); ?>" class="btn btn-sm btn-info">View</a>
                        <a href="<?php echo e(route('lotteries.edit', $lottery)); ?>" class="btn btn-sm btn-primary">Edit</a>
                        <form action="<?php echo e(route('lotteries.destroy', $lottery)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/loteriAX/resources/views/lotteries/index.blade.php ENDPATH**/ ?>