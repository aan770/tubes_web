<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM Bulutangkis UINAM - Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .register-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #0d6efd, #0069d9);
            height: 100vh;
        }

        .register-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border-top: 3px solid #0d6efd;
        }

        .register-form h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 26px;
            color: #0d6efd;
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            border-color: #0069d9;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background-color: #0069d9;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0d6efd;
            border: none;
        }

        @media (max-width: 576px) {
            .register-form {
                padding: 30px;
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #004085;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">
                <img src="Screenshot 2024-11-01 035903.png" alt="Logo UKM Bulutangkis" style="width: 50px; height: 50px; border-radius: 50%;">
                UKM Bulutangkis UINAM
            </a>
        </div>
    </nav>

    <section class="register-section">
        <div class="container mt-5">
            <div class="register-form">
                <h2 class="text-center mb-4">Daftar Akun</h2>
                <?php
                session_start();
                if (isset($_SESSION['error'])) {
                    echo '<div style="color: red; font-weight: bold;">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
                <form action="register_process.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Pilih Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>
                <div class="mt-3 text-center">
                    <p>Sudah punya akun? <a href="login.php">Kembali ke Halaman Login</a></p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
