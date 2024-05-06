<?php
session_start();
if (!isset($_SESSION['mail'])) {
    header("Location: ../../../LoginandRegister/adminLogin.php");
    exit;
}
?>

<?php
require '../../../../dbconnect.php';

// Fetch student data for the current page
$query = "SELECT * FROM temp_internship";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>internship verify</title>
    <link rel="stylesheet" href="../list/list.css">
    <script src="https://kit.fontawesome.com/f540fd6d80.js" crossorigin="anonymous"></script>
</head>


<body>
    <div class="heading1">
        <h1>Verification of Internships</h1>
    </div>
    <a href="../admin.php">
        <div class="regallclosebtn"><i class="fa-solid fa-caret-left" title="back to dashboard"></i></div>
    </a>
    <div class="whole-body">
        <div class="inner-whole-body">
            <table border="1">
                <tr class="for-overflow">
                    <th>Company Name</th>
                    <th>Company Email</th>
                    <th>Internship topic</th>
                    <th>work location</th>
                    <th>duration</th>
                    <th>stipend</th>
                    <th>last date to apply</th>
                    <th>required skills</th>
                    <th>about the internship</th>
                    <th>certificate on completion</th>
                    <th>Number of openings</th>
                    <th>Operations</th>
                </tr>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<td>" . $row['com_id'] . "</td>";
                        echo "<td>" . $row['com_email'] . "</td>";
                        echo "<td>" . $row['Topic'] . "</td>";
                        echo "<td>" . $row['work_location'] . "" . $row['location_name'] . "</td>";
                        echo "<td>" . $row['duration'] . "</td>";
                        echo "<td>" . $row['stipend'] . "</td>";
                        echo "<td>" . $row['apply_by'] . "</td>";
                        echo "<td>" . $row['required_skills'] . "</td>";
                        echo "<td>" . $row['about_internship'] . "</td>";
                        echo "<td>" . $row['certificate'] . "</td>";
                        echo "<td>" . $row['openings'] . "</td>";
                        echo "<td><a class='accdec acc' href='../pvalidation/acceptStuValidation.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>Accept</a><a class='accdec dec' href='../pvalidation/declineStuValidation.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>Decline</a></td>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No data found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>