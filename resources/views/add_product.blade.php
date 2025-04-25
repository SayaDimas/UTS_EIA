<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
  <h2>Tambah Produk</h2>

  <form id="product-form">
    <div class="form-group">
      <label for="name">Nama Produk:</label>
      <input type="text" class="form-control" id="name" name="nama" required>
    </div>

    <div class="form-group">
      <label for="category">Kategori:</label>
      <select class="form-control" id="category" name="kategori" required>
        <option value="makanan">Makanan</option>
        <option value="minuman">Minuman</option>
        <option value="snack">Snack</option>
        <option value="dessert">Dessert</option>
      </select>
    </div>

    <div class="form-group">
      <label for="description">Deskripsi Produk:</label>
      <textarea class="form-control" id="description" name="deskripsi" rows="4" required></textarea>
    </div>

    <div class="form-group">
      <label for="price">Harga:</label>
      <input type="number" class="form-control" id="price" name="harga" required>
    </div>

    <button type="submit" class="btn btn-primary">Tambah Produk</button>
    <a href="index.html" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
document.getElementById('product-form').addEventListener('submit', async function (e) {
  e.preventDefault();

  const token = localStorage.getItem('token');
  if (!token) {
    alert('Anda belum login!');
    return;
  }

  const form = e.target;
  const formData = new FormData(form);

  try {
    const response = await fetch('/api/products', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`
      },
      body: formData
    });

    const result = await response.json();

    if (!response.ok) {
      throw new Error(result.message || 'Gagal menambahkan produk');
    }

    alert('Produk berhasil ditambahkan!');
    form.reset();
    window.location.href = 'index.html';

  } catch (error) {
    alert('Error: ' + error.message);
  }
});
</script>
</body>
</html>
