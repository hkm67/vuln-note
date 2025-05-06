<?php
session_start();

// Admin Only
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    echo "Access denied.";
    exit;
}
?>
<h2>Admin: View System Logs</h2>

<form method="GET">
    <label>Search Logs:</label>
    <input type="text" name="q" placeholder="Enter search keyword">
    <button type="submit">Search</button>
</form>

<?php

if (isset($_GET['q'])) {
    $keyword = $_GET['q'];
    echo "You searched for: " . htmlentities($keyword) . "<br>";
    echo "<h3>Results:</h3><pre>";
    $output = shell_exec("cat /var/www/html/vuln-note/access.log | grep $keyword");
    echo "Command output: <pre>" . htmlentities($output) . "</pre>";
}
?>
