<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="./assets/favicon.ico">
    <title>Document</title>
</head>
<body>
    <header>
        <?php include("../layout/navbar/navbar.html")?>
    </header>
    <main class="flex flex-row">
        <section class="border border-black mt-[65px]">
            <?php include("../layout/sidebar/sidebarAdmin.html")?>
        </section>
        <section class="w-full h-full flex justify-center items-center border border-black mt-[65px]">
            <h1>This is Admin Dashboard</h1>
        </section>
    </main>
</body>
</html>