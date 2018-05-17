<?php 
require_once('../Connections/acad_conn.php');
if (!isset($_SESSION)) {
  @session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
$mensaje="";

if (isset($_POST['usuario'])) 
{
  $loginUsername=$_POST['usuario'];
  $password=$_POST['password'];
  $password=sha1($password);

  mysql_select_db($database_Sabana_conn, $Sabana_conn);
  
  $LoginRS__query=sprintf("SELECT id FROM usuarios WHERE usuario='%s' AND password='%s' AND activo=true",
 
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
 
  $LoginRS = mysql_query($LoginRS__query, $Sabana_conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
 
  if ($loginFoundUser) 
  {
	  $row_loginRS = mysql_fetch_assoc($LoginRS);
    
   
    $_SESSION['Username'] = $loginUsername;
   
         

   
 	   echo "
        <script language='JavaScript'>
         window.location.href='menu.php';  
        </script>";  
  }	
 
		else
		{
		$mensaje="Datos Incorrectos, Intente de nuevo";
		}
  
		
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..:. Admin - Portal Sabio .:..</title>

<link rel="stylesheet" type="text/css" media="screen" href="../css/main.css" />

<script type="text/javascript" src="../js/jquery.js"></script>		  
		  
<script type="text/javascript" >
$(document).ready( function(){
	
		
	
												
												
												
				
  




    



$.get("../header.html",
  function(data){
    $('#header').html(data);
  });
  $.get("../footer.html",
  function(data){
    $('#footer').html(data);
  });

  });
  </script>
</head>


 <body>
<div id="header"></div>
        
<div id="menu_superior"></div>
      

<article id="content">
<form action="<?php echo $loginFormAction;?>" method="post" id="form_acceso">
<table width="501" border="0" cellpadding="0" cellspacing="0" class="tabla_form_index">
    <tr>
      <td colspan="2" class="text_right">Usuario ::</td>
      <td><input name="usuario" type="usuario" required="required" class="stilo_textarea_adicional" id="user" placeholder="Usuario" title="Usuario" autocomplete="off" maxlength="40"/></td>
    </tr>
    <tr>
      <td colspan="3" height="10"></td>
      </tr>
    <tr>
      <td colspan="2" class="text_right">Contraseña ::</td>
      <td><input name="password" type="password" required="required" class="stilo_textarea_adicional" id="password" placeholder="Contraseña" title="password" autocomplete="off" maxlength="40"/></td>
      </tr>
    <tr>
      <td height="10" colspan="3"></td>
      </tr>
    <tr>
      <td colspan="2"></td>
      <td><input type="submit" class="button_enviar" value="Ingresar" /></td>
      </tr>
    <tr>
      <td width="124"></td>
      <td width="82"></td>
      <td><div class="div_response_index" id="response"><?php echo $mensaje;?></div></td>
      </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>Olvidé mi Contraseña</td>
    </tr>
  </table>
  </form>
</article>
    
    
<div id="footer"></div>    
   

    </body>


</html>
