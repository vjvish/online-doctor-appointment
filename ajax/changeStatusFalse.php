<?php
<<<<<<< HEAD

    //include '../connection.php';
=======
ini_set('display_errors','1');
    include '../connection.php';
>>>>>>> 62c2c783c9683aa8bf3ebeaf4522a9c8329c5767
    
    $appointment_id = $_POST['appmt_id'];
    $query = "update appointment_data set status = 'false' where appointment_id = '$appointment_id'";
    
    $res = mysqli_query($con,$query);

?>
