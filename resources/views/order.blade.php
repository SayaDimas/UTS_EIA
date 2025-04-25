<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="{{ asset('icon/fav.ico') }}" type="image/x-icon">
  <title>Orderan Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Orderan</h2>
    <a href="/dashboard" class="btn btn-secondary">Kembali ke Produk</a>
  </div>

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>User</th>
        <th>Jumlah</th>
        <th>Total Harga</th>
        <th>Status</th>
        <th>Ubah Status</th>
      </tr>
    </thead>
    <tbody id="order-table-body"></tbody>
  </table>
</div>

<script>
async function fetchOrders() {
  const token = localStorage.getItem('token');

  if (!token) {
    window.location.href = '/';
    return;
  }

  try {
    const response = await fetch('/api/orders', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });

    const orders = await response.json();

    const tableBody = document.getElementById('order-table-body');
    tableBody.innerHTML = '';

    orders.forEach(order => {
      const row = document.createElement('tr');

      row.innerHTML = `
        <td>${order.id}</td>
        <td>${order.product?.nama || '-'}</td>
        <td>${order.user?.name || '-'}</td>
        <td>${order.quantity}</td>
        <td>Rp${order.total_price}</td>
        <td><span class="badge bg-info">${order.status}</span></td>
        <td>
          <select class="form-select" onchange="updateStatus(${order.id}, this.value)">
            <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
            <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>processing</option>
            <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>completed</option>
            <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>cancelled</option>
          </select>
        </td>
      `;

      tableBody.appendChild(row);
    });

  } catch (error) {
    alert('Gagal mengambil data order: ' + error.message);
  }
}

async function updateStatus(orderId, newStatus) {
  const token = localStorage.getItem('token');

  try {
    const response = await fetch(`/api/orders/${orderId}/status`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ status: newStatus })
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Gagal mengubah status');
    }

    alert(`Status order #${orderId} diubah menjadi "${newStatus}"`);
    fetchOrders(); // Refresh data
  } catch (error) {
    alert('Gagal mengubah status: ' + error.message);
  }
}

fetchOrders();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
