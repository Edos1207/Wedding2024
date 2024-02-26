
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Photo Upload</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-fluid">
        <h1 class="wedding-title">Wedding E&K</h1>
        <div class="file-input-wrapper mt-4 mt-md-5">
            <div id="error-message" style="color: red;"></div>
            <label for="fileInput" class="w-100 text-center">
                <div class="form-wrapper w-100">
                    <h5>Select File here</h5>
                    <div>
                        <img width="60" src="icon/cloud-arrow-up-solid.svg" alt="">
                    </div>
                    <p class="mb-2">Click anywhere in the box to select files</p>
                    <div class="mb-2">
                        <span>OR</span>
                    </div>
                    <form id="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="files[]" id="fileInput" multiple class="form-control" style="display: none;">
                        
                        <button class="btn btn-primary" type="button" id="fileSelectButton">Browse Files</button>
                        <button class="btn submit-btn" type="submit" name="submit" style="display: none;">Upload</button>
                        <p class="mb-0"><span id="selectedFileName"></span></p>
                    </form>
                    
                </div>
            </label>
            <p class="support-files pt-1"><b>Supported files:</b> JPG, JPEG, PNG, GIF, MP4, MOV, AVI, MKV and WEBM.</p>
        </div>

        <section>
            <div class="gallery" id="gallery">
                <?php
                    $uploadDir = 'uploads/';
                    $files = scandir($uploadDir);
                    $imageFiles = array_filter($files, function($file) {
                        return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
                    });
                    if (empty($imageFiles)) {
                        echo "No images available.";
                    } else {
                        include 'gallery.php';
                    }
                ?>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Fancybox
            $('.fancybox').fancybox({
                buttons: [
                    'slideShow',
                    'fullScreen',
                    'download',
                    'close',
                ],
                afterShow: function(instance, current) {
                    $('.fancybox-video').attr('controlslist', 'download');
                }
            });
            
        });
    </script>
    <script>
        // Add JavaScript validation
        $(document).ready(function() {
            $('#upload-form').submit(function(event) {
                var fileInput = $('#fileInput')[0];
                var errorMessage = $('#error-message');

                // Check if any files are selected
                if (fileInput.files.length === 0) {
                    errorMessage.text('Please select at least one file.');
                    event.preventDefault(); // Prevent form submission
                    return;
                }

                // Check file types
                var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi', 'MKV', 'WEBM'];
                for (var i = 0; i < fileInput.files.length; i++) {
                    var fileExtension = fileInput.files[i].name.split('.').pop().toLowerCase();
                    if (!allowedExtensions.includes(fileExtension)) {
                        errorMessage.text('Error: Unsupported file format. Only JPG, JPEG, PNG, GIF, MP4, MOV, AVI, MKV and WEBM files are allowed.');
                        event.preventDefault(); // Prevent form submission
                        return;
                    }
                }
            });
        });
    </script>
    <script>
        document.getElementById('fileSelectButton').addEventListener('click', function() {
            document.getElementById('fileInput').click();
        });

        document.getElementById('fileInput').addEventListener('change', function() {
            var fileName = '';
            if (this.files && this.files.length > 0) {
                fileName = this.files[0].name;
            }
            document.getElementById('selectedFileName').textContent = fileName;
            document.getElementById('fileSelectButton').style.display = 'none';
            document.getElementById('selectedFileName').style.display = 'inline-block';
            document.querySelector('button[type="submit"]').style.display = 'inline-block';
        });

    </script>
    
</body>
</html>
