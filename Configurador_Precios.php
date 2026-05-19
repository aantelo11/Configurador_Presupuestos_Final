<?php
include("db.php");
$servicios = "SELECT * FROM servicios";
$resultado = $conexion->query($servicios);
?>

<link rel="stylesheet" href="estilos.css">
<script src="script.js"></script>
<section>
    <form action="" method="post" id="formulario">
        <?php if ($resultado->num_rows > 0): ?>
            <article class="servicios-estilo">
                <?php foreach ($resultado as $servicio): ?>
                    <div class="servicio-estilos">
                        <img class="imagen-estilos" src="<?= $servicio['imagen_ruta'] ?>" alt="">
                        <div class="textos-div-stilos">
                            <p class="textos-estilos tipo-estilos"><?= $servicio['tipo'] ?></p>
                            <p class="textos-estilos nombre-servicio-estilos"><?= $servicio['nombre'] ?></p>
                        </div>
                        <button type="button" class="textos-estilos precio-estilos">Contratar</button>
                        <input type="checkbox" name="servicios[]" value="<?= $servicio['id'] ?>" class="checkbox-servicio" hidden>
                    </div>
                <?php endforeach; ?>
                <div id="servicios-inputs"></div>
            </article>

            <article>
                <div class="formulario-container textos-estilos">
                    <h3 class="form-title">Formulario de contacto:</h3>
                        <div class="grid">
                            <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Nombre"  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                            title="Solo se permiten letras y espacios"required>
                        </div>

                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" id="apellidos" name="apellidos" placeholder="Apellido" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                            title="Solo se permiten letras y espacios"required>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" placeholder="+34 123456789" pattern="^\+?[0-9][0-9\s\-\(\)]{6,20}$" title="Ingrese un número de teléfono válido. Puede incluir el prefijo internacional (+), espacios o guiones."required>
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" name="correo" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required placeholder="ejemplo@correo.com" title="Ingrese un correo electrónico válido">
                        </div>    
                        <div id="error-mensaje" class="textos-estilos"></div>
                        <button id="boton" type="submit">Confirmar Registro</button>
                    </div>
                </div>
            </article>
        </form>
        <div id="div-datos" class="oculto">
            <img src="imagenes/cerrar-ventana.svg" id="cerrar-ventana" alt="" srcset="">
            <img src="imagenes/dekeva_logo.webp" id="logo-dekeva" alt="Logo Dekeva">
            <h2 class="textos-estilos titulo-presupuesto">Presupuesto de los servicios</h2>
                <p id="respuesta" class="texto-estilos"></p>
                <h2 class="textos-estilos titulo-presupuesto">Informacion Grupo Dekeva</h2>
                <ul id="lista" class="textos-estilos">
                    <li><a href="mailto:info@grupodekeva.es">info@grupodekeva.es</a></li>
                    <li><a href="tel:+34611421957">+34 611 42 19 57</a></li>
                    <li><a href="https://www.instagram.com/grupodekeva">@grupodekeva</a></li>
                    <li><a href="https://maps.google.com/?q=Benalm%C3%A1dena+M%C3%A1laga">Benalmádena, Málaga</a></li>
                </ul>
            </div>
        <?php else: ?>
            <p>No hay servicios disponibles</p>
        <?php endif ?>
</section>