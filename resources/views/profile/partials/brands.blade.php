<div class="mb-3">
    <label for="brandId" class="form-label">Brand</label>
    <select name="brand_id" id="brandId" class="form-control" onchange="onBrandChange(event)">
        <option value="">Select a Brand</option>
        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
        @endforeach
    </select>
</div>
