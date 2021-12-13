<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "php/config.php";
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);    //fetching details of user from database
        }
    }
    else{  
        header("location: ../login.php");
    }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Edit Profile</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder= "<?php echo $row['fname'] ?>">
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="<?php echo $row['lname'] ?>">
          </div>
        </div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="<?php echo $row['email'] ?>">
        </div>
        <div class="field input">
          <label>Change Password</label>
          <input type="password" name="password" placeholder="Enter password">
          <i class="fas fa-eye"></i>
        </div>
        <div class="field image">
          <label>Current Image</label>
          <img src="php/images/<?php echo $row['img']; ?>" alt=""> 
          <label>Change Image</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Submit Changes">
        </div>
        <center><a href="users.php">Go Back</a></center>
      </form>
    </section>
  </div>
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/edit.js"></script>
</body>
</html>
