<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Warung Desa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        .login-container img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 15px;
            color: #333;
        }
        label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            text-align: left;
            display: block;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- LOGO ADMIN -->
        <img src="{{ asset('images/wardes.JPG') }}" alt="Logo Warung Desa">
        
        <h2>WARDES</h2>
        
        @if ($errors->any())
            <div class="error">{{ $errors->first('login_error') }}</div>
        @endif
        
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <label for="email">Alamat Email</label>
            <input type="email" name="email" placeholder="Alamat Email" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">LOGIN</button>
        </form>
    </div>
</body>
</html>
