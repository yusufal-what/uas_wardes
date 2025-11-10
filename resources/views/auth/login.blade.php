{{-- 
    View: Halaman Login Customer
    File: resources/views/auth/login.blade.php
    Deskripsi: Form login untuk customer/user (bukan admin)
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Customer</title>
    <style>
        /* Reset default margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Styling body - center container */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Container utama */
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        /* Judul */
        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
            font-size: 28px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        /* Form group */
        .form-group {
            margin-bottom: 20px;
        }

        /* Label */
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        /* Input fields */
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }

        /* Error message */
        .error {
            color: #f44336;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* Success message */
        .success {
            background: #4CAF50;
            color: white;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        /* Checkbox remember me */
        .checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkbox input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
            cursor: pointer;
        }

        .checkbox label {
            margin-bottom: 0;
            font-weight: normal;
            cursor: pointer;
        }

        /* Button */
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Links */
        .links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .links a:hover {
            text-decoration: underline;
        }

        /* Admin link */
        .admin-link {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .admin-link a {
            color: #999;
            font-size: 12px;
            text-decoration: none;
        }

        .admin-link a:hover {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Judul halaman --}}
        <h2>🛒 Login</h2>
        <p class="subtitle">Masuk untuk melanjutkan belanja</p>

        {{-- Pesan sukses (misalnya setelah logout) --}}
        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form login --}}
        <form method="POST" action="{{ route('login.post') }}">
            @csrf {{-- CSRF token untuk keamanan --}}

            {{-- Input Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Masukkan email Anda"
                    required 
                    autofocus
                >
                {{-- Tampilkan error jika validasi gagal --}}
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Password --}}
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Masukkan password Anda"
                    required
                >
                {{-- Tampilkan error jika validasi gagal --}}
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Checkbox Remember Me --}}
            <div class="checkbox">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat Saya</label>
            </div>

            {{-- Tombol Login --}}
            <button type="submit">Login</button>
        </form>

        {{-- Link ke halaman register --}}
        <div class="links">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>

        {{-- Link ke admin login --}}
        <div class="admin-link">
            <a href="{{ route('admin.login') }}">Login sebagai Admin →</a>
        </div>
    </div>
</body>
</html>
