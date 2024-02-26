<?php
$uploadDir = 'uploads/';
$filenames = [];

if (file_exists('filenames.json')) {
    $filenames = json_decode(file_get_contents('filenames.json'), true);
}

// Group filenames by upload date and convert dates to timestamps
$groupedFiles = [];
foreach ($filenames as $fileInfo) {
    $uploadDate = strtotime($fileInfo['upload_date']); // Convert to timestamp
    $groupedFiles[$uploadDate][] = $fileInfo['filename'];
}

// Sort groups by upload date and reverse the order
krsort($groupedFiles);

// Track which images have been displayed
$displayedImages = [];

// Display images grouped by upload date
foreach ($groupedFiles as $uploadDate => $files) {
    // Check if any images exist for this date
    $imagesExist = false;
    foreach ($files as $filename) {
        $filePath = $uploadDir . $filename;
        if (file_exists($filePath)) {
            $imagesExist = true;
            break;
        }
    }

    // If no images exist, skip displaying this date
    if (!$imagesExist) {
        continue;
    }

    $formattedDate = date('F j, Y', $uploadDate); // Format date for display
    echo '<div class="mb-3">';
    echo '<p class="fs-6 mb-3">' . $formattedDate . '</p>'; // Display the upload date header
    echo '<div class="d-flex flex-wrap gallery-row">';
    foreach ($files as $filename) {
        // Check if this image has already been displayed
        if (in_array($filename, $displayedImages)) {
            continue; // Skip this image if already displayed
        }

        $filePath = $uploadDir . $filename;
        $fileType = pathinfo($filePath, PATHINFO_EXTENSION);

        if (file_exists($filePath)) {
            if (in_array($fileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                echo '<div class="image-content"><a href="' . $filePath . '" class="fancybox" data-fancybox="images"><img src="' . $filePath . '" class="uploaded-content" alt="' . $filename . '"></a></div>';
            } elseif (in_array($fileType, ['mp4', 'mov', 'avi'])) {
                echo '<div class="image-content"><a href="' . $filePath . '" class="fancybox fancybox-video" data-fancybox="images"><video src="' . $filePath . '" class="uploaded-content" alt="' . $filename . '"></video></a></div>';
            }

            // Add displayed image to the list
            $displayedImages[] = $filename;
        }
    }
    echo '</div>';
    echo '</div>';
}
?>
