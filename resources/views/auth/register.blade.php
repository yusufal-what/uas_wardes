{{-- 
    View: Halaman Register Customer
    File: resources/views/auth/register.blade.php
    Deskripsi: Form registrasi untuk customer/user baru
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Customer</title>
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
            max-width: 450px;
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
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
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
            margin-top: 10px;
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

        /* Password info */
        .password-info {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Judul halaman --}}
        <h2>📝 Daftar</h2>
        <p class="subtitle">Buat akun baru untuk mulai belanja</p>

        {{-- Form registrasi --}}
        <form method="POST" action="{{ route('register.post') }}">
            @csrf {{-- CSRF token untuk keamanan --}}

            {{-- Input Nama Lengkap --}}
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="Masukkan nama lengkap Anda"
                    required 
                    autofocus
                >
                {{-- Tampilkan error jika validasi gagal --}}
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="contoh@email.com"
                    required
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
                    placeholder="Minimal 6 karakter"
                    required
                >
                <p class="password-info">Password minimal 6 karakter</p>
                {{-- Tampilkan error jika validasi gagal --}}
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Masukkan password yang sama"
                    required
                >
                <p class="password-info">Masukkan password yang sama dengan di atas</p>
            </div>

            {{-- Tombol Register --}}
            <button type="submit">Daftar Sekarang</button>
        </form>

        {{-- Link ke halaman login --}}
        <div class="links">
            Sudah punya akun? <a href="{{ route('login') }}">Login Sekarang</a>
        </div>
    </div>
</body>
</html>
