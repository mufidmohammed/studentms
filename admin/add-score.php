<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

try {
    $std_sql = "SELECT ID, StuID FROM tblstudent";
    $std_stmt = $dbh->prepare($std_sql);
    $std_stmt->execute();
    $students = $std_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $students = [];
}

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $student_id = $_POST['student_id'];
        $class_score = $_POST['class_score'];
        $exam_score = $_POST['exam_score'];
        $subject = $_POST['subject'];
        $sql = "INSERT INTO tblscore(class_score, exam_score, _subject, student_id) VALUES(:class_score, :exam_score, :_subject, :student_id)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':class_score', $class_score, PDO::PARAM_STR);
        $query->bindParam(':exam_score', $exam_score, PDO::PARAM_STR);
        $query->bindParam(':_subject', $subject, PDO::PARAM_STR);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId > 0) {
            echo '<script>alert("Score has been added.")</script>';
            echo "<script>window.location.href ='add-score.php'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
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
                            <h3 class="page-title"> Add Class </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"> Add Class</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">

                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center;">Add Class</h4>

                                        <form class="forms-sample" method="post">

                                            <div class="form-group">
                                                <label for="exampleInputName1">Student ID</label>
                                                <select name="student_id" class="form-control" required="true">
                                                    <option value=""></option>
                                                    <?php foreach ($students as $student) : ?>
                                                        <option value="<?= $student['ID'] ?>"><?= $student['StuID'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Subject</label>
                                                <!-- <input type="text" name="subject" value="" class="form-control" required='true'> -->
                                                <select name="subject" class="form-control" required='true'>
                                                    <option value="">Please choose a subject</option>
                                                    <option value="english language">English Language</option>
                                                    <option value="integrated science">Integrated Science</option>
                                                    <option value="mathematics">Mathematics</option>
                                                    <option value="social studies">Social Studies</option>
                                                    <option value="RME">Religious and Moral Education</option>
                                                    <option value="BDT">Basic Design and Technology</option>
                                                    <option value="ghanaian language">Ghanaian Language</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Class Score</label>
                                                <input type="number" name="class_score" value="" class="form-control" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Exam Score</label>
                                                <input type="number" name="exam_score" value="" class="form-control" required='true'>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
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

    </html><?php }  ?>