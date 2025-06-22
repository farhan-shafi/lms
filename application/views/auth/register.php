<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Register</h3>
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
                    
                    <form action="/lms/index.php/auth/register_process" method="post">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                        </div>
                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Register As:</label>
                            <select class="form-select" id="role" name="role">
                                <option value="student">Student</option>
                                <option value="instructor">Instructor</option>
                            </select>
                            <small class="form-text text-muted">Instructor accounts require admin approval.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                    <div class="mt-3 text-center">
                        Already have an account? <a href="/lms/index.php/auth/login">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
