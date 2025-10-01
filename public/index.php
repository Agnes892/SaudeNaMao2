<?php
include '../app/configuracao.php';
include '../app/autoload.php';
include '../app/Libraries/Rota.php';
include '../app/Libraries/Database.php';
/*
$db= new Database;

$db->query("SELECT * FROM posts");
foreach($db->resultados() as $post){
   echo $post->titulo.'<br>';
}

$db->query("SELECT * FROM posts ORDER BY id DESC");
$db->resultado();
echo $db->resultado()->titulo;

$id = 1;
$db->query("DELETE FROM posts WHERE id = :id");
$db->bind(":id", $id);
$db->executa();
echo "<hr>Total Resultados: ".$db->totalResultados();


date_default_timezone_set('America/Cuiaba');
$id = 2;
$usuarioId = 100;
$titulo = 'Titulo Editado';
$texto = 'Texto Editado';
$criadoEm = date('Y-m-d H:i:s');
$db->query("UPDATE posts SET usuario_id = :usuario_id, titulo = :titulo, texto=:texto, criado_em=:criadoEm WHERE id=:id");
$db->bind(":id",$id);
$db->bind(":usuario_id",$usuarioId);
$db->bind(":titulo",$titulo);
$db->bind(":texto",$texto);
$db->bind(":criadoEm",$criadoEm);

$db->executa();


$usuarioId = 12;
$titulo= 'a volta de quem não foi';
$texto = 'texto texto texto texto';

$db->query("INSERT INTO posts(usuario_id, titulo, texto) VALUES (:usuario_id, :titulo, :texto)");

$db->bind(":usuario_id", $usuarioId);
$db->bind(":titulo", $titulo);
$db->bind(":texto", $texto);
$db->executa();
echo '<hr>Total resultado: '.$db->totalResultados();
echo '<hr>Último id: '.$db->ultimoIdInserido();
*/

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= APP_NOME ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=URL?>/public/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="<?=URL?>/public/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=URL?>/public/img/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=URL?>/public/img/logo.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=URL?>/public/img/logo.png">
    <link rel="manifest" href="<?=URL?>/public/site.webmanifest">

   <link rel="stylesheet" href="<?=URL?>/public/bootstrap/css/bootstrap.css"/>
   <link rel="stylesheet" href="<?=URL?>/public/css/estilos.css"/>
   <link rel="stylesheet" href="<?=URL?>/public/css/home.css"/>
   <link rel="stylesheet" href="<?=URL?>/public/css/sobre.css"/>

   <link rel="stylesheet" href="<?=URL?>/public/css/saudename.css"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <script src="<?=URL?>/public/bootstrap/js/bootstrap.js"></script>

   
   <script src="<?URL?>/public/bootstrap/js/bootstrap.js"></script>


   <script src="<?=URL?>/public/js/notificacoes.js"></script>
   

</head>
<body>
   <?php 
   // Verifica se é uma página standalone (sem layout)
   $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
   $standalone_pages = [
       'usuarios/loginPrincipal', 
       'usuarios/cadastrar', 
       'usuarios/painelAdmin',
       'adminpanel/editarPagina',
       'adminpanel/unidades',
       'adminpanel/usuarios',
       'adminpanel/configuracoes',
       'adminpanel/api',
       'adminpanel/gerarBackup'
   ];
   $is_standalone = false;
   
   if(isset($url)){
       $url_clean = trim(rtrim($url, '/'));
       // Verifica se está na lista de páginas standalone ou se começa com adminpanel
       if(in_array($url_clean, $standalone_pages) || strpos($url_clean, 'adminpanel') === 0){
           $is_standalone = true;
       }
   }
   
   if (!$is_standalone) {
       include '../app/Views/header.php';
       echo '<main class="container">';
   }
   
   new Rota();
   
   if (!$is_standalone) {
       echo '</main>';
       include '../app/Views/footer.php';
   }
   ?>
</body>
</html>