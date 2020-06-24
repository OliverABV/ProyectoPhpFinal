<?php
    //session_id();       // Uso no imprescindible. Si se usa debe estar antes de 'session_start()'
    session_start();    // Iniciar la sesión

    session_unset();    // Borrar las variables de sesión
    setcookie(session_name(), 0, 1 , ini_get("session.cookie_path"));    // Eliminar la cookie
    session_destroy();  // Destruir la sesión
    header('Location: ./index.html');
?>