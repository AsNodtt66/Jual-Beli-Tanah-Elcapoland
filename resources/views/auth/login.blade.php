<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - El Capo Land</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --elcapo-brown-dark: #4E2E1D;
            --elcapo-brown-light: #D8AE7E;
            --elcapo-brown-medium: #8D6B4F;
            --elcapo-cream: #F5E8D7;
            --elcapo-green: #5C7C4A;
        }
        
        body {
            background: linear-gradient(135deg, var(--elcapo-brown-light), var(--elcapo-brown-medium));
            height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-card {
            background: var(--elcapo-cream);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: 1px solid rgba(78, 46, 29, 0.1);
        }
        
        .brand-header {
            background: var(--elcapo-brown-dark);
            color: white;
            padding: 25px 20px;
            text-align: center;
        }
        
        .form-control:focus {
            border-color: var(--elcapo-brown-medium);
            box-shadow: 0 0 0 0.25rem rgba(141, 107, 79, 0.25);
        }
        
        .btn-elcapo {
            background-color: var(--elcapo-brown-dark);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-elcapo:hover {
            background-color: var(--elcapo-brown-medium);
            transform: translateY(-2px);
        }
        
        .elcapo-link {
            color: var(--elcapo-brown-dark);
            font-weight: 500;
            text-decoration: none;
        }
        
        .elcapo-link:hover {
            color: var(--elcapo-green);
            text-decoration: underline;
        }
        
        .form-check-input:checked {
            background-color: var(--elcapo-green);
            border-color: var(--elcapo-green);
        }

        .custom-notification {
            font-size: 1.1rem;
            text-align: center;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 25px;
            border-radius: 10px;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            font-family: 'Lora', serif;
            transition: all 0.5s ease;
            opacity: 0;
            transform: translate(-50%, -20px);
        }

        .custom-notification.success {
            background-color: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <div class="brand-header">
                        <h2 class="mb-1"><i class="bi bi-tree me-2"></i>ELCAPO LAND</h2>
                        <p class="mb-0">Platform Jual Beli Tanah Terpercaya</p>
                    </div>
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-center" style="color: var(--elcapo-brown-dark);">Login ke Akun Anda</h4>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div id="success-notification" class="custom-notification success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required autofocus value="{{ old('email') }}">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            
                            <button type="submit" class="btn btn-elcapo mb-4">Login</button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0">Belum punya akun? 
                                <a href="{{ route('register') }}" class="elcapo-link">Daftar sebagai Pembeli</a> atau 
                                <a href="{{ route('register') }}?role=seller" class="elcapo-link">Daftar sebagai Penjual</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan notifikasi
        function showCustomNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `custom-notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            // Animasi masuk
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translate(-50%, 0)';
            }, 10);

            // Hilang setelah 1 detik
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translate(-50%, -20px)';
                setTimeout(() => notification.remove(), 500);
            }, 1000);
        }

        // Cek apakah ada notifikasi sukses dari session
        @if (session('success'))
            showCustomNotification("{{ session('success') }}", 'success');

            // Tentukan URL redirect berdasarkan peran
            @auth
                setTimeout(() => {
                    window.location.href = "{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'buyer' ? route('buyer.dashboard') : route('seller.dashboard')) }}";
                }, 3500); // Delay redirect untuk melihat notifikasi
            @endauth
        @endif
    </script>
</body>
</html>