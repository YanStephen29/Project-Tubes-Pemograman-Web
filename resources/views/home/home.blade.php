<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Are you Hungry?</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .no-shrink {
            flex-shrink: 0;
        }
    </style>
    <script>
        function scrollToVisionMission() {
            document.getElementById('vision-mission').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function scrollToFooter() {
            document.querySelector('footer').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    </script>
</head>
<body class="bg-white">
    <header class="w-full flex justify-between items-center px-5 bg-white fixed top-0 left-0 z-50">
        <img src="{{ asset('images/logo_warna.png') }}" alt="Logo" class="h-20">
        <nav>
            <ul class="flex space-x-4">
                <li>
                    <button onclick="scrollToVisionMission()" class="text-gray-700 hover:text-orange-500 font-semibold py-2 px-4 transition duration-300 ease-in-out">
                        About Us
                    </button>
                </li>
                <li>
                    <button onclick="scrollToFooter()" class="text-gray-700 hover:text-orange-500 font-semibold py-2 px-4 transition duration-300 ease-in-out">
                        Services
                    </button>
                </li>
                <li>
                    <button class="text-gray-700 hover:text-orange-500 font-semibold py-2 px-4 transition duration-300 ease-in-out">
                        Language
                    </button>
                </li>
            </ul>
        </nav>
    </header>

    <main class="flex flex-col items-center w-full mt-[80px]">
        <div class="w-full flex justify-center bg-orange-400 rounded-t-3xl">
            <div class="flex items-center justify-between max-w-7xl mx-auto px-10 py-10 w-full">
                <div class="flex flex-col space-y-6">
                    <h1 class="text-7xl font-bold text-white">Say No To<br>Food Waste</h1>
                    <div class="flex space-x-6">
                        <button onclick="location.href='{{ route('login') }}'" class="bg-white text-orange-400 font-bold px-8 py-3 rounded-full hover:bg-red-500 hover:text-white transition duration-300">SIGN IN</button>
                        <button onclick="location.href='{{ route('register.role') }}'" class="bg-white text-orange-400 font-bold px-8 py-3 rounded-full hover:bg-yellow-300 hover:text-white transition duration-300">SIGN UP</button>
                    </div>
                </div>
                <img src="{{ asset('images/home_awal.png') }}" alt="Food Waste Illustration" class="h-94 ml-auto">
            </div>
        </div>
    </main>

    <div id="vision-mission" class="my-8 mx-auto px-5 bg-gray-100 py-10">
        <div class="flex overflow-x-auto snap-x snap-mandatory whitespace-nowrap gap-8">
            <div id="vision" class="snap-center flex-shrink-0 w-auto max-w-[500px] px-16 py-12 bg-white shadow-lg rounded-lg border border-gray-200 mx-auto transform transition-transform duration-300 hover:scale-105">
                <i class="fas fa-eye text-orange-500 text-5xl mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-800 mt-4">Vision</h3>
                <p class="text-gray-600 mt-4 leading-relaxed">
                    To bring delicious food to everyone, everywhere.
                </p>
            </div>

            <div id="mission" class="snap-center flex-shrink-0 w-auto max-w-[500px] px-16 py-12 bg-white shadow-lg rounded-lg border border-gray-200 mx-auto transform transition-transform duration-300 hover:scale-105">
                <i class="fas fa-hands-helping text-orange-500 text-5xl mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-800 mt-4">Mission</h3>
                <p class="text-gray-600 mt-4 leading-relaxed">
                    Delivering quality food and happiness with every meal.
                </p>
            </div>

            <div id="goals" class="snap-center flex-shrink-0 w-auto max-w-[500px] px-16 py-12 bg-white shadow-lg rounded-lg border border-gray-200 mx-auto transform transition-transform duration-300 hover:scale-105">
                <i class="fas fa-bullseye text-orange-500 text-5xl mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-800 mt-4">Goals</h3>
                <p class="text-gray-600 mt-4 leading-relaxed">
                    Creating memorable dining experiences for our customers.
                </p>
            </div>
        </div>
    </div>
        
    <footer class="bg-orange-200 text-black text-center p-4 mt-8">
        <p class="font-bold">Connect with us:</p>
        <a href="https://instagram.com" target="_blank" class="mr-3 inline-flex items-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram Logo" class="h-6 w-6 mr-2">Instagram
        </a>
        <a href="https://wa.me" target="_blank" class="mr-3 inline-flex items-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp Logo" class="h-6 w-6 mr-2">WhatsApp
        </a>
        <a href="https://facebook.com" target="_blank" class="inline-flex items-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook Logo" class="h-6 w-6 mr-2">Facebook
        </a>
    </footer>
    
    
</body>
</html>
