<?php include 'includes/header.php'; ?>


        <!-- Modal Search Start -->
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
        <!-- Modal Search End -->


        <!-- Hero Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 text-secondary">Alimentos 100% orgánicos</h4>
                        <h1 class="mb-5 display-3 text-primary">Frutas y Verduras ORGÁNICAS</h1>
                        <div class="position-relative mx-auto">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number" placeholder="Nombre Producto">
                            <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Buscar</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="assets/img/hero-img-1.png" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Frutas</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="assets/img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Verduras</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->


        <!-- Featurs Section Start -->
        <div class="container-fluid featurs py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-car-side fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Envíos a Domicilio</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-user-shield fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Pago con seguridad</h5>
                                <p class="mb-0">Pago con 100% de seguridad</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-exchange-alt fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Devoluciones en 30 días</h5>
                                <p class="mb-0">Garantía de reembolso por 30 días</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fa fa-phone-alt fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Soporte 24/7</h5>
                                <p class="mb-0">Soporte rápido en todo momento</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featurs Section End -->


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>Nuestros productos orgánicos</h1>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                        <span class="text-dark" style="width: 170px;">Todos los Productos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                        <span class="text-dark" style="width: 110px;">Verduras</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                        <span class="text-dark" style="width: 110px;">Frutas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                        <span class="text-dark" style="width: 110px;">Panadería</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-2.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Frambuesa</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-4.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Albaricoques</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-3.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Banana</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-1.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Naranjas</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-2.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Frambuesa</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Uvas</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Uvas</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-2.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Frambuesa</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-1.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Naranjas</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Manzana</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Uvas</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-4.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Albaricoques</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-5" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-3.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Banana</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-2.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Frambuesas</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/fruite-item-1.jpg" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Frutas</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>Naranjas</h4>
                                                    <p>(Descripción)</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->


        <!-- Featurs Start -->
        <!--<div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-secondary rounded border border-secondary">
                                <img src="assets/img/featur-1.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-primary text-center p-4 rounded">
                                        <h5 class="text-white">Manzanas frescas</h5>
                                        <h3 class="mb-0">20% OFF</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-dark rounded border border-dark">
                                <img src="assets/img/featur-2.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-light text-center p-4 rounded">
                                        <h5 class="text-primary">Frutas sabrosas</h5>
                                        <h3 class="mb-0">Entrega gratis</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-primary rounded border border-primary">
                                <img src="assets/img/featur-3.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-secondary text-center p-4 rounded">
                                        <h5 class="text-white">Vegetales exóticos</h5>
                                        <h3 class="mb-0">Descuento de 30$</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Featurs End -->


        <!-- Vesitable Shop Start-->
        <div class="container-fluid vesitable py-5">
            <div class="container py-5">
                <h1 class="mb-0">Verduras orgánicas frescas</h1>
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="assets/img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Verduras</div>
                        <div class="p-4 rounded-bottom">
                            <h4>Lechuga</h4>
                            <p>(Descripción)</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="assets/img/vegetable-item-1.jpg" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Verduras</div>
                        <div class="p-4 rounded-bottom">
                            <h4>Tomate</h4>
                            <p>(Descripción)</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="assets/img/vegetable-item-3.png" class="img-fluid w-100 rounded-top bg-light" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Frutas</div>
                        <div class="p-4 rounded-bottom">
                            <h4>Banana</h4>
                            <p>(Descripción)</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="assets/img/vegetable-item-4.jpg" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Verduras</div>
                        <div class="p-4 rounded-bottom">
                            <h4>Morron</h4>
                            <p>(Descripción)</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="assets/img/vegetable-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Verduras</div>
                        <div class="p-4 rounded-bottom">
                            <h4>Papa</h4>
                            <p>(Descripción)</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="assets/img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Verduras</div>
                        <div class="p-4 rounded-bottom">
                            <h4>Parsely</h4>
                            <p>(Descripción)</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="assets/img/vegetable-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Verduras</div>
                        <div class="p-4 rounded-bottom">
                            <h4>Potatoes</h4>
                            <p>(Descripción)</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="assets/img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Verduras</div>
                        <div class="p-4 rounded-bottom">
                            <h4>Parsely</h4>
                            <p>(Descripción)</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vesitable Shop End -->


        <!-- Banner Section Start-->
        <!--<div class="container-fluid banner bg-secondary my-5">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="py-4">
                            <h1 class="display-3 text-white">Fresh Exotic Fruits</h1>
                            <p class="fw-normal display-3 text-dark mb-4">in Our Store</p>
                            <p class="mb-4 text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic words etc.</p>
                            <a href="#" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">BUY</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="assets/img/baner-1.png" class="img-fluid w-100 rounded" alt="">
                            <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute" style="width: 140px; height: 140px; top: 0; left: 0;">
                                <h1 style="font-size: 100px;">1</h1>
                                <div class="d-flex flex-column">
                                    <span class="h2 mb-0">50$</span>
                                    <span class="h4 text-muted mb-0">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Banner Section End -->


        <!-- Bestsaler Product Start -->
        <!--<div class="container-fluid py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-4">Productos más vendidos</h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="assets/img/best-product-1.jpg" class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5">Organic Tomato</a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="mb-3">3.12 $</h4>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="assets/img/best-product-2.jpg" class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5">Organic Tomato</a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="mb-3">3.12 $</h4>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="assets/img/best-product-3.jpg" class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5">Organic Tomato</a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="mb-3">3.12 $</h4>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="assets/img/best-product-4.jpg" class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5">Organic Tomato</a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="mb-3">3.12 $</h4>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="assets/img/best-product-5.jpg" class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5">Organic Tomato</a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="mb-3">3.12 $</h4>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="assets/img/best-product-6.jpg" class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5">Organic Tomato</a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="mb-3">3.12 $</h4>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="text-center">
                            <img src="assets/img/fruite-item-1.jpg" class="img-fluid rounded" alt="">
                            <div class="py-4">
                                <a href="#" class="h5">Organic Tomato</a>
                                <div class="d-flex my-3 justify-content-center">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <h4 class="mb-3">3.12 $</h4>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="text-center">
                            <img src="assets/img/fruite-item-2.jpg" class="img-fluid rounded" alt="">
                            <div class="py-4">
                                <a href="#" class="h5">Organic Tomato</a>
                                <div class="d-flex my-3 justify-content-center">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <h4 class="mb-3">3.12 $</h4>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="text-center">
                            <img src="assets/img/fruite-item-3.jpg" class="img-fluid rounded" alt="">
                            <div class="py-4">
                                <a href="#" class="h5">Organic Tomato</a>
                                <div class="d-flex my-3 justify-content-center">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <h4 class="mb-3">3.12 $</h4>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="text-center">
                            <img src="assets/img/fruite-item-4.jpg" class="img-fluid rounded" alt="">
                            <div class="py-2">
                                <a href="#" class="h5">Organic Tomato</a>
                                <div class="d-flex my-3 justify-content-center">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <h4 class="mb-3">3.12 $</h4>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Agregar al Carrito</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Bestsaler Product End -->


        <!-- Fact Start -->
        <!--<div class="container-fluid py-5">
            <div class="container">
                <div class="bg-light p-5 rounded">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Clientes satisfechos</h4>
                                <h1>1963</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Calidad del servicio</h4>
                                <h1>99%</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Certificados de calidad</h4>
                                <h1>33</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Productos disponibles</h4>
                                <h1>789</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Fact Start -->


        <!-- Tastimonial Start -->
        <!--<div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="testimonial-header text-center">
                    <h4 class="text-primary">Our Testimonial</h4>
                    <h1 class="display-5 mb-5 text-dark">Our Client Saying!</h1>
                </div>
                <div class="owl-carousel testimonial-carousel">
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry's standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="assets/img/testimonial-1.jpg" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry's standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="assets/img/testimonial-1.jpg" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry's standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="assets/img/testimonial-1.jpg" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Tastimonial End -->


<?php
    include_once 'includes/footer.php';
?>