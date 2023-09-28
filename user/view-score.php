<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsuid'] == 0)) {
    header('location:logout.php');
}

// if ($_POST['student_id']) {
//     $_SESSION['student_id'] = $_POST['student_id'];
// } elseif (!$_SESSION['student_id']) {
//     header("Location: dashboard.php");
// }

$id = $_SESSION['sturecmsuid'];

$sql = "SELECT `ID` FROM `tblstudent` WHERE `ID` = :id ";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$student_id = $result['ID'];

$sql1 = "SELECT * FROM `tblscore` WHERE `student_id` = :student_id";
$stmt1 = $dbh->prepare($sql1);
$stmt1->bindParam(':student_id', $student_id, PDO::PARAM_STR);
$stmt1->execute();

$scores = $stmt1->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Student Management System|| View Scores</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include_once('includes/header.php'); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include_once('includes/sidebar.php'); ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> View Scores </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Student</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Scores</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <h4 class="card-title mb-sm-0">Scores</h4>
                                        <!-- <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> View all Scores</a> -->
                                    </div>
                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="font-weight-bold">Subject</th>
                                                    <th class="font-weight-bold">Class Score (%)</th>
                                                    <th class="font-weight-bold">Exam Score (%)</th>
                                                    <th class="font-weight-bold">Total Score</th>
                                                    <th class="font-weight-bold">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php foreach ($scores as $score) : ?>
                                                    <tr>
                                                        <td><?= htmlentities($score['_subject']) ?></td>
                                                        <td><?= htmlentities($score['class_score']) ?></td>
                                                        <td><?= htmlentities($score['exam_score']) ?></td>
                                                        <td><?= htmlentities($score['class_score'] + $score['exam_score']) ?></td>
                                                        <td>
                                                            <div><a href="edit-score.php?scoreid=<?php echo htmlentities($score['ID']); ?>"><i class="icon-eye"></i></a>
                                                                || <a href="show-scores.php?delid=<?php echo ($score['ID']); ?>" onclick="return confirm('Do you really want to Delete ?');"> <i class="icon-trash"></i></a></div>
                                                        </td>
                                                    <tr>
                                                    <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <?php include_once('includes/footer.php'); ?>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->

</html>