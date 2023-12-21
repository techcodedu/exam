<?php
include('../includes/database.php');

// Initialize variables
$firstName = $lastName = $dob = $sex = $citymunId = $statusId = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize it
    $firstName = $conn->real_escape_string($_POST['first_name']);
    $lastName = $conn->real_escape_string($_POST['last_name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $sex = $conn->real_escape_string($_POST['sex']);
    $address = $conn->real_escape_string($_POST['address']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $citymunId = isset($_POST['citymun_id']) ? $conn->real_escape_string($_POST['citymun_id']) : "";
    $statusId = isset($_POST['status_id']) ? $conn->real_escape_string($_POST['status_id']) : "";
    

    // SQL to insert data
   $currentDateTime = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tblIndividuals (first_name, last_name, date_of_birth, sex, address, contact, citymun_id, status_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiiiss", $firstName, $lastName, $dob, $sex, $address, $contact, $citymunId, $statusId, $currentDateTime, $currentDateTime);

    if (!$stmt->execute()) {
        // Handle error, e.g., print a user-friendly message
        echo "Error: " . $stmt->error;
    } else {
        header("Location: view_person.php");
        exit();
    }
    $stmt->close();
}

// Fetch city/municipality data for dropdown
$citymunQuery = "SELECT id, citymun_m FROM tblcitymun";
$citymunResult = $conn->query($citymunQuery);

// Fetch status data for dropdown
$statusQuery = "SELECT status_id, status_name FROM tblstatus";
$statusResult = $conn->query($statusQuery);

include('../includes/header.php');
include('settings.php');
?>
<div class="container mt-5">
    <h2>Add New Individual</h2>
    <form method="post">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="mb-3">
            <label for="sex" class="form-label">Sex</label>
            <select class="form-select" id="sex" name="sex" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact">
        </div>
        <div class="mb-3">
            <label for="citymun_id" class="form-label">City/Municipality</label>
            <select class="form-select" id="citymun_id" name="citymun_id" required>
                <option value="">Select City/Municipality</option>
                <?php while ($row = $citymunResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['citymun_m']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="status_id" class="form-label">Status</label>
            <select class="form-select" id="status_id" name="status_id" required>
                <option value="">Select Status</option>
                <?php while ($row = $statusResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['status_id']); ?>">
                    <?php echo htmlspecialchars($row['status_name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php
include('../includes/footer.php');
?>