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

    <form id="editProductForm">
        <div class="form-group">
            <label for="name">Nama Produk:</label>
            <input type="text" class="form-control" id="name" name="nama" value="{{ $product->nama }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Produk:</label>
            <textarea class="form-control" id="description" name="deskripsi" rows="4" required>{{ $product->deskripsi }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Harga:</label>
            <input type="number" class="form-control" id="price" name="harga" value="{{ $product->harga }}" required>
        </div>

        <div class="form-group">
            <label for="category">Kategori:</label>
            <select class="form-control" id="category" name="kategori" required>
                <option value="Makanan" {{ $product->kategori == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="Minuman" {{ $product->kategori == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="Snack" {{ $product->kategori == 'Snack' ? 'selected' : '' }}>Snack</option>
                <option value="Dessert" {{ $product->kategori == 'Dessert' ? 'selected' : '' }}>Dessert</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="/edit-produk" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    document.getElementById('editProductForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const token = localStorage.getItem('token');
        if (!token) {
            alert('Token tidak ditemukan! Silakan login ulang.');
            return;
        }

        const productId = '{{ $product->id }}';

        // Ambil data dari input
        const form = e.target;
        const formData = {
            nama: form.name.value,
            deskripsi: form.description.value,
            harga: form.price.value,
            kategori: form.category.value,
        };

        try {
            const response = await fetch(`/api/products/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.ok) {
                alert('Produk berhasil diperbarui!');
                window.location.href = '/dashboard';
            } else {
                console.error(data);
                alert('Gagal memperbarui produk: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan saat mengirim data!');
        }
    });
</script>
</body>
</html>
