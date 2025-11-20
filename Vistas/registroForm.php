<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="max-width: 450px; width: 100%;">
        <h3 class="text-center mb-4">Crear Cuenta</h3>

        <form method="POST" action="/proyecto-Final-MVC/index.php?control=login&accion=registrar">

            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="clave" required>
            </div>

            <button class="btn btn-success w-100">Registrarme</button>

            <div class="text-center mt-3">
                <a href="index.php?control=login&accion=form" class="text-decoration-none">Volver al login</a>
            </div>

        </form>
    </div>
</div>
