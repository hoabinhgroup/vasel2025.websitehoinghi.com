<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Closed - VASEL 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Arial', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .card-body {
            padding: 3rem;
            text-align: center;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem auto;
            animation: pulse 2s infinite;
        }

        .icon-circle i {
            font-size: 2rem;
            color: white;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="icon-circle">
                            <i class="fas fa-times"></i>
                        </div>
                        <h2 class="text-danger mb-3">Registration Closed</h2>
                        <h4 class="text-muted mb-4">Đăng ký đã đóng</h4>
                        <p class="text-muted mb-4">
                            {{ $message_en ?? 'The registration period for VASEL 2025 has ended. We apologize for any
                            inconvenience.' }}
                        </p>
                        <p class="text-muted mb-4">
                            <strong>{{ $message_vn ?? 'Thời gian đăng ký cho VASEL 2025 đã kết thúc. Chúng tôi xin lỗi
                                vì sự bất tiện này.' }}</strong>
                        </p>
                        <div class="mt-4">
                            <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-home me-2"></i>
                                Back to Homepage / Về trang chủ
                            </a>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                For more information, please contact us at: <br>
                                <strong>info@vasel2025.com</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>