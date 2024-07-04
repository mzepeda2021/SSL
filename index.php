<?php
session_start();
class Conectar{
protected $dbh;
   protected function Conexion() {
        try {
            $serverName = "localhost";
            $userName = "root";
            $password = "";
            $dbName = "ssl";
            
            $this->dbh = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establecer el modo de error para excepciones
            $this->dbh->exec("SET NAMES 'utf8'"); // Establecer la codificaci贸n de caracteres
            
            return $this->dbh;
        } catch (PDOException $e) {
            print "隆Error BD, checale bien mich, ahi no es man!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

public function set_names(){
return $this->dbh->query("SET NAMES 'utf8'");
}

public function ruta() {
    return "http://localhost/SSL/";
}

}
    if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){
 class Usuario extends Conectar{

        public function login(){
            $conectar=parent::conexion();
            parent::set_names();
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"];
                $rol = $_POST["rol_id"];
                if(empty($correo) and empty($pass)){
                    header("Location:".conectar::ruta()."index.php?m=2");
					exit();
                }else{
                    $sql = "SELECT * FROM tm_usuario WHERE usu_correo=? and usu_pass=MD5(?) and rol_id=? and est=1";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $pass);
                    $stmt->bindValue(3, $rol);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        $_SESSION["usu_id"]=$resultado["usu_id"];
                        $_SESSION["usu_nom"]=$resultado["usu_nom"];
                        $_SESSION["usu_ape"]=$resultado["usu_ape"];
                        $_SESSION["rol_id"]=$resultado["rol_id"];
                        header("Location:".Conectar::ruta()."view/Home/");
                        exit(); 
                    }else{
                        header("Location:".Conectar::ruta()."index.php?m=1");
                        exit();
                    }
                }
            }
        }


        /* TODO:Insert */
        public function insert_usuario($usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$usu_telf){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_usuario (usu_id, usu_nom, usu_ape, usu_correo, usu_pass, rol_id, usu_telf, fech_crea, fech_modi, fech_elim, est) 
                    VALUES (NULL,?,?,?,MD5(?),?,?,now(), NULL, NULL, '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $usu_telf);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Update */
        public function update_usuario($usu_id,$usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$usu_telf){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario set
                usu_nom = ?,
                usu_ape = ?,
                usu_correo = ?,
                usu_pass = MD5(?),
                rol_id = ?,
                usu_telf = ?
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $usu_telf);
            $sql->bindValue(7, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Delete */
        public function delete_usuario($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_d_usuario_01(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Todos los registros */
        public function get_usuario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_usuario_01()";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Obtener registros de usuarios segun rol 2 */
        public function get_usuario_x_rol(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario where est=1 and rol_id=2";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x id */
        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_usuario_02(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de registros segun usu_id */
        public function get_usuario_total_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets Abiertos por usu_id */
        public function get_usuario_totalabierto_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='En proceso'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets Cerrado por usu_id */
        public function get_usuario_totalcerrado_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Cerrado'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets por categoria segun usuario */
        public function get_usuario_grafico($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                and tm_ticket.usu_id = ?
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Total de ticket por usuario (empaquetador) */
        public function get_ticket_grafico_x_usuario() {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "SELECT u.usu_nom AS nombre_usuario, COUNT(t.usu_asig) AS total_tickets_asignados
FROM tm_usuario u
LEFT JOIN tm_ticket t ON u.usu_id = t.usu_asig
GROUP BY u.usu_nom
HAVING total_tickets_asignados > 0";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(':usu_id', $usu_id, PDO::PARAM_INT);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    echo json_encode($resultado);
}

     /* TODO:Total de ticket por usuario (empaquetador)(24hrs) */
    public function get_ticket_grafico_x_usuario_24hrs() {
    $conectar = parent::conexion();
    parent::set_names();
    // Obtener los tickets asignados después del último reinicio
    $sql = "SELECT u.usu_nom AS nombre_usuario, COUNT(t.usu_asig) AS total_tickets_asignados
FROM tm_usuario24hrs u
LEFT JOIN tm_ticket24hrs t ON u.usu_id = t.usu_asig
GROUP BY u.usu_nom
HAVING total_tickets_asignados > 0";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    echo json_encode($resultado);
  
}

     /* TODO:Total de ticket por usuario (empaquetador)(semanal) */
    public function get_ticket_grafico_x_usuario_semanal() {
    $conectar = parent::conexion();
    parent::set_names();
    // Obtener los tickets asignados después del último reinicio
    $sql = "SELECT u.usu_nom AS nombre_usuario, COUNT(t.usu_asig) AS total_tickets_asignados
FROM tm_usuario24hrs u
LEFT JOIN tm_ticket48hrs t ON u.usu_id = t.usu_asig
GROUP BY u.usu_nom
HAVING total_tickets_asignados > 0";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    echo json_encode($resultado);
  
}

     /* TODO:Total de ticket por usuario (empaquetador)(mensual) */
    public function get_ticket_grafico_x_usuario_mensual() {
    $conectar = parent::conexion();
    parent::set_names();
    // Obtener los tickets asignados después del último reinicio
    $sql = "SELECT u.usu_nom AS nombre_usuario, COUNT(t.usu_asig) AS total_tickets_asignados
FROM tm_usuario24hrs u
LEFT JOIN tm_ticket72hrs t ON u.usu_id = t.usu_asig
GROUP BY u.usu_nom
HAVING total_tickets_asignados > 0";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    echo json_encode($resultado);
  
}





        /* TODO: Actualizar contraseña del usuario */
        public function update_usuario_pass($usu_id,$usu_pass){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario
                SET
                    usu_pass = MD5(?)
                WHERE
                    usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_pass);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
        $usuario = new Usuario();
        $usuario->login();
    }
?>
<!DOCTYPE html>
<html>
<head lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SSL (Sistema Seguimiento De Licitaciones)</title>

    <link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="img/favicon.png" rel="icon" type="image/png">
    <link href="img/favicon.ico" rel="shortcut icon">

    <link rel="stylesheet" href="public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/morris.css">
    <style>
        #error-gif {
    text-align: center;
}

#error-gif img {
    max-width: 100%;
}
</style>
</head>
<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">

                <form class="sign-box" action="" method="post" id="login_form">

                    <input type="hidden" id="rol_id" name="rol_id" value="2">

                    <div class="sign-avatar">
                        <img src="public/2.jpg" alt="" id="imgtipo">
                    </div>
                    <header class="sign-title" id="lbltitulo">Acceso Vendedores</header>

                <!-- Aquí mostraremos el GIF -->
                <div id="error-gif" style="display: none;">
                    <img src="didnt.gif" alt="Error" />
                </div>

                    <!-- TODO: validar segun valor al iniciar session -->
                    <?php
                        if (isset($_GET["m"])){
                            switch($_GET["m"]){
                                case "1";
                                    ?>
                                     <script> document.getElementById('error-gif').style.display = 'block'; </script>
                                        <div class="alert alert-warning alert-icon alert-close alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <i class="font-icon font-icon-warning"></i>
                                            El Usuario y/o Contraseña son incorrectos.
                                        </div>
                                    <?php
                                break;

                                case "2";
                                    ?>
                                        <div class="alert alert-warning alert-icon alert-close alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <i class="font-icon font-icon-warning"></i>
                                            Los campos estan vacios.
                                        </div>
                                    <?php
                                break;
                            }
                        }
                    ?>

                    <div class="form-group">
                        <input type="text" id="usu_correo" name="usu_correo" class="form-control" placeholder="E-Mail"/>
                    </div>
                    <div class="form-group">
                        <input type="password" id="usu_pass" name="usu_pass" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <!--
                        <div class="float-right reset">
                            <a href="reset-password.html">Cambiar Contraseña</a>
                        </div>
-->
                        <div class="float-left reset">
                            <a href="#" id="btnsoporte">Acceso Administradores</a>
                        </div>
                         
                    </div>
                    <input type="hidden" name="enviar" class="form-control" value="si">
                    <button type="submit" class="btn btn-rounded">Acceder</button>
                </form>
            </div>
        </div>
    </div>

<script src="public/js/lib/jquery/jquery.min.js"></script>
<script src="public/js/lib/tether/tether.min.js"></script>
<script src="public/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="public/js/plugins.js"></script>
<script type="text/javascript" src="public/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function(){
            setTimeout(function(){
                $('.page-center').matchHeight({ remove: true });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            },100);
        });
    });
</script>
<script src="public/js/app.js"></script>

<script type="text/javascript" src="datos.js"></script>

</body>
</html>