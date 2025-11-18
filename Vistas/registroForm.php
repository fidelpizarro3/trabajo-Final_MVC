<h2>Registro de Usuario</h2>

<form method="POST" action="index.php?control=login&accion=registrarUsuario">
    
    <label>Nombre de usuario:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="clave" required><br><br>

    <button type="submit">Registrarse</button>
</form>

<br>
<a href="index.php?control=login&accion=form">¿Ya tenés cuenta? Iniciar sesión</a>
