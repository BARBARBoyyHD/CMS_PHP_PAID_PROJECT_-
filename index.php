<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="./assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Seblaktasti</title>
</head>
<body>
    <main class="min-h-screen flex flex-col md:flex-row">
       
        <section class="hidden md:flex md:w-[680px] w-full h-[680px] bg-[#982B1C] justify-center items-center">
            <img src="./assets/seblaktasti.png" alt="Seblaktasti" class="max-w-full max-h-full object-contain">
        </section>
       
        <section class="md:w-[680px] w-full h-[680px] flex justify-center items-center">
            <div class="w-auto h-auto flex flex-col justify-center items-center gap-2">
                <a href="php/login.php" class="w-[150px] h-[40px] rounded-[4px] flex justify-center items-center bg-[#982B1C] font-bold text-white hover:bg-red-700 transition">
                    Login as User
                </a>
                <a href="php/adminLogin.php" class="w-[150px] h-[40px] rounded-[4px] flex justify-center items-center  bg-[#982B1C]  font-bold text-white hover:bg-red-700 transition">
                    Login as Admin
                </a>
            </div>
        </section>
    </main>
</body>
</html>
