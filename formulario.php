<?php
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$ciudad = $_POST['ciudad'];
$mensaje = $_POST['mensaje']; 

if( !empty($nombre) || !empty($email)  || !empty($ciudad) || !empty($mensaje))
{
    $host = "localhost:3307";#apuntamos al puerto de la base de datos
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "contactar";#

    #enlazamos conexion con los atributos y representados con conn
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
    if(mysqli_connect_error()){
        die('connect error('.mysqli_connect_error().')'.mysqli_connect_error());
}

else{
    #sentencias preparadas 
    $SELECT = "SELECT email from contactos where email = ? limit 1";#DATO QUE NO SE VA A REPETIR -> en caso del formulario seria el correo
    $INSERT = "INSERT INTO email(nombre , email , ciudad , mensaje)
    values(? , ? , ? , ? ) ";
    $stmt = $conn->prepare($SELECT);#stmt identificador 
    $stmt ->bind_param("s" ,$email);
    $stmt ->execute();
    $stmt ->bind_result($email);
    $stmt ->store_result();
    $rnum = $stmt->num_rows;
    if($rnum == 0){
        $stmt ->close();
        $stmt = $conn->prepare($INSERT);
        $stmt ->bind_param("sssss",$nombre , $email , $ciudad , $mensaje")
        $stmt ->execute();
            #echo "¡Gracias por tu retroalimentación!.";
        }
        else {
            #echo "alguien registro ese correo."; #comentario si se registra otra encuesta con el mismo correo

        }
        $stmt->close();
        $conn->close();
    }


else{
    echo "todos los datos son OBLIGARTORIOS";
    die();
}

?>
