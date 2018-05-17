<?php
require_once('Connections/acad_conn.php');
mysql_select_db($database_acad_conn, $acad_conn);
$query_seccion = sprintf("select * from seccion");
$seccionRS = mysql_query($query_seccion, $acad_conn);

?>
      
<nav>

    
<ul>
 <?php while($seccion_row= mysql_fetch_assoc($seccionRS))	 {?>
       <li><a href="#"><?php echo $seccion_row['nombre'];?></a></li>
<?php }    ?> 

        
</ul>
     

</nav> 

