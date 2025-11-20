<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Iniciar Sesión</h3>

        <form method="POST" action="/proyecto-Final-MVC/index.php?control=login&accion=validar">

            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="clave" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Ingresar</button>

            <div class="text-center mt-3">
                <a href="index.php?control=login&accion=registro" class="text-decoration-none">
                    ¿No tenés cuenta? Registrate
                </a>
            </div>
        </form>
    </div>
</div>
