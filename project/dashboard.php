<?php
include 'prosses.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">To-Do List</h1>

        <!-- Notifikasi Pengingat -->
        <?php if ($reminder_tasks->num_rows > 0): ?>
            <div class="alert alert-warning">
                <?php while ($reminder = $reminder_tasks->fetch_assoc()): ?>
                    <p><strong>Reminder:</strong> Task "<?= $reminder['task'] ?>" is due!</p>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <!-- Form Tambah Tugas -->
        <form method="POST" class="d-flex mb-4">
            <input type="text" name="task" class="form-control me-2" placeholder="Enter a new task" required>
            <input type="datetime-local" name="reminder_at" class="form-control me-2" required>
            <button type="submit" name="add_task" class="btn btn-primary">Add Task</button>
        </form>

        <!-- Tabel Daftar Tugas -->
        <table class="table table-bordered bg-white">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Reminder At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['task'] ?></td>
                            <td>
                                <?php if ($row['is_completed']): ?>
                                    <span class="badge bg-success">Completed</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $row['reminder_at'] ? date("d M Y, H:i", strtotime($row['reminder_at'])) : '-' ?>
                            </td>
                            <td>
                                <?php if (!$row['is_completed']): ?>
                                    <a href="?complete_task=<?= $row['id'] ?>" class="btn btn-success btn-sm">Complete</a>
                                <?php endif; ?>
                                <a href="?delete_task=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No tasks found. Add a task above!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="container py-5">
            <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>