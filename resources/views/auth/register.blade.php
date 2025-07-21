<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - El Capo Land</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        
        .register-card {
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
            font-weight: 500;
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
        
        .role-selector {
            display: flex;
            margin-bottom: 25px;
            gap: 10px;
        }
        
        .role-option {
            flex: 1;
            text-align: center;
            padding: 15px 10px;
            border: 2px solid var(--elcapo-brown-dark);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            background-color: var(--elcapo-cream);
        }
        
        .role-option.active {
            background: var(--elcapo-brown-dark);
            color: white;
            border-color: var(--elcapo-brown-dark);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .role-option h5 {
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .role-option p {
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        .seller-fields {
            background: rgba(141, 107, 79, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-top: 15px;
        }
        
        .divider {
            height: 1px;
            background-color: rgba(78, 46, 29, 0.1);
            margin: 25px 0;
        }
        
        .custom-notification {
            font-size: 1.1rem;
            text-align: center;
        }
        
        .spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="register-card">
                    <div class="brand-header">
                        <h2 class="mb-1"><i class="bi bi-tree me-2"></i>ELCAPO LAND</h2>
                        <p class="mb-0">Platform Jual Beli Tanah Terpercaya</p>
                    </div>
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-center" style="color: var(--elcapo-brown-dark);">Daftar Akun Baru</h4>
                        
                        <div class="role-selector">
                            <div class="role-option {{ request()->input('role') !== 'seller' ? 'active' : '' }}" 
                                 data-role="buyer">
                                <h5>Pembeli</h5>
                                <p>Saya ingin mencari dan membeli tanah</p>
                            </div>
                            <div class="role-option {{ request()->input('role') === 'seller' ? 'active' : '' }}" 
                                 data-role="seller">
                                <h5>Penjual</h5>
                                <p>Saya ingin menjual tanah</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('register.process') }}" id="register-form">
                            @csrf
                            <input type="hidden" name="role" id="role-input" 
                                   value="{{ request()->input('role') === 'seller' ? 'seller' : 'buyer' }}">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-medium">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-medium">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-medium">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password-confirm" class="form-label fw-medium">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="seller-fields" style="{{ request()->input('role') === 'seller' ? '' : 'display:none;' }}">
                                <h5 class="mb-3" style="color: var(--elcapo-brown-dark);">Informasi Penjual</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="ktp" class="form-label fw-medium">Nomor KTP</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-card-text"></i></span>
                                            <input type="text" class="form-control" id="ktp" name="ktp" value="{{ old('ktp') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="npwp" class="form-label fw-medium">NPWP (Opsional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-receipt"></i></span>
                                            <input type="text" class="form-control" id="npwp" name="npwp" value="{{ old('npwp') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-text">
                                        <small>Dokumen akan diverifikasi oleh admin sebelum Anda dapat menjual tanah</small>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-elcapo mt-2" id="register-button">Daftar</button>
                        </form>
                        
                        <div class="divider"></div>
                        
                        <div class="text-center">
                            <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="elcapo-link">Login disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script untuk role selector
        document.querySelectorAll('.role-option').forEach(option => {
            option.addEventListener('click', function() {
                const role = this.getAttribute('data-role');
                
                // Update UI
                document.querySelectorAll('.role-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                this.classList.add('active');
                
                // Update hidden input
                document.getElementById('role-input').value = role;
                
                // Tampilkan/sembunyikan seller fields
                if (role === 'seller') {
                    document.querySelector('.seller-fields').style.display = 'block';
                } else {
                    document.querySelector('.seller-fields').style.display = 'none';
                }
            });
        });

        // Fungsi untuk notifikasi kustom
        function showCustomNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `custom-notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            // Styling dinamis
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.left = '50%';
            notification.style.transform = 'translateX(-50%)';
            notification.style.padding = '15px 25px';
            notification.style.borderRadius = '10px';
            notification.style.zIndex = '1000';
            notification.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.2)';
            notification.style.fontFamily = "'Lora', serif";
            notification.style.transition = 'all 0.5s ease';
            notification.style.opacity = '0';
            notification.style.transform = 'translate(-50%, -20px)';

            // Variasi warna berdasarkan tipe
            if (type === 'warning') {
                notification.style.backgroundColor = 'rgba(255, 193, 7, 0.9)';
                notification.style.color = '#333';
                notification.style.border = '2px solid #FFC107';
            } else if (type === 'success') {
                notification.style.backgroundColor = '#d4edda';
                notification.style.color = '#155724';
                notification.style.border = '2px solid #c3e6cb';
            } else if (type === 'error') {
                notification.style.backgroundColor = '#f8d7da';
                notification.style.color = '#721c24';
                notification.style.border = '2px solid #f5c6cb';
            }

            // Animasi masuk
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translate(-50%, 0)';
            }, 10);

            // Hilang setelah 5 detik
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translate(-50%, -20px)';
                setTimeout(() => notification.remove(), 500);
            }, 5000);
        }

        // Animasi loading untuk form register dan penanganan notifikasi
        document.getElementById('register-form').addEventListener('submit', function(e) {
            const button = document.getElementById('register-button');
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-arrow-repeat spin me-1"></i> Memproses...';

            // Kirim form menggunakan AJAX
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                button.disabled = false;
                button.innerHTML = 'Daftar';
                
                if (data.success) {
                    showCustomNotification(data.message || 'Pendaftaran berhasil bro! Silakan login.', 'success');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1000);
                } else {
                    showCustomNotification(data.message || 'Pendaftaran gagal bro! Coba lagi ya.', 'error');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                button.innerHTML = 'Daftar';
                showCustomNotification('Ada apa nih? Coba lagi nanti ya bro!', 'error');
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 5000);
            });
        });

        // Tampilkan notifikasi jika ada session success atau error
        @if (session('success'))
            showCustomNotification('{{ session('success') }}', 'success');
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 5000);
        @endif
        @if (session('error'))
            showCustomNotification('{{ session('error') }}', 'error');
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 5000);
        @endif
    </script>
</body>
</html>