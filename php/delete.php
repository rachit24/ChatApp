<?php 
  session_start();
  include_once "config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
  else{
      $sql = mysqli_query($conn, "DELETE FROM users WHERE unique_id = {$_SESSION['unique_id']}");
      $msg_sql = mysqli_query($conn, "DELETE FROM messages WHERE incoming_msg_id = {$_SESSION['unique_id']} OR outgoing_msg_id = {$_SESSION['unique_id']}");
      echo '<script>
              alert("Account Deleted Successfully");
          </script>';
    if($sql && $msg_sql){
        session_unset();
        session_destroy();
        header("location: ../index.php");
    }else{
		echo 'Some Problem Occured!';
	}
  }
?>