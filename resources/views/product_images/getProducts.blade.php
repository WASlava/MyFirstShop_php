<div class="mb-3" id="productsDiv">
    <label for="productId" class="control-label">Products</label>
    <select name="product_id" id="productId" class="form-control">
        <option value="0">All</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->title }}</option>
        @endforeach
    </select>
</div>
