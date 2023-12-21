<?php include('../includes/database.php'); ?>
<?php include('../includes/header.php'); ?>
<?php include('../includes/navbar.php'); ?>
<div class="container mt-5">
    <h2>Search Individuals</h2>
    <!-- Search form -->
    <form action="" method="post" class="d-flex">
        <input class="form-control me-2" type="search" name="search_query" placeholder="Search by name or DOB"
            aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
    </form>
    <!-- Search results table -->
    <?php
    if (isset($_POST['search'])) {
        $search_query = $conn->real_escape_string($_POST['search_query']);

        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, first_name, last_name, date_of_birth FROM tblIndividuals WHERE first_name LIKE CONCAT('%',?,'%') OR last_name LIKE CONCAT('%',?,'%') OR date_of_birth = ?");
        $stmt->bind_param("sss", $search_query, $search_query, $search_query);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table class='table mt-4'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>ID</th>";
            echo "<th scope='col'>First Name</th>";
            echo "<th scope='col'>Last Name</th>";
            echo "<th scope='col'>Date of Birth</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No results found.</p>";
        }
        $stmt->close();
    }
    ?>
</div>
<?php include('../includes/footer.php'); ?>