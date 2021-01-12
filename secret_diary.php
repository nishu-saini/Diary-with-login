<?php
    $error = "";
    session_start();

    if(array_key_exists("logout", $_GET)) {
        unset($_SESSION);
        setcookie('id',"", time() - 60*60);
        $_COOKIE['id'] = "";
        
    } else if((array_key_exists('id', $_SESSION) && $_SESSION['id']) || (array_key_exists('id', $_COOKIE) && $_COOKIE['id'])) {
       header("Location: loggedInPage.php"); 
        
    }
    
    if(array_key_exists("submit",$_POST)) {
        include("connection.php");
        
        #Checking email and password are entered or not...
        if(!$_POST['email']) {
            $error = "Email is required!<br>";
        }
        
        if(!$_POST['password']) {
            $error = "Password is required<br>";
        }
        
        if($error) {
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else if($_POST['signUp']=='1') {
            #For signUp email is already existed in db or not...
             $query = "SELECT id FROM mysecretdiary WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
            $result = mysqli_query($link, $query);
            
            if(mysqli_num_rows($result)) {
                $error = "<p>This email is already taken!!!</p>";
                
            } else {
                #For Loggin form...
                $query = "INSERT INTO mysecretdiary(`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
                
                $store_data = mysqli_store_result($link);
                
                if(mysqli_query($link, $query, $store_data)) {
                   $query = "UPDATE mysecretdiary SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = '".mysqli_insert_id($link)."' LIMIT 1";
                    
                    $_SESSION['id'] = mysqli_insert_id($link);
                    
                    if($_POST['stayLoggedIn'] == '1') {
                        setcookie("id", mysqli_insert_id($link), time() + 60*60*24);
                           
                    }
                    
                    header("Location: loggedInPage.php");
                    
                } else {
                    $error = "<p>Could not signUp - try again later!</p>";
                    
                }   
            }     
            
        } else {
            $query = "SELECT * FROM mysecretdiary WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
            $result = mysqli_query($link, $query);
            $rows = mysqli_fetch_array($result);
            
            if(isset($rows)) {
                $hashPassword = md5(md5($rows['id']).$_POST['password']);
                
                if($hashPassword == $rows['password']) {
                    $_SESSION['id'] = $rows['id'];
                    
                    if($_POST['stayLoggedIn'] == '1') {
                         setcookie("id", mysqli_insert_id($link), time() + 60*60*24);
                        
                    }
                    
                    header("Location: loggedInPage.php");
                    
                } else {
                    $error = "<p>That email/password combination is not found!</p>";
                    
                }
            } else {
                $error = "<p>Looks like you are not signUp yet - first sign up!</p>";
                
            }   
        }  
    }

?>

<?php include("header.php"); ?>
        <div class="container">
            <h1>My Secret Diary</h1>
            <p><strong>Store your thaughts securely</strong></p>

            <div><?php if($error) { echo '<div class="alert alert-danger" role="alert">'.$error.'</div>'; } ?></div>

            <!-- Sign Up form -->
            <form method="post" id="signUpForm">
                <p>Interested? Sign up now!</p>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="asdf@gmail.com" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="password">
                </div>
                
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1" id="checkbox">
                    <label class="form-check-label" for="checkbox">Stay Logged In</label>
                </div>
                
                <input type="hidden" name="signUp" value="1">
                <input type="submit" class="btn btn-primary" name="submit" value="Sign Up">
                
                <p><a class="toggleForm">Log In!</a></p>

            </form>

            <!-- Loggin Form -->
            <form method="post" id="logInForm">
                <p>Login using your email and password!</p>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="asdf@gmail.com" aria-describedby="emailHelp">    
                    <small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="password">
                </div>    
                    
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1" id="checkbox">
                    <label class="form-check-label" for="checkbox">Stay Logged In</label>
                </div>
                
                <input type="hidden" name="signUp" value="0">
                <input type="submit" class="btn btn-primary" name="submit" value="login">
                
                <p><a class="toggleForm">Sign Up!</a></p>

            </form>
        </div>    

<?php include("footer.php"); ?>
      
      
      