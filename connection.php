<?php
    #conect to mysql database...
    $link = mysqli_connect("localhost", "quarn", "Chra-XXZP3eui$&", "secret_diary");
            if(mysqli_connect_error()) {
                die ("Database connection error!");
            }
?>
