<?php 
    include('/usr/share/php/adodb/adodb.inc.php'); 

    $dbdriver = 'postgres';    
    $dbserver = '37.187.122.232';
    $dbuser =  'grupo01sc';
    $dbpassword = 'grup001grup001*';
    $dbname = 'db_'.$dbuser; 
    
    $path = 'https://www.tecnoweb.org.bo/inf513/grupo01sc/practica4/Arturo_Aliaga/';
    
    $uploads_physical_path = './uploads/';
    $uploads_web_url = 'https://www.tecnoweb.org.bo/inf513/grupo01sc/practica4/Arturo_Aliaga/uploads/';
    
    if (!is_dir($uploads_physical_path)) {
        if (!mkdir($uploads_physical_path, 0777, true)) {
            error_log("No se pudo crear el directorio: $uploads_physical_path");
        }
    } else {
        chmod($uploads_physical_path, 0777);
    }
    
    if (!is_writable($uploads_physical_path)) {
        error_log("El directorio no es escribible: $uploads_physical_path");
        // Intentar corregir permisos
        chmod($uploads_physical_path, 0777);
    }
      
?>