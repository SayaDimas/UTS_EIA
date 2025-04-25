<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page</title>
  <link rel="icon" href="{{ asset('icon/fav.ico') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
    }
    .login-container {
      min-height: 100vh;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="container login-container d-flex justify-content-center align-items-center">
  <div class="col-md-6 col-lg-4">
    <div class="card p-4">
      <h3 class="text-center mb-4">Login</h3>
      <form id="login-form">
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" required placeholder="Enter email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required placeholder="Enter password">
        </div>
        <div id="error-msg" class="text-danger text-center mb-3" style="display: none;"></div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="mt-3 text-center">
          <small>Belum punya akun? <a href="/register">Daftar di sini</a></small>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    function parseJwt(token) {
      const base64Url = token.split('.')[1];
      const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));

      return JSON.parse(jsonPayload);
    }

    document.getElementById('login-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      try {
        const response = await fetch('/api/auth/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (response.ok) {
          localStorage.setItem('token', data.access_token);

          const payload = parseJwt(data.access_token);
          if (payload && payload.sub) {
            localStorage.setItem('user_id', payload.sub);
          }

          window.location.href = '/dashboard'; // Redirect ke halaman dashboard
        } else {
          document.getElementById('error-msg').style.display = 'block';
          document.getElementById('error-msg').textContent = data.message || 'Login gagal.';
        }
      } catch (err) {
        document.getElementById('error-msg').style.display = 'block';
        document.getElementById('error-msg').textContent = 'Terjadi kesalahan jaringan.';
      }
    });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
