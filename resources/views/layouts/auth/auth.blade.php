<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
            width: 100%;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Decorative circles */
        body::before {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            left: -100px;
            animation: float 6s ease-in-out infinite;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -50px;
            right: -50px;
            animation: float 8s ease-in-out infinite reverse;
            z-index: 0;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(20px);
            }
        }

        .container-fluid {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 0;
        }

        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px 15px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            padding: 2rem 2rem 0.5rem;
            background: transparent !important;
        }

        .card-body {
            padding: 1.5rem 2rem 2rem;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 20px 12px 45px;
            font-size: 15px;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: 2.5rem;
        }

        /* PERBAIKAN KHUSUS ERROR MESSAGE */
        .invalid-feedback {
            display: block !important;
            width: 100%;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #dc3545;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            line-height: 1.4;
            padding: 0;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .header-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .input-icon {
            position: relative;
            width: 100%;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 18px;
            z-index: 10;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-icon input:focus~i {
            color: #764ba2;
            transform: translateY(-50%) scale(1.1);
        }

        .card-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        /* RESPONSIVE UNTUK MOBILE */
        @media (max-width: 576px) {
            body::before {
                width: 200px;
                height: 200px;
                top: -50px;
                left: -50px;
            }

            body::after {
                width: 150px;
                height: 150px;
                bottom: -30px;
                right: -30px;
            }

            .login-wrapper {
                padding: 15px 12px;
            }

            .login-card {
                border-radius: 18px;
                max-width: 100%;
            }

            .card-header {
                padding: 1.5rem 1.25rem 0.5rem;
            }

            .card-body {
                padding: 1.25rem 1.25rem 1.5rem;
            }

            .header-icon {
                width: 60px;
                height: 60px;
                margin-bottom: 15px;
            }

            .header-icon i {
                font-size: 30px !important;
            }

            .card-title {
                font-size: 1.35rem !important;
            }

            .card-header p {
                font-size: 0.85rem !important;
                margin-top: 0.5rem !important;
            }

            .form-control {
                font-size: 14px;
                padding: 11px 15px 11px 42px;
                border-radius: 10px;
            }

            .input-icon i {
                left: 13px;
                font-size: 16px;
            }

            .btn-login {
                padding: 12px;
                font-size: 15px;
                border-radius: 10px;
            }

            .invalid-feedback {
                font-size: 0.8rem;
                line-height: 1.3;
                margin-top: 0.4rem;
            }

            .mb-3 {
                margin-bottom: 1rem !important;
            }

            .mb-4 {
                margin-bottom: 1.25rem !important;
            }
        }

        /* EXTRA SMALL DEVICES */
        @media (max-width: 375px) {
            .login-wrapper {
                padding: 12px 10px;
            }

            .login-card {
                border-radius: 16px;
            }

            .card-header {
                padding: 1.25rem 1rem 0.5rem;
            }

            .card-body {
                padding: 1rem 1rem 1.25rem;
            }

            .header-icon {
                width: 55px;
                height: 55px;
                margin-bottom: 12px;
            }

            .header-icon i {
                font-size: 26px !important;
            }

            .card-title {
                font-size: 1.2rem !important;
            }

            .card-header p {
                font-size: 0.8rem !important;
            }

            .form-control {
                font-size: 13px;
                padding: 10px 12px 10px 40px;
            }

            .input-icon i {
                font-size: 15px;
                left: 12px;
            }

            .btn-login {
                padding: 11px;
                font-size: 14px;
            }

            .invalid-feedback {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    @yield('content')
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>

</html>
