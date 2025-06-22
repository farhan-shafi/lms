
<?php
// Simple login form for debugging
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <!-- Show errors if any -->
                        <?php if(isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Show success messages if any -->
                        <?php if(isset($_GET['success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_GET['success']) ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Information about dynamic login -->
                        <div class="alert alert-info mb-3">
                            <p><strong>Note:</strong> You need to register an account before logging in.</p>
                            <p>Use your email and password to log in after registration.</p>
                        </div>
                        
                        <!-- Simple login form that bypasses CI's form processing -->
                        <form action="/lms/index.php/auth/login_process" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        <div class="mt-3 text-center">
                            Don't have an account? <a href="/lms/index.php/auth/register">Register here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
