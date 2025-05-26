<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Contact Hero Section -->
<section class="contact-hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="page-title">Contact Us</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="contact-info-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="contact-info-box">
                    <div class="icon-box">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Our Location</h4>
                    <p>123 Education Street<br>Learning City, LC 12345<br>United States</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-box">
                    <div class="icon-box">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h4>Call Us</h4>
                    <p>+1 (555) 123-4567<br>+1 (555) 987-6543</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-box">
                    <div class="icon-box">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4>Email Us</h4>
                    <p>info@lmssystem.com<br>support@lmssystem.com</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="contact-image">
                    <img src="<?= base_url('assets/images/contact-us.jpg') ?>" alt="Contact Us" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-form-box">
                    <h2>Get In Touch</h2>
                    <p>We'd love to hear from you. Fill out the form below, and we'll get back to you as soon as possible.</p>
                    
                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?= validation_errors() ?>
                    </div>
                    <?php endif; ?>
                    
                    <?= form_open('home/contact', ['class' => 'contact-form']); ?>
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?= set_value('subject') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required><?= set_value('message') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container-fluid p-0">
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215151242542!2d-73.9888168!3d40.7410428!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzI3LjgiTiA3M8KwNTknMTkuNyJX!5e0!3m2!1sen!2sus!4v1620123456789!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <h2 class="section-title text-center">Frequently Asked Questions</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="accordion" id="faqAccordion1">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How do I enroll in a course?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion1">
                            <div class="card-body">
                                To enroll in a course, simply browse our course catalog, select the course you're interested in, and click the "Enroll" button. You'll need to create an account or log in if you haven't already.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How do I pay for courses?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion1">
                            <div class="card-body">
                                We accept various payment methods, including credit/debit cards and PayPal. When you enroll in a paid course, you'll be prompted to select your preferred payment method at checkout.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="accordion" id="faqAccordion2">
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How do I become an instructor?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion2">
                            <div class="card-body">
                                To become an instructor, click on the "Become an Instructor" link in the footer or navigation menu. You'll need to complete an application form and provide details about your expertise and the courses you'd like to teach.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Is there a mobile app available?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion2">
                            <div class="card-body">
                                Yes, we have mobile apps available for both iOS and Android platforms. You can download them from the App Store or Google Play Store to access your courses on the go.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
