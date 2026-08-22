<h1>Edit Product</h1>

<form action="{{ route('products.update', $product) }}" method="POST">

    @csrf
    @method('PUT')

    <input name="name" value="{{ old('name', $product->name) }}">

    <input name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}">

    <input name="quantity" type="number" value="{{ old('quantity', $product->quantity) }}">

    <button type="submit">Update</button>

</form>

<a href="{{ route('products.index') }}">Back</a>