<?php
session_start();

$users = [
    'admin' => 'GT2@#!Jzsdda9#1@',
    'guest' => 'guest123', // Guest Creds leaked in documentation
    'michael' => 'Password123!', // Weak Password for Brute-force
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if (isset($users[$user]) && $users[$user] === $pass) {
        $_SESSION['username'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<h2>Vuln Note</h2>
<h3>Login</h3>
<form method="POST">
    <input name="username" placeholder="Username"><br>
    <input name="password" type="password" placeholder="Password"><br>
    <button type="submit">Login</button>
</form>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
