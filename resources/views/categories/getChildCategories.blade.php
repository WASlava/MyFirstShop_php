<div class="form-group">
    <select name="ParentCategoryId[]" class="form-control">
        <option value="0">None</option>
        <?php foreach ($categories as $category): ?>
        <option value="<?= $category->id; ?>"><?= $category->category_name; ?></option>
        <?php endforeach; ?>
    </select>
</div>

