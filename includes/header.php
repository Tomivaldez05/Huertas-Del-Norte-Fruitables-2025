<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es-es">
<head>
    <meta charset="utf-8">
    <title>Huertas Del Norte</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<!-- Spinner -->
<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>

<!-- Navbar -->
<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white fs-6">Argentina</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white fs-6">huertasdelnorte.soporte@gmail.com</a></small>
            </div>
            <!--<div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">Política de Privacidad</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-2">Condiciones de Uso</small>/</a>
                <a href="#" class="text-white"><small class="text-white ms-2">Ventas y Devoluciones</small></a>
            </div>-->
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="index.php" class="navbar-brand"><img src="assets/img/LOGO.png" alt="Logo" style="height: 300px;"></a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item nav-link active" style="font-size: 18px;">Inicio</a>
                    <a href="shop.php" class="nav-item nav-link" style="font-size: 18px;">Tienda</a>
                    <a href="shop-detail.php" class="nav-item nav-link" style="font-size: 18px;">Detalle Tienda</a>
                    <!--<div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="carrito.php" class="dropdown-item">Carrito</a>
                            <a href="chackout.php" class="dropdown-item">Verificar</a>
                            <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                        </div>
                    </div>-->
                    <!--<a href="contact.php" class="nav-item nav-link">Contacto</a>-->
                </div>
                <div class="d-flex m-3 me-0">
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                    <div class="position-relative me-4 my-auto" id="carritoContainer">
                        <a href="carrito.php" class="position-relative" id="carritoDropdown">
                            <i class="fa fa-shopping-cart fa-2x"></i>
                            <span id="contador-carrito" class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;">0</span>
                        </a>
                        <div id="resumen-carrito" class="bg-white border rounded p-3 shadow position-absolute" style="top: 40px; right: 0; min-width: 250px; z-index: 999; display: none;">
                            <p class="mb-0">Cargando...</p>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['nombre_usuario'])): ?>
                        <div class="d-flex align-items-center">
                            <span class="me-3 my-auto text-primary fw-bold">👋 Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
                            <a href="logout.php" class="btn btn-outline-secondary btn-sm my-auto">Cerrar sesión</a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="my-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Modal Search -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar por palabra clave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
