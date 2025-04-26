@extends('layouts.app')
@section('content')
<div class="row">
    <h1>La carta ganadora es...</h1>
<div id="carouselCards" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach($order_card as $key => $cardId)
            @php
                $card = DB::table('cartas')->where('idcarta', $cardId)->first();
            @endphp
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <div class="card">
                    <img class="img-fluid" 
                        width="300"
                        height="450"
                         src="{{ asset('img/cards/' . $card->scrCarta) }}" 
                         alt="Card {{ $card->nombre }}">
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Navigation Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselCards" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselCards" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

    <!-- Indicators -->
    <div class="carousel-indicators">
        @foreach($order_card as $key => $cardId)
            <button type="button" 
                    data-bs-target="#carouselCards" 
                    data-bs-slide-to="{{ $key }}" 
                    class="{{ $key === 0 ? 'active' : '' }}" 
                    aria-current="{{ $key === 0 ? 'true' : 'false' }}" 
                    aria-label="Slide {{ $key + 1 }}">
            </button>
        @endforeach
    </div>
</div>

<!-- Velocity Controls -->
<div class="velocity-controls mt-3 mb-3 text-center">
    <div class="btn-group" role="group" aria-label="Velocity Controls">
        <button type="button" class="btn btn-secondary" onclick="changeVelocity(1000)">Slow</button>
        <button type="button" class="btn btn-secondary active" onclick="changeVelocity(300)">Normal</button>
        <button type="button" class="btn btn-secondary" onclick="changeVelocity(100)">Fast</button>
    </div>
    <button type="button" class="btn btn-primary ms-2" onclick="toggleAutoplay()" id="playPauseBtn">
        <span id="autoplayText">Pause</span>
    </button>
</div>
<div class="footer"><a href="CerrarSorteo/{{$sorteoID}}/{{$matching_cards[0]->idcarta}}/ {{$price_sorteo}}" class="btn btn-danger mb-3" style="margin-left: 3%;">Cerrar Sorteo</a><a href="/" class="btn btn-danger mb-3" style="margin-left: 3%;">Inicio</a></div>
<!-- Add required CSS -->
<style>
    .row>* {
        width: 60%;
    }
    .carousel-item {
        transition: transform .6s ease-in-out;
    }
    
    .carousel-item img {
        max-height: 400px;
        object-fit: contain;
    }
    
    .carousel-indicators {
        bottom: -50px;
    }
    
    .carousel-indicators button {
        background-color: #666;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
    }

    .velocity-controls .btn-group .btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
</style>

<!-- Add required JavaScript -->
<script>
let carousel;
let currentSlide = 0;
let isPlaying = true;
let currentInterval = 300;
const totalSlides = {{ count($order_card) }};

document.addEventListener('DOMContentLoaded', function() {
    carousel = new bootstrap.Carousel(document.getElementById('carouselCards'), {
        interval: currentInterval,
        wrap: false,  // Prevents wrapping around
        keyboard: true
    });

    // Listen for slide changes
    document.getElementById('carouselCards').addEventListener('slide.bs.carousel', function (e) {
        currentSlide = e.to;
        
        // Stop at last slide
        if (currentSlide === totalSlides - 1) {
            setTimeout(() => {
                stopCarousel();
            }, currentInterval);
        }
    });
});

function changeVelocity(interval) {
    // Update active button state
    document.querySelectorAll('.velocity-controls .btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');

    currentInterval = interval;
    
    // Only update if carousel is playing and not on last slide
    if (isPlaying && currentSlide < totalSlides - 1) {
        restartCarousel();
    }
}

function toggleAutoplay() {
    const autoplayText = document.getElementById('autoplayText');
    
    if (isPlaying) {
        stopCarousel();
    } else if (currentSlide < totalSlides - 1) {
        startCarousel();
    }
}
    @php
        $ganadorSorteo = DB::table('ventas')
                    ->where('number_card', $idCartaGanadora)
                    ->where('id_lottery', $sorteoID)
                    ->first()
                    ->buyer_name;
        $message = $matching_cards[0]->nombre."!, Premio:".$price_sorteo." <br> Ganador :".$ganadorSorteo ;
    @endphp

function stopCarousel() {
    carousel.pause();
    isPlaying = false;
    const h1 = document.querySelector('h1');
    h1.innerHTML  +=  "<?php echo $message; ?>";
    document.getElementById('autoplayText').textContent = 'Play';
}

function startCarousel() {
    carousel.cycle();
    isPlaying = true;
    document.getElementById('autoplayText').textContent = 'Pause';
}

function restartCarousel() {
    carousel.dispose();
    carousel = new bootstrap.Carousel(document.getElementById('carouselCards'), {
        interval: currentInterval,
        wrap: false,
        keyboard: true
    });
    
    if (isPlaying && currentSlide < totalSlides - 1) {
        carousel.cycle();
    }
}

// Add keyboard controls
document.addEventListener('keydown', function(event) {
    switch(event.key) {
        case 'ArrowLeft':
            carousel.prev();
            break;
        case 'ArrowRight':
            carousel.next();
            break;
        case ' ': // Spacebar
            event.preventDefault();
            toggleAutoplay();
            break;
    }
});
</script>

      
@endsection
