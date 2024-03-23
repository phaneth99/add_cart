<?php
include'connection.php';
setcookie('user_id','', time() -1, '/');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- font-awsome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link css -->
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <div class="content">

        <div class="box">
            <h3>Logged out successfull!<span>
                    <?= $fetch_profile['name'];?>
                </span></h3>
            <div class="btn-flex">

                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="register.php" class="btn btn-primary">Register</a>
            </div>
        </div>
    </div>
</body>

</html>