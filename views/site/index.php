<?php 
/** @var yii\web\View $this */
$this->title = 'Movies-Prime';
?>

<div class="site-index bg-dark text-white">

    <!-- HERO SIMPLE -->
    <div class="container py-5">
        <h1 class="fw-light">Movies-Prime</h1>
        <p class="text-secondary">Explora películas, actores y géneros</p>
    </div>

    <!-- CAROUSEL LIMPIO -->
    <div id="carouselMovies" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="https://via.placeholder.com/1400x500" class="d-block w-100" style="object-fit: cover; height: 500px;">
                <div class="carousel-caption text-start">
                    <h3 class="fw-light">Película 1</h3>
                    <p class="text-light">Descripción breve.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="https://via.placeholder.com/1400x500" class="d-block w-100" style="object-fit: cover; height: 500px;">
                <div class="carousel-caption text-start">
                    <h3 class="fw-light">Película 2</h3>
                    <p class="text-light">Otra descripción.</p>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMovies" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselMovies" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- SECCIONES -->
    <div class="container py-5">

        <div class="row text-center">

            <div class="col-md-4">
                <h5 class="fw-light">Películas</h5>
                <p class="text-secondary small">Catálogo disponible</p>
                <a class="btn btn-outline-light btn-sm" href="#">Explorar</a>
            </div>

            <div class="col-md-4">
                <h5 class="fw-light">Actores</h5>
                <p class="text-secondary small">Información y biografías</p>
                <a class="btn btn-outline-light btn-sm" href="#">Ver más</a>
            </div>

            <div class="col-md-4">
                <h5 class="fw-light">Géneros</h5>
                <p class="text-secondary small">Clasificación de contenido</p>
                <a class="btn btn-outline-light btn-sm" href="#">Descubrir</a>
            </div>

        </div>

    </div>

</div>