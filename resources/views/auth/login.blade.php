<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RapidCash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff9900;
            --primary-hover: #e68a00;
            --secondary-color: #2d2d4b;
            --success-color: #28a745;
            --success-hover: #218838;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes float {
            0% {
                transform: translatey(0px);
            }
            50% {
                transform: translatey(-20px);
            }
            100% {
                transform: translatey(0px);
            }
        }

        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            animation: float 6s ease-in-out infinite;
        }

        .login-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .login-box h2 {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 2rem;
            font-size: 2rem;
            text-align: center;
            position: relative;
        }

        .login-box h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .form-control {
            padding: 1rem 1.2rem;
            border: 2px solid #eee;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 153, 0, 0.25);
            transform: translateY(-2px);
        }

        .input-group {
            position: relative;
            margin-bottom: 1.8rem;
        }

        .input-group i {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            transition: all 0.3s ease;
        }

        .input-group:focus-within i {
            color: var(--primary-color);
        }

        .input-group input {
            padding-left: 3rem;
        }

        .btn {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:active::before {
            width: 400px;
            height: 400px;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
            border: none;
            box-shadow: 0 4px 15px rgba(255, 153, 0, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--primary-hover), var(--primary-color));
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 153, 0, 0.4);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-register {
            background: linear-gradient(45deg, var(--success-color), var(--success-hover));
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-register:hover {
            background: linear-gradient(45deg, var(--success-hover), var(--success-color));
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }

        .btn-register:active {
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .divider {
            margin: 2rem 0;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        .divider span {
            padding: 0 1.5rem;
            color: #777;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* Custom floating bubbles background */
        .bubbles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            top: 0;
            left: 0;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            opacity: 0.5;
            animation: rise 10s infinite ease-in;
        }

        .bubble:nth-child(1) {
            width: 40px;
            height: 40px;
            left: 10%;
            animation-duration: 8s;
        }

        .bubble:nth-child(2) {
            width: 20px;
            height: 20px;
            left: 20%;
            animation-duration: 5s;
            animation-delay: 1s;
        }

        .bubble:nth-child(3) {
            width: 50px;
            height: 50px;
            left: 35%;
            animation-duration: 7s;
            animation-delay: 2s;
        }

        .bubble:nth-child(4) {
            width: 80px;
            height: 80px;
            left: 50%;
            animation-duration: 11s;
            animation-delay: 0s;
        }

        .bubble:nth-child(5) {
            width: 35px;
            height: 35px;
            left: 55%;
            animation-duration: 6s;
            animation-delay: 1s;
        }

        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                transform: translate(100px, -500px);
            }
            100% {
                bottom: 1080px;
                transform: translateX(-200px);
            }
        }

        @media (max-width: 576px) {
            .login-box {
                padding: 2rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background bubbles -->
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h2>Welcome to RapidCash</h2>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Enter your email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Enter your password" 
                           name="password" 
                           required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>
     </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>