<?php 

session_start();
include 'config.php';
$pageTitle = "Profile"; 
include 'header.php';

if(isset($_SESSION['mail'])){
    
    $email  =   $_SESSION['mail'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->execute(array($email));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    
    if($count > 0){
        ?>

        <div class="card-container">
            <div class="card">
                <div class="face face1 text-center">
                    <a href="logout.php" class="log"><span>logOut</span></a>
                    <i class="fas fa-user-circle fa-7x"></i>
                    <h1>Welcome,</h1>
                    <span class="user"><?php echo $row['FullName'] ?> </span>
                    <span class="hover">hover card for more info</span>
                </div>
                <div class="face face2">
                    <ul>
                        <li><h4>E-mail</h4> <span><?php echo $row['Email'] ?></span> </li>
                        <li><h4>Phone</h4> <span><?php echo $row['Phone'] ?></span> </li>
                        <li><h4>Adress</h4> <span><?php echo $row['Address'] ?></span> </li>
                        
                    </ul>
                </div>
            </div>
            
        </div>

        <?php
    }

}else{
    
    header('location:index.php');
    exit();
}
include 'footer.php';
?>
