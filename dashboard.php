<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];
$is_guest = ($username === 'guest');

$notes_file = "notes.db";

// Delete Existing Notes
if (!$is_guest && isset($_GET['delete'])) {
    $lines = file($notes_file, FILE_IGNORE_NEW_LINES);
    $index = (int) $_GET['delete'];
    if (isset($lines[$index])) {
        unset($lines[$index]);
        file_put_contents($notes_file, implode("\n", $lines));
    }
    header("Location: dashboard.php");
    exit;
}

// Create New Notes
if (!$is_guest && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note'])) {
    $raw_note = trim($_POST['note']);
    if ($raw_note !== '') {
        $timestamp = date('Y-m-d H:i');
        $formatted_note = "[" . $username . " - " . $timestamp . "] " . $raw_note;
        file_put_contents($notes_file, $formatted_note . "\n", FILE_APPEND);
    }
    header("Location: dashboard.php");
    exit;
}


// Read All notes
$notes = file($notes_file, FILE_IGNORE_NEW_LINES);

echo "<h2>Welcome, " . htmlentities($username) . "</h2>";
?>

<a href="logout.php">Logout</a>
<?php if ($username === 'admin'): ?>
    | <a href="admin.php" style="color:blue;">Admin Panel</a>
<?php endif; ?>
<br><br>

<?php if (!$is_guest): ?>
    <form method="POST">
        <textarea name="note" placeholder="Write your note here" required></textarea><br>
        <button type="submit">Save Note</button>
    </form>
<?php else: ?>
    <p style="color:gray;">You are logged in as <strong>guest</strong>. Note creation and deletion are disabled.</p>
<?php endif; ?>

<h3>Shared Notes</h3>
<?php
foreach ($notes as $index => $note) {
    echo "<div style='border:1px solid black;margin:5px;padding:5px;'>";
    echo $note;

    if (!$is_guest) {
        echo " <a href='?delete=$index' style='color:red; margin-left:10px;'>[Delete]</a>";
    }
    echo "</div>";
}
?>
