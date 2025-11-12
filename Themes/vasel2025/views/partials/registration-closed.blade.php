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
                            {{ $message_en ?? 'Online registration for the VASEL 2025 Conference is now closed.' }}
                        </p>
                        <p class="text-muted mb-4">
                            <strong>{{ $message_vn ?? 'Cổng đăng ký trực tuyến Hội nghị VASEL 2025 đã đóng. Trân trọng
                                cảm ơn sự quan tâm của Quý vị.' }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>