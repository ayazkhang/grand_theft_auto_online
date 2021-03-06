<?php

require_once '../main_class.php';

if(isset($_SESSION['user_id'])){

    header('Location: index.php');
    die();
    
}

$obj = new MainClass();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, AdminWrap lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, AdminWrap lite design, AdminWrap lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="AdminWrap Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>AdminWrap Lite Template by WrapPixel</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/adminwrap-lite/" />
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <link href="../assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/login_style.css" rel="stylesheet">
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
</head>

<body class="fix-header card-no-border fix-sidebar">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Admin Wrap</p>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="page-wrapper" style="margin-left: 0px;">
            <div class="container-fluid">
                
                <div class="d-flex justify-content-center align-items-center mt-5">
                    <div class="card">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item text-center"> <a class="nav-link active btl" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Login</a> </li>
                        </ul>
                        <form action="#" method="POST" id="login_frm">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="form px-4 pt-5"> 
                                        
                                        <input type="text" name="email" id="email" class="form-control"  placeholder="Email">
                                        <div id="email_error" class="invalid-feedback" style="margin-bottom:12px;"></div>

                                        <input type="password"  name="password" id="password" class="form-control" placeholder="Password">
                                        <div id="password_error" class="invalid-feedback" style="margin-bottom:12px;"></div>
                                       
                                        <input type="submit" name="submit" class="btn btn-dark btn-block" value="Login">
                                        
                                        <p>don't have account?</p>
                                        <a href="register.php">Click here for create account</a>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <footer class="footer text-center"> ?? 2021 Adminwrap by <a href="https://www.wrappixel.com/">wrappixel.com</a> </footer>
         
        </div>
    </div>
    <script src="../assets/node_modules/jquery/jquery.min.js"></script>
    <script src="../assets/node_modules/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <script src="js/waves.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/custom.min.js"></script>

    
    <script>
        $('#login_frm').on('submit', function() {

            var email = $("#email").val();
            
            if(email == "" || email == ""){

                $("#email_error").css("display","block");
                $("#email_error").text("Please enter your email");
                return false;
            
            }else{

                $("#email_error").css("display","none");

                var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

                if(!pattern.test(email)){

                    $("#email_error").css("display","block");
                    $("#email_error").text("Please enter a valid email");
                    return false;
                
                }else{
                    $("#email_error").css("display","none");
                }
            }

            var password = $("#password").val();
            
            if(password == "" || password == ""){

                $("#password_error").css("display","block");
                $("#password_error").text("Please enter password");
                return false;
            
            }else{

                $("#password_error").css("display","none");
                if(password.length < 6){

                    $("#password_error").css("display","block");
                    $("#password_error").text("Please write atleast 6 characters ");
                    return false;

                }else{

                    $("#password_error").css("display","none");
                }
            }

            

        });
    </script>

</body>

</html>

<?php

if(isset($_POST['submit'])){

    $request = $_REQUEST;

    $user_profile = $obj->login($request);
    print_r($user_profile);

  if(isset($_SESSION['user_id'])){

    header("Location: index.php");

  }

}

?>