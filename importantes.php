<?php
require_once('Connections/acad_conn.php');
mysql_select_db($database_acad_conn, $acad_conn);
  if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}





//busco las ultimas cinco noticias marcadas como importantes
$query_importantes = sprintf("select * from contenido where seccion_id=%s and importante=true order by created_at desc limit 5", GetSQLValueString(2, "int"));
$importantesRS = mysql_query($query_importantes, $acad_conn);
$importantesDosRS = mysql_query($query_importantes, $acad_conn);
$numero_filas_importantes = mysql_num_rows($importantesRS);
if($numero_filas_importantes>0)
{
$importantes_row= mysql_fetch_assoc($importantesRS);

//si no existen noticias marcadas como importantes, se buscan las ultimas 5 noticias
$importantes_dos_row=mysql_fetch_assoc($importantesDosRS);

}else {
	
$query_importantes = sprintf("select * from contenido where seccion_id=%s order by created_at desc limit 5", GetSQLValueString(2, "int"));

$importantesRS = mysql_query($query_importantes, $acad_conn);
$importantes_row= mysql_fetch_assoc($importantesRS);	
$importantesDosRS = mysql_query($query_importantes, $acad_conn);	
$importantes_dos_row=mysql_fetch_assoc($importantesDosRS);
	
	
	}





?>


<div id="jslidernews2" class="lof-slidecontent" style="width:730px; height:300px;">
	<div class="preload"><div></div></div>
            
            
            <div  class="button-previous">Previous</div>
                   
    		 <!-- MAIN CONTENT --> 
              <div class="main-slider-content" style="width:730px; height:300px;">
                <ul class="sliders-wrap-inner">
                <?php do { 	
               
                //miro si tiene imagen principal asociada  asociadas
						$query_imagen = sprintf("select id from imagen where contenido_id=%s and principal=true limit 1", GetSQLValueString($importantes_row['id'], "int"));
											
						$imagenRS = mysql_query($query_imagen, $acad_conn);
						$numero_filas = mysql_num_rows($imagenRS);
						$imagenRow=mysql_fetch_assoc($imagenRS);
						//si tiene imagen principal asociada la muestro	                
	                if($numero_filas>0)
	                { ?>
	                	 		<li>
			                          <img src="images/<?php echo $imagenRow['nombre']; ?>" 
			                          title="<?php echo $imagenRow['nombre']; ?>" >           
         		         	        <div class="slider-description">
               			           <div class="slider-meta"><a target="_parent" title="<?php echo $importantes_row['nombre']; ?>" href="<?php echo $importantes_row['url']; ?>">/ <?php echo $importantes_row['nombre']; ?> /</a> <i> <?php echo $importantes_row['created_at']; ?></i></div>
                         			  <h4><?php echo $importantes_row['nombre']; ?></h4>
                            		  <p><?php echo $importantes_row['descripcion']; ?>
                                   <a class="readmore" href="<?php echo $importantes_row['url']; ?>">Leer más</a>
                                   </p>
                                   </div>
                    				</li>
						
	                	  <?php
	                
	                	}else {
	                		//si no tiene imagen principal asociada busco si tiene cualquier imagen asociada
	                		$query_imagenes = sprintf("select * from imagen where contenido_id=%s", GetSQLValueString($importantes_row['id'], "int"));
								$imagenesRS = mysql_query($query_imagenes, $acad_conn);
								$numero_filas_dos = mysql_num_rows($imagenRS);
								//si tiene imagenes asociadas escojo la primera y la muestro									 
								 if($numero_filas_dos>0)
								 {
								 	
								 	
								 	
								 	
								 	}
								 	else {
								 		//si no tiene imagenes asociadas imprimo la imagen por defecto
								 		?>
								 		<li>
			                          <img src="images/predeterminada.jpg" title="Newsflash 2" >           
         		         	        <div class="slider-description">
               			           <div class="slider-meta"><a target="_parent" title="<?php echo $importantes_row['nombre']; ?>" href="<?php echo $importantes_row['url']; ?>">/ IMPORTANTE /</a> <i> <?php echo $importantes_row['created_at']; ?></i></div>
                         			  <h4><?php echo $importantes_row['nombre']; ?></h4>
                            		  <p><?php echo  substr($importantes_row['descripcion'], 0, 90); ?>
                                   <a class="readmore" href="<?php echo $importantes_row['url']; ?>">Leer más</a>
                                   </p>
                                   </div>
                    				</li>
								 		<?php }
	                		
	                		
	                		}
          			      
                
                
                
                
                ?>
                    
                   <?php }  while($importantes_row= mysql_fetch_assoc($importantesRS))   ?>
                  </ul>  	
            </div>
 		   <!-- END MAIN CONTENT --> 
           <!-- NAVIGATOR -->
           	<div class="navigator-content">
                  <div class="navigator-wrapper">
                        <ul class="navigator-wrap-inner">
                        <?php do{ 	?>
                          <li>
                                <div>
                                    <img src="images/lofthumbs/791902news3.jpg" />
                                    <h3> <?php echo $importantes_dos_row['nombre']; ?> </h3>
                                    <span><?php echo $importantes_dos_row['created_at']; ?></span> - <?php echo substr($importantes_dos_row['descripcion'], 0, 50); ?>...
                                </div>    
                            </li>
                         <?php } while($importantes_dos_row= mysql_fetch_assoc($importantesDosRS))    ?>     		
                        </ul>
                  </div>
   
             </div> 
          <!----------------- END OF NAVIGATOR --------------------->
          <div class="button-next">Next</div>
 
 		 <!-- BUTTON PLAY-STOP -->
          <div class="button-control"><span></span></div>
          <!-- END OF BUTTON PLAY-STOP -->
           
 </div> 
