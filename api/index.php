<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
ob_start(); 

if (!isset($_GET['page'])) {
    $_GET['page'] = "login";
}

// __DIR__ lagane se PHP ko pata chalta hai ke 'api' folder ke andar hi check karna hai
$page_path = __DIR__ . "/web_temp/" . $_GET['page'] . ".html.php";

if (file_exists($page_path)) 
{
    /* Common Header */
    $head_title = $_GET['page'];
    
    // 1. Models aur Common ab api folder ke andar hi hain
    include_once(__DIR__ . "/models/logincookie.php");
    
    // 2. Main Config folder API se BAHAR root par hai (Isiliye dirname(__DIR__) use kiya hai)
    include_once(dirname(__DIR__) . "/env/main_config.php");
    
    // 3. Header, Page Content aur Footer links
    include_once(__DIR__ . "/common/header.php");
    include_once($page_path);
    include_once(__DIR__ . "/common/footer.php");
    
} else {
    // Agar page nahi mila toh public/images folder se image load hogi
    ?>
    <img src="/images/html-404-error.jpg" width="100%" height="100%">
    <?php
    die();
}
?>
