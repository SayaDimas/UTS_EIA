<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="{{ asset('icon/fav.ico') }}" type="image/x-icon">
  <title>Tambah Stok</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      margin-top: 40px;
      border-radius: 1rem;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">Tambah Stok</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/add-produk">Tambah Produk</a>
          </li>
          <li class="nav-item">
            <button onclick="logout()" class="btn btn-danger">Logout</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="card p-4">
      <h3 class="mb-4">Tambah Stok untuk Produk</h3>
      <div id="product-info"></div>

      <form id="add-stock-form" class="mt-3">
        <div class="mb-3">
          <label for="stock" class="form-label">Jumlah Stok yang ingin ditambahkan</label>
          <input type="number" id="stock" class="form-control" min="1" placeholder="Masukkan jumlah stok" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>

  <script>
    const productId = window.location.pathname.split('/').pop(); // ambil ID dari URL
    const token = localStorage.getItem('token');

    if (!token) {
      window.location.href = '/';
    }

    async function fetchProduct() {
      try {
        const response = await fetch(`/api/products/${productId}`, {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        });

        const product = await response.json();

        if (!response.ok) throw new Error(product.message || 'Gagal memuat produk');

        const container = document.getElementById('product-info');
        container.innerHTML = `
          <h5>${product.nama}</h5>
          <p><strong>Deskripsi:</strong> ${product.deskripsi || '-'}</p>
          <p><strong>Kategori:</strong> ${product.kategori || '-'}</p>
          <p><strong>Harga:</strong> Rp${product.harga}</p>
          <p><strong>Stok Saat Ini:</strong> ${product.inventories?.stock ?? '0'}</p>
        `;
      } catch (err) {
        alert('Error: ' + err.message);
      }
    }

    document.getElementById('add-stock-form').addEventListener('submit', async (e) => {
      e.preventDefault();

      const stockQty = parseInt(document.getElementById('stock').value);
      if (!stockQty || stockQty <= 0) {
        return alert('Jumlah stok harus lebih dari 0');
      }

      try {
        const response = await fetch('/api/inventory/add-stock', {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            product_id: productId,
            stock: stockQty
          })
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Gagal menambah stok');

        alert('Stok berhasil ditambahkan!');
        window.location.href = '/dashboard';
      } catch (err) {
        alert('Error: ' + err.message);
      }
    });

    function logout() {
      localStorage.removeItem('token');
      window.location.href = '/';
    }

    fetchProduct();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
