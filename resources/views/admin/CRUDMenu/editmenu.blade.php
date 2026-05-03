<h3>Edit Product</h3>

<form action="/products/updateProduct" method="POST">
    @csrf

    <input type="hidden" name="id" value="{{ $product->id }}">

    <input type="text" name="name" value="{{ $product->name }}" class="form-control mb-2">
    <input type="text" name="category" value="{{ $product->category }}" class="form-control mb-2">
    <input type="number" name="qty" value="{{ $product->qty }}" class="form-control mb-2">
    <input type="number" name="price" value="{{ $product->price }}" class="form-control mb-2">

    <button type="submit" class="btn btn-primary">Update</button>
</form>