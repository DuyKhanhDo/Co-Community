<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không tìm thấy trang - Comovie Admin</title>
    <style>
        :root {
            --primary-color: #1a1d29;
            --secondary-color: #0095ff;
            --accent-color: #ff3d71;
            --background-color: #f5f6fa;
            --text-color: #2a2a2a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            text-align: center;
        }

        .error-container {
            max-width: 600px;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .error-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .error-message {
            font-size: 18px;
            margin-bottom: 30px;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: var(--secondary-color);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0077cc;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">Không tìm thấy trang</h1>
        <p class="error-message">Trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.</p>
        <a href="<?php echo BASE_URL; ?>" class="btn">Quay lại Trang chủ</a>
    </div>
</body>

</html>