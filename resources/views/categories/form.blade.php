<form action="{{ route($route, $category->id ?? '') }}" method="POST">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div class="form-group">
        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" id="category_name" class="form-control" value="{{ old('category_name', $category->category_name ?? '') }}">
    </div>

    <div class="form-group">
        <label for="parent_category_id">Parent Category</label>
        <select name="parent_category_id" id="parent_category_id" class="form-control">
            <option value="">No Parent</option>
            @foreach($parentCategories as $parentCategory)
                <option value="{{ $parentCategory->id }}" {{ (old('parent_category_id') ?? ($category->parent_category_id ?? '')) == $parentCategory->id ? 'selected' : '' }}>
                    {{ $parentCategory->category_name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
