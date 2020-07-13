<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');
}
include_once './PostgreSQL/ConexionBD.php';

//<!-- OBTENER TODAS LAS PREGUNTAS DE LA PUBLICACIONES DEL USUARIO -->
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT CS.*,
U.foto_usuario, U.nombre_usuario, U.apellidopat_usuario, U.apellidomat_usuario, U.telefono_usuario, U.email_usuario, U.certificado_usuario,
PU.titulo
FROM contratacion_servicio CS
INNER JOIN usuario2 AS U ON CS.id_dueno = U.id_usuario
INNER JOIN publicacion_usuario AS PU ON CS.id_publicacion = PU.id_publicacion_usuario
WHERE id_contratante = ?
ORDER BY fecha_contratacion DESC");

$consultaSQL->bindParam(1, $_SESSION['inicioSesion']['id_usuario']);
$consultaSQL->execute();
$listaPreguntas = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT COUNT(*)
FROM contratacion_servicio CS
INNER JOIN usuario2 AS U ON CS.id_dueno = U.id_usuario
INNER JOIN publicacion_usuario AS PU ON CS.id_publicacion = PU.id_publicacion_usuario
WHERE id_contratante = ?");

$consultaSQL->bindParam(1, $_SESSION['inicioSesion']['id_usuario']);
$consultaSQL->execute();
$contadorSolicitudes = $consultaSQL->fetch();
ConexionBD::cerrarConexion();

if ($contadorSolicitudes['count'] != 0) {
foreach ($listaPreguntas as $lista) { ?>
    <hr class="line">
                            <div class="contenedor-comentarios">
                                <div class="comentarios">
                                <?php echo "<a class='publicacion' href=DetallesPublicacion.php?id=" . $lista['id_publicacion'] . ">" . $lista['titulo'] . "</a>"; ?>
                                    <div class="photo-perfil">
                                        <img src="<?php echo $lista['foto_usuario']; ?>" alt="">
                                    </div>
                                    <div class="info-comentarios" >
                                        <div class="header-comentario">
                                            <h4><?php echo $lista['nombre_usuario']; ?>&nbsp;<?php echo $lista['apellidopat_usuario']; ?>&nbsp;<?php echo $lista['apellidomat_usuario']; ?></h4>
                                            <h5>Fecha Contratacion: <?php
                                            $date = date_create($lista['fecha_contratacion']);
                                            echo date_format($date, 'd-m-Y');
                                            ?>
                                            </h5>
                                            <h5>Horas Contratadas: <?php echo $lista['horas_contratadas']; ?></h5>
                                            <h5>Telefono Principal: <?php echo $lista['telefono_usuario']; ?></h5>
                                            <h5>Correo: <?php echo $lista['email_usuario']; ?></h5>
                                            <h5>Certificado: <?php if($lista['certificado_usuario'] != "Sin Certificado"){ ?>
                                            <img src="<?php echo $lista['certificado_usuario']; ?>" height="50px" height="50px">
                                            <?php }else{ ?>
                                            Sin Certificado
                                           <?php } ?></h5>
                                        </div>
                                        <textarea disabled style="overflow:auto;resize:none" class="form-control" id="textPregunta" name="textPregunta" rows="3" cols="70" class="pane"><?php echo $lista['mensaje_dueno']; ?>
                                        </textarea>
                                        <div class="header-comentario">

                                        <form action="guardarRespuestaContratacionCliente.php?id=<?php echo $lista['id_contratacion'] ?>" method="POST" enctype="multipart/form-data">
                                       
                                        <textarea  <?php if(!is_null($lista['confirmacion_contratante'])){ ?> disabled <?php } ?> style="overflow:auto;resize:none" class="form-control" id="textRespuesta" name="textRespuesta" rows="3" cols="70" class="pane"><?php if(!is_null($lista['confirmacion_dueno'])){
                                        echo $lista['mensaje_contratante'];
                                        } ?></textarea>
                                        <button <?php if(!is_null($lista['confirmacion_contratante'])){ ?> disabled <?php } ?> class="btn btn-default" type="submit" name="Confirmacion" value="1">Confirmar</button>
                                        <button <?php if(!is_null($lista['confirmacion_contratante'])){ ?> disabled <?php } ?> class="btn btn-default" type="submit" name="Confirmacion" value="0">Rechazar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
<?php } ?>
<?php }else{ ?>
<!-- SI NO TIENE SERVICIOS CONTRATADOS HAS ESTO-->
<h2>No Tiene Ningun Servicio Contratadado</h2>
<a href="http://localhost/ProyectoPhpFinal/MiPerfil.php">Volver a Mi Perfil</a> 
<?php } ?>