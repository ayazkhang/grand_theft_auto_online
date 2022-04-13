<?php

require_once '../main_class.php';
if(!isset($_SESSION['user_id'])){

    header('Location: login.php');
    die();
    
}

$userid = $_SESSION['user_id'];
$obj = new MainClass();
$get_posts= $obj->get_posts($userid);
$get_loged_in_user_followings= $obj->get_user_followings($userid);
$get_suggested_users= $obj->get_suggested_users($userid);


?>
<!DOCTYPE html>
<html lang="en">

<head>
 <?php
    
  require_once'head.php';  
 ?>
</head>

<body class="fix-header fix-sidebar card-no-border">
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
                        
                       
                    </div>
                </div>

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-8">
                        <div class="card text-center">
                            <div class="card-body">
                                <?php
                                    if(isset($_SESSION['successmsg'])){
                                        
                                        echo '<div class="alert alert-success" role="alert">';
                                            
                                            echo $_SESSION["successmsg"];
                                            unset($_SESSION['successmsg']);

                                        echo '</div>';
                                    
                                    }
                                
                                ?>
                                <a type="button" onclick="show_modal()"class="btn btn-primary">Create Post</a>
                            </div>
                        </div>
                        <?php
                        if(!empty($get_posts)){
                            foreach($get_posts as $post){

                        ?>
                            <div class="card w-100">
                                <div class="up-img" style="background-image:url(<?php echo  $post['post_picture']; ?>)"></div>
                                <div class="card-body">
                                    <h5 class=" card-title">Created By <?php echo  $post['first_name']. " | Dated ". $post['created_at']  ?></h5>
                                    <p class="mb-0 mt-3"><?php echo  $post['descriptions']; ?></p>
                                   
                                </div>
                            </div>

                        <?php
                            }
                        }
                        
                        ?>


                    </div>
                    <!-- Column -->
                    <div class="col-lg-4 set-height">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">Followings</h5>

                                <ul class="feeds">
                                        
                                <?php
                                foreach($get_loged_in_user_followings as $followings){
                                    
                                    echo '<li><div class="bg-light-info"><span class="round"><img src="'.$followings['profile_picture'].'" alt="user" width="50"></span></div><a  href="view_profile.php?id='. $followings['id'] .'"> '. $followings['first_name'] .'</a> <span class="text-muted"><a id="'.$followings['id'].'" type="button" name="'. $followings['first_name'] .'" onclick="show_unfollow_modal(this.id,this.name)" class="text-info">Un Follow</a></span></li>';
                                
                                }
                                ?>
                                    
                                </ul>
                            
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                
                            <h5 class="card-title">Suggested Users</h5>

                                <ul class="feeds">
                                        
                                <?php
                                foreach($get_suggested_users as $suggested_user){
                                    
                                    echo '<li><div class="bg-light-info"><span class="round"><img src="'.$suggested_user['profile_picture'].'" alt="user" width="50"></span></div><a  href="view_profile.php?id='. $suggested_user['id'] .'"> '. $suggested_user['first_name'] .'</a> <span class="text-muted"><a id="'.$suggested_user['id'].'" type="button" name="'. $suggested_user['first_name'] .'" onclick="show_follow_modal(this.id,this.name)" class="text-info">Follow</a></span></li>';
                                
                                }
                                ?>
                                    
                                </ul>
                            
                            </div>
                        </div>
                        
                    </div>
                </div>
           
            </div>
     
            <footer class="footer"> © 2021 Adminwrap by <a href="https://www.wrappixel.com/">wrappixel.com</a> </footer>
       
        </div>

    </div>

<!-- Modal -->
<div class="modal fade" id="post_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <form method="POST" action="#" id="post_form" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-body">
        
            <div class="form-group">
                <label for="exampleFormControlInput1">Please select Image</label>
                <input type="file" name="post_picture" id="post_picture" class="form-control" id="exampleFormControlInput1" placeholder="Select File">
                <div id="file_error" class="invalid-feedback" style="margin-bottom:12px;"></div>

            </div>
            
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Post Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                <div id="description_error" class="invalid-feedback" style="margin-bottom:12px;"></div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_modal()">Close</button>
            <input type="submit" name="submit" class="btn btn-primary" value="Publish">
        </div>
    </div>
    </form>

  </div>
