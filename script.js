document.addEventListener("DOMContentLoaded", gestionEventos);

function gestionEventos() {
    document.querySelectorAll('.precio-estilos').forEach(button => {
        button.addEventListener('click', botonPulsado);
    });
    document.getElementById("formulario").addEventListener("submit", enviarPresupuesto);
    document.getElementById("cerrar-ventana").addEventListener("click", cerrarVentana);
}

function botonPulsado(evento) {
    console.log(evento.target);
    const boton = evento.target;
    evento.target.classList.toggle("activo");
    const checkbox = boton.parentElement.querySelector('.checkbox-servicio');
    checkbox.checked = boton.classList.contains("activo");
    console.log(checkbox.checked)
}

function cerrarVentana() {
    const divCerrar = document.getElementById("div-datos");
    divCerrar.classList.add("oculto");
}

async function enviarPresupuesto(event) {
    event.preventDefault();
    const boton = document.getElementById("boton");
    boton.disabled = true;
    const formulario = event.target;
    const formData = new FormData(formulario);
    try {
        const respuesta = await fetch("Procesar_Presupuesto.php", {
            method: "POST",
            body: formData
        });
        if (!respuesta.ok) {
            throw new Error("Error al intentar procesar los datos");
        }

        const datos = await respuesta.json();

        if (datos.error) {
            const errorMensaje = document.getElementById("error-mensaje");
            errorMensaje.textContent = datos.mensaje;
            errorMensaje.classList.add("error-mensaje");
            return;
        }

        const respuestaTexto = document.getElementById("respuesta");

        document.getElementById("respuesta").textContent = datos.total + "€";
        document.getElementById("div-datos").classList.remove("oculto");
        document.getElementById("error-mensaje").textContent = "";

    } catch (error) {
        document.getElementById("respuesta").textContent = "Error en la conexión";
    } finally {
        boton.disabled = false;
    }
}