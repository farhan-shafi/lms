<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="dashboard-container">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2">
                <?php $this->load->view('templates/admin_sidebar'); ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10">
                <!-- Dashboard Header -->
                <div class="admin-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="admin-title"><?= $is_edit ? 'Edit Course' : 'Create Course' ?></h1>
                            <p class="admin-subtitle"><?= $is_edit ? 'Update course information' : 'Add a new course' ?></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">Back to Courses</a>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Course Form -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>
                        
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger"><?= validation_errors() ?></div>
                        <?php endif; ?>
                        
                        <form action="<?= $is_edit ? base_url('admin/edit_course/' . $course['id']) : base_url('admin/edit_course') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Course Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title', $is_edit ? $course['title'] : '') ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <input type="text" class="form-control" id="short_description" name="short_description" value="<?= set_value('short_description', $is_edit ? $course['short_description'] : '') ?>" required>
                                        <small class="text-muted">A brief description (1-2 sentences)</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Full Description</label>
                                <textarea class="form-control" id="description" name="description" rows="6" required><?= set_value('description', $is_edit ? $course['description'] : '') ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="instructor_id" class="form-label">Instructor</label>
                                        <select class="form-control" id="instructor_id" name="instructor_id" required>
                                            <option value="">Select Instructor</option>
                                            <?php foreach ($instructors as $instructor): ?>
                                                <option value="<?= $instructor['id'] ?>" <?= set_select('instructor_id', $instructor['id'], ($is_edit && $course['instructor_id'] == $instructor['id'])) ?>>
                                                    <?= $instructor['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>" <?= set_select('category_id', $category['id'], ($is_edit && $course['category_id'] == $category['id'])) ?>>
                                                    <?= $category['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="level" class="form-label">Level</label>
                                        <select class="form-control" id="level" name="level" required>
                                            <option value="beginner" <?= set_select('level', 'beginner', ($is_edit && $course['level'] == 'beginner')) ?>>Beginner</option>
                                            <option value="intermediate" <?= set_select('level', 'intermediate', ($is_edit && $course['level'] == 'intermediate')) ?>>Intermediate</option>
                                            <option value="advanced" <?= set_select('level', 'advanced', ($is_edit && $course['level'] == 'advanced')) ?>>Advanced</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="<?= set_value('price', $is_edit ? $course['price'] : '0.00') ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="is_free" class="form-label">Course Type</label>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1" <?= set_checkbox('is_free', '1', ($is_edit && $course['is_free'] == 1)) ?>>
                                            <label class="form-check-label" for="is_free">
                                                Free Course
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="language" class="form-label">Language</label>
                                        <input type="text" class="form-control" id="language" name="language" value="<?= set_value('language', $is_edit ? $course['language'] : 'English') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">Duration</label>
                                        <input type="text" class="form-control" id="duration" name="duration" value="<?= set_value('duration', $is_edit ? $course['duration'] : '') ?>" placeholder="e.g. 8 weeks, 4 hours">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="outcomes" class="form-label">Learning Outcomes</label>
                                <textarea class="form-control" id="outcomes" name="outcomes" rows="4" placeholder="What students will learn (one per line)"><?= set_value('outcomes', $is_edit ? $course['outcomes'] : '') ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="requirements" class="form-label">Requirements</label>
                                <textarea class="form-control" id="requirements" name="requirements" rows="4" placeholder="Prerequisites for this course (one per line)"><?= set_value('requirements', $is_edit ? $course['requirements'] : '') ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="draft" <?= set_select('status', 'draft', ($is_edit && $course['status'] == 'draft')) ?>>Draft</option>
                                            <option value="pending" <?= set_select('status', 'pending', ($is_edit && $course['status'] == 'pending')) ?>>Pending Review</option>
                                            <option value="published" <?= set_select('status', 'published', ($is_edit && $course['status'] == 'published')) ?>>Published</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Course Thumbnail</label>
                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                        <?php if ($is_edit && isset($course['thumbnail']) && !empty($course['thumbnail'])): ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url($course['thumbnail']) ?>" alt="Current Thumbnail" class="img-thumbnail" style="max-width: 200px;">
                                                <small class="text-muted d-block">Current thumbnail</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($is_edit): ?>
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" value="<?= $course['slug'] ?>" readonly disabled>
                                    <small class="text-muted">Slug cannot be changed after creation</small>
                                </div>
                            <?php endif; ?>
                            
                            <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Update Course' : 'Create Course' ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
