<?php
    # Loggin page for secret diary content...
    session_start();
    $diaryContent = "";

    if(array_key_exists('id',$_COOKIE)) {
        $_SESSION['id'] = $_COOKIE['id'];
        
    }
    
    if(array_key_exists('id',$_SESSION)) {
        
        include("connection.php");
        
        $query = "SELECT diary FROM mysecretdiary WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT = 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        
        $diaryContent = $row;
        
    } else {
        header("Location: secret_diary.php");
        
    }

    include("header.php");

?>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
        <a class="navbar-brand" href="#">Secret Diary</a>
        <div class="form-inline my-2 my-lg-0" id="navbarLogout">
            <a href ='secret_diary.php?logout=1'><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button></a>
        </div>
    </nav>

    <div class="container-fluid" id="contentArea">
        <textarea id="diary" class="form-control"><?php echo $diaryContent; ?></textarea>
        
    </div>

<?php include("footer.php"); ?>

