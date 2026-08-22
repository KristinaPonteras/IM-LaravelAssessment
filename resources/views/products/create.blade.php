<h1>Add Product</h1>

<form action="{{ route('products.store') }}" method="POST">

    @csrf

    <input name="name" placeholder="Name" value="{{ old('name') }}">

    <input name="price" type="number" step="0.01" placeholder="Price" value="{{ old('price') }}">

    <input name="quantity" type="number" placeholder="Quantity" value="{{ old('quantity') }}">

    <button type="submit">Save</button>

</form>

<a href="{{ route('products.index') }}">Back</a>