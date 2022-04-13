<?php
require_once '../main_class.php';

if(!isset($_SESSION['user_id'])){

    header('Location: login.php');
    die();
    
}

$userid = $_SESSION['user_id'];
$obj = new MainClass();
$array = $obj->get_user($userid);

?>
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html"><b>
                            <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <span>
                            <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                            <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">     
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#"
                                id="navbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                src="<?php echo $array['profile_picture']; ?>" alt="user" class="" /> <span
                                    class="hidden-md-down"><?php echo $_SESSION["first_name"];  ?> &nbsp;</span> </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown"></ul>
                        </li>
                    </ul>
                </div>