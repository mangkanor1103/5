<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warning</title>
    <style>
        body { 
            text-align: center; 
            font-family: Arial, sans-serif; 
            padding: 50px; 
            background-color: red; 
            color: white; 
        }
        h1 { 
            font-size: 40px; 
        }
        p { 
            font-size: 20px; 
        }
        a { 
            color: yellow; 
            font-size: 18px; 
            text-decoration: underline; 
        }
        img { 
            margin-top: 20px; 
            max-width: 80%; 
            height: auto; 
            border: 5px solid white; 
            border-radius: 10px; 
        }
    </style>
</head>
<body>
    <h1>⚠ Warning ⚠</h1>
    <p>Your face moved out of the allowed area! Please keep your face centered.</p>
    <div>
        <img id="warningImage" src="" alt="Captured Warning Image">
    </div>
    <div id="noImageMessage" style="display: none;">
        <p>No warning image available. Please try again later.</p>
    </div>

    <script>
        // Fetch and display the latest warning image
        document.addEventListener("DOMContentLoaded", () => {
            const imgElement = document.getElementById("warningImage");
            const noImageMessage = document.getElementById("noImageMessage");

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

            // Automatically go back after 5 seconds
            setTimeout(() => {
                window.history.back();
            }, 5000);
        });
    </script>
</body>
</html>