@if ($products->isEmpty())
    <p>No products found for this brand.</p>
@else
    <div class="mb-3">
        <label for="productId" class="form-label">Product</label>
        <select name="product_id" id="productId" class="form-control" required>
            <option value="">Select a Product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->title }}</option>
            @endforeach
        </select>
    </div>
@endif
