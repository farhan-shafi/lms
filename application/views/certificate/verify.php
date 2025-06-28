<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-5">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-0">Certificate Verification</h1>
                        <p class="text-muted">Verify the authenticity of EduLearn LMS certificates</p>
                    </div>
                    
                    <form action="<?= base_url('certificate/verify') ?>" method="get">
                        <div class="row mb-4">
                            <div class="col-md-8 offset-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="number" placeholder="Enter certificate number (e.g., CERT-2025-000001-12345)" value="<?= $this->input->get('number') ?>" required>
                                    <button class="btn btn-primary" type="submit">Verify</button>
                                </div>
                                <div class="form-text text-center">
                                    Enter the certificate ID found at the bottom of the certificate
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <?php if (isset($verified)): ?>
                        <?php if ($verified): ?>
                            <div class="alert alert-success">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle fa-3x me-3"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="alert-heading">Certificate Verified!</h4>
                                        <p class="mb-0">This certificate is valid and was issued by EduLearn LMS.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Certificate Details</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Certificate Number:</th>
                                            <td><?= $certificate['certificate_number'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Recipient:</th>
                                            <td><?= $user['name'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Course:</th>
                                            <td><?= $course['title'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Issue Date:</th>
                                            <td><?= date('F j, Y', strtotime($certificate['issue_date'])) ?></td>
                                        </tr>
                                    </table>
                                    
                                    <div class="text-center mt-3">
                                        <a href="<?= base_url('certificate/view/' . $certificate['id']) ?>" class="btn btn-outline-primary">
                                            <i class="fas fa-eye"></i> View Certificate
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-times-circle fa-3x me-3"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="alert-heading">Invalid Certificate</h4>
                                        <p class="mb-0"><?= $message ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> About Certificate Verification</h5>
                        </div>
                        <div class="card-body">
                            <p>Our certificate verification system allows you to check the authenticity of certificates issued by EduLearn LMS. Each certificate has a unique number that can be verified using this tool.</p>
                            
                            <h6 class="mt-3">Why Verify?</h6>
                            <ul>
                                <li>Confirm the authenticity of a certificate</li>
                                <li>Validate the achievements of certificate holders</li>
                                <li>Protect against fraudulent certificates</li>
                            </ul>
                            
                            <h6 class="mt-3">How to Find the Certificate Number</h6>
                            <p>The certificate number can be found at the bottom of the certificate, formatted as: <strong>CERT-YYYY-XXXXXX-ZZZZZ</strong></p>
                            
                            <div class="text-center mt-3">
                                <img src="<?= base_url('assets/images/certificate-sample.jpg') ?>" alt="Sample Certificate" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
