<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');
}
include_once './PostgreSQL/ConexionBD.php';

//<!-- OBTENER TODAS LAS PREGUNTAS DE LA PUBLICACIONES DEL USUARIO -->
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT CS.*,
U.foto_usuario, U.nombre_usuario, U.apellidopat_usuario, U.apellidomat_usuario,
PU.titulo
FROM contratacion_servicio CS
INNER JOIN usuario2 AS U ON CS.id_contratante = U.id_usuario
INNER JOIN publicacion_usuario AS PU ON CS.id_publicacion = PU.id_publicacion_usuario
WHERE id_dueno = ?
ORDER BY fecha_contratacion DESC");

$consultaSQL->bindParam(1, $_SESSION['inicioSesion']['id_usuario']);
$consultaSQL->execute();
$listaPreguntas = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

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
                                            </h5>Horas Contratadas: <?php echo $lista['horas_contratadas']; ?></h5>
                                        </div>

                                        <form action="guardarRespuestaContratacionDueño.php?id=<?php echo $lista['id_contratacion'] ?>" method="POST" enctype="multipart/form-data">
                                       
                                        <textarea  <?php if(!is_null($lista['confirmacion_dueno'])){ ?> disabled <?php } ?> style="overflow:auto;resize:none" class="form-control" id="textRespuesta" name="textRespuesta" rows="3" cols="70" class="pane"><?php if(!is_null($lista['confirmacion_dueno'])){
                                            echo $lista['mensaje_dueno'];
                                        } ?></textarea>
                                        <button <?php if(!is_null($lista['confirmacion_dueno'])){ ?> disabled <?php } ?> class="btn btn-default" type="submit" name="Confirmacion" value="1">Confirmar</button>
                                        <button <?php if(!is_null($lista['confirmacion_dueno'])){ ?> disabled <?php } ?> class="btn btn-default" type="submit" name="Confirmacion" value="0">Rechazar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
<?php } ?>