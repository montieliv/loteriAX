<?php $__env->startSection('content'); ?>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Get the input element
    const costInput = document.getElementById('cost_cards');
    array1=costInput.value.split(',');
    array2=[];
    for (let i = 0; i < array1.length; i++) {
        if (array1[i] == '$5') {
            array2.push("$50");
        } else if (array1[i] == '$10') {
            array2.push("$100");
        } else if (array1[i] == '$20') {
            array2.push("$200");
        } else if (array1[i] == '$30') {
            array2.push("$300");
        }
    }
    document.getElementById('prize_cards').value = array2;
});
</script>

<?php
function obtenerNumerosAleatorios() {
    // Crear un array con los números del 1 al 54
    $numeros = range(1, 54);
    
    // Mezclar el array aleatoriamente
    shuffle($numeros);
    
    // Convertir el array en una cadena de texto separada por comas
    return implode(',', $numeros);
}

function generarCostoNumeros() {
    // Inicializar el array
    $numeros = array();

    // Añadir los números especificados
    $numeros = array_merge($numeros, array_fill(0, 5, 300)); // 5 veces 300
    $numeros = array_merge($numeros, array_fill(0, 10, 200)); // 10 veces 200
    $numeros = array_merge($numeros, array_fill(0, 14, 100)); // 14 veces 100
    $numeros = array_merge($numeros, array_fill(0, 25, 50));  // 25 veces 50

    // Calcular cuántos números adicionales se necesitan para llegar a 54
    $cantidadActual = count($numeros);
    $cantidadFaltante = 54 - $cantidadActual;

    // Si es necesario, añadir números aleatorios para completar la lista
    if ($cantidadFaltante > 0) {
        $numerosAleatorios = array_merge(
            array_fill(0, $cantidadFaltante, rand(1, 300))
        );
        $numeros = array_merge($numeros, $numerosAleatorios);
    }
    // Mezclar el array para obtener un orden aleatorio
    shuffle($numeros);
    $contador=0;
    foreach ($numeros as $numero) {
        $contador++;
        if ($contador <= 53) {
            if ($numero == 50) {
                echo "$5,";
            } elseif ($numero == 100) {
                echo "$10,";
            } elseif ($numero == 200) {
                echo "$20,";
            } elseif ($numero == 300) {
                echo "$30,";
            }
        } else {
            if ($numero == 50) {
                echo "$5";
            } elseif ($numero == 100) {
                echo "$10";
            } elseif ($numero == 200) {
                echo "$20";
            } elseif ($numero == 300) {
                echo "$30";
            }
        }
        
    }
    // Convertir el array en una cadena de texto separada por comas
    return null;
}

?>

<div class="container">
    <h1>Crear Nuevo Sorteo</h1>

    <form action="<?php echo e(route('lotteries.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="date">Fecha</label>
            <input type="date" class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
            <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="form-group">
            <label for="cost_cards">Orden Aleatorio de las Cartas</label>
            <input type="text"  class="form-control <?php $__errorArgs = ['order_cards'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   id="order_cards" name="order_cards" value="<?php echo obtenerNumerosAleatorios(); ?>" required>
            <?php $__errorArgs = ['cost_cards'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="cost_cards">Costo Aleatorio de las Cartas</label>
            <input type="text" class="form-control <?php $__errorArgs = ['cost_cards'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   id="cost_cards" name="cost_cards" value="<?php echo generarCostoNumeros(); ?>"  required>
            <?php $__errorArgs = ['cost_cards'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="prize_cards">Premio Aleatorio de las Cartas</label>
            <input type="text"   class="form-control <?php $__errorArgs = ['prize_cards'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   id="prize_cards" name="prize_cards" value="" required>
            <?php $__errorArgs = ['prize_cards'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="btn btn-primary">Crear Nuevo Sorte</button>
        <a href="<?php echo e(route('lotteries.index')); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/loteriAX/resources/views/lotteries/create.blade.php ENDPATH**/ ?>