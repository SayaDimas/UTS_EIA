<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>{{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}</h2>

    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Nama Produk:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ isset($product) ? $product->name : '' }}" required>
        </div>

        <div class="form-group">
            <label for="category">Kategori:</label>
            <select class="form-control" id="category" name="category" required>
                <option value="Makanan" {{ (isset($product) && $product->category == 'Makanan') ? 'selected' : '' }}>Makanan</option>
                <option value="Minuman" {{ (isset($product) && $product->category == 'Minuman') ? 'selected' : '' }}>Minuman</option>
                <option value="Snack" {{ (isset($product) && $product->category == 'Snack') ? 'selected' : '' }}>Snack</option>
                <option value="Dessert" {{ (isset($product) && $product->category == 'Dessert') ? 'selected' : '' }}>Dessert</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Gambar Produk:</label>
            <input type="file" class="form-control-file" id="image" name="image">
            @if(isset($product) && $product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Preview" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Produk:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ isset($product) ? $product->description : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Harga:</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ isset($product) ? $product->price : '' }}" required>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="status" name="status" {{ (isset($product) && $product->status) ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Tampilkan di Menu</label>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>