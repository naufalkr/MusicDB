<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to YourApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .welcome-title {
            font-size: 48px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1db954;
        }

        .description {
            font-size: 18px;
            margin-bottom: 30px;
            color: #b3b3b3;
        }

        .btn {
            padding: 10px 30px;
            background-color: #1db954;
            color: #fff;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #18a74a;
        }

        .auth-links {
            margin-top: 20px;
        }

        .auth-links a {
            color: #b3b3b3;
            text-decoration: none;
            font-size: 16px;
            margin: 0 10px;
        }

        .auth-links a:hover {
            color: #fff;
        }

        footer {
            margin-top: 50px;
            font-size: 14px;
            color: #b3b3b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="welcome-title">Welcome to YourApp</h1>
        <p class="description">Stream music, podcasts, and more from your favorite artists.</p>
        <button class="btn">Get Started</button>
        <div class="auth-links">
            <a href="/login">Log In</a> |
            <a href="/register">Register</a>
        </div>
        <footer>
            &copy; 2024 YourApp. All rights reserved.
        </footer>
    </div>
</body>
</html>
