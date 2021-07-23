<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


<?php
$ruta = Request::path();
$rutaExploded = explode('/', $ruta);
/*
if (sizeof($rutaExploded) > 1) { ?>
    <link rel="stylesheet" href="../fonts/all.css">
    <link rel="stylesheet" href="../css/estilos.css">
<?php } else { ?>
    <link rel="stylesheet" href="fonts/all.css">
    <link rel="stylesheet" href="css/estilos.css">
<?php }
*/
?>
<link rel="stylesheet" href="{{url('fonts/all.css')}}">
<link rel="stylesheet" href="{{url('css/estilos.css')}}">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-67Q4GG8WL9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-67Q4GG8WL9');
</script>
