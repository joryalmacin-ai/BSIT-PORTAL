<?php
session_start();
include '../config.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

// Add Event
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $date = $_POST['date'];
    $details = $_POST['details'];

    $stmt = $conn->prepare("INSERT INTO events (name, event_date, details) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $date, $details);
    $stmt->execute();
    header("Location: events_crud.php");
}

// Edit Event
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $details = $_POST['details'];

    $stmt = $conn->prepare("UPDATE events SET name=?, event_date=?, details=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $date, $details, $id);
    $stmt->execute();
    header("Location: events_crud.php");
}

// Delete Event
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM events WHERE id=$id");
    header("Location: events_crud.php");
}

$result = $conn->query("SELECT * FROM events ORDER BY event_date DESC");
?>

<h1>Manage Events</h1>

<!-- Add Form -->
<h2>Add Event</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Event Name" required><br>
    <input type="date" name="date" required><br>
    <textarea name="details" placeholder="Event Details" required></textarea><br>
    <button type="submit" name="add">Add Event</button>
</form>

<!-- List of Events -->
<h2>Existing Events</h2>
<table border="1">
<tr>
<th>ID</th><th>Name</th><th>Date</th><th>Details</th><th>Actions</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['event_date'] ?></td>
<td><?= $row['details'] ?></td>
<td>
<a href="events_crud.php?edit=<?= $row['id'] ?>">Edit</a> |
<a href="events_crud.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<!-- Edit Form -->
<?php
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $edit_result = $conn->query("SELECT * FROM events WHERE id=$id")->fetch_assoc();
?>
<h2>Edit Event</h2>
<form method="POST">
<input type="hidden" name="id" value="<?= $edit_result['id'] ?>">
<input type="text" name="name" value="<?= $edit_result['name'] ?>" required><br>
<input type="date" name="date" value="<?= $edit_result['event_date'] ?>" required><br>
<textarea name="details" required><?= $edit_result['details'] ?></textarea><br>
<button type="submit" name="update">Update Event</button>
</form>
<?php } ?>
