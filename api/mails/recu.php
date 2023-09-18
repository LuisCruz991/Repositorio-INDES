<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Cargando las clases de phpmailer 
require '../libraries/PHPMailer/src/Exception.php';
require '../libraries/PHPMailer/src/PHPMailer.php';
require '../libraries/PHPMailer/src/SMTP.php';

// Cargando la clase necesaria para cargar los datos del usuario 
require_once('../entities/dto/usuario.php');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// se verifica que los parametros enviados no sean nulos
if (isset($_GET['nombre_usuario']) && isset($_GET['codigo'])) {
    // se crea el objeto usuario 
    $user = new Usuario;
    // le asignamos el valor de del nombre del usuario 
    if ($user->setAlias($_GET['nombre_usuario'])) {
        // obtenemos los valores de la consulta 
        if ($data = $user -> readByname()) {
            // asignamos el valor del codigo a una variable 
            $code = $_GET['codigo'];
            // se ejecuta el codigo de la libreria 
            try {
                //Server settings
                $mail->SMTPDebug = 0; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
                $mail->SMTPAuth = true; //Enable SMTP authentication
                $mail->Username = 'josue.portillo0123@gmail.com'; //SMTP username
                $mail->Password = 'egzi ugui bwms teph '; //SMTP password
                $mail->SMTPSecure = 'ssl'; //Enable implicit TLS encryption
                $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('josue.portillo0123@gmail.com', 'Soporte INDES'); // Direccion de correo de donde se envia el correo
                $mail->addAddress($data['correo_usuario']); //Direccion de correo a dode se envia el correo

                //Content
                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = 'Tu codigo de verificacion';
                $mail->Body = " $code";

                $mail->send();
                echo 'Mensaje envido de forma exitosa';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo 'ha ocurrido un error leyendo los datos del usuario';
        }
    }
} else {
    echo 'El nombre de usuario ingresado no es valido';

}