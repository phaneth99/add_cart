<?php
include'connection.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id= '';
    header('Location:login.php');
}

$select_profile =  $conn->prepare("SELECT * FROM users WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- font-awsome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link css -->
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <div class="content">

        <div class="box">
            <h3>Welcome : <span>
                    <?= $fetch_profile['name'];?>
                </span></h3>
            <div class="btn-flex">

                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="register.php" class="btn btn-primary">Register</a>
            </div>
            <a href="../index.php" class="btn btn-primary">Add product cart</a>
            <a href=" logout.php" class="btn btn-delete"
                onclick="return confirm('Logout from the website?');">Logout</a>
        </div>
    </div>
</body>

</html>