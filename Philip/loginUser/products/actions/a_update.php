<?php
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: ../../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}


require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';

if ($_POST) {
    $id = $_POST["id"];
    $room = $_POST["room"];
    $floor = $_POST["floor"];
    $description = $_POST["description"];
    $status = $_POST["status"];
    $price = $_POST['price'];
    $duration = $_POST["duration"];
    //variable for upload pictures errors is initialized
    $uploadError = '';

    $picture = file_upload($_FILES['picture'], "product");//file_upload() called  
    if($picture->error===0){
        ($_POST["picture"]=="product.png")?: unlink("../pictures/$_POST[picture]");           
        $sql = "UPDATE hotel SET room = '$room', price = $price, floor = $floor, description = '$description', status = '$status', duration = $duration, picture = '$picture->fileName' WHERE id = {$id}";
    }else{
        $sql = "UPDATE hotel SET room = '$room', price = $price, floor = $floor, description = '$description', status = '$status', duration = $duration WHERE id = {$id}";
    }
    #echo $sql; 
    #run query
    $db->query($sql);

    // check for status and delete entry accordingly
    if ($_POST["old_status"] == "booked" && $status == "available") $db->query("DELETE FROM booking WHERE `fk_hotel_id` = {$id}");

    if (1) {
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
    } 
    // else {
    //     $class = "danger";
    //     $message = "Error while updating record : <br>" . mysqli_connect_error();
    //     $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
    // }
    $db->close();   
} else {
    header("location: ../error.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Update</title>
        <?php require_once '../../components/boot.php'?> 
    </head>
    <body>
        <div class="container">
            <div class="mt-3 mb-3">
                <h1>Update request response</h1>
            </div>
            <div class="alert alert-<?php echo $class;?>" role="alert">
                <p><?php echo ($message) ?? ''; ?></p>
                <p><?php echo ($uploadError) ?? ''; ?></p>
                <a href='../update.php?id=<?=$id;?>'><button class="btn btn-warning" type='button'>Back</button></a>
                <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
            </div>
        </div>
    </body>
</html>