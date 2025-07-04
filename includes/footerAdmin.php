<!-- includes/footer.php -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  window.alert = function(mensaje) {
    Swal.fire({
      icon: 'info',
      text: mensaje
    });
  };
</script>
<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">© 2025 Huertas del Norte</span>
    <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">Panel de administración</span>
  </div>
</footer>
