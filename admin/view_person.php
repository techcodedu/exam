<?php
include('../includes/database.php');

// Fetch all individual's details
$sql = "SELECT * FROM tblIndividuals";
$result = $conn->query($sql);

include('../includes/header.php');
include('settings.php');
?>
<div class="container mt-5">
    <h2>All Individuals</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Sex</th>
                <th>Address</th>
                <th>Contact</th>
                <th>City/Municipality ID</th>
                <th>Status ID</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                <td><?php echo htmlspecialchars($row['sex']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><?php echo htmlspecialchars($row['contact']); ?></td>
                <td><?php echo htmlspecialchars($row['citymun_id']); ?></td>
                <td><?php echo htmlspecialchars($row['status_id']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php'); ?>