<?php 
  include('/usr/share/php/adodb/adodb.inc.php');
  include('env.php');
  $user=$_POST['user'];
  $password=$_POST['password'];
  
  $db = ADONewConnection($dbdriver); 
  $db->debug = false; 
  $db->Connect($dbserver, $dbuser, $dbpassword, $dbname); 
  $rs = $db->Execute("SELECT * FROM permiso WHERE per_cod='$user' AND perm_pass='$password';"); 
  $db->Close();
  $perm=$rs->GetArray(); 
  
  if (count($perm)!=0)
  {          
           $db = ADONewConnection($dbdriver);
           $db->debug = false;
           $db->Connect($dbserver, $dbuser, $dbpassword, $dbname);
           $rs = $db->Execute("SELECT * FROM persona WHERE per_cod='$user';");
           $datauser=$rs->GetArray();
           $rs = $db->Execute("SELECT * FROM grupo WHERE grup_cod='".$perm[0]['grup_cod']."';");
           $datagrup=$rs->GetArray();
           $db->Close();            
           session_start();
           $_SESSION['nivel'] =$datagrup[0]['grup_cod'];
           $_SESSION['ci'] = trim($datauser[0]['per_cod']);
           $_SESSION['usuario'] = trim($datauser[0]['per_nom']).' '.trim($datauser[0]['per_appm']); 
           header ("Location: pc_menu.php");
 }
 else
{
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
        .error { color: red; text-align: center; }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="pc_login.php">Ingreso</a>
        </nav>
    </header>
    
    <main>
        <div class="error">
            <h1>No tiene Acceso al Sistema</h1>
            <p><a href="pc_login.php">Intentar de nuevo</a></p>
        </div>
    </main>
    
    <footer>
        Copyright (c) <?php echo date('Y'); ?>
    </footer>
</body>
</html>
<?php
  }     
    
?>