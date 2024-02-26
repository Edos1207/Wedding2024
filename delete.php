<?php
session_start();

// Define the username and password
$validUsername = "admin";
$validPassword = "password";

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, check if login form submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Verify credentials
        if ($username === $validUsername && $password === $validPassword) {
            $_SESSION['username'] = $username; // Set session variable
        } else {
            echo "Invalid username or password";
        }
    } else {
        header('Location: login.php'); // Redirect to login page
        exit;
    }
}

// Handle logout request
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Handle image deletion
if (isset($_POST['delete'])) {
    $uploadDir = 'uploads/';
    $deletedFilenames = $_POST['files']; // Get array of deleted filenames
    foreach ($deletedFilenames as $filename) {
        $filePath = $uploadDir . $filename;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Remove deleted filenames from filenames.json
    $filenames = [];
    if (file_exists('filenames.json')) {
        $filenames = json_decode(file_get_contents('filenames.json'), true);
        // Filter out deleted filenames
        $filenames = array_filter($filenames, function($fileInfo) use ($deletedFilenames) {
            return !in_array($fileInfo['filename'], $deletedFilenames);
        });
        // Save updated filenames to filenames.json
        file_put_contents('filenames.json', json_encode($filenames));
    }

    // Redirect to prevent form resubmission on refresh
    header('Location: delete.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Images</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-5">Delete Images</h2>
        <form action="" method="post">
            <div class="row">
                <div>
                    <?php
                        // Check if the user is logged in
                        if (!isset($_SESSION['username'])) {
                            header('Location: login.php');
                            exit;
                        }
                        $uploadDir = 'uploads/';
                        $filenames = [];
                        if (file_exists('filenames.json')) {
                            $filenames = json_decode(file_get_contents('filenames.json'), true);
                        }
                        if (!empty($filenames)) {
                            // Add checkbox to select all
                            echo '<div class="form-check d-inline-flex align-items-center">';
                            echo '<input type="checkbox" class="form-check-input" id="select-all">';
                            echo '<label class="form-check-label ms-2 fw-bold" for="select-all">Select All</label>';
                            echo '</div>';
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered">';
                            foreach ($filenames as $fileInfo) {
                                $filename = $fileInfo['filename'];
                                echo '<tr>';
                                echo '<td class="align-middle text-center"><input class="form-check-input delete-checkbox" type="checkbox" name="files[]" value="' . $filename . '"></td>';
                                echo '<td class="align-middle text-center"><img class="table-image" src="' . $uploadDir . $filename . '"></td>';
                                echo '<td class="align-middle">' . $filename . '</td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                            echo '</div>';
                        } else {
                            echo "<p class='mt-3'>No images found.</p>";
                        }
                    ?>
                </div>
                <div>
                    <div class="text-center mt-3 mt-md-5 mb-5">
                        <button type="submit" class="btn btn-danger mb-2 mx-2" name="delete">Delete Selected Images</button>
                        <button type="submit" class="btn btn-secondary mb-2 mx-2" name="logout">Logout</button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min"></script>
<script>
    // Script to select/deselect all checkboxes
    $(document).ready(function() {
        $('#select-all').change(function() {
            $('.delete-checkbox').prop('checked', $(this).prop('checked'));
        });
    });
</script>
</html>
