<?php
include 'inc/header.php';
include '../config.php';

$sql = "SELECT * FROM announcements ORDER BY date_posted DESC";
$result = $conn->query($sql);
?>

<h1>Announcements</h1>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<div class='announcement'>";
        echo "<h2>".$row['title']."</h2>";
        echo "<p>".$row['content']."</p>";
        echo "<small>Posted on: ".$row['date_posted']."</small>";
        echo "</div>";
    }
} else {
    echo "<p>No announcements yet.</p>";
}
?>

<?php include 'inc/footer.php'; ?>
