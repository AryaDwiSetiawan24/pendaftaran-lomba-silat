<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Peserta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">
</head>
<style>
    html {
        scroll-behavior: smooth;
    }
</style>

<body>
    <!-- Page wrapper -->
    <div class="min-h-screen bg-gray-100">
        <x-peserta.nav />
        <!-- Content area -->
        <main>
            <div class="max-w-7xl mx-auto px-4 py-8 pt-20">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
