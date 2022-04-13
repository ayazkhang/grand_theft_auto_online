<?php

require_once '../main_class.php';
if(!isset($_SESSION['user_id'])){

    header('Location: login.php');
    die();
    
}

$userid = $_SESSION['user_id'];
$obj = new MainClass();
$array = $obj->get_user($userid);
$following_count = $obj->get_user_following_count($userid);
$get_user_followers_count = $obj->get_user_followers_count($userid);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    
        require_once'head.php';  
   ?>
</head>

<body class="fix-header card-no-border fix-sidebar">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Admin Wrap</p>
        </div>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <?php
                    require_once 'nav.php';
                ?>
            </nav>
        </header>
        <aside class="left-sidebar">
            <?php require_once'sidebar.php'; ?>
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Profile</h3>
                   
                    </div>
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="mt-4"> <img src="<?php echo $array['profile_picture']; ?>" class="img-circle"
                                        width="150" />
                                    <h4 class="card-title mt-2">
                             <?php echo $array['first_name'] . " ". $array['last_name']; ?></h4>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-4"><a href="javascript:void(0)" class="link">
                                                <font class="font-medium">Followings <?php echo $following_count; ?></font>
                                            </a></div>
                                        <div class="col-4"><a href="javascript:void(0)" class="link">
                                                <font class="font-medium">Followers <?php echo $get_user_followers_count; ?></font>
                                            </a></div>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tab panes -->
                            <div class="card-body">
                                <?php
                                    if(isset($_SESSION['errormsg'])){
                                        
                                        echo '<div class="alert alert-danger" role="alert">';
                                            
                                            echo $_SESSION["errormsg"];
                                            unset($_SESSION['errormsg']);

                                        echo '</div>';
                                    
                                    }

                                    if(isset($_SESSION['successmsg'])){
                                        
                                        echo '<div class="alert alert-success" role="alert">';
                                            
                                            echo $_SESSION["successmsg"];
                                            unset($_SESSION['successmsg']);

                                        echo '</div>';
                                    
                                    }
                                    ?>
                                <form class="form-horizontal form-material mx-2" method="POST" action="#" id="profile_form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-md-12">First Name</label>
                                        <div class="col-md-12">
                                            <input type="text" id="first_name" name="first_name" value="<?php echo $array['first_name'];?>" placeholder="First Name"
                                                class="form-control form-control-line">
                                                <div id="first_name_error" class="invalid-feedback">
                                                   
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">Last Name</label>
                                        <div class="col-md-12">
                                            <input type="text" id="last_name" name="last_name" value="<?php echo $array['last_name'];?>" placeholder="Last Name"
                                                class="form-control form-control-line">
                                                <div id="last_name_error" class="invalid-feedback">
                                                   
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="text" id="email" name="email" value="" placeholder="Email"
                                                class="form-control form-control-line" 
                                                >
                                                <div id="email_error" class="invalid-feedback">
                                                   
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">New Password</label>
                                        <div class="col-md-12">
                                            <input type="password" id="password" name="password" value=""
                                                class="form-control form-control-line">
                                                <div id="password_error" class="invalid-feedback">
                                                   
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Phone No</label>
                                        <div class="col-md-12">
                                            <input type="text" id="cell_no" name="cell_no" value="<?php echo $array['cell_no'];?>" placeholder="Phone No"
                                                class="form-control form-control-line">
                                                
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">About</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" id="about" name="about" class="form-control form-control-line"><?php echo $array['about'];?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">Change Profile Picture</label>
                                        <div class="col-md-12">
                                            <input type="file" id="profile_picture" name="profile_picture" value="" 
                                                class="form-control form-control-line">
                                                
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?php echo $array['id'] ?>">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="submit" name="submit" class="btn btn-success" value="Update Profle">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer"> © 2021 Adminwrap by <a href="https://www.wrappixel.com/">wrappixel.com</a> </footer>
         
        </div>
    </div>
    <script src="../assets/node_modules/jquery/jquery.min.js"></script>
    <script src="../assets/node_modules/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <script src="js/waves.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/custom.min.js"></script>

    <script>
        $('#profile_form').on('submit', function() {
    
            var first_name = $("#first_name").val();
            
            if(first_name.length > 0 && first_name.length < 3){

                $("#first_name_error").css("display","block");
                $("#first_name_error").text("Please write atleast 3 characters ");
                return false;

            }else{

                $("#first_name_error").css("display","none");
            
            }

            var last_name = $("#last_name").val();
           
            if(last_name.length > 0 && last_name.length < 3){

                $("#last_name_error").css("display","block");
                $("#last_name_error").text("Please write atleast 3 characters ");
                return false;

            }else{
                $("#last_name_error").css("display","none");
            }
            

            var email = $("#email").val();
            
            if(email != ""){


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
        
            if(password.length > 0 && password.length <= 5){

                $("#password_error").css("display","block");
                $("#password_error").text("Please write atleast 6 characters ");
                return false;

            }else{

                $("#password_error").css("display","none");

            }
            
            
        

        });
    </script>
</body>

</html>

<?php

if(isset($_POST['submit'])){

    $request = $_REQUEST;
    $user_profile = $obj->update_profile($request);

}




?>