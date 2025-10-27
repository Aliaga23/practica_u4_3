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
        table { border-collapse: collapse; }
        td { padding: 8px; }
        input[type="text"], input[type="password"] { width: 200px; padding: 5px; }
        input[type="submit"], input[type="reset"] { padding: 8px 15px; margin: 5px; }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="pc_login.php">Ingreso</a>
        </nav>
    </header>
    
    <main>
        <form method="post" action="ps_login.php">
            <h2>Agenda Personal (tres capas)</h2>
            <table>
                <tr>
                    <td width="89">Usuario:</td>
                    <td width="145"><input name="user" type="text" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input name="password" type="password" required></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="reset" name="Reset" value="Limpiar">
                        <input type="submit" name="Submit" value="Ingresar">
                    </td>
                </tr>
            </table>
        </form>
    </main>
    
    <footer>
        Copyright (c) <?php echo date('Y'); ?>
    </footer>
</body>
</html>