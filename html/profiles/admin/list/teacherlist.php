<?php
    session_start();
    if (!isset($_SESSION['mail'])) {
        header("Location: ../../../LoginandRegister/adminLogin.php");
    }
?>

<?php
    require '../../../../dbconnect.php';

    // Pagination parameters
    $recordsPerPage = 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;

    // Search term
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Fetch records for the current page with search
    $query = "SELECT * FROM tech_personal_details WHERE CONCAT(F_name, ' ', L_name, ' ', email, ' ', phone_no, ' ', pin, ' ', city, ' ', state, ' ', country, ' ', gender) LIKE ? LIMIT ?, ?";
    $stmt = mysqli_prepare($conn, $query);
    $searchParam = "%" . $search . "%";
    mysqli_stmt_bind_param($stmt, "sii", $searchParam, $offset, $recordsPerPage);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Count total number of records with search
    $totalRecordsQuery = "SELECT COUNT(*) AS total FROM tech_personal_details WHERE CONCAT(F_name, ' ', L_name, ' ', email, ' ', phone_no, ' ', pin, ' ', city, ' ', state, ' ', country, ' ', gender) LIKE ?";
    $stmtTotal = mysqli_prepare($conn, $totalRecordsQuery);
    mysqli_stmt_bind_param($stmtTotal, "s", $searchParam);
    mysqli_stmt_execute($stmtTotal);
    $totalRecordsResult = mysqli_stmt_get_result($stmtTotal);
    $totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers list</title>
    <link rel="stylesheet" href="list.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/f540fd6d80.js" crossorigin="anonymous"></script>
    <script src="../../../../javaScripts/tableascdesc.js"></script>
</head>

<body>
    <div class="heading1">
        <h1>Teachers list</h1>
    </div>
    <a href="../admin.php">
        <div class="regallclosebtn"><i class="fa-solid fa-caret-left"></i></div>
    </a>
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by anything" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="whole-body">
        <div class="inner-whole-body">
            <table border="1">
                <tr>
                    <th onclick="sortTable(0)" data-column="0">ID<span class="sort-icon"></span></th>
                    <th onclick="sortTable(1)" data-column="1">First Name<span class="sort-icon"></span></th>
                    <th onclick="sortTable(2)" data-column="2">Last Name<span class="sort-icon"></span></th>
                    <th onclick="sortTable(3)" data-column="3">Email<span class="sort-icon"></span></th>
                    <th onclick="sortTable(4)" data-column="4">Mobile<span class="sort-icon"></span></th>
                    <th onclick="sortTable(5)" data-column="5">ZIP Code<span class="sort-icon"></span></th>
                    <th onclick="sortTable(6)" data-column="6">City<span class="sort-icon"></span></th>
                    <th onclick="sortTable(7)" data-column="7">State<span class="sort-icon"></span></th>
                    <th onclick="sortTable(8)" data-column="8">Country<span class="sort-icon"></span></th>
                    <th onclick="sortTable(9)" data-column="9">Gender<span class="sort-icon"></span></th>
                    <th>Operations</th>
                </tr>

                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['tech_id'] . "</td>";
                        echo "<td>" . $row['F_name'] . "</td>";
                        echo "<td>" . $row['L_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone_no'] . "</td>";
                        echo "<td>" . $row['pin'] . "</td>";
                        echo "<td>" . $row['city'] . "</td>";
                        echo "<td>" . $row['state'] . "</td>";
                        echo "<td>" . $row['country'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td><a href='../list/updateTeacher.php?id=" . htmlspecialchars($row['tech_id'], ENT_QUOTES, 'UTF-8') . "'><button class='edit-btn'>Edit</button></a>";
                        echo "<button class='delete-btn' data-tech-id='" . $row['tech_id'] . "'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No records found.</td></tr>"; // Display message if no data found
                }
                ?>
            </table>
            <div class="pagination-container">
                <?php
                // Display pagination links
                $totalPages = ceil($totalRecords / $recordsPerPage);
                echo "<div class='pagination'>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = $i == $page ? 'active' : '';
                    echo "<a class='$activeClass' href='?page=$i&search=$search'>$i</a>";
                }
                echo "</div>";
                ?>
                <div class="record-info">
                    <?php
                    // Display number of records in the current page out of all records
                    $startRecord = ($page - 1) * $recordsPerPage + 1;
                    $endRecord = min($page * $recordsPerPage, $totalRecords);
                    echo "Showing $startRecord - $endRecord of $totalRecords records.";
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>