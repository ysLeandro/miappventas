<?php 
/** @var yii\web\View $this */
/** @var app\models\Pelicula[] $peliculas */

use yii\helpers\Html;

$this->title = 'Movies-Prime | Inicio';
?>

<div class="site-index bg-transparent text-white">

    <div class="container py-5 text-center">
        <h1 class="fw-bold display-5">Movies-Prime</h1>
        <p class="text-secondary lead">Tu catálogo digital premium de películas y cine</p>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div id="carouselMovies" class="carousel slide shadow-lg" data-bs-ride="carousel" style="border-radius: 20px; overflow: hidden; border: 1px solid #1c2538;">
                    
                    <div class="carousel-inner" style="height: 450px; background-color: #131927;">
                        <div class="carousel-item active h-100">
                            <div class="w-100 h-100" style="background: linear-gradient(rgba(0,0,0,0.2), #0c111b), url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=1425&auto=format&fit=crop') center/cover no-repeat;"></div>
                            <div class="carousel-caption text-start pb-5 px-4">
                                <h2 class="fw-bold display-6 text-white mb-2">Bienvenidos al Cine Digital</h2>
                                <p class="text-secondary col-md-8">Descubre los últimos lanzamientos y gestiona tu base de datos cinematográfica de forma rápida e interactiva.</p>
                            </div>
                        </div>
                        <div class="carousel-item h-100">
                            <div class="w-100 h-100" style="background: linear-gradient(rgba(0,0,0,0.2), #0c111b), url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat;"></div>
                            <div class="carousel-caption text-start pb-5 px-4">
                                <h2 class="fw-bold display-6 text-white mb-2">Administración Centralizada</h2>
                                <p class="text-secondary col-md-8">Control absoluto para organizar películas, asignar portadas personalizadas y clasificar todo tu contenido en tiempo real.</p>
                            </div>
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMovies" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMovies" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                
                <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                    <h4 class="fw-bold text-white-50 m-0">Últimos Lanzamientos</h4>
                    <?= Html::a('Ver Todo →', ['/pelicula/index'], ['class' => 'text-primary text-decoration-none small fw-bold']) ?>
                </div>
                
                <div class="position-relative movie-slider-wrapper">
                    
                    <button class="slider-arrow btn-left" id="slideLeftBtn" aria-label="Desplazar a la izquierda">‹</button>
                    
                    <div class="movie-slider-container" id="movieSlider">
                        <?php if (!empty($peliculas)): ?>
                            <?php foreach ($peliculas as $pelicula): ?>
                                <div class="movie-slider-card">
                                    <?php 
                                    $rutaFisicaArchivo = Yii::getAlias('@webroot') . '/portadas/' . $pelicula->portada;
                                    $tieneImagenValida = !empty($pelicula->portada) && file_exists($rutaFisicaArchivo) && preg_match('/\.(jpg|jpeg|png|webp)$/i', $pelicula->portada);
                                    ?>

                                    <?= Html::a(
                                        '<div class="movie-img-wrapper">' . 
                                            ($tieneImagenValida 
                                                ? Html::img(Yii::getAlias('@web') . '/portadas/' . $pelicula->portada, ['class' => 'img-fluid', 'alt' => $pelicula->titulo, 'style' => 'width:100%; height:100%; object-fit:cover;'])
                                                : '<div class="no-cover-placeholder d-flex flex-column align-items-center justify-content-center p-3 text-center h-100">' .
                                                    '<span class="fs-3 mb-1">🎬</span>' .
                                                    '<span class="text-secondary" style="font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">' . Html::encode($pelicula->titulo) . '</span>' .
                                                  '</div>'
                                            ) . 
                                        '</div>' .
                                        '<div class="movie-title-footer text-truncate">' . Html::encode($pelicula->titulo) . '</div>',
                                        ['/pelicula/view', 'idpelicula' => $pelicula->idpelicula],
                                        ['class' => 'text-decoration-none']
                                    ) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-secondary ms-2 small">No hay películas registradas en este momento.</p>
                        <?php endif; ?>
                    </div>
                    
                    <button class="slider-arrow btn-right" id="slideRightBtn" aria-label="Desplazar a la derecha">›</button>

                </div>

            </div>
        </div>
    </div>

</div>

<?php
// Script JS para mover el slider de forma fluida mediante las flechas
$js = <<<JS
    const slider = document.getElementById('movieSlider');
    const btnLeft = document.getElementById('slideLeftBtn');
    const btnRight = document.getElementById('slideRightBtn');

    if (slider && btnLeft && btnRight) {
        // Al hacer clic en la flecha izquierda, retrocede de forma fluida
        btnLeft.addEventListener('click', () => {
            slider.scrollBy({
                left: -650, 
                behavior: 'smooth'
            });
        });

        // Al hacer clic en la flecha derecha, avanza de forma fluida
        btnRight.addEventListener('click', () => {
            slider.scrollBy({
                left: 650, 
                behavior: 'smooth'
            });
        });
    }
JS;
$this->registerJs($js);
?>