<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Set a flag to indicate logout
file_put_contents('logout_flag.txt', '1'); // Create a flag file

// Redirect to index.php and refresh the page
echo '<script>
        sessionStorage.clear(); 
        window.location.href="index.php"; 
        setTimeout(() => { location.reload(); }, 1000); // Refresh the page after 1 second
      </script>';
?>