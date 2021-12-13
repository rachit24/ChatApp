<?php 
  // session_start();
  // include_once "php/config.php";
  // if(!isset($_SESSION['unique_id'])){
  //   header("location: login.php");
  // }
?>
<?php include_once "modal_header.php"; ?>
<body>
  <div class="wrapper">
    <a href="users.php" class="back">Go Back</a>
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);    //fetching details of user from database
            }
          ?>
          <img src="php/images/<?php echo $row['img']; ?>" alt="" >
          <div class="details">
            <p><b>First Name: </b><?php echo $row['fname'] ?></p>
            <p><b>Last Name: </b> <?php echo  $row['lname'] ?></p>
            <p><b>Email ID: </b> <?php echo $row['email']; ?></p>
            <p><b>User ID: </b> <?php echo $row['unique_id']; ?></p>
            <p><b>Member Since: </b> <?php echo $row['joined']; ?></p>
          </div>
        </div>
        <a href="edit-profile.php?profile_id=<?php echo $row['unique_id']; ?>" class="logout">Edit Profile</a>
      </header>
      <center><a href="#myModal" class="trigger-btn" data-toggle="modal">Delete Account</a></center>
      <!-- <center><a href="delete-account.php" class="back">Delete Account</a></center> -->
    </section>
  </div>
  
</body>
</html>