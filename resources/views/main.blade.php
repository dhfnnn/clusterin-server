<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clusterin</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

    body {
        height: 100vh;
        width: 100%;
        background: rgb(15, 15, 15);
        overflow: hidden;
    }

    .logo {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 75%;
        min-width: 250px;
        max-width: 400px;
        z-index: 1;
    }


    .snowflake {
        position: absolute;
        top: -100px;
        color: white;
        font-size: 10px;
        user-select: none;
        pointer-events: none;
        animation: fall linear infinite;
    }

    #imgs {
        width: 40px;
        border-radius: 50%;
    }

    @keyframes fall {
        0% {
            transform: translateY(0);
            opacity: 1;
        }

        100% {
            transform: translateY(100vh);
            opacity: 0;
        }
    }
</style>

<body>
    <img src="{{ asset('images/logoRemove.png') }}" class="logo">

    <script>
        const snowflakeCount = 30;

        for (let i = 0; i < snowflakeCount; i++) {
            const snowflake = document.createElement('div');
            //snowflake.id = 'imgs';
            //snowflake.src = 'image.png';
            snowflake.classList.add('snowflake');
            snowflake.textContent = 'Wokekek';

            const size = Math.random() * 5 + 5; // Ukuran bola salju kecil (5-10px)
            snowflake.style.fontSize = `${size}px`;

            snowflake.style.left = `${Math.random() * 100}%`;
            snowflake.style.animationDuration = `${Math.random() * 5 + 5}s`; // 5-10 detik durasi jatuh
            snowflake.style.animationDelay = `${Math.random() * 10}s`;

            document.body.appendChild(snowflake);
        }
    </script>
</body>

</html>