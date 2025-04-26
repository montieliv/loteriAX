<x-modal id="saleModal" title="Vender Carta">
    <form id="saleForm" action="{{ route('vender.carta') }}" method="POST">
        @csrf
        <input type="hidden" id="cardNumber" name="cardNumber">
        <input type="hidden" id="lotteryId" name="lotteryId" value="{{ $lottery->id }}">
        
        <div class="mb-3">
            <label for="buyerName" class="form-label">Nombre del Comprador</label>
            <input type="text" class="form-control" id="buyerName" name="buyerName" required>
        </div>

        <div id="modalStatus"></div>
    </form>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="confirmSale">Confirmar Venta</button>
    </x-slot>
</x-modal>
