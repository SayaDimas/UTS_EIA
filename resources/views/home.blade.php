<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Home - Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      margin-bottom: 20px;
      border-radius: 1rem;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Produk</h2>
    <div>
      <a href="/add-product" class="btn btn-primary me-2">Tambah Produk</a>
      <button onclick="logout()" class="btn btn-danger">Logout</button>
    </div>
  </div>

  <div id="product-list" class="row"></div>
</div>

<script>
async function fetchProducts() {
  const token = localStorage.getItem('token');
  if (!token) {
    window.location.href = '/';
    return;
  }

  try {
    const response = await fetch('/api/products', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Gagal mengambil data produk');
    }

    const productList = document.getElementById('product-list');
    productList.innerHTML = '';

    data.forEach(product => {
      const card = document.createElement('div');
      card.className = 'col-md-4';
      card.innerHTML = `
        <div class="card p-3">
          <h5>${product.nama}</h5>
          <p>${product.deskripsi || 'Tidak ada deskripsi'}</p>
          <p><strong>Harga:</strong> Rp${product.harga}</p>
          <p><strong>Stok:</strong> ${product.inventories ? product.inventories.stock : 'Tidak tersedia'}</p>
          <a href="/edit-product/${product.id}" class="btn btn-warning">Edit</a>
        </div>
      `;
      productList.appendChild(card);
    });

  } catch (error) {
    alert('Error: ' + error.message);
  }
}

function logout() {
  localStorage.removeItem('token');
  window.location.href = '/';
}

fetchProducts();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>