<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
}

$scoreid = $_GET['scoreid'];

try {
    $sql = "SELECT * FROM tblscore WHERE ID=:id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $scoreid);
    $stmt->execute();
    $score = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $score = [];
}

if (isset($_POST['submit'])) {
    $class_score = $_POST['class_score'];
    $exam_score = $_POST['exam_score'];
    $subject = $_POST['subject'];
    $sql = "UPDATE tblscore SET class_score=:class_score, exam_score=:exam_score, _subject=:_subject WHERE ID=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $scoreid, PDO::PARAM_STR);
    $query->bindParam(':class_score', $class_score, PDO::PARAM_STR);
    $query->bindParam(':exam_score', $exam_score, PDO::PARAM_STR);
    $query->bindParam(':_subject', $subject, PDO::PARAM_STR);
    $query->execute();
    
    echo '<script>alert("Score has been updated successfully.")</script>';
    echo "<script>window.location.href ='show-scores.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Student Management System|| Add Class</title>
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
                        <h3 class="page-title"> Edit Score </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Edit Score</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Edit Score</h4>

                                    <form class="forms-sample" method="post">

                                        <div class="form-group">
                                            <label for="exampleInputName1">Subject</label>
                                            <input type="text" name="subject" value="<?= $score['_subject'] ?>" class="form-control" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Class Score</label>
                                            <input type="number" name="class_score" value="<?= $score['class_score'] ?>" class="form-control" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Exam Score</label>
                                            <input type="number" name="exam_score" value="<?= $score['exam_score'] ?>" class="form-control" required='true'>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                                    </form>

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
</body>

</html>