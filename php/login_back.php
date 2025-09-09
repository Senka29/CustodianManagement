<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard/main.php");
    exit();
}

include 'connect/connection.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT username, password, email FROM bcp_sms4_admins WHERE username = ?";


    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Prepare Error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $otp = rand(100000, 999999); 
            $_SESSION['username'] = $user['username'];
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $user['email'];
            //$_SESSION['user_type'] = $user['user_type']; // Store user type in session
            //ito bago din to
            $_SESSION['session_id'] = session_id(); // Store session ID

            echo "<script>
                  localStorage.setItem('session_active', 'true');
                  localStorage.setItem('session_id', '" . session_id() . "');
                  </script>";

                  //hanggang dito sa echo

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'bcpclinicmanagement@gmail.com';
                $mail->Password   = 'fvzf ldba jroq xzjf';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('bcpclinicmanagement@gmail.com', 'Clinic Management System');
                $mail->addAddress($user['email']);

                $mail->isHTML(true);
                $mail->Subject = 'Your Secure 2-Factor Authentication (2FA) Code';
                $mail->Body    = 'Hello,<br><br>Your One-Time Password (OTP) for secure access is: <b style="font-size: 18px; color: #007BFF;">' . $otp . '</b>.<br><br>'
                               . 'This code is valid for the next 5 minutes. Please do not share it with anyone for your security.<br><br>'
                               . 'If you did not request this code, please ignore this email or contact support immediately.<br><br>'
                               . 'Thank you for using our services.<br>'
                               . '<i>Your Trusted Team</i>';
                $mail->AltBody = 'Hello, '
                               . 'Your One-Time Password (OTP) for secure access is: ' . $otp . '. '
                               . 'This code is valid for the next 5 minutes. Please do not share it with anyone for your security. '
                               . 'If you did not request this code, please ignore this email or contact support immediately. '
                               . 'Thank you for using our services. '
                               . '- Your Trusted Team';
                

                if ($mail->send()) {
                    $_SESSION['otp_sent'] = true;
                } else {
                    $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $error = "Invalid account credentials!";
        }
    } else {
        $error = "Invalid account ID!";
    }

    $stmt->close();
    $conn->close();
}

?>