</div>


<!-- Unfellow Modal -->
<div class="modal fade" id="un_follow_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="#" method="POST" id="un_follow_form">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Un follow User</h5>
        
        </div>
        <div class="modal-body">
            <h5>Are you sure want to unfollow Methew</h5>
            <input type="hidden" value="" name="un_follow_user_id" id="un_follow_user_id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="hide_un_follow_modal()">Close</button>
            <input type="submit" name="un_follow_form_submit" class="btn btn-primary" value="Un Follow">
        </div>
        </div>
    </form>  

  </div>
</div>

<!-- fellow Modal -->
<div class="modal fade" id="follow_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="#" method="POST" id="follow_form">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Follow User</h5>
        
        </div>
        <div class="modal-body">
            <h5>Are you sure want to follow</h5>
            <input type="hidden" value="" name="follow_user_id" id="follow_user_id">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="hide_follow_modal()">Close</button>
            <input type="submit" name="follow_form_submit" class="btn btn-primary" value="Follow">
        </div>
        </div>
    </form>  

  </div>
</div>


    <script src="../assets/node_modules/jquery/jquery.min.js"></script>
    <script src="../assets/node_modules/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <script src="js/waves.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="../assets/node_modules/raphael/raphael-min.js"></script>
    <script src="../assets/node_modules/morrisjs/morris.min.js"></script>
    <script src="../assets/node_modules/d3/d3.min.js"></script>
    <script src="../assets/node_modules/c3-master/c3.min.js"></script>
    <script src="js/dashboard1.js"></script>
    <script>

        function show_follow_modal(id,name){
            
            $("#follow_user_id").val(id);
            $('#follow_modal').modal('show');
        }

        function hide_follow_modal(){
            $('#follow_modal').modal('hide');
        }

        function show_unfollow_modal(id,name){
            
            $("#un_follow_user_id").val(id);
            $('#un_follow_modal').modal('show');
        }

        function hide_un_follow_modal(){
            $('#un_follow_modal').modal('hide');
        }

        function show_modal(){

            $('#post_modal').modal('show');
    
        }

        function close_modal(){
            $('#post_modal').modal('hide');  
        }

    
        $('#post_form').on('submit', function() {

            var ext = $('#post_picture').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){

                $("#file_error").css("display","block");
                $("#file_error").text("Please select image with extention gif, png, jpg, jpeg");
                return false;

            }else{
                $("#file_error").css("display","none");
            }


            var description = $("#description").val();
         
            
            if(description == ""){

                $("#description_error").css("display","block");
                $("#description_error").text("Please write post description");
                return false;
            
            }else{
                
                $("description_error").css("display","none");
                
                if(description.length > 250){
                    $("#description_error").css("display","block");
                    $("#description_error").text("Description length should be less than 250 characters");
                    return false;
                }

                if(/^[-,-.-'a-zA-Z0-9- ]*$/.test(description) == false) {
                    $("#description_error").css("display","block");
                    $("#description_error").text("Please enter a valid description");
                    return false;
                }else{
                    $("#description_error").css("display","none");
                }

            } 
            
            
            
        

        });
    </script>
</body>
</html>

<?php

if(isset($_POST['submit'])){
    
    $request = $_REQUEST;
    $user_profile = $obj->create_post($request);
    print_r($user_profile);

}

if(isset($_POST['un_follow_form_submit'])){
    
    $request = $_REQUEST;
    $un_follow_user = $obj->un_follow_uer($request);
    print_r($un_follow_user);

}

if(isset($_POST['follow_form_submit'])){
    
    $request = $_REQUEST;
    $follow_user = $obj->follow_uer($request);
    
    print_r($follow_user);


}
