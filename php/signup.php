<?php
    session_start();
    include_once "config.php";
    //getting data from signup.js (AJAX)
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){      //whether email is valid or not
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                echo "$email - This email already exist!";
            }else{
                if(isset($_FILES['image'])){
                    $img_name = $_FILES['image']['name']; //user uploaded img name
                    $img_type = $_FILES['image']['type']; //user uploaded img type
                    $tmp_name = $_FILES['image']['tmp_name']; //temp name to save img in our folder
                    
                    $img_explode = explode('.',$img_name); //exploding the name to get extension
                    $img_ext = end($img_explode); //storing extenstion in a variable
    
                    $extensions = ["jpeg", "png", "jpg"]; //valid extensions
                    if(in_array($img_ext, $extensions) === true){   //whether image extension matches or not
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time();     //getting current time
                            $new_img_name = $time.$img_name;    //Renaming the image file with current time
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){ //moving the image in folder
                                $ran_id = rand(time(), 100000000);  //generating id for user
                                $status = "Active now"; 
                                $encrypt_pass = md5($password);     //hashing password
                                //storing data in database
                                date_default_timezone_set('Asia/Kolkata');
                                $joining_date = date("F j, Y, g:i a"); 
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status, joined)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}', '{$joining_date}')");
                                //After inserting all the data
                                if($insert_query){
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    }else{
                                        echo "This email address not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>