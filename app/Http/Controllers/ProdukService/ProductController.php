<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Edit Produk</h2>

    <form id="editProductForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="productId" name="productId" value="{{ $productId }}">

        <div class="form-group">
            <label for="nama">Nama Produk:</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk:</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" class="form-control" id="harga" name="harga" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori:</label>
            <select class="form-control" id="kategori" name="kategori" required>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
                <option value="Snack">Snack</option>
                <option value="Dessert">Dessert</option>
            </select>
        </div>

        <div class="form-group">
            <label for="stock">Stok:</label>
            <input type="number" class="form-control" id="stock" name="stock">
        </div>

        <div class="form-group">
            <label for="image">Gambar Produk:</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Ambil ID produk dari URL
        const productId = "{{ $productId }}";

        // Ambil data produk dari API
        $.ajax({
            url: `/api/products/${productId}`,
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token') // Ganti dengan token yang sesuai
            },
            success: function(data) {
                // Isi form dengan data produk
                $('#nama').val(data.nama);
                $('#deskripsi').val(data.deskripsi);
                $('#harga').val(data.harga);
                $('#kategori').val(data.kategori);
                $('#stock').val(data.inventories.stock); // Asumsi bahwa stok ada di relasi inventories
            },
            error: function(xhr) {
                alert('Gagal mengambil data produk.');
            }
        });

        // Kirim form untuk memperbarui produk
        $('#editProductForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            $.ajax({
                url: `/api/products/${productId}`,
                method: 'PUT',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Ganti dengan token yang sesuai
                },
                success: function(response) {
                    alert('Produk berhasil diperbarui.');
                    window.location.href = "{{ route('products.index') }}"; // Redirect ke halaman daftar produk
                },
                error: function(xhr) {
                    alert('Gagal memperbarui produk.');
                }
            });
        });
    });
</script>
</body>
</html>