<?php
include 'login_back.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="assets/img/bcp logo.png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Property Custodian Management.">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Login - CMS</title>

</head>
<body>
    <div class="logo">
        <img src="assets/img/bcp logo.png" alt="Logo">
        <p>Property Custodian Management System</p>
    </div>

    <div class="login-container">
        <h2>Log Into Your Account</h2>
        <?php if (!empty($error)): ?>
            <div class="error-message" style="color: red;">
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <form id="loginForm" action="index.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required aria-label="Account ID">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required aria-label="Password">

            <div class="forgot-password">
                <a href="#" aria-label="Forgot password?">Forgot your password?</a>
            </div>

            <button type="submit">LOGIN</button><br></br>
        </form>
        <a href="register/registerforadmin.php" class="btn">Sign Up</a>

            <div id="otpModal" class="modal">
            <div class="modal-content" id="otpModalContent">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Verify Your Account</h2>
                <p>We emailed you a 6-digit OTP code. Enter the code below to confirm your email address.</p>

                <?php if (!empty($_SESSION['otp_error'])): ?>
                    <div class="error-message" style="color: red;">
                        <?= $_SESSION['otp_error']; ?>
                    </div>
                    <?php unset($_SESSION['otp_error']); ?>
                <?php endif; ?>

                <form id="otpForm" action="verify_otp.php" method="post">
                    <div class="otp-input">
                        <input type="text" name="otp1" maxlength="1" oninput="handleInput(this)" onkeydown="handleKeyDown(this, event)" required>
                        <input type="text" name="otp2" maxlength="1" oninput="handleInput(this)" onkeydown="handleKeyDown(this, event)" required>
                        <input type="text" name="otp3" maxlength="1" oninput="handleInput(this)" onkeydown="handleKeyDown(this, event)" required>
                        <input type="text" name="otp4" maxlength="1" oninput="handleInput(this)" onkeydown="handleKeyDown(this, event)" required>
                        <input type="text" name="otp5" maxlength="1" oninput="handleInput(this)" onkeydown="handleKeyDown(this, event)" required>
                        <input type="text" name="otp6" maxlength="1" oninput="handleInput(this)" onkeydown="handleKeyDown(this, event)" required>
                    </div>
                    <button type="submit">Verify Now</button>
                </form>
            </div>
        </div>

        <script src="../js/login.js"></script>

        <script>
            window.onload = function () {
                <?php if (isset($_SESSION['otp_sent']) && $_SESSION['otp_sent']): ?>
                    showModal();
                    <?php unset($_SESSION['otp_sent']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['show_otp_modal']) && $_SESSION['show_otp_modal']): ?>
                    showModal();
                    <?php unset($_SESSION['show_otp_modal']); ?>
                <?php endif; ?>
            };

        </script> 

        
<script>
window.addEventListener("storage", function(event) {
    if (event.key === "forceLogout") {
        showLogoutModal();
    }
});

function showLogoutModal() {
    let modal = document.createElement("div");
    modal.innerHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center;">
            <div style="background: white; padding: 20px; border-radius: 10px; text-align: center;">
                <p style="font-size: 18px;">We've detected that you logged out in another tab.</p>
                <button onclick="redirectToLogin()" style="background: #007BFF; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">OK</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function redirectToLogin() {
    window.location.href = "index.php"; // Redirect back to login page
}
</script>



    </div>
</body>
</html>