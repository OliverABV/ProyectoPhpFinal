<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Side Menu</title>
        <link type="text/css" rel=stylesheet href="css/Publicaciones2.css"> 
    </head>
    <body>

        <div id="sidemenu" class="menu-expanded">
            <!-- Header-->
            <div id="header">
                <div id="title"><span>EduWeb</span></div>
                <div id="menu-btn">
                    <div class="btn-hamburger"></div>
                    <div class="btn-hamburger"></div>
                    <div class="btn-hamburger"></div>

                </div>
            </div>
            <!-- Profile -->
            <div id="profile">

                <div id="photo"> <?php
                    if (!empty($_SESSION['inicioSesion']['nombre_usuario'])) {
                        $avatar = $_SESSION['inicioSesion']['foto_usuario'];  
                        echo '<img src="' . $avatar . '">';
                    } else {
                        $avatar = $_SESSION['inicioSesion']['foto_entidad'];
                        echo '<img src="' . $avatar . '">';
                    }
                    ?> </div>

                <div id="name">  <?php
                    if (!empty($_SESSION['inicioSesion']['nombre_usuario'])) {
                        $avatar = $_SESSION['inicioSesion']['foto_usuario'];
                        echo $_SESSION['inicioSesion']['nombre_usuario'];
                       // echo' ';
                       // echo '<img src="' . $avatar . '" width="50" height="50">';
                    } else {
                        $avatar = $_SESSION['inicioSesion']['foto_entidad'];
                        echo $_SESSION['inicioSesion']['nombre_comercial_entidad'];
                       // echo ' ';
                       // echo '<img src="' . $avatar . '" width="50" height="50">';
                    }
                    ?>  <!-- Aqui va el nombre de Usuario --></div>
            </div>





            <!-- Items -->
            <div id="menu-items">
                <div class="item">
                    <a href="MaquetaPublicaciones.php" class="category_item" category="EliminarFiltro">
                        <div class="icon"><img src="img/form.png"  alt=""></div>
                        
                        <div class="tittle"><span>Mostrar Todo</span></div>
                    </a>
                </div>

                <div class="item">
                    <a href="MaquetaPublicaciones.php?filtro=tutoria">
                        <div class="icon"><img src=""  alt=""></div>
                        <div class="tittle"><span>Tutoria</span></div>
                    </a>
                </div>
                <div class="item separator">

                </div>

                <div class="item">
                    <a href="MaquetaPublicaciones.php?filtro=asesoria">
                        <div class="icon"><img src=""  alt=""></div>
                        <div class="tittle"><span>Asesoria</span></div>
                    </a>
                </div>

                <div class="item">
                    <a href="MaquetaPublicaciones.php?filtro=oportunidad">
                        <div class="icon"><img src=""  alt=""></div>
                        <div class="tittle"><span>Oportunidad</span></div>
                    </a>
                </div>
            </div>

        </div>








        <script>
            const btn = document.querySelector('#menu-btn');
            const menu = document.querySelector('#sidemenu');
            btn.addEventListener('click', e => {
                menu.classList.toggle("menu-expanded");
                menu.classList.toggle("menu-collapsed");

                document.querySelector('body').classList.toggle('body-expanded');
            });
        </script>
    </body>
</html>
