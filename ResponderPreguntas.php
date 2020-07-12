<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');
}
include_once './PostgreSQL/ConexionBD.php';

//<!-- OBTENER TODAS LAS PREGUNTAS DE LA PUBLICACIONES DEL USUARIO -->
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT  PU.id_pregunta_publicacion, PU.id_publicacion_usuario, PUS.titulo, PU.id_usuario_pregunta, PU.fecha_pregunta_publicacion, PU.id_usuario_dueno_publicacion, PU.pregunta_publicacion, PU.fecha_respuesta_publicacion, PU.respuesta_publicacion,
U.foto_usuario, U.nombre_usuario, U.apellidopat_usuario, U.apellidomat_usuario
FROM preguntas_publicacion AS PU 
INNER JOIN usuario2 AS U ON PU.id_usuario_pregunta = U.id_usuario
NATURAL JOIN publicacion_usuario AS PUS
WHERE PU.id_usuario_dueno_publicacion = ?
ORDER BY fecha_pregunta_publicacion DESC");

$consultaSQL->bindParam(1, $_SESSION['inicioSesion']['id_usuario']);
$consultaSQL->execute();
$listaPreguntas = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

foreach ($listaPreguntas as $lista) { ?>
    <hr class="line">
                            <div class="contenedor-comentarios">
                                <div class="comentarios">
                                <?php echo "<a class='publicacion' href=DetallesPublicacion.php?id=" . $lista['id_publicacion_usuario'] . ">" . $lista['titulo'] . "</a>"; ?>
                                    <div class="photo-perfil">
                                        <img src="<?php echo $lista['foto_usuario']; ?>" alt="">
                                    </div>
                                    <div class="info-comentarios" >
                                        <div class="header-comentario">
                                            <h4><?php echo $lista['nombre_usuario']; ?>&nbsp;<?php echo $lista['apellidopat_usuario']; ?>&nbsp;<?php echo $lista['apellidomat_usuario']; ?></h4>
                                            <h5>Pregunta: <?php
                                            $date = date_create($lista['fecha_pregunta_publicacion']);
                                            echo date_format($date, 'd-m-Y');
                                            ?></h5>
                                        </div>
                                            
                                            <textarea disabled style="overflow:auto;resize:none" class="form-control" id="textPregunta" name="textPregunta" rows="3" cols="70" class="pane"><?php echo $lista['pregunta_publicacion']; ?></textarea>
                                        <div class="header-comentario">
                                            <h4></h4>
                                            <h5>Respuesta: <?php if(!is_null($lista['fecha_respuesta_publicacion'])){
                                            $date = date_create($lista['fecha_respuesta_publicacion']);
                                            echo date_format($date, 'd-m-Y');
                                            }else{
                                                echo 'aun sin respuesta';
                                            }?></h5>

                                        </div>
                                        <form action="GuardarRespuesta.php?id=<?php echo $lista['id_pregunta_publicacion'] ?>" method="POST" enctype="multipart/form-data">
                                       
                                        <textarea  <?php if(!is_null($lista['respuesta_publicacion'])){ ?> disabled <?php } ?> style="overflow:auto;resize:none" class="form-control" id="textRespuesta" name="textRespuesta" rows="3" cols="70" class="pane"><?php if(!is_null($lista['respuesta_publicacion'])){
                                            echo $lista['respuesta_publicacion'];
                                        } ?></textarea>
                                        <button <?php if(!is_null($lista['respuesta_publicacion'])){ ?> disabled <?php } ?> class="btn btn-default" type="submit" name="" >Responder</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
<?php } ?>