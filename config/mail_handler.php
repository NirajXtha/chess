<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
    function sendMail($username, $email, $otp) {
        $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;                                       
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                             
                    $mail->Username   = 'shresthaniraj633@gmail.com'; // Your email address
                    $mail->Password   = 'kcxencgrdhswjjol'; // Your email password (Google generated password)                
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;  
                
                    $mail->setFrom('shresthaniraj633@gmail.com', 'MyChess');           
                    $mail->addAddress($email, $username);
                    
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Chess OTP Verification';
                    $mail->Body    = '
                        <div class="container">
                        <div class="header">
                        <a>Verify It is You</a>
                        </div>
                        <br />
                        <strong>Dear ' . $username . ',</strong>
                        <p>
                        We have received a signup request for your MyChess account. For
                        security purposes, please verify your identity by providing the
                        following One-Time Password (OTP).
                        <br />
                        <b>Your One-Time Password (OTP) verification code is:</b>
                        </p>
                        <h2 class="otp">' . $otp . '</h2>
                        <p style="font-size: 0.9em">
                        <strong>One-Time Password (OTP) is valid for 5 minutes.</strong>
                        <br />
                        <br />
                        If you did not initiate this signup request, please disregard this
                        message. Please ensure the confidentiality of your OTP and do not share
                        it with anyone.<br />
                        <strong>Do not forward or give this code to anyone.</strong>
                        <br />
                        <br />
                        <strong>Thank you for using our services.</strong>
                        <br />
                        <br />
                        Best regards,
                        <br />
                        <strong>Chess | Niraj Shrestha</strong>
                        </p>
                    
                        <hr style="border: none; border-top: 0.5px solid #131111" />
                        <div class="footer">
                        <p>This email can not receive replies.</p>
                        <p>
                            For more information about MyChess and your account, visit
                            <strong>MyChess</strong>
                        </p>
                        </div>
                    </div>
                    <div style="text-align: center">
                        <div class="email-info">
                        <span>
                            This email was sent to
                            <a href="mailto:' . $email . '">' . $email . '</a>
                        </span>
                        </div>
                        <div class="email-info">
                        <a href="/">MyChess</a> | Thankot
                        | Kathmandu, Nepal
                        </div>
                        <div class="email-info">
                        &copy; 2023 MyChess. All rights
                        reserved.
                        </div>
                    </div>
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