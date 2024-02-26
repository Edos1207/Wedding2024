<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Login Form -->
    <div class="container">
        <div class="row justify-content-center mt-5">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card shadow">
            <div class="card-title text-center mb-0">
                <h2 class="p-3 mb-0">Login</h2>
            </div>
            <div class="card-body p-4 pt-3">
                <form action="delete.php" method="post">
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input class="form-control" type="text" id="username" name="username" />
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input class="form-control" type="password" id="password" name="password" />
                </div>
                <div class="d-grid">
                    <button type="submit" name="login" class="btn submit-btn">Login</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min"></script>
</body>
</html>
