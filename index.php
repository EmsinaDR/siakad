<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Memuat SIAKAD...</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            text-align: center;
            padding-top: 50px;
            background-color: #f0f2f5;
        }

        img.logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 20px;
        }

        h1 {
            margin-top: 10px;
            font-size: 24px;
            color: #333;
        }

        .tagline {
            font-size: 16px;
            color: #666;
            margin-bottom: 40px;
        }

        #progressContainer {
            width: 60%;
            max-width: 500px;
            background-color: #ddd;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        #progressBar {
            width: 0%;
            height: 30px;
            background: linear-gradient(to right, #4caf50, #81c784);
            color: #fff;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            transition: width 0.1s;
        }

        footer {
            margin-top: 60px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>

<body>

    <!-- 🔰 LOGO SEKOLAH -->
    <img src="http://localhost/siakad/public/img/logo.png" alt="Logo Sekolah" class="logo">
    <!-- <img src="http://localhost/siakad/public/img/Logo Siakad Ata Digital.png" alt="Logo Sekolah" class="logo"> -->


    <!-- 📣 TAGLINE -->
    <h1>🚀 Memuat Sistem SIAKAD</h1>
    <div class="tagline">"Melayani dengan data, membimbing dengan digital."</div>

    <!-- 🔄 PROGRESS BAR -->
    <div id="progressContainer">
        <div id="progressBar">0%</div>
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> - Sistem Akademik Sekolah Ata Digital | Laravel + Laragon
    </footer>

    <script>
        let progress = 0;
        const progressBar = document.getElementById("progressBar");

        const interval = setInterval(() => {
            progress++;
            progressBar.style.width = progress + "%";
            progressBar.textContent = progress + "%";

            if (progress >= 100) {
                clearInterval(interval);
                // 🔁 Redirect otomatis setelah selesai loading
                const baseURL = window.location.origin;
                const redirectTo = baseURL + "/siakad/public";
                window.location.href = redirectTo;
            }
        }, 20); // 20ms * 100 = 2 detik
    </script>

</body>

</html>