<?php
session_start();
include '../db.php';

// Redirect jika belum login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Waktu saat ini
$current_time = date('Y-m-d H:i:s');

// Ambil semua tugas
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");

// Periksa pengingat
$reminder_tasks = $conn->query("SELECT * FROM tasks WHERE reminder_at IS NOT NULL AND reminder_at <= '$current_time' AND is_completed = 0");

// Tambah tugas baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $task = htmlspecialchars($_POST['task']);
    $reminder_at = $_POST['reminder_at'];

    $stmt = $conn->prepare("INSERT INTO tasks (task, reminder_at) VALUES (?, ?)");
    $stmt->bind_param("ss", $task, $reminder_at);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}

// Tandai tugas selesai
if (isset($_GET['complete_task'])) {
    $id = intval($_GET['complete_task']);
    $conn->query("UPDATE tasks SET is_completed = 1 WHERE id = $id");
    header("Location: dashboard.php");
    exit();
}

// Hapus tugas
if (isset($_GET['delete_task'])) {
    $id = intval($_GET['delete_task']);
    $conn->query("DELETE FROM tasks WHERE id = $id");
    header("Location: dashboard.php");
    exit();
}
