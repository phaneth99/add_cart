<?php
@include 'config.php';
include'connection.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id= '';
    header('Location:users/login.php');
}

if(isset($_POST['add_product'])){
    
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.$product_image;

    if(empty($product_name) || empty($product_price) || empty($product_image)){
        $message[] = 'Please fill out all';
            
    }
    else{
        $insert = "INSERT INTO products(name, price, image) VALUE('$product_name','$product_price' ,
        '$product_image')";
        $upload = mysqli_query($conn,$insert);

        if($upload){
            move_uploaded_file($product_image_tmp_name,$product_image_folder);
            $message[] = 'new product added successfully';
        }
        else{
            
            $message[] = 'could not add a product';
        }
    }
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- font-awsome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<?php 
if(isset($message)){
    foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
        
    }
}
?>

<body>
    <div class="btn-back">
        <a href="./users/home.php" class=" btn">Go Back!</a>
    </div>
    <div class="container">

        <div class="admin_product_form_container">

            <form action="<?php  $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <h3 class="header">add a new product</h3>
                <input type="text" placeholder="enter product name" name="product_name" class="box">
                <input type="number" placeholder="enter product price" name="product_price" class="box">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box    ">
                <input type="submit" name="add_product" value="add product" class="btn">
            </form>

        </div>
    </div>

    <?php 
    $select = mysqli_query($conn, "SELECT * FROM products")
    ?>
    <div class="product_display">
        <table class="product_display_table">
            <thead>
                <tr>
                    <th>product image</th>
                    <th>product name</th>
                    <th>product price</th>
                    <th>product action</th>
                </tr>
            </thead>

            <?php
             while($row = mysqli_fetch_assoc($select)){
                
             ?>
            <tr>
                <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt="image"></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['price']; ?>$</td>
                <td>
                    <a href="update.php?edit=<?php echo $row['id']; ?>" class="btn"><i class=" fas fa-edit"></i>edit</a>
                    <a onclick="confirmDelete(id=<?php echo $row['id']?>)" href="index.php" class="btn"><i
                            class=" fas fa-trash"></i>delete</a>
                </td>

            </tr>
            <?php };?>
        </table>
    </div>
</body>

<script>
function confirmDelete(id) {
    if (confirm(" Are you sure you want to delete this item?")) {
        window.location.href = 'delete.php?delete=' + id;
    }
}
</script>

</html>