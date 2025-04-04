<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Gobierno')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
</head>

<body>
    @include('layouts.header')
    <div class="sidebar-mobile-overlay" id="sidebar-overlay"></div>
    @include('layouts.sidebar')
    <main class="content">
        @yield('content')
    </main>
    @include('layouts.footer')
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        let isMobile = window.innerWidth <= 992;
        const userProfile = document.querySelector('.user-profile');

        userProfile.addEventListener('click', function(e) {
            e.stopPropagation();
            userProfile.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (!userProfile.contains(e.target)) {
                userProfile.classList.remove('active');
            }
        });

        function checkMobile() {
            isMobile = window.innerWidth <= 992;
            if (!isMobile) {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            }
        }

        menuToggle.addEventListener('click', () => {
            if (isMobile) {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            }
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            ODA
        });

        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', () => {
                if (isMobile) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            });
        });

        window.addEventListener('resize', checkMobile);

        checkMobile();
    </script>
    @stack('scripts')
</body>

</html>
