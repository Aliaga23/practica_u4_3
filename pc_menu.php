<?php 
include('env.php');
session_start();
$_SESSION['nivel'] = intval($_SESSION['nivel']); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda Personal (tres capas)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        header { background: #f0f0f0; padding: 10px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: blue; }
        nav a.active { color: red; font-weight: bold; }
        footer { background: #f0f0f0; padding: 10px; margin-top: 20px; }
        .user-info { float: right; font-weight: bold; }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="personas.php">Personas</a>
            <a href="ps_logout.php">Salir</a>
            <span class="user-info"><?php echo $_SESSION['usuario']; ?></span>
        </nav>
    </header>
    
    <main>
        <?php if ($_SESSION['nivel'] == 2): ?>
            <h1>Bienvenido Propietario</h1>
        <?php elseif ($_SESSION['nivel'] == 1): ?>
            <h1>Bienvenido Amigo</h1>
        <?php endif; ?>
    </main>
    
    <footer>
        Copyright (c) <?php echo date('Y'); ?>
    </footer>
</body>
</html>
