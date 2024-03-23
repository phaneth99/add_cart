<?php
    include'connection.php';

    if(isset($_POST['submit'])){
    
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_users = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $select_users->execute([$email]);

    if($select_users->rowCount() > 0){
        $message[] = 'email already taken!';
    }else{
        if($pass != $cpass){
            $message[] = 'confirm password not matched!';
        }else{
            $insert_user = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
            $insert_user->execute([$name, $email,$cpass]);
            
            if($insert_user){
                $fetch_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND  password = ?");
                $fetch_user->execute([$email, $cpass]);
                $row = $fetch_user->fetch(PDO::FETCH_ASSOC);
                if($fetch_user->rowCount() > 0){
                  setcookie('user_id',$row['id'], time() + 60*60*24, '/');
                 header('Location:home.php');
                 // 60 * 60 *24 = 86400 seconds =  1 day
                 // set  cookies for 1 month use 60 *60 *24 *30

                }

            }
            
        }
    }
    
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resister</title>
    <!-- font-awsome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link css -->
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>


    <?php
    if(isset($message)){
        foreach($message as $message){
            echo'
            <div class="message">
            <span>'.$message.'</span>
            <i class=" fa-solid fa-xmark" onclick="this.parentElement.remove();"></i>
        </div>
            ';
        }
    }
?>

    <!-- Register Section -->
    <section class="form-container">
        <form action="" method="POST">
            <h3>Register now </h3>
            <input type="text" required maxlength="20" placeholder="enter your username" class="box" name="name">
            <input type="email" required maxlength="50" placeholder=" enter your email" class="box" name="email">
            <input type="password" required maxlength="50" placeholder=" enter your password" class="box" name="pass">
            <input type="password" required maxlength="50" placeholder=" confirm your password" class="box"
                name="cpass">
            <input type="submit" value="register now" name="submit" class="btn btn-primary">
            <p>Aleady have an account? <a href="login.php">login now</a></p>
        </form>
    </section>

</body>

</html>