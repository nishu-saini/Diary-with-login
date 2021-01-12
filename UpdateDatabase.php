<!-- Script used for take content from page and store in database -->
<?php
    session_start();

    if(array_key_exists("content", $_POST)) {
        include("connection.php");
        $query = "UPDATE mysecretdiary SET diary = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT = 1";
        $store_data = mysqli_store_result($link);
        mysqli_query($link,$query,$store_data);
        
    }

?>
