<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel=stylesheet href="css/Publicaciones2.css"> 
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        
    </head>
    <body>

        <div id="sidemenu" class="menu-expanded">
            <!-- Header-->
            <div id="header">
                <div id="menu-btn">
                    <div class="btn-hamburger"></div>
                    <div class="btn-hamburger"></div>
                    <div class="btn-hamburger"></div>

                </div>
            </div>

            <!-- Items -->

        <center> 
        <div class="btn-group mr-2 col-xs-1 center-block">
            <a href="MaquetaPublicaciones.php" class="category_item" category="EliminarFiltro">
            <button type="button" class="btn btn-secondary">Mostrar Todo</button>
            </a>
            <a href="MaquetaPublicaciones.php?filtro=tutoria">
            <button type="button" class="btn btn-secondary">Tutoria</button>
            </a>
            <a href="MaquetaPublicaciones.php?filtro=asesoria">
            <button type="button" class="btn btn-secondary">Asesoria</button>
            </a>
            <!--  Oportunidad
            <a href="MaquetaPublicaciones.php?filtro=oportunidad">
            <button type="button" class="btn btn-secondary">Oportunidad</button>
            </a>   
              -->    
        </div>
        </center>

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
