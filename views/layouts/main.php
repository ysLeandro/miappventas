<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => '🎬 Movies-Prime',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark fixed-top shadow-sm']
    ]);

    // Menú Izquierdo: Navegación de secciones
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto'],
        'items' => [
            ['label' => 'Inicio', 'url' => ['/site/index']],
            [
                'label' => 'Gestionar Películas',
                'items' => [
                    ['label' => 'Películas', 'url' => ['/pelicula/index']],
                    ['label' => 'Géneros', 'url' => ['/genero/index']],
                    ['label' => 'Actores', 'url' => ['/actor/index']],
                    ['label' => 'Directores', 'url' => ['/director/index']],
                    // Menú condicional: Solo si el usuario es Admin ve la opción User
                    (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin') ? ['label' => 'Usuarios', 'url' => ['/user/index']] : '',
                ],
            ],
            Yii::$app->user->isGuest ? '' : ['label' => 'Cambiar Contraseña', 'url' => ['/user/change-password']],
        ]
    ]);

    // Menú Derecho: Barra superior responsiva con el nombre y rol del usuario logueado
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto align-items-center'],
        'items' => [
            Yii::$app->user->isGuest
                ? ['label' => 'Iniciar Sesión', 'url' => ['/site/login'], 'linkOptions' => ['class' => 'btn btn-outline-primary px-3 rounded-pill text-white']]
                : '<li class="nav-item d-flex align-items-center">'
                    . '<span class="text-secondary small me-2">'
                    . '👤 ' . Html::encode(Yii::$app->user->identity->nombre . ' ' . Yii::$app->user->identity->apellido)
                    . ' <span class="badge bg-dark border border-secondary text-capitalize ms-1">' . Html::encode(Yii::$app->user->identity->role) . '</span>'
                    . '</span>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
                    . Html::submitButton('Salir', ['class' => 'logout-btn ms-2'])
                    . Html::endForm()
                    . '</li>'
        ]
    ]);

    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main" style="padding-top: 90px; margin-bottom: 40px;">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
                'options' => ['class' => 'breadcrumb mb-4']
            ]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-4 text-secondary border-top border-secondary" style="background-color: #090d14 !important;">
    <div class="container">
        <div class="row align-items-center text-center text-md-start">
            <div class="col-md-6 mb-2 mb-md-0 text-white-50">
                &copy; <strong>Movies-Prime</strong> <?= date('Y') ?> | Catálogo de Cine Digital. Todos los derechos reservados.

            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="badge bg-dark border border-secondary rounded-pill px-3 py-2 text-secondary">Responsive UI v2.0</span>
                <span class="badge bg-primary rounded-pill px-3 py-2 ms-1">Bootstrap 5</span>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
