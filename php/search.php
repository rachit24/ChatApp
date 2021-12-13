<?php
    session_start();
    include_once "config.php";

    //Getting user ID through session
    $outgoing_id = $_SESSION['unique_id'];
    //Getting searchTerm from AJAX request (users.js)
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    //Finding users from SQL
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
?>