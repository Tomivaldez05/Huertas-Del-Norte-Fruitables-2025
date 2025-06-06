<?php
include_once 'includes/header.php';
require_once 'includes/db.php';
?>
  <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
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


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h2 class="mb-4">Carrito de Compras</h2>
                <div class="row">
                    <!-- Tabla de productos -->
                    <div class="col-md-8">
                        <div class="table-responsive" id="tabla-carrito"></div>
                    </div>
                    <!-- Resumen -->
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h4>Resumen</h4>
                            <p id="total-carrito">Total: $0.00</p>
                            <a href="checkout.php" class="btn btn-success w-100 mt-2">Ir a Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart Page End -->
<script src="assets/js/carrito-pagina.js"></script>
<?php
include_once 'includes/footer.php';
?>