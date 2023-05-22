<?php

session_start();

if (isset($_SESSION['user_id'])) {
  //echo "loggato come: " . $_SESSION['user_id'];
  header("Location: index.php");
  exit;
}


//////////////////////////
//DEBUGGING|ERROR OUTPUT//
//////////////////////////

$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

ini_set("display_errors", TRUE);



//////////////////////////////
//INCLUDE DB CONNECTION FILE//
//////////////////////////////


if (isset($_POST['submit'])) {

  try {
    include_once 'dbconnect.inc.php';
  } catch (Exception $e) {
    echo "Sorry, connection unsuccessful: [ " . $e->getMessage() . " ]";
  }

  $email = $mysqli->real_escape_string($_POST['email']);
  $password = $mysqli->real_escape_string($_POST['password']);

  if ($email == "clinica2023" && $password == "clinica2023") {
    $_SESSION['user_id'] = "clinica2023";
    $_SESSION['first_name'] = "Mario";
    $_SESSION['last_name'] = "Rossi";
    $_SESSION['dob'] = "12-07-1989";
    $_SESSION['email'] = "mario@rossi.com";
    $_SESSION['telephone'] = "3381449834";
    header("Location: index.php");
    exit;
  }

  try {
    //STAGE 1: Prepare statement
    $stmt = $mysqli->prepare("SELECT * FROM pw_iseppe_medics WHERE email = ?");
    //STAGE 2: bind and execute
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result->num_rows > 0) {
      echo "mail non trovata";
      header("Location: login.php");
      exit;
    }

    //Close statement execution to free server resources
    $stmt->close();
  } catch (mysqli_sql_exception $e) {
    $errmsg = $e->getMessage();
    $query_string = http_build_query(array('errmsg' => $errmsg));
    header("Location: 400.php?" . $query_string);
    exit;
  }


  while ($row = $result->fetch_assoc()) {

    if (password_verify($password, $row['password'])) {

      //echo "credenziali giuste";
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['first_name'] = $row['first_name'];
      $_SESSION['last_name'] = $row['last_name'];
      $_SESSION['dob'] = $row['dob'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['telephone'] = $row['telephone'];

      header("Location: index.php");
      exit;
    } else {
      header("Location: login.php");
      exit;
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/fire.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/fire.png" alt="">
                  <span class="d-none d-lg-block">Iseppos</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" action="login.php" method="post" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="email" class="form-control" id="yourEmail" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="submit" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="registration.php">Create an account</a></p>
                      <br>
                      <p><span style="color: red;"> Credenziali demo: clinica2023 - clinica2023</span></p>
                      <p><a href="ISEPPE_DA_FINIRE_relazione_project_work.pdf">Clicca per visualizzare la Relazione Finale</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>