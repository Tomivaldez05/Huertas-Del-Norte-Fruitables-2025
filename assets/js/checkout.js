const mp = new MercadoPago("APP_USR-c7bc1d8d-239a-4ceb-bb8e-8da8d8ccb2c5", {
  locale: "es-AR"
});
document.addEventListener("DOMContentLoaded", function () {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    const resumen = document.querySelector("#resumen-checkout tbody");

    if (!resumen) return;

    resumen.innerHTML = ""; // limpiamos el contenido

    let subtotal = 0;

    for (const [id, item] of Object.entries(carrito)) {
        const totalItem = item.precio * item.cantidad;
        subtotal += totalItem;

        const fila = `
            <tr>
                <th scope="row">
                    <div class="d-flex align-items-center mt-2">
                        <img src="${item.imagen}" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                    </div>
                </th>
                <td class="py-5">${item.nombre}</td>
                <td class="py-5">$${item.precio.toFixed(2)}</td>
                <td class="py-5">${item.cantidad}</td>
                <td class="py-5">$${totalItem.toFixed(2)}</td>
            </tr>
        `;
        resumen.innerHTML += fila;
    }

    // Fila Subtotal
    resumen.innerHTML += `
        <tr>
            <th scope="row"></th>
            <td class="py-5"></td>
            <td class="py-5"></td>
            <td class="py-5">
                <p class="mb-0 text-dark py-3">Subtotal</p>
            </td>
            <td class="py-5">
                <div class="py-3 border-bottom border-top">
                    <p class="mb-0 text-dark">$${subtotal.toFixed(2)}</p>
                </div>
            </td>
        </tr>
    `;

    // Fila Envío
    resumen.innerHTML += `
        <tr>
            <th scope="row"></th>
            <td class="py-5">
                <p class="mb-0 text-dark py-4">Envío</p>
            </td>
            <td colspan="3" class="py-5">
                <div class="form-check text-start">
                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Shipping-1" name="shipping" value="0" checked>
                    <label class="form-check-label" for="Shipping-1">Envío gratis</label>
                </div>
                <div class="form-check text-start">
                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Shipping-2" name="shipping" value="15">
                    <label class="form-check-label" for="Shipping-2">Tarifa: $15.00</label>
                </div>
            </td>
        </tr>
    `;

    // Fila Total (preliminar)
    resumen.innerHTML += `
        <tr>
            <th scope="row"></th>
            <td class="py-5">
                <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
            </td>
            <td class="py-5"></td>
            <td class="py-5"></td>
            <td class="py-5">
                <div class="py-3 border-bottom border-top">
                    <p id="total-final" class="mb-0 text-dark">$${subtotal.toFixed(2)}</p>
                </div>
            </td>
        </tr>
    `;

    // Actualizar total si cambia el método de envío
    const inputsEnvio = document.querySelectorAll("input[name='shipping']");
    inputsEnvio.forEach(input => {
        input.addEventListener("change", () => {
            inputsEnvio.forEach(i => i.checked = false);
            input.checked = true;

            const costoEnvio = parseFloat(input.value);
            const totalFinal = subtotal + costoEnvio;

            document.getElementById("total-final").textContent = `$${totalFinal.toFixed(2)}`;
        });
    });
});

document.getElementById('form-checkout').addEventListener('submit', async function(e) {
  e.preventDefault();

  const form = new FormData(this);
  const datos = Object.fromEntries(form.entries());

  const carrito = JSON.parse(localStorage.getItem("carrito")) || {};

  if (Object.keys(carrito).length === 0) {
    alert("Tu carrito está vacío.");
    return;
  }

  const respuesta = await fetch('acciones/finalizar_pedido.php', {
    method: 'POST',
    body: JSON.stringify({
      cliente: datos,
      carrito: carrito
    }),
    headers: {
      'Content-Type': 'application/json'
    }
  });

  const resultado = await respuesta.json();

  if (resultado.ok) {
    localStorage.removeItem("carrito");
    window.location.href = "gracias.php?pedido=" + resultado.numero_pedido;
  } else {
    alert("Ocurrió un error al finalizar el pedido.");
    console.error(resultado.error);
  }
});
document.getElementById("mercadoPago").addEventListener("change", async function (e) {
    if (!e.target.checked) return;

    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};

    const respuesta = await fetch("acciones/crear_preferencia.php", {
        method: "POST",
        body: JSON.stringify({ carrito }),
        headers: { "Content-Type": "application/json" }
    });

    const data = await respuesta.json();

    if (data.id) {
        window.location.href = data.init_point;
    } else {
        alert("Error al crear preferencia de pago");
        console.error(data);
    }
});

