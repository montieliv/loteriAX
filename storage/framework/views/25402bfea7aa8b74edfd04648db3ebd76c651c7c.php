<?php $__env->startSection('content'); ?>
<script> 
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.responsive-image');
        
        // Implement lazy loading with IntersectionObserver
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.src; // This will trigger the actual image load
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        }
         });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const saleModal = new bootstrap.Modal(document.getElementById('saleModal'));
    const sellButtons = document.querySelectorAll('.sell-button');
    const confirmSaleButton = document.getElementById('confirmSale');
    const modalStatus = document.getElementById('modalStatus');

    sellButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const cardNumber = this.getAttribute('data-card');
            document.getElementById('cardNumber').value = cardNumber;
            saleModal.show();
        });
    });
});
</script>

<style>
    .responsive-imagex {
        width: 80%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
        position: middle;
        margin-bottom: .25rem;
        padding-left: 0rem;
        border: .0625rem solid #e5e5e5;
        border-radius: .25rem;"
    }
    /* Zoom effect on hover */
    .image-container:hover .responsive-image {
        transform: scale(1.1);
        position: relative;
        z-index: 1000;
    }

    /* Optional: Add media queries for different screen sizes */
    @media (max-width: 768px) {
        .image-container:hover .responsive-image {
            transform: scale(1.3);
        }
    }

    @media (max-width: 480px) {
        .image-container:hover .responsive-image {
            transform: scale(1.2);
        }
    }
    .deshabilitado {
    pointer-events: none;
    color: gray;
    text-decoration: none;
}
</style>
    <?php $__currentLoopData = $lotteries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lottery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            function stringToArray(string $string): array
            {
                return array_filter(explode(',', $string));
            }
            $string = $lottery->order_cards;
            $arrayCards = stringToArray($string);
            $sizeC=sizeof($arrayCards);

            $string2 = $lottery->cost_cards;
            $arrayCostCards = stringToArray($string2);

            $string3 = $lottery->prize_cards;
            $arrayPrizeCards = stringToArray($string3);
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saleModalLabel">Vender Carta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saleForm" action="<?php echo e(route('lottery.sell')); ?>" method="POST" >
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="cardNumber" name="cardNumber">
                    <input type="hidden" id="lotteryId" name="lotteryId" value="<?php echo e($lottery->id); ?> ">
                    <div class="mb-3">
                        <label for="buyerName" class="form-label">Nombre del Comprador</label>
                        <input type="text" class="form-control" id="buyerName" name="buyerName" required>
                    </div>
                </form>
            </div>
            <div class="modal-body" id="modalStatus"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="confirmSale">Confirmar Venta</button>
                <script>
                    document.getElementById('confirmSale').addEventListener('click', function() {
                        document.getElementById('saleForm').submit();
                    });
                </script>
                
            </div>
        </div>
    </div>
</div>
    <h1>Sorteal Actual #<?php echo e($lottery->id); ?>  <a href="/" class="btn btn-info mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"></path>
</svg>Inicio</a></h1>
        
<div class="row">
        <div class="row g-2">
            <?php for($j = 0; $j <= $sizeC-1; $j++): ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="image-container">
                        <?php $nameCard=$arrayCards[$j] ?>
                        <?php
                                    $vendida = App\Models\Venta::select('buyer_name')
                                                            ->where('id_lottery', $lottery->id)
                                                            ->where('number_card', $arrayCards[$j])
                                                            ->first()
                        ?>
                        <img src="<?php echo e(asset('img/cards/' .$nameCard. '.jpg')); ?>" 
                            class="responsive-imagex image-container:hover responsive-image" 
                            alt="Card <?php echo e($arrayCards[$j]); ?>"
                            loading="lazy">
                            <div>
                                <p class="card-text text-center mb-0">Costo <?php echo e($arrayCostCards[$j]); ?>

                                Premio <?php echo e($arrayPrizeCards[$j]); ?><br>
                                <a href="#" 
                                class="btn <?php echo e($vendida ? 'btn-danger' : 'btn-success btn-sm sell-button'); ?>" 
                                class="<?php echo e($vendida ? 'deshabilitado' : ''); ?>"
                                data-card="<?php echo e($arrayCards[$j]); ?>"
                                <?php echo e($vendida ? 'disabled' : ''); ?>>
                                    <?php echo e($vendida ?  $vendida["buyer_name"] : 'Vender'); ?>

                                </a>
                            </p>
                            </div>
                        
                    </div>
                </div>
            <?php endfor; ?>
            </div>
</div>

<?php $__env->stopSection(); ?>
                    
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/loteriAX/resources/views/lotteries/actuals.blade.php ENDPATH**/ ?>