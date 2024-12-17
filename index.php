<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Menentukan karakter set untuk halaman ini -->
    <meta charset="UTF-8">
    <!-- Menetapkan viewport agar halaman ini responsif pada berbagai perangkat -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Menentukan judul halaman -->
    <title>UKM Bulutangkis UINAM - Home</title>
    <!-- Menambahkan CSS Bootstrap dari CDN untuk gaya tampilan -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        /* Gaya untuk gambar di header */
        header img {
            max-width: 100%;
            height: auto;
            margin: 0 auto;
            border-radius: 10px;
        }

        /* Gaya untuk judul bagian */
        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0069d9;
        }

        /* Gaya untuk bagian about dan contact dengan animasi */
        .about, .contact {
            padding: 40px 0;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        /* Menambahkan animasi saat bagian about atau contact muncul */
        .about.show, .contact.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Gaya untuk galeri gambar */
        .image-gallery {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        /* Gaya untuk gambar di dalam galeri */
        .image-gallery img {
            max-width: 200px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Gaya untuk logo di navbar */
        .navbar-brand img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        /* Gaya untuk navbar dengan latar belakang biru */
        .navbar {
            background-color: #004085;
        }

        /* Gaya untuk teks di navbar */
        .navbar-brand {
            color: white;
        }

        /* Gaya untuk navbar ketika hover */
        .navbar-brand:hover {
            color: #f8f9fa;
        }

        /* Gaya untuk header dengan gradien warna */
        header {
            background: linear-gradient(135deg, #0069d9, #004085);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        /* Menambahkan padding dan posisi relatif untuk header */
        header {
            position: relative;
            text-align: center;
            padding: 5rem 0;
        }

        /* Gaya untuk gambar header dengan efek hover */
        header img {
            width: 50%;
            max-width: 600px;
            height: 5%;
            margin: 0 auto;
            border-radius: 8px;
            transition: transform 0.3s ease-in-out;
        }

        /* Efek saat gambar di header di-hover */
        header img:hover {
            transform: scale(1.05);
        }

        /* Gaya untuk judul dan teks di header dengan efek hover */
        header h1 {
            font-size: 3rem;
            font-weight: bold;
            transition: text-shadow 0.3s ease;
        }

        header .lead {
            font-size: 1.25rem;
            transition: text-shadow 0.3s ease;
        }

        /* Efek saat judul dan teks di header di-hover */
        header h1:hover, header .lead:hover {
            text-shadow: 2px 2px 8px #223d9480;
        }

        /* Efek untuk navbar saat menu di-hover */
        .navbar-nav .nav-link {
            transition: text-shadow 0.3s ease;
        }

        /* Efek saat link navbar di-hover */
        .navbar-nav .nav-link:hover {
            text-shadow: 2px 2px 8px #223d9480;
        }

        /* Gaya untuk footer */
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }

        /* Gaya untuk teks footer */
        footer p {
            margin-bottom: 0;
            color: #333;
        }

        /* Gaya khusus untuk perangkat dengan lebar maksimal 768px */
        @media (max-width: 768px) {
            /* Mengubah orientasi galeri gambar menjadi vertikal */
            .image-gallery {
                flex-direction: column;
                align-items: center;
            }

            /* Menyesuaikan ukuran gambar dalam galeri */
            .image-gallery img {
                max-width: 100%;
            }

            /* Menyesuaikan ukuran gambar header */
            header img {
                width: 80%;
                max-width: 400px;
            }

            /* Menyesuaikan ukuran font untuk judul header */
            header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar dengan brand dan menu navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <!-- Logo dan nama UKM Bulutangkis -->
            <a class="navbar-brand" href="#">
                <img src="Screenshot 2024-11-01 035903.png" alt="Logo UKM Bulutangkis">
                UKM Bulutangkis UINAM
            </a>
            <!-- Tombol untuk menampilkan menu navbar di perangkat kecil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Menu Home -->
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <!-- Menu About -->
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <!-- Menu Contact -->
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <!-- Menu Login -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header dengan gambar dan sambutan -->
    <header>
        <div class="container">
            <h1>Selamat Datang di UKM Bulutangkis UINAM!</h1>
            <p class="lead">Tempat berkumpul bagi pecinta olahraga bulutangkis. Bergabunglah untuk latihan dan berprestasi bersama kami!</p>
            <!-- Gambar yang digunakan di header -->
            <img src="Gambar WhatsApp 2024-12-17 pukul 16.02.49_c3b4cbca.jpg" class="img-fluid mb-4" alt="UKM Bulutangkis">
        </div>
    </header>

    <!-- Galeri gambar dengan beberapa gambar -->
    <section class="image-gallery">
        <div>
            <img src="Gambar WhatsApp 2024-11-01 pukul 04.21.09_0dcf6ff7.jpg" alt="Gambar 1">
        </div>
        <div>
            <img src="Gambar WhatsApp 2024-11-01 pukul 04.21.09_426874ca.jpg" alt="Gambar 2">
        </div>
        <div>
            <img src="Gambar WhatsApp 2024-11-01 pukul 04.21.09_ed48fd78.jpg" alt="Gambar 3">
        </div>
    </section>

    <!-- Bagian Tentang UKM Bulutangkis -->
    <section id="about" class="about bg-light">
        <div class="container">
            <h2 class="section-title text-center">Tentang UKM Bulutangkis UINAM</h2>
            <p class="text-center">UKM Bulutangkis UINAM adalah wadah bagi mahasiswa UINAM yang memiliki minat dan bakat dalam olahraga bulutangkis...</p>
        </div>
    </section>

    <!-- Bagian Kontak -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title text-center">Kontak Kami</h2>
            <p class="text-center">Jika Anda memiliki pertanyaan atau ingin bergabung dengan UKM Bulutangkis UINAM...</p>
            <!-- Informasi kontak -->
            <div class="row text-center">
                <div class="col-md-4">
                    <h5>Alamat</h5>
                    <p>Jalan H.M. Yasin Limpo No. 36, Kampus UINAM, Makassar, Indonesia</p>
                </div>
                <div class="col-md-4">
                    <h5>Telepon</h5>
                    <p>(0411) 123-4567</p>
                </div>
                <div class="col-md-4">
                    <h5>Email</h5>
                    <p>info@ukmbulutangkisuinam.ac.id</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer dengan hak cipta -->
    <footer>
        <p>&copy; 2024 UKM Bulutangkis. All Rights Reserved.</p>
    </footer>

    <!-- Script untuk Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk menambahkan animasi saat menggulir -->
    <script>
        function handleScroll() {
            const sections = document.querySelectorAll('.about, .contact');
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
                    section.classList.add('show');
                }
            });
        }
        window.addEventListener('scroll', handleScroll);
    </script>
</body>
</html>
