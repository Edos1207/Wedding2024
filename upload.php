<?php
if(isset($_POST['submit'])) {
    $uploadDir = 'uploads/';
    $fileNames = [];

    foreach ($_FILES['files']['name'] as $key => $name) {
        $targetFile = $uploadDir . basename($_FILES['files']['name'][$key]);
        // Check if the file already exists in the JSON file
        if (!fileExistsInJson($_FILES['files']['name'][$key])) {
            if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetFile)) {
                $fileNames[] = [
                    'filename' => basename($_FILES['files']['name'][$key]),
                    'upload_date' => date('Y-m-d') // Store the current date
                ];
            }
        }
    }

    // Save filenames to a JSON file for persistence
    $existingFilenames = [];
    if (file_exists('filenames.json')) {
        $existingFilenames = json_decode(file_get_contents('filenames.json'), true);
    }
    if ($existingFilenames === null) {
        $existingFilenames = [];
    }
    $fileNames = array_merge($existingFilenames, $fileNames);
    file_put_contents('filenames.json', json_encode($fileNames));

    // Redirect back to index.php
    header('Location: index.php');
    exit;
}

// Function to check if filename exists in JSON file
function fileExistsInJson($filename) {
    $filenames = [];
    if (file_exists('filenames.json')) {
        $filenames = json_decode(file_get_contents('filenames.json'), true);
    }
    foreach ($filenames as $fileInfo) {
        if ($fileInfo['filename'] == $filename) {
            return true;
        }
    }
    return false;
}
?>
