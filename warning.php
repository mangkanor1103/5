<?php
// Start the session
session_start();

// Include the database connection
require_once 'dbConnection.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit(); // Ensure no further code is executed
} else {
    $name = $_SESSION['name'];
    $email = $_SESSION['email']; // Initialize the email variable
}

// Automatically save the warning when the page is loaded
$timestamp = date('Y-m-d H:i:s'); // Get the current timestamp

// Insert the warning into the database using a simple query
$sql = "INSERT INTO warning (timestamp, email) VALUES ('$timestamp', '$email')";

if ($con->query($sql) === TRUE) {
    $saveMessage = "Warning saved successfully!";
} else {
    $saveMessage = "Failed to save warning: " . $con->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warning</title>
    <style>
        body { 
            display: flex; 
            flex-direction: row; 
            justify-content: space-between; 
            align-items: center; 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            height: 100vh; 
            background-color: red; 
            color: white; 
        }
        .left { 
            flex: 1; 
            padding: 20px; 
            text-align: left; 
        }
        .right { 
            flex: 1; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 20px; 
        }
        h1 { 
            font-size: 40px; 
        }
        p { 
            font-size: 20px; 
            margin: 20px 0; 
        }
        button { 
            margin-top: 20px; 
            padding: 10px 20px; 
            font-size: 18px; 
            color: white; 
            background-color: black; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        button:hover { 
            background-color: gray; 
        }
        img { 
            max-width: 100%; 
            max-height: 100%; 
            border: 5px solid white; 
            border-radius: 10px; 
        }
        #noImageMessage { 
            text-align: center; 
        }
    </style>
</head>
<body>
    <div class="left">
        <h1>⚠ Warning ⚠</h1>
        <p>Your face has moved out of the allowed area! Please keep your face centered for the system to work properly.</p>
        <p id="saveMessage"><?php echo htmlspecialchars($saveMessage); ?></p>
        <button id="goBackButton">Go Back</button>
    </div>
    <div class="right">
        <img id="warningImage" src="" alt="Captured Warning Image">
        <div id="noImageMessage" style="display: none;">
            <p>No warning image is currently available. Please try again later.</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const imgElement = document.getElementById("warningImage");
            const noImageMessage = document.getElementById("noImageMessage");

            // Fetch and display the latest warning image
            fetch('http://127.0.0.1:5000/get_warning_image')
                .then(response => {
                    if (response.ok) {
                        return response.blob();
                    } else {
                        throw new Error("No warning image available.");
                    }
                })
                .then(blob => {
                    const imageUrl = URL.createObjectURL(blob);
                    imgElement.src = imageUrl;
                })
                .catch(error => {
                    console.error("Error loading warning image:", error);
                    imgElement.style.display = "none"; // Hide the image element
                    noImageMessage.style.display = "block"; // Show the fallback message
                });

            // Add event listener to the "Go Back" button
            const goBackButton = document.getElementById("goBackButton");
            goBackButton.addEventListener("click", () => {
                // First restart the Python session
                fetch('http://127.0.0.1:5000/restart', {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Python session restarted:", data);
                    // Then go back to previous page
                    window.history.back();
                })
                .catch(error => {
                    console.error("Failed to restart Python session:", error);
                    // Still go back even if restart fails
                    window.history.back();
                });
            });
        });
    </script>
</body>
</html>