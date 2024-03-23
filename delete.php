<?php 
@include 'config.php' ; 
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM products WHERE  id = $id");
    header('location:index.php');
}
?>