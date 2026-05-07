<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome Back — SIPADI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --color-primary: #22C55E; /* Hijau sesuai desain */
            --color-primary-dark: #16A34A;
            --color-bg: #F8FAFC;
            --color-text-main: #0F172A;
            --color-text-muted: #64748B;
            --color-border: #E2E8F0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--color-text-main);
        }

        /* Container Card */
        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        /* Logo & Header */
        .logo-icon {
            color: var(--color-primary);
            font-size: 48px;
            margin-bottom: 16px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .header-subtitle {
            font-size: 14px;
            color: var(--color-text-muted);
            margin-bottom: 32px;
        }

        /* Form Styling */
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
        }

        .forgot-link {
            font-size: 12px;
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
        }

        .input-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            background-color: #fff;
            outline: none;
        }

        .input-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        /* Password Input Wrapper */
        .password-wrapper {
            position: relative;
        }

        .toggle-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-muted);
            cursor: pointer;
        }

        /* Checkbox */
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--color-text-muted);
            margin-bottom: 24px;
            cursor: pointer;
        }

        /* Button */
        .btn-sign-in {
            width: 100%;
            background-color: var(--color-primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-sign-in:hover {
            background-color: var(--color-primary-dark);
        }

        /* Dropdown/Select Styling */
        select.input-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748B'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-icon">
            <i class="ph-fill ph-plant"></i>
        </div>

        <h1 class="header-title">Welcome back</h1>
        <p class="header-subtitle">Enter your credentials to access your account</p>

        @if($errors->any())
            <div style="background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: left; display: flex; align-items: center; gap: 8px;">
                <i class="ph ph-warning-circle" style="font-size: 18px;"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('autentikasi.login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" id="username" class="input-control" placeholder="Masukkan username Anda" value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <div class="label-row">
                    <label class="form-label" for="password">Password</label>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" class="input-control" placeholder="••••••••" required>
                    <i class="ph ph-eye toggle-icon" id="toggle-pwd"></i>
                </div>
            </div>

            <label class="remember-me">
                <input type="checkbox" name="remember">
                Remember me for 30 days
            </label>

            <button type="submit" class="btn-sign-in">Sign in</button>
        </form>
    </div>

    <script>
        const togglePwd = document.getElementById('toggle-pwd');
        const pwdInput = document.getElementById('password');

        togglePwd.addEventListener('click', () => {
            const isPwd = pwdInput.type === 'password';
            pwdInput.type = isPwd ? 'text' : 'password';
            togglePwd.classList.toggle('ph-eye', !isPwd);
            togglePwd.classList.toggle('ph-eye-slash', isPwd);
        });
    </script>
</body>
</html>