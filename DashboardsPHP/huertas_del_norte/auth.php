<?php
// auth.php

function verificarSesion() {
    // Verifica si el usuario está logueado
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }
    return $_SESSION['id_usuario'];
}
