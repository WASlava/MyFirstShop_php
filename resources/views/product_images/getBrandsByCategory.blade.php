<div class="mb-3" id="brandsDiv">
    <label for="brandId" class="control-label">Brands</label>
    <select name="brand_id" id="brandId" class="form-control" onchange="onBrandChange(event)">
        <option value="0">All</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
        @endforeach
    </select>
</div>
