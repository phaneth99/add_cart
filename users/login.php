<?php
    include'connection.php';

    if(isset($_POST['submit'])){
        
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_users = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $select_users->execute([$email, $pass]);
    $row = $select_users->fetch(PDO::FETCH_ASSOC);

    if($select_users->rowCount() > 0){
       setcookie('user_id',$row['id'], time() + 60*60*24, '/');
       header('Location:home.php');
    }
    else{
        $message[] = 'incorrect email or password!';
    }
 }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <!-- Login Section -->
    <section class="form-container">
        <form action="#" method="post">
            <h3>login </h3>
            <input type="email" required maxlength="50" placeholder=" enter your email" class="box" name="email">
            <input type="password" required maxlength="50" placeholder=" your password" class="box" name="pass">
            <input type="submit" value="login now" name="submit" class="btn btn-primary">
            <p>Don't have an account? <a href="register.php">register</a></p>
        </form>
    </section>

</body>

</html>