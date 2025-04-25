<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Produk</h2>

    <form action="/api/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Produk:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->nama }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Produk:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $product->deskripsi }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Harga:</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->harga }}" required>
        </div>

        <div class="form-group">
            <label for="category">Kategori:</label>
            <select class="form-control" id="category" name="category" required>
                <option value="Makanan" {{ $product->kategori == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="Minuman" {{ $product->kategori == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="Snack" {{ $product->kategori == 'Snack' ? 'selected' : '' }}>Snack</option>
                <option value="Dessert" {{ $product->kategori == 'Dessert' ? 'selected' : '' }}>Dessert</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Gambar Produk:</label>
            <input type="file" class="form-control-file" id="image" name="image">
            @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="Preview" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="status" name="status" {{ $product->status ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Tampilkan di Menu</label>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="/edit-produk" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
