<?php
session_start();
ob_start();


include "database.php";


class MainClass  extends Database{
   
    public $fetch;

    /* Get database access */
    public function __construct() {
        parent::__construct();
    }

    
    public function get_users() {
        $stmt = $this->conn->prepare("SELECT * FROM users");
        if($stmt->execute()) {
            while($rows = $stmt->fetch()) {
                $this->get_users[] = $rows;
            }
            return $this->get_users;
        }
        else {
            return false;
        }
    }//  End of public function get_users() {

    public function get_user_posts($id) {
        
        $user_id = $id;
        $stmt = $this->conn->prepare("SELECT * FROM posts JOIN users on posts.created_by = users.id WHERE posts.created_by = $user_id ORDER BY posts.created_at DESC");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($rows = $stmt->fetch()) {
                $this->loged_in_user_posts[] = $rows;
            }
            return $this->loged_in_user_posts;
        }
        else {
            return false;
        }
    }//  End of public function posts() {

    public function get_posts($id) {

        $user_id = $id;
        $stmt = $this->conn->prepare("SELECT * FROM posts JOIN users on posts.created_by = users.id WHERE users.id IN(SELECT follow_user_id from following where user_id = '$id') OR (users.id = '$id') ORDER by posts.created_at DESC"); 
        
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            while($rows = $stmt->fetch()) {
                $this->loged_in_user_followings_posts[] = $rows;
            }
            return $this->loged_in_user_followings_posts;
        }else {
            return false;
        }

    }//END OF public function get_posts($id) {

    public function get_user($id){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE ID =$id");
        if($stmt->execute()) {

            $this->user = $stmt->fetch();
            return $this->user;                  
            
        }
        else {
            return false;
        }
    }//END OF public function get_user($id){

    public function get_user_following_count($id){
        $stmt = $this->conn->prepare("SELECT * FROM following WHERE user_id =$id");
        if($stmt->execute()){
            // return $this->fetch = $stmt->fetchColumn();
            $this->user_following_count = $stmt->rowCount();  
            return $this->user_following_count;                  
            
        }
        else {
            return false;
        }
    }//  End of public function get_user_following_count($id){

    public function get_user_followers_count($id){
        $stmt = $this->conn->prepare("SELECT * FROM following WHERE follow_user_id =$id");
        if($stmt->execute()){
            // return $this->fetch = $stmt->fetchColumn();
            $this->user_followers_count = $stmt->rowCount();  
            return $this->user_followers_count;                  
            
        }
        else {
            return false;
        }
    }// END OF public function get_user_followers_count($id){

    public function update_profile($array){

        $email = $array['email'];
        $user_id = $array['user_id'];

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email ='$email' AND id !='$user_id'");
        $stmt->execute();
        if($stmt->rowCount() > 0){

            $_SESSION["errormsg"] = "Email already exist for another user. Please enter another email";
            header('Location: profile.php');
            ob_end_flush();
         
            
        }else{

        if($_FILES['profile_picture']["name"] != "") {
          
            $time = date("d-m-Y")."-".time() ;
            $img = basename($_FILES["profile_picture"]["name"]); 
            $target_dir = "images/";
            $target_file = $target_dir . $time."-".$img;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        
            $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["profile_picture"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["profile_picture"]["name"])). " has been uploaded.";

                
                $sql = "UPDATE users SET profile_picture = '$target_file' WHERE id = '$user_id'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();

                header('Location: profile.php');
                ob_end_flush();
                die();

            }
        }

        

        }
        
        $sql = "UPDATE users SET";
        if(!empty($array['first_name'])){
            $first_name = $array['first_name'];
            $sql .= " first_name = '$first_name' ,";
        }

        if(!empty($array['last_name'])){
            $last_name = $array['last_name'];
            $sql .= " last_name = '$last_name' ,";
        }

        if(!empty($array['email'])){
            $email = $array['email'];
            $sql .= " email = '$email' ,";
        }

        if(!empty($array['password'])){
            $password = md5($array['password']);
            $sql .= " password = '$password' ,";
        }

        if(!empty($array['cell_no'])){
            $cell_no = $array['cell_no'];
            $sql .= " cell_no = '$cell_no' ,";
        }

        if(!empty($array['about'])){
            $about = $array['about'];
            $sql .= " about = '$about' ";
        }
        
        $sql .= "WHERE id = '$user_id'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $_SESSION["successmsg"] = "Profile Updated successfully";
        header('Location: profile.php');
        ob_end_flush();
        die();

    }  
    }//  End of public function update_profile($array){

    public function create_user($array){
        
        $email = $array['email'];
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email ='$email'");
        $stmt->execute();
        if($stmt->rowCount() > 0){

            $_SESSION["errormsg"] = "Email already exist. Please enter another email";
            header('Location: register.php');
            ob_end_flush();
         
           
        }else{

    
    try {

        // prepare sql and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO users(first_name, last_name, email, password, cell_no)  values(:first_name, :last_name, :email, :passworda, :cell_no)");
        $stmt->bindParam(':first_name', $firstname);
        $stmt->bindParam(':last_name', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passworda', $password);
        $stmt->bindParam(':cell_no', $cell_no);

        $firstname = $array['first_name'];
        $lastname = $array['last_name'];
        $email = $array['email'];
        $password = md5($array['password']);
        $cell_no = $array['cell_no'];
        $stmt->execute();
        $id = $this->conn->lastInsertId();
        $_SESSION["user_id"] = $id;
        
        $_SESSION["first_name"] = $array['first_name'];
        $_SESSION["last_name"] = $array['last_name'];
    
        header('Location: index.php');
        ob_end_flush();
        die();

    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    }
    }//end of public function create_user($array){


    public function login($array){
        
        $email = $array['email'];
        $password = md5($array['password']);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email =:email AND password =:passworda");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passworda', $password);
        $stmt->execute();

        if($stmt->rowCount() > 0) {

            $this->user = $stmt->fetch();
            $user_id = $this->user['id'];  
            $_SESSION["user_id"] = $user_id;   
            $_SESSION["first_name"] = $this->user['first_name']; ;   
            $_SESSION["last_name"] = $this->user['last_name']; ;   

            header('Location: index.php');
            ob_end_flush();
            die();

        }else {
            
            return 'false';
        
        }

    }//End of public function login($array){

    public function create_post($array){

        $time = date("d-m-Y")."-".time() ;
        $img = basename($_FILES["post_picture"]["name"]); 
        $target_dir = "images/";
        $target_file = $target_dir . $time."-".$img;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    
        $check = getimagesize($_FILES["post_picture"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["post_picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["post_picture"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["post_picture"]["name"])). " has been uploaded.";

        }

        try{

            $stmt = $this->conn->prepare("INSERT INTO posts(descriptions, created_by, post_picture)  values(:descriptiona, :created_by, :post_picture)");
            $stmt->bindParam(':descriptiona', $description);
            $stmt->bindParam(':created_by', $created_by);
            $stmt->bindParam(':post_picture', $post_picture);

            $description = $array['description'];
            $created_by = $_SESSION['user_id'];
            $post_picture = $target_file;
            
            $stmt->debugDumpParams();
            $stmt->execute();

            $_SESSION["successmsg"] = "Post created successfully";
            header('Location: index.php');
            ob_end_flush();
            die();

        }catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
      
    
        header('Location: index.php');
        ob_end_flush();
        die();

    }

    }//END OF public function create_post($array){

    public function get_user_followings($id){

        $user_id = $id;
        $stmt = $this->conn->prepare("SELECT users.first_name, users.id, users.profile_picture FROM following JOIN users ON following.follow_user_id = users.id WHERE following.user_id = $user_id GROUP BY users.id");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            
            while($rows = $stmt->fetch()) {
                $this->loged_in_user_followings[] = $rows;
            }
            return $this->loged_in_user_followings;
        }else {
            return $this->loged_in_user_followings = array();
        }
    }// END OF public function get_user_followings($id){

    public function un_follow_uer($array){

        $id = $array['un_follow_user_id'];
        $user_id = $_SESSION['user_id'];
        
        $stmt = $this->conn->prepare("DELETE from following where user_id = $user_id AND follow_user_id = $id");
        $stmt->execute();
        
        header('Location: index.php');
        ob_end_flush();
        die();

    }//public function un_follow_uer($array){

    public function follow_uer($array){


        $id = $array['follow_user_id'];
        $user_id = $_SESSION['user_id'];
        $stmt = $this->conn->prepare("SELECT * FROM following WHERE user_id =$user_id AND follow_user_id = $id");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            
            header('Location: index.php');
            ob_end_flush();
            die();              
            
        }
        $stmt = $this->conn->prepare("INSERT INTO following(user_id, follow_user_id) values(:user_id, :follow_user_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':follow_user_id', $id);
        $stmt->execute();
        
        header('Location: index.php');
        ob_end_flush();
        die();


    }// end of public function follow_uer($array){

    public function get_suggested_users($id){

        $user_id = $id;
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id NOT IN (SELECT follow_user_id FROM following WHERE user_id = $user_id) AND users.id != $user_id");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            
            while($rows = $stmt->fetch()) {
                $this->suggested_users[] = $rows;
            }
            return $this->suggested_users;
        }else {
            return $this->suggested_users = array();
        }
    }// end of public function get_suggested_users($id){    

}


