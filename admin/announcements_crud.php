<?php
session_start();
include '../config.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

// Add Announcement
if(isset($_POST['add'])){
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO announcements (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    header("Location: announcements_crud.php");
}

// Edit Announcement
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE announcements SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    header("Location: announcements_crud.php");
}

// Delete Announcement
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM announcements WHERE id=$id");
    header("Location: announcements_crud.php");
}

$result = $conn->query("SELECT * FROM announcements ORDER BY date_posted DESC");
?>

<h1>Manage Announcements</h1>

<!-- Add Form -->
<h2>Add Announcement</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="content" placeholder="Content" required></textarea><br>
    <button type="submit" name="add">Add</button>
</form>

<!-- List of Announcements -->
<h2>Existing Announcements</h2>
<table border="1">
    <tr>
        <th>ID</th><th>Title</th><th>Content</th><th>Date</th><th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['content'] ?></td>
            <td><?= $row['date_posted'] ?></td>
            <td>
                <a href="announcements_crud.php?edit=<?= $row['id'] ?>">Edit</a> | 
                <a href="announcements_crud.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- Edit Form -->
<?php
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $edit_result = $conn->query("SELECT * FROM announcements WHERE id=$id")->fetch_assoc();
?>
<h2>Edit Announcement</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit_result['id'] ?>">
    <input type="text" name="title" value="<?= $edit_result['title'] ?>" required><br>
    <textarea name="content" required><?= $edit_result['content'] ?></textarea><br>
    <button type="submit" name="update">Update</button>
</form>
<?php } ?>
