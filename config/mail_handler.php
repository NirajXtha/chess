<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
    function sendMail($username, $email, $otp) {
        $email_password = getenv('EMAIL_PASSWORD');
        $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 2;                                       
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                             
                    $mail->Username   = 'shresthaniraj633@gmail.com'; // Your email address
                    $mail->Password   = $email_password; // Your email password (Google generated password)                
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;  
                
                    $mail->setFrom('noreply@gmail.com', 'MyChess');           
                    $mail->addAddress($email, $username);
                    
                    $mail->isHTML(false);                                  
                    $mail->Subject = 'Chess OTP Verification';
                    $mail->Body    = '
                        Testing
                    ';
                    $mail->send();
                    return true;
                } catch (Exception $e) {
                    echo '
                        <script>
                            $(document).ready(function(){
                                Swal.fire({
                                    icon: "error",
                                    title: "Invalid email address!",
                                    text: "Please try again!",
                                });
                            });
                        </script>
                    ';
                    return false;
                }
    }

?>