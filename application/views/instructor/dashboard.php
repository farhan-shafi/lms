<h2>My Courses</h2>
<?php if (!empty($courses)): ?>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li>
                <?= $course['title'] ?> - <?= $course['status'] ?>
                <a href="<?= site_url('instructor/edit_course/' . $course['id']) ?>">Edit</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No courses found. <a href="<?= site_url('instructor/create_course') ?>">Create a new course</a>.</p>
<?php endif; ?>
