<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard/certificates') ?>">My Certificates</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Certificate Details</li>
                </ol>
            </nav>
            
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-0">Course Completion Certificate</h1>
                        <p class="text-muted">This certifies that you have successfully completed the course</p>
                    </div>
                    
                    <div class="certificate-preview bg-light p-4 mb-4 text-center">
                        <div class="certificate-inner border p-5 bg-white" style="background-image: url('<?= base_url('assets/images/certificate-bg-watermark.jpg') ?>'); background-size: cover; background-position: center;">
                            <div class="certificate-header mb-4">
                                <img src="<?= base_url('assets/images/logo.png') ?>" alt="EduLearn LMS" height="60">
                                <h2 class="mt-3">Certificate of Completion</h2>
                                <p class="lead">This is to certify that</p>
                            </div>
                            
                            <div class="recipient-name mb-3">
                                <h3 class="display-5 fw-bold text-primary"><?= $user['name'] ?></h3>
                            </div>
                            
                            <div class="certificate-text mb-4">
                                <p>has successfully completed the course</p>
                                <h4 class="h3 text-success"><?= $course['title'] ?></h4>
                                <p class="mt-2">with a total duration of <?= $course['duration'] ?? '10' ?> hours</p>
                            </div>
                            
                            <div class="row mt-5">
                                <div class="col-md-6 text-md-start">
                                    <p class="mb-0">Date: <?= date('F j, Y', strtotime($certificate['issue_date'])) ?></p>
                                    <p>Certificate ID: <?= $certificate['certificate_number'] ?></p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <img src="<?= base_url('assets/images/signature.png') ?>" alt="Signature" height="60"><br>
                                    <p class="mb-0">_________________________</p>
                                    <p>Course Instructor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="certificate-actions text-center">
                        <a href="<?= base_url('certificate/download/' . $certificate['id']) ?>" class="btn btn-primary me-2">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                        <a href="<?= base_url('certificate/verify?number=' . $certificate['certificate_number']) ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-check-circle"></i> Verify Certificate
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Certificate Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Certificate Number:</th>
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
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i> Share Your Achievement</h5>
                        </div>
                        <div class="card-body">
                            <p>Share your achievement with your network:</p>
                            <div class="d-flex justify-content-center social-share mt-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(base_url('certificate/verify?number=' . $certificate['certificate_number'])) ?>" target="_blank" class="btn btn-outline-primary mx-1">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?= urlencode('I just completed ' . $course['title'] . ' on EduLearn LMS! Check out my certificate:') ?>&url=<?= urlencode(base_url('certificate/verify?number=' . $certificate['certificate_number'])) ?>" target="_blank" class="btn btn-outline-info mx-1">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(base_url('certificate/verify?number=' . $certificate['certificate_number'])) ?>" target="_blank" class="btn btn-outline-secondary mx-1">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                            
                            <div class="mt-4">
                                <label for="certificateLink" class="form-label">Certificate Link:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="certificateLink" value="<?= base_url('certificate/verify?number=' . $certificate['certificate_number']) ?>" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard()">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        var copyText = document.getElementById("certificateLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        
        alert("Certificate link copied!");
    }
</script>
