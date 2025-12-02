<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}
?>
<h1>Admin Dashboard</h1>
<p>Welcome, <?php echo $_SESSION['admin']; ?>!</p>
<a href="logout.php">Logout</a>
