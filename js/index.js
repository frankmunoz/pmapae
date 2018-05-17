$(document).ready( function(){
	
	
$.get("header.html",
  function(data){
    $('#header').html(data);
  });
  
   $.get("menu_lateral.php",
  function(data){
    $('#menu_lateral').html(data);
  });
   $.get("footer.html",
  function(data){
    $('#footer').html(data);
  });
});



