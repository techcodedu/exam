<?php
include('../includes/database.php');

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;
if (!$id) {
    echo "Invalid ID provided.";
    exit();
}

$individual = null;

// Fetch individual's details for editing
if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update'])) {
    $stmt = $conn->prepare("SELECT * FROM tblIndividuals WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $individual = $result->fetch_assoc();

    if (!$individual) {
        echo "No individual found with ID $id";
        exit();
    }
}

// Handle form submission for updating individual's details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $firstName = $conn->real_escape_string($_POST['first_name']);
    $lastName = $conn->real_escape_string($_POST['last_name']);
    $dob = $conn->real_escape_string($_POST['date_of_birth']);
    $sex = $conn->real_escape_string($_POST['sex']);
    $address = $conn->real_escape_string($_POST['address']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $citymunId = $conn->real_escape_string($_POST['citymun_id']);
    $statusId = $conn->real_escape_string($_POST['status_id']);

    $updateStmt = $conn->prepare("UPDATE tblIndividuals SET first_name = ?, last_name = ?, date_of_birth = ?, sex = ?, address = ?, contact = ?, citymun_id = ?, status_id = ? WHERE id = ?");
    $updateStmt->bind_param("sssssiiii", $firstName, $lastName, $dob, $sex, $address, $contact, $citymunId, $statusId, $id);
    $updateStmt->execute();

    header("Location:view_person.php");
    exit();
}

include('../includes/header.php');
include('../includes/navbar.php');
?>

<div class="container mt-5">
    <h2>Edit Individual</h2>
    <?php if ($individual): ?>
    <form method="post">
        <input type="hidden" name="update" value="1">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name"
                value="<?php echo htmlspecialchars($individual['first_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name"
                value="<?php echo htmlspecialchars($individual['last_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                value="<?php echo htmlspecialchars($individual['date_of_birth']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="sex" class="form-label">Sex</label>
            <select class="form-select" id="sex" name="sex" required>
                <option value="Male" <?php echo $individual['sex'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $individual['sex'] == 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address"
                value="<?php echo htmlspecialchars($individual['address']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact"
                value="<?php echo htmlspecialchars($individual['contact']); ?>">
        </div>
        <div class="mb-3">
            <label for="citymun_id" class="form-label">City/Municipality ID</label>
            <input type="number" class="form-control" id="citymun_id" name="citymun_id"
                value="<?php echo htmlspecialchars($individual['citymun_id']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="status_id" class="form-label">Status ID</label>
            <input type="number" class="form-control" id="status_id" name="status_id"
                value="<?php echo htmlspecialchars($individual['status_id']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <?php else: ?>
    <p>Individual not found.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>