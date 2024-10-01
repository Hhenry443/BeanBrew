<?php
require '../../helpers.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../../App/partials/db.php';

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the submitted form data
        $username = $_POST['username'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        // Prepare an SQL statement to insert the data
        $stmt = $pdo->prepare("INSERT INTO tbl_posts (username, title, content) 
                               VALUES (:username, :title, :content)");

        // Bind parameters to the query
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $postID = $pdo->lastInsertId();

            // Handle the image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Define the target directory
                $targetDir = __DIR__ . '/../images/posts/'; // Adjust this path as needed

                // Create the directory if it doesn't exist
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                // Generate the new file name
                $newFileName = $postID . '.jpg'; // Post ID with .jpg extension
                $targetFilePath = $targetDir . $newFileName;

                // Validate the file type
                $fileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif']; // Allowed file types

                if (in_array($fileType, $allowedTypes)) {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                        // Update the database with the new image path
                        $imageURL = 'images/posts/' . $newFileName; // Path to store in DB
                        $updateStmt = $pdo->prepare("UPDATE tbl_posts SET imageURL = :imageURL WHERE postID = :postID");
                        $updateStmt->bindParam(':imageURL', $imageURL);
                        $updateStmt->bindParam(':postID', $postID);
                        $updateStmt->execute();

                        echo "The file has been uploaded successfully.";
                    } else {
                        echo "There was an error uploading your file.";
                    }
                } else {
                    echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            } else {
                echo "No image uploaded or there was an upload error.";
            }

            // Redirect to the post page
            redirect('/post.php?id=' . $postID);
        } else {
            echo "Failed to insert post.";
        }
    }
} catch (PDOException $e) {
    // Handle any errors during the connection or execution
    echo "Database error: " . $e->getMessage();
}
