<form method="post" action="<?= site_url('instructor/create_course') ?>">
    <input type="text" name="title" placeholder="Course Title" required />
    <textarea name="description" placeholder="Course Description"></textarea>
    <input type="number" name="price" placeholder="Price" required />
    <select name="category_id">
        <!-- Populate categories dynamically -->
        <option value="1">Category 1</option>
        <option value="2">Category 2</option>
    </select>
    <button type="submit">Create Course</button>
</form>
