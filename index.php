<?php
error_reporting(0);

require_once('Connections/pae_conn.php');
require_once('Classes/simplexlsx.class.php');

extract($_POST);

if (isset($action) && $action === "upload") {
    echo "aqui";
//cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_

    $archivo = $_FILES["excel"]["name"];

    $tipo = $_FILES["excel"]["type"];

    $destino = "bak_" . $archivo;

    if (copy($_FILES["excel"]["tmp_name"], $destino))
        echo "Archivo Cargado Con Éxito";
    else
        echo "Error Al Cargar el Archivo";


////////////////////////////////////////////////////////
}


//unlink($destino);*/
//}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="/favicon.ico" />
        <title>Programa Mundial de Alimentos - PAE</title>
        <link rel="stylesheet" type="text/css" media="screen" href="/pma_pae/css/main.css" />
        <!--  <link rel="stylesheet" type="text/css" media="screen" href="http://vjs.zencdn.net/c/video-js.css" />-->
        <link rel="stylesheet" type="text/css" media="screen" href="/pma_pae/css/gridNavigation.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/pma_pae/css/newsslidershow.css" />
      <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://vjs.zencdn.net/c/video.js"></script>-->
        <script type="text/javascript" src="/pma_pae/js/jquery.js"></script>		  
        <script type="text/javascript" src="/pma_pae/js/mosaic.1.0.1.min.js"></script>
        <script type="text/javascript" src="/pma_pae/js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="/pma_pae/js/jquery.gridnav.js"></script>
        <script type="text/javascript" src="/pma_pae/js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="/pma_pae/js/newsslidershow.js"></script>
        <script type="text/javascript" src="/pma_pae/js/index.js"></script>
        <style>

            ul.lof-main-wapper li {
                position:relative;	
            }

        </style>
    </head>
    <body>
        <div id="header"></div>

        <div id="menu_superior"></div>


        <article id="content">
            <section id="noticias">

                Selecciona el archivo a importar:

                <form name="carga" method="post" action="" enctype="multipart/form-data" >

                    <input type="file" name="excel" />
                    <input type="submit" name="enviar"  value="Comparar"  />
                    <input type="hidden" value="upload" name="action" />

                </form>

                <form name="importa" method="post" action="">
                    <input type="hidden" name="destino"  value="<?=$destino?>"  />
                    <input type="hidden" value="importar" name="action" />
                    <input type="submit" name="enviar"  value="Importar"  />
                </form>
                <?php
                echo "DESTINO==".$destino;
                if (isset($destino) && file_exists($destino)) {

                    if ($xlsx = SimpleXLSX::parse($destino)) {
                        echo '<h1>Comparación</h1>';
                        echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

                        list($cols, ) = $xlsx->dimension();
                        $j = 0;
                        mysqli_select_db($pae_conn, $database_pae_conn);
//consulto el contenido de esta página
                        if (mysqli_connect_errno()) {
                            echo "ERROR " . mysqli_connect_error();
                        }

                        foreach ($xlsx->rows() as $k => $r) {


                            echo '<tr>';
                            if ($k != 0)
                                echo '<td>' . $j . '</td>';
                            else
                                echo '<td>' . $j . '</td>';

                            for ($i = 0; $i <= $cols; $i++) {
                                echo '<td>' . ( (isset($r[$i])) ? $r[$i] . ' - <b>' . $i . '</b>' : '&nbsp;' ) . ' </td>';
                            }

                            if ($k != 0) {
                                if ($action == "importar") {
                                    if (trim($r[22]) == 'NO PROGRAMAR')
                                        $estado = "INACTIVA";
                                    else
                                        $estado = "ACTIVA";

                                    if (trim($r[17]) == 'MINUTA A')
                                        $tipo_minuta = 1;
                                    else if (trim($r[17]) == 'MINUTA B')
                                        $tipo_minuta = 3;
                                    else if (trim($r[17]) == 'INDUSTRIALIZADA' || trim($r[17]) == 'INDUS SEMANAL')
                                        $tipo_minuta = 2;
                                    else
                                        $tipo_minuta = 6;

                                    $cm_rango_cuatro = isset($r[8]) ? $r[8] : 0;
                                    $cm_rango_siete = isset($r[9]) ? $r[9] : 0;
                                    $cm_rango_trece = isset($r[10]) ? $r[10] : 0;
                                    $cm_rango_dieciocho = 0;
                                    $ct_rango_cuatro = isset($r[11]) ? $r[11] : 0;
                                    $ct_rango_siete = isset($r[12]) ? $r[12] : 0;
                                    $ct_rango_trece = isset($r[13]) ? $r[13] : 0;
                                    $ct_rango_dieciocho = 0;
                                    $al_rango_cuatro = isset($r[14]) ? $r[14] : 0;
                                    $al_rango_siete = isset($r[15]) ? $r[15] : 0;
                                    $al_rango_trece = isset($r[16]) ? $r[16] : 0;
                                    $al_rango_dieciocho = 0;
                                    $sql2 = "UPDATE `pma_pae`.`institucion`
SET
`estado` ='" . $estado . "' ,
`cm_rango_cuatro` =" . $cm_rango_cuatro . ",
`cm_rango_siete` =" . $cm_rango_siete . ",
`cm_rango_trece`  =" . $cm_rango_trece . ",
`cm_rango_dieciocho` =" . $cm_rango_dieciocho . ",
`ct_rango_cuatro` = " . $ct_rango_cuatro . ",
`ct_rango_siete`  =" . $ct_rango_siete . ",
`ct_rango_trece` =" . $ct_rango_trece . ",
`ct_rango_dieciocho` =" . $ct_rango_dieciocho . ",
`al_rango_cuatro` =" . $al_rango_cuatro . ",
`al_rango_siete` =" . $al_rango_siete . ",
`al_rango_trece` =" . $al_rango_trece . ",
`al_rango_dieciocho` =" . $al_rango_dieciocho . ", 
`tipo_minuta` =" . $tipo_minuta . " 
WHERE `codigo_dane` = '" . trim($r[0]) . "'";
//echo $sql2."<hr>";

                                    $resultado = mysqli_query($pae_conn, $sql2) or die(mysqli_error($pae_conn));
                                }
                            }


                            echo '</tr><tr>';
                            echo '<td>' . ($j + 1) . ' </td>';
                            if ($k > 0) {
                                $fila = getInstitucion($r[0], $pae_conn);
                                for ($i = 0; $i < $cols; $i++) {
                                    $bgcolor = "";
									if(isset($fila[$i]) && isset($r[$i]) && trim($fila[$i]) != trim($r[$i])){
										$bgcolor="#FF0000";
									}
                                    echo '<td bgcolor="'.$bgcolor.'">' . ( isset($fila[$i]) ? $fila[$i] : '&nbsp;' ) . ' - <b>' . $i . '</b></td>';
                                }
                                echo '</tr>';
                                $j++;
                            }
                        }
                        echo '</table>';
                    }
                }
                ?> 

            </section>


        </article>

        <div id="menu_lateral"></div>    
        <div id="footer"></div>    


    </body>
