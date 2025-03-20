<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $titulo ?></title>

        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

        <link rel="stylesheet" href="<?= URL::to("assets/css/login.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/plugins/sweetalert/sweetalert.css") ?>" rel="stylesheet" type="text/css"/>
    </head>
    
    <body data-urlbase="<?= URL::base() ?>">
        <main class="login-container">
            <div class="login-card">
                <h2 class="login-title">Iniciar Sesión</h2>
                <form id="loginForm" method="POST" action="<?= URL::to('/login') ?>">
                    <div class="form-group">
                        <label for="vcUsuario">Usuario o Correo</label>
                        <input type="text" id="vcUsuario" name="vcUsuario" class="form-control" placeholder="Ingrese su usuario o correo" required>
                    </div>
                    <div class="form-group">
                        <label for="vcContrasenaUsuario">Contraseña</label>
                        <input type="password" id="vcContrasenaUsuario" name="vcContrasenaUsuario" class="form-control" placeholder="Ingrese su contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </main>

        <script src="<?= URL::to("assets/plugins/jquery.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/plugins/sweetalert/sweetalert.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/modulos/login/login.js") ?>" type="text/javascript"></script>
    </body>
</html>