<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Register')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* Font family */
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('{{ asset('img/img1.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
        display: flex; /* Membuat elemen dalam kartu berjajar secara horizontal */
        flex-direction: row; /* Pastikan elemen berjajar kiri-kanan */
        background: rgba(255, 255, 255, 0.2); /* Transparansi */
        backdrop-filter: blur(10px); /* Efek Blur */
        border: none;
        border-radius: 25px; /* Sudut Tumpul */
        color: white;
        width: 100%;
        max-width: 1000px; /* Lebar maksimal */
        height: 700px; /* Tinggi persegi */
        overflow: hidden; /* Agar isi kartu tidak keluar */
    }

    .card-img {
        flex: 1; /* Gambar mengambil separuh kartu */
        max-width: 50%; /* Maksimal 50% lebar kartu */
        height: 100%; /* Tinggi penuh */
        object-fit: cover; /* Memastikan gambar tidak terdistorsi */
    }

    .card-body {
        flex: 1; /* Formulir mengambil separuh kartu */
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.1); /* Tambahan latar transparan untuk formulir */
    }
    .form-control {
        background: rgba(255, 255, 255, 0.5); /* Transparansi input */
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.7);
        color: black;
    }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
 
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card shadow-lg">
                <!-- Gambar di sisi kiri -->
                <img src="{{ asset('img/img3.jpg') }}" alt="Register" class="card-img">
            
                <!-- Formulir di sisi kanan -->
                <div class="card-body">
                    @yield('content')
                </div>
            </div>  
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
