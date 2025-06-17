<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    // Guarda la página actual para volver luego
    $_SESSION['redirigir_a'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
}

include_once 'includes/header.php';
?>

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

        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Checkout</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item"><a href="#">Páginas</a></li>
                <li class="breadcrumb-item active text-white">Checkout</li>
            </ol>
        </div>
        <!-- Single Page Header End -->

        <!-- Checkout Page Start -->
        <div class="container-fluid py-5" style="font-size: 20px;">
            <div class="container py-5">
                <h1 class="mb-4">Detalles de facturación</h1>
                <form action="#" id="form-checkout">
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-7">
                            <!-- Nombres y Apellidos en la misma fila -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Nombres<sup>*</sup></label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Apellido<sup>*</sup></label>
                                        <input type="text" name="apellido" id="apellido" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Nombre de la empresa<sup></sup></label>
                                <input type="text" class="form-control">

                            
                            <!-- Email y Teléfono en la misma fila -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Email<sup>*</sup></label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Número de teléfono<sup>*</sup></label>
                                        <input type="tel" name="telefono" id="telefono" class="form-control" required>
                                    </div>
                                </div>

                            </div>
                            
                            <!-- Ciudad y Código Postal en la misma fila -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Ciudad<sup>*</sup></label>
                                        <input type="text" name="ciudad" id="ciudad" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Código postal<sup>*</sup></label>
                                        <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos de ancho completo -->
                            <div class="form-item">
                                <label class="form-label my-3">Nombre de la empresa</label>
                                <input type="text" name="empresa" id="empresa" class="form-control">
                            </div>
                            
                            <div class="form-item">
                                <label class="form-label my-3">Dirección <sup>*</sup></label>
                                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Numero de casa, nombre de la calle" required>
                            </div>
                            
                            <div class="form-item">
                                <label class="form-label my-3">País<sup>*</sup></label>
                                <input type="text" name="pais" id="pais" class="form-control" value="Argentina" required>
                            </div>

                            <hr>
                            <div class="form-check my-3">
                                <input class="form-check-input" type="checkbox" id="Address-1" name="usar_direccion_alternativa">
                                <label class="form-check-label" for="Address-1">Enviar a una dirección diferente</label>
                            </div>
                            
                            <!-- Sección de dirección alternativa (inicialmente oculta) -->
                            <div id="direccion-alternativa-section" style="display: none;">
                                <div class="form-item">
                                    <label class="form-label my-3">Dirección alternativa</label>
                                    <input type="text" name="direccion_alternativa" id="direccion_alternativa" class="form-control" placeholder="Dirección diferente para el envío">
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <textarea name="notas_adicionales" id="notas_adicionales" class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Información adicional sobre el pedido (Opcional)"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-5">
                            <div class="table-responsive" id="resumen-checkout">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-carrito-checkout">
                                        <!-- El contenido se cargará dinámicamente -->
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Métodos de pago como RADIO BUTTONS (solo uno seleccionable) -->
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <h5 class="mb-3">Método de pago</h5>
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="contrareembolso" name="metodo_pago" value="contrareembolso" checked>
                                        <label class="form-check-label" for="contrareembolso">Pago contra entrega</label>
                                    </div>
                                    <p class="text-start text-dark small">Pague en efectivo cuando reciba su pedido en la dirección indicada.</p>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="mercadoPago" name="metodo_pago" value="mercadopago">
                                        <label class="form-check-label" for="mercadoPago">Pagar con Mercado Pago</label>
                                    </div>
                                    <p class="text-start text-dark small">Pague de forma segura con tarjeta de crédito, débito o transferencia.</p>
                                </div>
                            </div>
                            
                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Realizar Pedido</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Page End -->
<script src="https://sdk.mercadopago.com/js/v2"></script>
<?php include_once 'includes/footer.php'; ?>git rebase --continue
