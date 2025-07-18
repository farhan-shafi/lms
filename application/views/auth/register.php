<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    <!-- Show errors if any -->
                    <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Show success messages if any -->
                    <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                    <?php endif; ?>
                    
                    <form action="<?= base_url('auth/register_process') ?>" method="post" enctype="multipart/form-data">
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
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                            <small class="form-text text-muted">Upload a profile picture (optional).</small>
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
                        Already have an account? <a href="<?= base_url('auth/login') ?>">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
