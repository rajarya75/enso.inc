<?php

session_start();



require_once 'api/config.php';



$error = "";



if (isset($_SESSION['nj_admin'])) {

    header('Location: ' . $admin_url);
    // header('Location: http://localhost/ryaninternationalacademy/ria-bawdhan/bavdhan_pune/admin/' );

    die('login');

}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {



    $email      = strtolower(htmlspecialchars($_POST['email']));

    $password   = $_POST['password'];



    if (array_key_exists($email, $admin_list)) {



        if ($admin_list[$email]['password'] == $password) {

            

            $_SESSION['nj_admin'] = $email;

            

            header('Location: ' . $admin_url);

            die('login in');

        } else {

            $error = "Invalid Email Id Or Password";

        }

    } else {

        $error = "Invalid Email Id Or Password";

    }

}

?>



<!DOCTYPE html>

<html lang="en">



<head>



    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">

    <meta name="author" content="">



    <title>Login</title>



    <!-- Custom fonts for this template-->

    <link href="assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">



    <!-- Custom styles for this template-->

    <link href="assets/admin/css/sb-admin-2.min.css" rel="stylesheet">

    <script src='https://www.google.com/recaptcha/api.js' async defer></script>



</head>



<body class="bg-gradient-primary">



    <div class="container">



        <!-- Outer Row -->

        <div class="row justify-content-center">



            <div class="col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">

                    <div class="card-body p-0">

                        <!-- Nested Row within Card Body -->

                        <div class="row">



                            <div class="col-md-12 ">

                                <div class="p-5">

                                    <div class="text-center">

                                        <h1 class="h4 text-gray-900 mb-4"><b>LOGIN</b></h1>

                                    </div>

                                    <form class="user" method="POST" action="">

                                        <div class="form-group">

                                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Username" required="" name="email">

                                        </div>

                                        <div class="form-group">

                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required="" name="password">

                                        </div>



                                        <input value="Login" type="submit" name="submit" class="btn btn-primary btn-user btn-block">



                                        <?php



                                        if ($error) {

                                            echo '<p>' . $error . '</p>';

                                        }

                                        ?>



                                    </form>

                                    <hr>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ./row -->

        </div>

    </div>



    <!-- Bootstrap core JavaScript-->

    <script src="assets/admin/vendor/jquery/jquery.min.js"></script>



</body>



</html>