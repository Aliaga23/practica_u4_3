<?php 
include('env.php');
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
        footer { background: #f0f0f0; padding: 10px; margin-top: 20px; }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="pc_login.php">Ingreso</a>
        </nav>
    </header>
    
    <main>
        <h1>Agenda Personal<br>INF513-SA</h1>
        
        <div style="background: #e8f4f8; padding: 15px; border: 1px solid #b0d4e3; margin: 20px 0; border-radius: 5px;">
            <h3>Credenciales de Acceso:</h3>
            <div style="margin: 10px 0;">
                <strong>Propietario:</strong><br>
                Usuario: <code>3924689</code><br>
                Contraseña: <code>654321</code>
            </div>
            <div style="margin: 10px 0;">
                <strong>Amigo:</strong><br>
                Usuario: <code>4012065</code><br>
                Contraseña: <code>123456</code>
            </div>
            <p style="font-size: 0.9em; color: #666; margin-top: 15px;">
                <em>Estas son las credenciales de prueba para acceder al sistema.</em>
            </p>
        </div>
    </main>
    
    <footer>
        Copyright (c) <?php echo date('Y'); ?>
    </footer>
</body>
</html>