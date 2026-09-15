<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wanderlust Admin | Dashboard</title>

    <!-- Tailwind CSS & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0ea5e9', // Sky blue
                        secondary: '#10b981', // Emerald green
                        dark: '#0f172a',
                        surface: '#ffffff',
                        background: '#f8fafc', // Light grayish blue
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0,0,0,0.05)',
                        'card': '0 10px 40px -10px rgba(0,0,0,0.03)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar for a clean look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Chart Canvas Resize constraints */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .doughnut-container {
            position: relative;
            height: 250px;
            width: 100%;
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body
    class="font-sans text-gray-700 bg-background antialiased h-screen flex overflow-hidden selection:bg-primary selection:text-white">

    @include('admin.menu')

    <main class="w-full flex-1 flex flex-col h-screen overflow-hidden">
        <section class="w-full flex-1 flex flex-col h-full overflow-hidden">
            @yield('content')
        </section>
    </main>

</body>

</html>
