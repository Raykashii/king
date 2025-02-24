<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RapidCash</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .nav-link {
            color: #333;
            margin: 0 1rem;
        }
        
        .get-started-btn {
            background-color: #ffa500;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
        }
        
        .get-started-btn:hover {
            background-color: #ff9000;
            color: white;
        }
        
        .learn-more-btn {
            background-color: #ffa500;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-size: 1.1rem;
        }
        
        .learn-more-btn:hover {
            background-color: #ff9000;
            color: white;
        }
        
        .hero-title {
            color: #2d2d5f;
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        
        .hero-text {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 500px;
        }
        
        .hero-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">RapidCash</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="btn get-started-btn" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">RapidCash</h1>
                    <p class="hero-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget libero feugiat, 
                        faucibus libero id, scelerisque quam
                    </p>
                    <a href="#" class="btn learn-more-btn">Learn More</a>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/welcome.png') }}" alt="Digital Wallet Illustration" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>