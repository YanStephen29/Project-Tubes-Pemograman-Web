<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food for Everyone</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to top right, #ff7105, #f6ccc2, #ff7105);
            overflow: hidden;
        }

        .center-image {
            max-width: 500px;
            max-height: 500px;
        }

        .loader {
            margin-top: 20px;
        }

        .progress-bar {
            width: 300px;
            height: 20px;
            background: #ddd;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            width: 0;
            background: #ff4500;
            animation: loading 3s forwards;
        }

        @keyframes loading {
            to {
                width: 100%;
            }
        }
    </style>
    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 3000);
    </script>
</head>
<body>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="center-image">
    <div class="loader">
        <div class="progress-bar">
            <div class="progress-bar-fill"></div>
        </div>
    </div>
</body>
</html>