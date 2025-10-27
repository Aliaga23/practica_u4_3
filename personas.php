<?php
include('env.php');
include('/usr/share/php/adodb/adodb-errorpear.inc.php');
include('/usr/share/php/adodb/tohtml.inc.php');
include("/usr/share/php/adodb/adodb.inc.php");

function mostrarHeader($titulo, $usuario, $nivel) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $titulo; ?></title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            header { background: #f0f0f0; padding: 10px; margin-bottom: 20px; }
            nav a { margin-right: 15px; text-decoration: none; color: blue; }
            footer { background: #f0f0f0; padding: 10px; margin-top: 20px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            .user-info { float: right; font-weight: bold; }
            input[type="text"], input[type="password"], input[type="email"], input[type="date"] { 
                width: 200px; padding: 5px; margin: 2px; 
            }
            input[type="submit"], input[type="reset"] { 
                padding: 8px 15px; margin: 5px; 
            }
        </style>
    </head>
    <body>
        <header>
            <nav>
                <a href="personas.php">Personas</a>
                <a href="ps_logout.php">Salir</a>
                <span class="user-info"><?php echo $usuario; ?></span>
            </nav>
        </header>
        <main>
    <?php
}

function mostrarFooter() {
    ?>
        </main>
        <footer>
            Copyright (c) <?php echo date('Y'); ?>
        </footer>
    </body>
    </html>
    <?php
}

switch ($_REQUEST['opcion']) {
    case 1: {
            session_start();
            if ($_SESSION['nivel'] == 2) { // Es el Propietario
                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                ?>
                <form method="post" action="personas.php" enctype="multipart/form-data">
                    <input type="hidden" name="opcion" value="10">
                    <h2>Registrar Nuevo Amigo</h2>
                    <table>
                        <tr><td>C.I. :</td><td><input type="text" name="cod" required></td></tr>
                        <tr><td>Contraseña :</td><td><input type="password" name="pass" required></td></tr>
                        <tr><td>Nombre :</td><td><input type="text" name="nom" required></td></tr>
                        <tr><td>Apellidos :</td><td><input type="text" name="appm" required></td></tr>
                        <tr><td>Profesión :</td><td><input type="text" name="prof"></td></tr>
                        <tr><td>Teléfono:</td><td><input type="text" name="tel"></td></tr>
                        <tr><td>Celular :</td><td><input type="text" name="cel"></td></tr>
                        <tr><td>E-Mail :</td><td><input type="email" name="email" required></td></tr>
                        <tr><td>Dirección :</td><td><input type="text" name="dir"></td></tr>
                        <tr><td>Fecha Nac. :</td><td><input type="date" name="fnac" required></td></tr>
                        <tr><td>Lugar Nac. :</td><td><input type="text" name="lnac"></td></tr>
                        <tr><td>Foto :</td><td>
                            <input type="file" name="foto" accept="image/*">
                            <br><small>Formatos: JPG, PNG, GIF. Máximo: 2MB</small>
                        </td></tr>
                        <tr><td colspan="2"><input type="submit" value="Registrar"></td></tr>
                    </table>
                </form>
                <?php
                mostrarFooter();
            }
        }
        break;
    case 2: {
            // Mostrar detalles de una persona
            session_start();
            $per_cod = $_REQUEST['per_cod'];
            
            $db = ADONewConnection($dbdriver);
            $db->debug = false;
            $db->Connect($dbserver, $dbuser, $dbpassword, $dbname);
            $result = $db->Execute("SELECT * FROM persona WHERE per_cod='$per_cod'");
            $persona = $result->FetchRow();
            $db->Close();
            
            if ($persona) {
                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                ?>
                <h2>Detalles de la Persona</h2>
                <table>
                    <tr><td><strong>C.I.:</strong></td><td><?php echo $persona['per_cod']; ?></td></tr>
                    <tr><td><strong>Nombre:</strong></td><td><?php echo $persona['per_nom']; ?></td></tr>
                    <tr><td><strong>Apellidos:</strong></td><td><?php echo $persona['per_appm']; ?></td></tr>
                    <tr><td><strong>Profesión:</strong></td><td><?php echo $persona['per_prof']; ?></td></tr>
                    <tr><td><strong>Teléfono:</strong></td><td><?php echo $persona['per_telf']; ?></td></tr>
                    <tr><td><strong>Celular:</strong></td><td><?php echo $persona['per_cel']; ?></td></tr>
                    <tr><td><strong>E-Mail:</strong></td><td><?php echo $persona['per_email']; ?></td></tr>
                    <tr><td><strong>Dirección:</strong></td><td><?php echo $persona['per_dir']; ?></td></tr>
                    <tr><td><strong>Fecha Nac.:</strong></td><td><?php echo $persona['per_fnac']; ?></td></tr>
                    <tr><td><strong>Lugar Nac.:</strong></td><td><?php echo $persona['per_lnac']; ?></td></tr>
                    <tr><td><strong>Foto:</strong></td><td>
                        <?php if(isset($persona['per_foto']) && $persona['per_foto'] != 'default.jpg'): ?>
                            <img src="<?php echo $uploads_web_url . $persona['per_foto']; ?>" style="max-width:200px;max-height:200px;">
                        <?php else: ?>
                            Sin foto
                        <?php endif; ?>
                    </td></tr>
                </table>
                <br>
                <a href="personas.php">Volver al listado</a>
                <?php if($_SESSION['nivel'] == 2 || $_SESSION['ci'] == $persona['per_cod']): ?>
                    | <a href="personas.php?opcion=3&per_cod=<?php echo $persona['per_cod']; ?>">Editar</a>
                <?php endif; ?>
                <?php
                mostrarFooter();
            } else {
                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                echo "<h2>Persona no encontrada</h2>";
                echo "<a href='personas.php'>Volver al listado</a>";
                mostrarFooter();
            }
        }
        break;
    case 3: {
            // Mostrar formulario de edición
            session_start();
            if ($_SESSION['nivel'] == 2 || $_SESSION['ci'] == $_REQUEST['per_cod']) { 
                $per_cod = $_REQUEST['per_cod'];
                
                $db = ADONewConnection($dbdriver);
                $db->debug = false;
                $db->Connect($dbserver, $dbuser, $dbpassword, $dbname);
                $result = $db->Execute("SELECT * FROM persona WHERE per_cod='$per_cod'");
                $persona = $result->FetchRow();
                $db->Close();
                
                if ($persona) {
                    mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                    ?>
                    <h2>Modificar Persona</h2>
                    <form method="post" action="personas.php" enctype="multipart/form-data">
                        <input type="hidden" name="opcion" value="30">
                        <input type="hidden" name="per_cod" value="<?php echo $persona['per_cod']; ?>">
                        <table>
                            <tr><td>C.I. :</td><td><input type="text" name="cod" value="<?php echo $persona['per_cod']; ?>" readonly></td></tr>
                            <tr><td>Nombre :</td><td><input type="text" name="nom" value="<?php echo trim($persona['per_nom']); ?>" required></td></tr>
                            <tr><td>Apellidos :</td><td><input type="text" name="appm" value="<?php echo trim($persona['per_appm']); ?>" required></td></tr>
                            <tr><td>Profesión :</td><td><input type="text" name="prof" value="<?php echo trim($persona['per_prof']); ?>"></td></tr>
                            <tr><td>Teléfono:</td><td><input type="text" name="tel" value="<?php echo trim($persona['per_telf']); ?>"></td></tr>
                            <tr><td>Celular :</td><td><input type="text" name="cel" value="<?php echo trim($persona['per_cel']); ?>"></td></tr>
                            <tr><td>E-Mail :</td><td><input type="email" name="email" value="<?php echo trim($persona['per_email']); ?>" required></td></tr>
                            <tr><td>Dirección :</td><td><input type="text" name="dir" value="<?php echo trim($persona['per_dir']); ?>"></td></tr>
                            <tr><td>Fecha Nac. :</td><td><input type="date" name="fnac" value="<?php echo $persona['per_fnac']; ?>" required></td></tr>
                            <tr><td>Lugar Nac. :</td><td><input type="text" name="lnac" value="<?php echo trim($persona['per_lnac']); ?>"></td></tr>
                            <tr><td>Foto actual:</td><td>
                                <?php if(isset($persona['per_foto']) && $persona['per_foto'] != 'default.jpg'): ?>
                                    <img src="<?php echo $uploads_web_url . $persona['per_foto']; ?>" style="width:100px;height:100px;"><br>
                                    Archivo: <?php echo $persona['per_foto']; ?>
                                <?php else: ?>
                                    Sin foto
                                <?php endif; ?>
                            </td></tr>
                            <tr><td>Nueva foto :</td><td>
                                <input type="file" name="foto" accept="image/*">
                                <br><small>Formatos: JPG, PNG, GIF. Máximo: 2MB (Opcional)</small>
                            </td></tr>
                            <tr><td colspan="2">
                                <input type="submit" value="Actualizar">
                                <a href="personas.php">Cancelar</a>
                            </td></tr>
                        </table>
                    </form>
                    <?php
                    mostrarFooter();
                } else {
                    mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                    echo "<h2>Persona no encontrada</h2>";
                    echo "<a href='personas.php'>Volver al listado</a>";
                    mostrarFooter();
                }
            } else {
                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                echo "<h2>Acceso denegado</h2>";
                echo "<a href='personas.php'>Volver al listado</a>";
                mostrarFooter();
            }
        }
        break;
    case 4: {
            // Eliminar persona (solo propietario)
            session_start();
            if ($_SESSION['nivel'] == 2) { // Es el Propietario
                $per_cod = $_REQUEST['per_cod'];
                
                // Obtener datos de la persona antes de eliminar
                $db = ADONewConnection($dbdriver);
                $db->debug = false;
                $db->Connect($dbserver, $dbuser, $dbpassword, $dbname);
                $result = $db->Execute("SELECT * FROM persona WHERE per_cod='$per_cod'");
                $persona = $result->FetchRow();
                
                if ($persona) {
                    // Eliminar foto si existe
                    if (isset($persona['per_foto']) && $persona['per_foto'] != 'default.jpg') {
                        $foto_path = $uploads_physical_path . $persona['per_foto'];
                        if (file_exists($foto_path)) {
                            unlink($foto_path);
                        }
                    }
                    
                    // Eliminar permisos primero
                    $db->Execute("DELETE FROM permiso WHERE per_cod='$per_cod'");
                    
                    // Eliminar persona
                    $rs = $db->Execute("DELETE FROM persona WHERE per_cod='$per_cod'");
                    
                    if ($rs) {
                        $content = "<h1>Persona eliminada exitosamente</h1>";
                        $content .= "<p>Se eliminó: " . trim($persona['per_nom']) . " " . trim($persona['per_appm']) . "</p>";
                        if (isset($persona['per_foto']) && $persona['per_foto'] != 'default.jpg') {
                            $content .= "<p>También se eliminó la foto: " . $persona['per_foto'] . "</p>";
                        }
                    } else {
                        $content = "<h1>Error al eliminar la persona</h1>";
                    }
                } else {
                    $content = "<h1>Persona no encontrada</h1>";
                }
                
                $db->Close();
                
                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                echo $content;
                echo "<br><a href='personas.php'>Volver al listado</a>";
                mostrarFooter();
                
            } else {
                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                echo "<h2>Acceso denegado</h2>";
                echo "<a href='personas.php'>Volver al listado</a>";
                mostrarFooter();
            }
        }
        break;
    case 10: {
            $cod = $_POST['cod'];
            $nom = $_POST['nom'];
            $appm = $_POST['appm'];
            $prof = $_POST['prof'];
            $tel = $_POST['tel'];
            $cel = $_POST['cel'];
            $email = $_POST['email'];
            $dir = $_POST['dir'];
            $fnac = $_POST['fnac'];
            $lnac = $_POST['lnac'];
            $tipo = $_POST['tipo'];
            $pass = $_POST['pass'];
            
            // Manejo de la foto
            $foto_nombre = 'default.jpg';
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $max_size = 2 * 1024 * 1024; // 2MB
                
                if (in_array($_FILES['foto']['type'], $allowed_types) && $_FILES['foto']['size'] <= $max_size) {
                    $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                    $foto_nombre = $cod . '_' . time() . '.' . $extension;
                    $upload_path = $uploads_physical_path . $foto_nombre;
                    
                    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {
                        $foto_nombre = 'default.jpg';
                    }
                }
            }

            //***AHORA UTILIZAMOS ADODB PARA CONECTAR A LA BASE DE DATOS Y LOGRAR INDEPENDENCIA DE LA DB Y LA LG
            $db = ADONewConnection($dbdriver);
            $db->debug = false;
            $sqlper = "INSERT INTO persona VALUES ('$cod', '$nom', '$appm','$prof', '$tel', '$cel', '$email', '$dir', '$fnac', '$lnac', true, now(), now(), '$foto_nombre');";
            //echo $sqlper;
            $sqlperm = "INSERT INTO permiso VALUES ('$cod',1,'$pass','" . date("Y-m-d") . "','" . date("Y-m-d", strtotime(date("Y-m-d") . "+ 365 days")) . "', true, now(),now());";
            //echo $sqlperm;                
            $db->Connect($dbserver, $dbuser, $dbpassword, $dbname);
            $rs = $db->Execute($sqlper . '  ' . $sqlperm);
            $content = "<h1>La Operacion se realizo con Exito.</h1>";
            if ($foto_nombre != 'default.jpg') {
                $content .= "<p>La foto se subió exitosamente.</p>";
            }
            $db->Close();

            if (!$rs) {
                //print $db->ErrorMsg();

                //header ("Location: ps_mensaje.php?def=Detalle&error=No se pudo realzar el Registro");
                $e = ADODB_Pear_Error();
                //echo '<p>',$e->message,'</p>';
                $p1 = stripos($e->message, '[');
                $p2 = stripos($e->message, ']');
                $msg_error = substr($e->message, $p1, $p2 - $p1 + 1);
                $content = "<h1>No se pudo realizar la Operacion.</h1> <h4>" . $msg_error . "</h4>";
            }
            //echo $content;

            session_start();
            mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
            echo $content;
            echo "<br><a href='personas.php'>Volver al listado</a>";
            mostrarFooter();
        }
        break;
    case 30: {
            // Procesar actualización de persona con foto
            session_start();
            if ($_SESSION['nivel'] == 2) { // Es el Propietario
                $per_cod = $_POST['per_cod'];
                $nom = $_POST['nom'];
                $appm = $_POST['appm'];
                $prof = $_POST['prof'];
                $tel = $_POST['tel'];
                $cel = $_POST['cel'];
                $email = $_POST['email'];
                $dir = $_POST['dir'];
                $fnac = $_POST['fnac'];
                $lnac = $_POST['lnac'];
                
                // Manejo de la foto
                $foto_nombre = null;
                if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    $max_size = 2 * 1024 * 1024; // 2MB
                    
                    if (in_array($_FILES['foto']['type'], $allowed_types) && $_FILES['foto']['size'] <= $max_size) {
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                        $foto_nombre = $per_cod . '_' . time() . '.' . $extension;
                        $upload_path = $uploads_physical_path . $foto_nombre;
                        
                        if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {
                            // Foto subida exitosamente
                        } else {
                            $foto_nombre = null;
                        }
                    } else {
                        $foto_nombre = null;
                    }
                }
                
                // Conexión a la base de datos
                $db = ADONewConnection($dbdriver);
                $db->debug = false;
                $db->Connect($dbserver, $dbuser, $dbpassword, $dbname);
                
                // Preparar la consulta SQL
                if ($foto_nombre) {
                    $sql = "UPDATE persona SET per_nom='$nom', per_appm='$appm', per_prof='$prof', per_telf='$tel', per_cel='$cel', per_email='$email', per_dir='$dir', per_fnac='$fnac', per_lnac='$lnac', per_foto='$foto_nombre', per_update=now() WHERE per_cod='$per_cod'";
                } else {
                    $sql = "UPDATE persona SET per_nom='$nom', per_appm='$appm', per_prof='$prof', per_telf='$tel', per_cel='$cel', per_email='$email', per_dir='$dir', per_fnac='$fnac', per_lnac='$lnac', per_update=now() WHERE per_cod='$per_cod'";
                }
                
                $rs = $db->Execute($sql);
                
                if ($rs) {
                    $content = "<h1>Los datos se actualizaron correctamente.</h1>";
                    if ($foto_nombre) {
                        $content .= "<p>La foto se subió exitosamente.</p>";
                    }
                } else {
                    $content = "<h1>Error al actualizar los datos.</h1>";
                }
                
                $db->Close();
                
                // Mostrar resultado
                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                echo $content;
                echo "<br><a href='personas.php'>Volver al listado</a>";
                mostrarFooter();
            } else {
                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                echo "<h2>Acceso denegado</h2>";
                echo "<a href='personas.php'>Volver al listado</a>";
                mostrarFooter();
            }
        }
        break;
    default: {
            session_start();
            if ($_SESSION['nivel'] == 2) { // Es el Propietario
                $db = ADONewConnection($dbdriver);
                $db->debug = false;
                $db->Connect($dbserver, $dbuser, $dbpassword, $dbname);
                $result = $db->Execute("SELECT * FROM persona;");
                $amigos = $result->GetArray();
                $db->Close();

                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                ?>
                <h2>Listado de Amigos</h2>
                <a href="personas.php?opcion=1">Nuevo</a>
                <table>
                    <tr>
                        <th>C.I.</th>
                        <th>Nombre Completo</th>
                        <th>Foto</th>
                        <th>Mostrar</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                    <?php foreach($amigos as $amigo): ?>
                    <tr>
                        <td><?php echo $amigo['per_cod']; ?></td>
                        <td><?php echo $amigo['per_appm'] . ' ' . $amigo['per_nom']; ?></td>
                        <td>
                            <?php if(isset($amigo['per_foto']) && $amigo['per_foto'] != 'default.jpg'): ?>
                                <img src="<?php echo $uploads_web_url . $amigo['per_foto']; ?>" style="width:50px;height:50px;">
                            <?php else: ?>
                                Sin foto
                            <?php endif; ?>
                        </td>
                        <td><a href="personas.php?opcion=2&per_cod=<?php echo $amigo['per_cod']; ?>">Mostrar</a></td>
                        <td><a href="personas.php?opcion=3&per_cod=<?php echo $amigo['per_cod']; ?>">Editar</a></td>
                        <td><a href="personas.php?opcion=4&per_cod=<?php echo $amigo['per_cod']; ?>">Eliminar</a></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php
                mostrarFooter();
                
            } else { // Es el Amigo
                $db = ADONewConnection($dbdriver);
                $db->debug = false;
                $db->Connect($dbserver, $dbuser, $dbpassword, $dbname);
                $result = $db->Execute("SELECT * FROM persona WHERE per_cod='" . $_SESSION['ci'] . "';");
                $amigos = $result->GetArray();
                $db->Close();

                mostrarHeader("Agenda Personal (tres capas)", $_SESSION['usuario'], $_SESSION['nivel']);
                ?>
                <h2>Mis Datos</h2>
                <table>
                    <tr>
                        <th>C.I.</th>
                        <th>Nombre Completo</th>
                        <th>Foto</th>
                        <th>Mostrar</th>
                        <th>Modificar</th>
                    </tr>
                    <?php foreach($amigos as $amigo): ?>
                    <tr>
                        <td><?php echo $amigo['per_cod']; ?></td>
                        <td><?php echo $amigo['per_appm'] . ' ' . $amigo['per_nom']; ?></td>
                        <td>
                            <?php if(isset($amigo['per_foto']) && $amigo['per_foto'] != 'default.jpg'): ?>
                                <img src="<?php echo $uploads_web_url . $amigo['per_foto']; ?>" style="width:50px;height:50px;">
                            <?php else: ?>
                                Sin foto
                            <?php endif; ?>
                        </td>
                        <td><a href="personas.php?opcion=2&per_cod=<?php echo $amigo['per_cod']; ?>">Mostrar</a></td>
                        <td><a href="personas.php?opcion=3&per_cod=<?php echo $amigo['per_cod']; ?>">Editar</a></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php
                mostrarFooter();
            }
        }
}