</html>


<?php

function getInstitucion($institucion, $pae_conn) {
    $arrayResult = [];
    $sql = "
        SELECT 
            i.codigo_dane, i.nombre, i.codigo_dane_principal, ip.nombre,e.nombre, m.nombre, m.codigo_divipola, ti.nombre,
            i.cm_rango_cuatro,i.cm_rango_siete,i.cm_rango_trece,i.ct_rango_cuatro,i.ct_rango_siete,i.ct_rango_trece,
            i.al_rango_cuatro,i.al_rango_siete,i.al_rango_trece,
            tm.nombre, i.indicaciones, p.nombre_completo,p.telefono, p.email, i.estado 
        FROM pma_pae.institucion i
            left join pma_pae.institucion ip on i.codigo_dane_principal=ip.codigo_dane
            left join etc e on i.etc_id=e.id 
            left join municipio m on m.id = i.municipio_id
            left join tipo_institucion ti on i.tipo_institucion_id=ti.id
            left join tipo_minuta tm on tm.id=i.tipo_minuta
            left join tipo_modalidad tmo on tmo.id=i.tipo_modalidad
            left join rol_persona_institucion rpi on i.id=rpi.institucion_id and rpi.rol_id=1
            left join persona p on p.id=rpi.persona_id 
        WHERE
            i.codigo_dane='" . trim($institucion) . "'";
//print_r($r);

    $resultado = mysqli_query($pae_conn, $sql) or die(mysqli_error($pae_conn));
    $cantidad = mysqli_num_fields($resultado);
    while ($fila = mysqli_fetch_row($resultado)) {
        for ($i = 0; $i < $cantidad; $i++) {
            $arrayResult[] = $fila[$i];
        }
    }
//    echo "<pre>";
//    print_r($arrayResult);
//    echo "</pre>";
    return $arrayResult;
}
