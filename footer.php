        <!-- Javascript -->
        <script type="text/javascript">
            $('.toggleForm').click(function() {
                
               $('#signUpForm').toggle();
               $('#logInForm').toggle(); 
                
            });
            
            $('#diary').bind('input propertychange', function() {
                $.ajax({
                    method: "POST",
                    url: "UpdateDatabase.php",
                    data: { content: $('#diary').val() }
                    });
            });
            
            
        </script>

        <!-- jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        
    </body>
</html>
      