<?php
session_start();
// $koneksi = mysqli_connect("localhost", "tkbmyid_user_air", "#Us3r_A1r_2025#", "tkbmyid_air_gentara");
// if ($koneksi) echo "koneksi berhasil....";
// else echo "gagal....";

include './assets/funch.php';
$air = new klas_air;
$koneksi = $air->koneksi();

//memasukan data ke tabel user
// $pass = password_hash("warga", PASSWORD_DEFAULT);
// mysqli_query($koneksi, "INSERT INTO akun(username,password,nama,alamat,kota,tlp,level,tipe,status) VALUES ('warga3','$pass','warga','polines','Semarang','0241111','warga','-','AKTIF')");
// if (mysqli_affected_rows($koneksi) > 0) echo "Data berhasil masuk......";
// else echo "gagal....";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="./styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            margin-top: 4rem;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .form-control {
            border-radius: 0.75rem;
        }

        .btn-primary {
            border-radius: 0.75rem;
            background-color: #6a11cb;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4b09a7;
        }

        .register-text {
            margin-top: 1rem;
            text-align: center;
        }

        .alert {
            border-radius: 0.5rem;
        }

        footer {
            color: white;
            text-align: center;
            padding: 2rem 0 1rem;
            padding-top: 5rem;
        }
    </style>
    </head>
    <body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4">
                <h3 class="text-center mb-4 fw-bold text-primary">Login</h3>

                <?php
                if (isset($_POST['tombol'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $qc = mysqli_query($koneksi, "SELECT username, password FROM akun WHERE username='$username'");
                    $dc = mysqli_fetch_row($qc);

                    if (!empty($dc[0])) {
                        $pass_cek = $dc[1];
                        if (password_verify($password, $pass_cek)) {
                            $_SESSION['user'] = $username;
                            $_SESSION['pass'] = $password;
                            echo "<script>window.location.replace('./login/index.php')</script>";
                        } else {
                            echo '<div class="alert alert-danger">Password salah</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning">Username tidak ditemukan</div>';
                    }
                }
                ?>

                <form method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="username" id="floatingUser" placeholder="Username" required>
                        <label for="floatingUser">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="d-grid">
                        <input type="submit" name="tombol" value="Login" class="btn btn-primary">
                    </div>
                </form>

                <div class="register-text">
                    <p class="mt-3">Don't have an account? <a href="./registration.php" class="text-decoration-none text-primary fw-semibold">Sign up now!</a></p>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-4">
    <div class="text-center small text-white" style="color:white;">
      &copy; AquaPay <?= date("Y") ?>. All rights reserved.
    </div>
    </footer>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
