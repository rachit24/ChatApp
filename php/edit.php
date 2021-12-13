<?php
    session_start();
    include_once "config.php";
    //getting data from edit.js (AJAX)
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $img_name = $_FILES['image']['name'];               //user uploaded img name

    if(!empty($fname) || !empty($lname) || !empty($email) || !empty($password) || !empty($img_name)){
        if(!empty($fname)){
            $sql = mysqli_query($conn, "UPDATE users SET fname = '{$fname}' WHERE unique_id = {$_SESSION['unique_id']} ");
        }
        if(!empty($lname)){
            $sql = mysqli_query($conn, "UPDATE users SET lname = '{$lname}' WHERE unique_id = {$_SESSION['unique_id']} ");
        }
        if(!empty($password)){
            $encrypt_pass = md5($password);
            $sql = mysqli_query($conn, "UPDATE users SET $password = '{$encrypt_pass}' WHERE unique_id = {$_SESSION['unique_id']} ");
        }
        if(!empty($email)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){      //whether email is valid or not
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                if(mysqli_num_rows($sql) > 0){
                    echo "$email - This email already exist";
                }else{
                    $sql = mysqli_query($conn, "UPDATE users SET email = '{$email}' WHERE unique_id = {$_SESSION['unique_id']} ");
                }
            }
            else{
                echo "Not a Valid Email ID";
            }
        }

        if(empty($img_name)) {
            $query = "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}";
            $select_image = mysqli_query($conn,$query);
            while($row = mysqli_fetch_array($select_image)) {
                $img_name = $row['img'];
            }
        }

        // if(!empty($img_name)){
        else
        {
            $img_type = $_FILES['image']['type'];               //user uploaded img type
            $tmp_name = $_FILES['image']['tmp_name'];               //temp name to save img in our folder
            
            $img_explode = explode('.',$img_name);                  //exploding the name to get extension
            $img_ext = end($img_explode);                           //storing extenstion in a variable
    
            $extensions = ["jpeg", "png", "jpg"];                       //valid extensions
            if(in_array($img_ext, $extensions) === true){               //whether image extension matches or not
                $types = ["image/jpeg", "image/jpg", "image/png"];
                if(in_array($img_type, $types) === true){
                    $time = time();                                         //getting current time
                    $new_img_name = $time.$img_name;                        //Renaming the image file with current time
                    move_uploaded_file($tmp_name,"images/".$new_img_name); //moving the image in folder 
                    $sql = mysqli_query($conn, "UPDATE users SET img = '{$new_img_name}' WHERE unique_id = {$_SESSION['unique_id']} ");
                }
                else{
                    echo "Please upload an image file - jpeg, png, jpg";
                }  
            }
            else{
                echo "Please upload an image file - jpeg, png, jpg";                
            }
        }
        echo "!";
    }
    else{
        echo "No Details Updated!";
    }
         
?>