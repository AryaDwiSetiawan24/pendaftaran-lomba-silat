<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">
</head>

<body>
    <!-- Page wrapper -->
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <x-admin.header />

        <div class="flex flex-1 pt-16 flex-col md:flex-row">
            <x-admin.sidebar />

            <main class="flex-1">
                <!-- Content area -->
                <div class="p-4 lg:ml-60 md:ml-60 sm:p-6 md:p-8">
                    <!-- Alert -->
                    <x-alert />

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>
