<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snappix - Landing Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            color: #000;
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 3rem;
            border-bottom: 1px solid #ddd;
        }

        nav .logo {
            font-weight: bold;
            font-size: 1.5rem;
            color: #ff2c2c;
        }

        nav ul {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: black;
            font-weight: 500;
        }

        .auth-buttons a {
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            /* Animasi untuk semua perubahan */
        }

        .btn-login {
            background-color: red;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-signup {
            background-color: #ccc;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Efek hover */
        .btn-login:hover {
            background-color: #e60000;
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-signup:hover {
            background-color: #b3b3b3;
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }



        /* Hero Section */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 3rem;
            position: relative;
        }

        .hero .text-center {
            text-align: center;
            flex: 1;
            position: relative;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            font-weight: 400;
            margin: 0;
        }

        .hero .explore-btn {
            margin-top: 1rem;
            background-color: black;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 30px;
            border: none;
            cursor: pointer;
        }

        .side-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 280px;
            flex: 1 1 250px;
        }

        .side-item .text {
            margin-bottom: 15px;
            text-align: left;
        }

        .side-item .image img {
            width: 100%;
            border-radius: 20px;
            animation: fadeUp 1s ease-out forwards;
        }

        .side-item.left .image {
            margin-top: 50px;
            /* foto kiri turun */
        }

        .side-item.right .image {
            margin-top: 15px;
            /* foto kanan naik */
        }

        /* Background gradient in center */
        .bg-gradient {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 300px;
            height: 300px;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, rgba(255, 255, 255, 1) 0%, rgba(173, 216, 230, 0.4) 30%, rgba(255, 215, 0, 0.4) 60%);
            z-index: -1;
            border-radius: 50%;
            filter: blur(50px);
        }

        /* Animasi masuk dari bawah */
        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Terapkan animasi */
        .hero h1 {
            animation: fadeUp 1s ease-out forwards;
        }

        .side-image img {
            animation: fadeUp 1s ease-out forwards;
        }

        /* Biar kiri dan kanan beda delay */
        .side-image.left img {
            animation-delay: 0.3s;
        }

        .side-image.right img {
            animation-delay: 0.6s;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav>
        <div class="logo">Snappix</div>
        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn-signup">Sign up</a>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="hero">
        <!-- Left -->
        <div class="side-item left">
            <div class="text">
                <p class="caption">01 <br> Lorem ipsum dolor sit amet...</p>
            </div>
            <div class="image">
                <img src="{{ asset('storage/images/Hitam.png') }}" alt="Left Photo">
            </div>
        </div>

        <!-- Center -->
        <div class="text-center">
            <div class="bg-gradient"></div>
            <h1>Save Photos<br>You Like</h1>
        </div>

        <!-- Right -->
        <div class="side-item right">
            <div class="image">
                <img src="{{ asset('storage/images/Putih.png') }}" alt="Right Photo">
            </div>
            <div class="text">
                <p class="caption">02 <br> Lorem ipsum dolor sit amet...</p>
            </div>
        </div>
    </section>

</body>

</html>