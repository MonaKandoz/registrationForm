<?php 
    session_start();
    $pageTitle = 'Registration form';
    if(isset($_SESSION['mail'])){
        header('location:registration.php');
        exit();
    }

    include 'config.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
       
        $mail       =   $_POST['mail'];
        $pass       =   $_POST['pass'];
        $hashPass   =   sha1($pass);
        
        $hidden     =   $_POST['hidden'];


        if($hidden === 'logIn'){

            //check if user exist in db

            $stmt = $conn->prepare("SELECT Email, Password FROM users WHERE Email = ? AND Password = ?");
            $stmt->execute(array($mail, $hashPass));
            $count = $stmt->rowCount();

            if($count > 0){
                $_SESSION['mail'] = $mail;
                header('location:registration.php');
                exit();
            }else{
                echo '<div class="row justify-content-center"><div class="alert alert-danger col-md-6">invalid E-mail or password</div></div>';
            }


        }else if($hidden === 'signUp'){

            $full       =   $_POST['full'];
            $phone      =   $_POST['phone'];
            $address    =   $_POST['address'];

            $statement = $conn->prepare("SELECT Email FROM users WHERE Email = ?");
            $statement->execute(array($mail));
            $count2 = $statement->rowCount();
            if($count2 > 0){
                echo '<div class="row justify-content-center"><div class="alert alert-danger col-md-6">sorry this E-mail is exist</div></div>';
            }else{
                $formError = array();
                if(strlen($full) < 4){
                    $formError[] = 'UserName can\'t be less than<strong> 4 characters</strong>';
                }
                if(strlen($full) > 20){
                    $formError[] = 'UserName can\'t be more than<strong> 20 characters</strong>';
                }
                foreach($formError as $error){
                
                    echo '<div class="row justify-content-center"><div class="alert alert-danger col-md-6">' . $error . '</div></div></br>';
                }
                
                if(empty($formError)){
                    $stmt2 = $conn->prepare("INSERT INTO users(FullName, Email, Password, Phone, Address) VALUES (?, ?, ?, ?, ?)");
                    $stmt2->execute(array($full, $mail, $hashPass, $phone, $address));
                    $_SESSION['mail'] = $mail;
                    sleep(5);
                    header('location:registration.php');
                    exit();
                }
            }   
            
        }
    }
    
?>


<!DOCTYPE html>

    <?php include 'header.php'; ?>
        
        <div class="container" id="container">
            <div class="row">
                <div class="form-container signup-container col col-md-6 col-12">
                    <form class="signUp" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="success()">
                        <input type="hidden" value="signUp" name="hidden">
                        <h1>create an account</h1>
                        <div class="form-group">
                            <input type="text" class="form-control" name="full" placeholder="Type your full name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="mail" placeholder="Type your e-mail address" required>
                        </div>
                        <div class="form-group ">
                            <input type="password" class="form-control" name="pass" autocomplete="off" placeholder="Your password" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Type your phone number">
                        </div><div class="form-group">
                            <input type="text" class="form-control" name="address" placeholder="Type your home address">
                        </div>
                        
                        <button type="submit" id="signup">Sign up</button>
                    </form>
                </div>
                
                <div class="form-container signin-container col col-md-6 col-12">
                    <form class="logIn" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" value="logIn" name="hidden">
                        <h1>login</h1>
                            <div class="form-group">
                            <input type="email" class="form-control" name="mail" placeholder="Your e-mail address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pass" placeholder="Your e-mail address" required>
                        </div>
                        <button type="submit" >Login</button>
                    </form>
                </div>
            </div>
            <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel right-overlay">
                            <h1>Welcome back!</h1>
                            <p>To keep connected with us please logIn with your personal information.</p>
                            <span class="or">or</span>
                            <button class="ghost" id="sign-up">SignUp</button>
                        </div>
                        <div class="overlay-panel left-overlay">
                            <h1>Hello, friend!</h1>
                            <p>Enter your personal details to start your journey with us.</p>
                            <span class="or">or</span>
                            <button class="ghost" id="LogIn">LogIn</button>
                        </div>
                    </div>
                </div>
        </div>
<?php include 'footer.php'; ?>