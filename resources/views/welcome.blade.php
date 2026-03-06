<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUMINA • Feasts</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&amp;family=Inter:wght@400&amp;family=Inter:wght@500&amp;family=Inter:wght@600&amp;display=swap');
        
        :root {
            --accent: 245 158 11;
        }

        .tail-text {
            font-family: "Playfair Display", sans-serif;
        }

        .hero-bg {
            background: linear-gradient(135deg, #451a03 0%, #052e16 100%);
        }

        .nav-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link:hover {
            color: rgb(245 158 11);
            transform: translateY(-2px);
        }

        .dish-card {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .dish-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 25px 50px -12px rgb(0 0 0);
        }

        .tab-active {
            border-bottom: 3px solid rgb(245 158 11);
            color: rgb(245 158 11);
        }

        .floating-leaf {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        .section-header {
            position: relative;
        }

        .section-header:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 2px;
            background: rgb(245 158 11);
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
        }

        .food-particle {
            position: absolute;
            font-size: 18px;
            opacity: 0.15;
            pointer-events: none;
            animation: particleFloat 25s linear infinite;
            z-index: 1;
        }

        .menu-item-dot {
            width: 6px;
            height: 6px;
            background: rgb(245 158 11);
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .success-toast {
            animation: toastPop 0.4s ease forwards;
        }

        .hero-plate {
            animation: plateRotate 20s linear infinite;
        }
    </style>
</head>
<body class="bg-stone-50 text-stone-900 font-sans overflow-x-hidden">
    
    <!-- TAILWIND SCRIPT ALREADY INCLUDED VIA CDN -->

    <!-- NAVBAR -->
    <nav id="navbar" 
         class="bg-white border-b border-stone-100 backdrop-blur-lg bg-opacity-90 sticky top-0 z-50 transition-all">
        <div class="max-w-screen-2xl mx-auto">
            <div class="px-8 py-5 flex items-center justify-between">
                
                <!-- LOGO -->
                <div onclick="navigateToSection('hero')" 
                     class="flex items-center gap-x-2 cursor-pointer">
                    <div class="w-9 h-9 bg-gradient-to-br from-amber-400 to-emerald-500 rounded-2xl flex items-center justify-center text-white text-xs font-bold shadow-inner">
                        L
                    </div>
                    <div>
                        <span class="tail-text text-3xl font-semibold tracking-tighter">LUMINA</span>
                    </div>
                </div>

                <!-- DESKTOP MENU -->
                <div class="hidden md:flex items-center gap-x-8 text-sm font-medium">
                    <a onclick="navigateToSection('hero')" 
                       class="nav-link cursor-pointer text-stone-500 hover:text-stone-900">HOME</a>
                    <a onclick="navigateToSection('menu')" 
                       class="nav-link cursor-pointer text-stone-500 hover:text-stone-900">MENUS</a>
                    <a onclick="navigateToSection('events')" 
                       class="nav-link cursor-pointer text-stone-500 hover:text-stone-900">EVENTS</a>
                    <a onclick="navigateToSection('about')" 
                       class="nav-link cursor-pointer text-stone-500 hover:text-stone-900">OUR STORY</a>
                    <a onclick="navigateToSection('testimonials')" 
                       class="nav-link cursor-pointer text-stone-500 hover:text-stone-900">STORIES</a>
                </div>

                <div class="flex items-center gap-x-4">
                    <button onclick="showQuoteModal()" 
                            class="bg-white text-xs font-semibold border border-amber-300 hover:border-amber-400 transition-colors px-5 py-2.5 rounded-3xl flex items-center gap-x-2 shadow-sm">
                        <i class="fa-regular fa-calendar text-amber-500"></i>
                        <span>GET QUOTE</span>
                    </button>

                    <!-- MOBILE HAMBURGER -->
                    <button id="mobile-menu-btn"
                            class="md:hidden w-10 h-10 flex items-center justify-center text-stone-700">
                        <i id="hamburger-icon" class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- MOBILE MENU -->
        <div id="mobile-menu" class="hidden md:hidden max-w-screen-2xl mx-auto bg-white border-t px-8 py-6">
            <div class="flex flex-col gap-y-5 text-lg font-medium">
                <a onclick="mobileNavClick('hero')" 
                   class="py-2 border-b border-stone-100">Home</a>
                <a onclick="mobileNavClick('menu')" 
                   class="py-2 border-b border-stone-100">Menus</a>
                <a onclick="mobileNavClick('events')" 
                   class="py-2 border-b border-stone-100">Events</a>
                <a onclick="mobileNavClick('about')" 
                   class="py-2 border-b border-stone-100">Our Story</a>
                <a onclick="mobileNavClick('testimonials')" 
                   class="py-2">Stories</a>
            </div>
            
            <button onclick="mobileQuoteClick()" 
                    class="mt-8 w-full bg-amber-500 text-white font-semibold py-4 rounded-3xl flex items-center justify-center gap-x-3">
                <i class="fa-regular fa-paper-plane"></i>
                <span>Request a Quote</span>
            </button>
        </div>
    </nav>

    <!-- HERO -->
    <header id="hero" 
            class="hero-bg min-h-screen flex items-center relative overflow-hidden">
        
        <!-- DECORATIVE PARTICLES -->
        <div class="food-particle text-amber-300 top-[15%] left-[10%]">🍃</div>
        <div class="food-particle text-emerald-300 top-[25%] right-[15%] animation-delay-3000">🍓</div>
        <div class="food-particle text-amber-300 bottom-[30%] left-[20%] animation-delay-8000">🥑</div>
        <div class="food-particle text-emerald-300 top-[60%] right-[25%] animation-delay-12000">🍇</div>
        
        <div class="max-w-screen-2xl mx-auto px-8 grid md:grid-cols-12 gap-12 items-center relative z-10">
            <div class="md:col-span-7">
                <div class="inline-flex items-center gap-x-2 bg-white bg-opacity-10 text-white text-xs font-medium tracking-[1px] px-4 py-2 rounded-3xl mb-6 backdrop-blur-md">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                    SEASONAL • FRESH • ELEVATED
                </div>
                
                <h1 class="text-6xl md:text-7xl font-semibold text-white leading-none tracking-tighter tail-text">
                    CRAFTING MOMENTS<br>THAT TASTE LIKE <span class="text-amber-300">GOLD</span>
                </h1>
                
                <p class="mt-6 text-xl text-amber-100 max-w-md">
                    Premium catering for weddings, corporate events, 
                    and intimate celebrations.
                </p>
                
                <div class="flex items-center gap-x-4 mt-12">
                    <button onclick="navigateToSection('menu')" 
                            class="bg-white text-stone-900 font-semibold px-10 py-6 rounded-3xl flex items-center gap-x-3 hover:shadow-2xl transition-all active:scale-95">
                        <span>EXPLORE MENUS</span>
                        <i class="fa-solid fa-arrow-right text-lg"></i>
                    </button>
                    
                    <button onclick="showQuoteModal()" 
                            class="border border-white border-opacity-40 hover:border-opacity-70 text-white font-medium px-8 py-6 rounded-3xl transition-all">
                        BOOK YOUR EVENT
                    </button>
                </div>
                
                <div class="mt-16 flex items-center gap-x-8 text-xs text-amber-200">
                    <div class="flex -space-x-3">
                        <div class="w-6 h-6 bg-white rounded-2xl flex items-center justify-center text-xs shadow">🌿</div>
                        <div class="w-6 h-6 bg-white rounded-2xl flex items-center justify-center text-xs shadow">🍷</div>
                    </div>
                    <div>
                        <span class="font-medium">Trusted by 240+ events this year</span>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SIDE VISUAL -->
            <div class="md:col-span-5 hidden md:flex justify-end">
                <div class="relative">
                    <div class="w-80 h-80 bg-white bg-opacity-10 backdrop-blur-3xl rounded-[4rem] flex items-center justify-center border border-white border-opacity-20 hero-plate">
                        <div class="text-center">
                            <div class="text-8xl mb-3">🍽️</div>
                            <div class="text-white text-sm font-medium tracking-widest">CURATED FOR YOU</div>
                        </div>
                    </div>
                    
                    <!-- floating badges -->
                    <div class="absolute -top-4 -right-4 bg-white text-stone-900 text-xs font-semibold shadow-xl px-4 py-2 rounded-3xl flex items-center gap-x-2">
                        <i class="fa-solid fa-leaf text-emerald-500"></i>
                        <span>FARM TO TABLE</span>
                    </div>
                    
                    <div class="absolute -bottom-6 -left-6 bg-white text-stone-900 text-xs font-semibold shadow-xl px-4 py-2 rounded-3xl flex items-center gap-x-2 rotate-[-8deg]">
                        <i class="fa-solid fa-star text-amber-500"></i>
                        <span>5.0 EXPERIENCE</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute bottom-12 left-1/2 flex flex-col items-center text-white text-xs tracking-widest">
            <div class="animate-bounce">↓</div>
            <span class="mt-1 opacity-60">SCROLL TO DISCOVER</span>
        </div>
    </header>

    <!-- TRUST BAR -->
    <div class="bg-white py-5 border-b">
        <div class="max-w-screen-2xl mx-auto px-8">
            <div class="flex flex-wrap items-center justify-center gap-x-12 gap-y-6 opacity-75 text-sm">
                <div class="flex items-center gap-x-2">
                    <i class="fa-regular fa-circle-check text-emerald-500"></i>
                    <span class="font-medium">Locally sourced</span>
                </div>
                <div class="flex items-center gap-x-2">
                    <i class="fa-regular fa-circle-check text-emerald-500"></i>
                    <span class="font-medium">Custom menus</span>
                </div>
                <div class="flex items-center gap-x-2">
                    <i class="fa-regular fa-circle-check text-emerald-500"></i>
                    <span class="font-medium">Zero waste focus</span>
                </div>
                <div class="flex items-center gap-x-2">
                    <i class="fa-regular fa-circle-check text-emerald-500"></i>
                    <span class="font-medium">Full service staff</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MENU SECTION -->
    <section id="menu" class="max-w-screen-2xl mx-auto px-8 py-24">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 text-xs font-semibold bg-amber-100 text-amber-700 rounded-3xl">SIGNATURE MENUS</span>
            <h2 class="tail-text text-5xl font-semibold tracking-tighter mt-3">Our Culinary Collections</h2>
        </div>
        
        <!-- TABS -->
        <div class="flex justify-center mb-12 border-b border-stone-200">
            <div onclick="switchMenuTab(0)" 
                 id="tab-0"
                 class="tab px-8 py-4 font-medium cursor-pointer tab-active flex items-center gap-x-2">
                <span>STARTERS</span>
            </div>
            <div onclick="switchMenuTab(1)" 
                 id="tab-1"
                 class="tab px-8 py-4 font-medium cursor-pointer flex items-center gap-x-2">
                <span>MAINS</span>
            </div>
            <div onclick="switchMenuTab(2)" 
                 id="tab-2"
                 class="tab px-8 py-4 font-medium cursor-pointer flex items-center gap-x-2">
                <span>DESSERTS</span>
            </div>
        </div>
        
        <!-- MENU GRID -->
        <div id="menu-grid" 
             class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Populated by JS -->
        </div>
    </section>

    <!-- EVENTS WE CATER -->
    <section id="events" 
             class="bg-white py-24">
        <div class="max-w-screen-2xl mx-auto px-8">
            <div class="grid md:grid-cols-12 gap-12 items-center">
                <div class="md:col-span-5">
                    <span class="text-emerald-600 text-sm font-semibold">FOR EVERY CELEBRATION</span>
                    <h2 class="tail-text text-5xl font-semibold tracking-tighter mt-2">We bring the feast to you</h2>
                    <p class="text-stone-600 mt-6 max-w-md">
                        Whether it's an intimate dinner for 10 or a grand wedding for 300, our team handles every detail.
                    </p>
                    
                    <ul class="mt-10 space-y-6">
                        <li class="flex gap-x-5">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0">💒</div>
                            <div>
                                <div class="font-semibold">Weddings &amp; Receptions</div>
                                <div class="text-sm text-stone-500">Multi-course plated or elegant family-style</div>
                            </div>
                        </li>
                        <li class="flex gap-x-5">
                            <div class="w-8 h-8 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center flex-shrink-0">💼</div>
                            <div>
                                <div class="font-semibold">Corporate &amp; Galas</div>
                                <div class="text-sm text-stone-500">Executive lunches, cocktail hours, product launches</div>
                            </div>
                        </li>
                        <li class="flex gap-x-5">
                            <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0">🎂</div>
                            <div>
                                <div class="font-semibold">Private Parties &amp; Birthdays</div>
                                <div class="text-sm text-stone-500">Intimate dinners, milestone celebrations</div>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="md:col-span-7">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-stone-50 p-8 rounded-3xl dish-card">
                            <div class="text-4xl mb-6">🌿</div>
                            <div class="font-semibold mb-1">Garden Inspired</div>
                            <div class="text-sm text-stone-500">Fresh herbs, edible flowers, seasonal produce</div>
                            <div class="mt-8 text-xs uppercase font-medium text-emerald-500 flex items-center gap-x-2">
                                <span class="flex-1 h-px bg-emerald-200"></span>
                                <span>FROM $65 / GUEST</span>
                            </div>
                        </div>
                        
                        <div class="bg-stone-50 p-8 rounded-3xl dish-card">
                            <div class="text-4xl mb-6">🔥</div>
                            <div class="font-semibold mb-1">Fire &amp; Smoke</div>
                            <div class="text-sm text-stone-500">Wood-fired meats, grilled vegetables, bold flavors</div>
                            <div class="mt-8 text-xs uppercase font-medium text-amber-500 flex items-center gap-x-2">
                                <span class="flex-1 h-px bg-amber-200"></span>
                                <span>FROM $78 / GUEST</span>
                            </div>
                        </div>
                        
                        <div class="bg-stone-50 p-8 rounded-3xl dish-card">
                            <div class="text-4xl mb-6">🌊</div>
                            <div class="font-semibold mb-1">Coastal Collection</div>
                            <div class="text-sm text-stone-500">Fresh seafood, citrus, delicate herbs</div>
                            <div class="mt-8 text-xs uppercase font-medium text-sky-500 flex items-center gap-x-2">
                                <span class="flex-1 h-px bg-sky-200"></span>
                                <span>FROM $92 / GUEST</span>
                            </div>
                        </div>
                        
                        <div class="bg-stone-50 p-8 rounded-3xl dish-card">
                            <div class="text-4xl mb-6">🍫</div>
                            <div class="font-semibold mb-1">Sweet Escape</div>
                            <div class="text-sm text-stone-500">Dessert-focused grazing tables &amp; stations</div>
                            <div class="mt-8 text-xs uppercase font-medium text-pink-500 flex items-center gap-x-2">
                                <span class="flex-1 h-px bg-pink-200"></span>
                                <span>FROM $48 / GUEST</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="max-w-screen-2xl mx-auto px-8 py-24 bg-stone-950 text-white">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="mx-auto w-14 h-14 bg-white bg-opacity-10 rounded-3xl flex items-center justify-center mb-6">
                    🌱
                </div>
                <h3 class="font-semibold text-xl">Hyper-local ingredients</h3>
                <p class="text-stone-400 text-sm mt-3">Sourced daily from 12 regional farms and fisheries</p>
            </div>
            <div class="text-center">
                <div class="mx-auto w-14 h-14 bg-white bg-opacity-10 rounded-3xl flex items-center justify-center mb-6">
                    👨‍🍳
                </div>
                <h3 class="font-semibold text-xl">Chef-led experience</h3>
                <p class="text-stone-400 text-sm mt-3">Our team of 8 executive chefs curate every plate</p>
            </div>
            <div class="text-center">
                <div class="mx-auto w-14 h-14 bg-white bg-opacity-10 rounded-3xl flex items-center justify-center mb-6">
                    ♻️
                </div>
                <h3 class="font-semibold text-xl">Sustainable practices</h3>
                <p class="text-stone-400 text-sm mt-3">100% compostable serveware and carbon offset deliveries</p>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section id="testimonials" 
             class="max-w-screen-2xl mx-auto px-8 py-24">
        <div class="flex flex-col md:flex-row items-center justify-between mb-12">
            <div>
                <span class="text-xs uppercase font-semibold text-amber-600">Real moments, real praise</span>
                <h2 class="tail-text text-5xl font-semibold tracking-tighter">What our clients say</h2>
            </div>
            <div class="flex items-center gap-x-3 mt-6 md:mt-0">
                <button onclick="prevTestimonial()" 
                        class="w-11 h-11 border border-stone-300 hover:border-stone-400 rounded-3xl flex items-center justify-center transition-colors">
                    ←
                </button>
                <button onclick="nextTestimonial()" 
                        class="w-11 h-11 border border-stone-300 hover:border-stone-400 rounded-3xl flex items-center justify-center transition-colors">
                    →
                </button>
            </div>
        </div>
        
        <div id="testimonial-container" 
             class="overflow-hidden">
            <div id="testimonial-track" 
                 class="flex transition-transform duration-700 ease-out">
                <!-- JS populated cards -->
            </div>
        </div>
    </section>

    <!-- FINAL CTA -->
    <div class="bg-gradient-to-r from-amber-400 to-emerald-500 py-16">
        <div class="max-w-screen-2xl mx-auto px-8 text-center">
            <h2 class="text-white text-4xl font-semibold tracking-tighter">Ready to make your next event unforgettable?</h2>
            <button onclick="showQuoteModal()" 
                    class="mt-8 bg-white text-stone-950 font-semibold text-lg px-16 py-7 rounded-3xl shadow-2xl shadow-emerald-800/30 hover:scale-105 transition-transform">
                START PLANNING YOUR FEAST
            </button>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-stone-950 text-white/80">
        <div class="max-w-screen-2xl mx-auto px-8 pt-16 pb-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-y-12">
                <div>
                    <div class="flex items-center gap-x-2 text-white mb-6">
                        <div class="w-7 h-7 bg-gradient-to-br from-amber-400 to-emerald-500 rounded-2xl flex items-center justify-center text-xs font-bold">L</div>
                        <span class="tail-text text-2xl font-semibold tracking-tighter">LUMINA</span>
                    </div>
                    <p class="text-xs max-w-[180px] text-white/60">
                        Premium catering that brings people together through extraordinary food.
                    </p>
                </div>
                
                <div>
                    <div class="uppercase text-xs font-semibold tracking-widest mb-4">Navigation</div>
                    <div class="space-y-2.5 text-sm">
                        <div onclick="navigateToSection('menu')" 
                             class="cursor-pointer hover:text-white">Menus</div>
                        <div onclick="navigateToSection('events')" 
                             class="cursor-pointer hover:text-white">Events</div>
                        <div onclick="navigateToSection('about')" 
                             class="cursor-pointer hover:text-white">Our Story</div>
                    </div>
                </div>
                
                <div>
                    <div class="uppercase text-xs font-semibold tracking-widest mb-4">Services</div>
                    <div class="space-y-2.5 text-sm">
                        <div class="cursor-pointer hover:text-white">Wedding Catering</div>
                        <div class="cursor-pointer hover:text-white">Corporate Events</div>
                        <div class="cursor-pointer hover:text-white">Private Dining</div>
                        <div class="cursor-pointer hover:text-white">Pop-up Experiences</div>
                    </div>
                </div>
                
                <div>
                    <div class="uppercase text-xs font-semibold tracking-widest mb-4">Contact</div>
                    <div class="text-sm space-y-1">
                        <div class="flex items-center gap-x-2">
                            <i class="fa-regular fa-envelope text-xs"></i>
                            <span>hello@luminafeasts.com</span>
                        </div>
                        <div class="flex items-center gap-x-2">
                            <i class="fa-solid fa-phone text-xs"></i>
                            <span>(415) 555-0192</span>
                        </div>
                        <div class="text-xs text-white/40 mt-6">San Francisco • Los Angeles • Seattle</div>
                    </div>
                </div>
                
                <div class="col-span-2 md:col-span-1">
                    <div class="bg-white/10 rounded-3xl p-5 text-xs">
                        <div class="flex justify-between text-[10px] font-medium mb-3">
                            <div>NEXT AVAILABLE</div>
                            <div class="text-emerald-400">MAR 28</div>
                        </div>
                        <button onclick="showQuoteModal()" 
                                class="text-xs bg-white text-stone-900 w-full py-3 rounded-3xl font-semibold">BOOK THIS DATE</button>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-white/10 mt-16 pt-8 text-xs flex flex-col md:flex-row justify-between items-center gap-y-3">
                <div>© 2025 Lumina Feasts. All rights reserved.</div>
                <div class="flex items-center gap-x-5 text-xs">
                    <span class="cursor-pointer hover:text-white">Instagram</span>
                    <span class="cursor-pointer hover:text-white">Pinterest</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- QUOTE MODAL -->
    <div onclick="if(event.target.id === 'quote-modal') this.classList.add('hidden')" 
         id="quote-modal"
         class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[9999] p-4">
        <div onclick="event.stopImmediatePropagation()" 
             class="bg-white max-w-lg w-full rounded-3xl shadow-2xl overflow-hidden">
            <div class="px-8 pt-8 pb-2">
                <div class="flex justify-between items-center">
                    <div class="text-xl font-semibold">Tell us about your event</div>
                    <button onclick="this.closest('#quote-modal').classList.add('hidden')" 
                            class="text-stone-400 hover:text-stone-600">
                        ✕
                    </button>
                </div>
            </div>
            
            <form id="quote-form" class="px-8 pb-8">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-stone-500 mb-1">YOUR NAME</label>
                        <input type="text" id="name" 
                               class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm"
                               placeholder="Jamie Rivera" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-stone-500 mb-1">EMAIL</label>
                        <input type="email" id="email" 
                               class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm"
                               placeholder="you@email.com" required>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-xs font-medium text-stone-500 mb-1">EVENT TYPE</label>
                    <select id="event-type" 
                            class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm">
                        <option value="">Select one...</option>
                        <option value="Wedding">Wedding / Reception</option>
                        <option value="Corporate">Corporate Event</option>
                        <option value="Private">Private Party / Birthday</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div>
                        <label class="block text-xs font-medium text-stone-500 mb-1">EVENT DATE</label>
                        <input type="date" id="date" 
                               class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-stone-500 mb-1">GUESTS</label>
                        <input type="number" id="guests" placeholder="80" 
                               class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-xs font-medium text-stone-500 mb-1">NOTES / SPECIAL REQUESTS</label>
                    <textarea id="notes" rows="3"
                              class="w-full border border-stone-200 focus:border-amber-400 rounded-3xl px-4 py-3 outline-none text-sm resize-none"
                              placeholder="Vegan options, dietary restrictions, theme ideas..."></textarea>
                </div>
                
                <button type="button" onclick="submitQuoteForm(event)" 
                        class="mt-8 w-full py-5 bg-stone-900 text-white rounded-3xl font-semibold text-sm tracking-widest hover:bg-black transition-colors">
                    SEND INQUIRY • WE RESPOND IN &lt;24H
                </button>
            </form>
        </div>
    </div>

    <!-- SUCCESS TOAST -->
    <div id="success-toast" 
         class="hidden fixed bottom-6 right-6 bg-emerald-600 text-white rounded-3xl shadow-2xl flex items-center gap-x-3 px-5 py-4 success-toast">
        <i class="fa-regular fa-circle-check text-xl"></i>
        <div>
            <span class="font-semibold">Thank you!</span><br>
            <span class="text-xs opacity-90">Your inquiry was received.</span>
        </div>
    </div>

    <script>
        // Tailwind already loaded via CDN
        
        let currentTab = 0
        
        const dishesData = [
            {
                category: 0,
                emoji: "🥑",
                name: "Avocado & Citrus Crostini",
                desc: "Toasted sourdough, pickled shallots, micro arugula",
                price: "18"
            },
            {
                category: 0,
                emoji: "🍄",
                name: "Truffle Stuffed Mushrooms",
                desc: "Wild mushrooms, herb ricotta, aged balsamic",
                price: "22"
            },
            {
                category: 0,
                emoji: "🍤",
                name: "Chili Lime Shrimp Skewers",
                desc: "Coconut rice cake base, fresh cilantro",
                price: "26"
            },
            {
                category: 1,
                emoji: "🐟",
                name: "Miso Glazed Black Cod",
                desc: "Pickled ginger, toasted sesame, baby bok choy",
                price: "38"
            },
            {
                category: 1,
                emoji: "🥩",
                name: "Herb Crusted Beef Tenderloin",
                desc: "Red wine jus, roasted root vegetables",
                price: "44"
            },
            {
                category: 1,
                emoji: "🍝",
                name: "Wild Mushroom Risotto",
                desc: "Truffle oil, parmesan crisps (vegetarian)",
                price: "29"
            },
            {
                category: 2,
                emoji: "🍰",
                name: "Olive Oil Chocolate Cake",
                desc: "Blood orange segments, rosemary cream",
                price: "14"
            },
            {
                category: 2,
                emoji: "🍓",
                name: "Vanilla Bean Panna Cotta",
                desc: "Strawberry rose compote, pistachio crumble",
                price: "16"
            },
            {
                category: 2,
                emoji: "🍪",
                name: "Mini Tahini Brownies",
                desc: "Sesame brittle, dark chocolate drizzle",
                price: "12"
            }
        ]
        
        const testimonialsData = [
            {
                quote: "Lumina made our wedding feel like a fairytale. Every single guest raved about the food and the service was impeccable.",
                author: "Priya & Michael Patel",
                role: "Wedding • Sonoma, CA",
                emoji: "💍"
            },
            {
                quote: "Our product launch was elevated tenfold thanks to Lumina's team. The grazing tables were beautiful and the flavors unforgettable.",
                author: "Sarah Chen",
                role: "Head of Marketing @ Lumos Labs",
                emoji: "🚀"
            },
            {
                quote: "We do quarterly team offsites and Lumina is our go-to. They always remember our vegetarian and gluten-free colleagues.",
                author: "Marcus Rivera",
                role: "CEO @ Verdant Ventures",
                emoji: "👥"
            }
        ]
        
        // Render dishes
        function renderDishes(category) {
            const container = document.getElementById("menu-grid")
            container.innerHTML = ""
            
            const filtered = category === -1 
                ? dishesData 
                : dishesData.filter(dish => dish.category === category)
            
            filtered.forEach(dish => {
                const cardHTML = `
                    <div class="dish-card bg-white border border-transparent hover:border-amber-200 rounded-3xl overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-amber-400 to-emerald-400"></div>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="text-4xl">${dish.emoji}</div>
                                <div class="text-right">
                                    <span class="text-xs font-medium uppercase bg-stone-100 text-stone-400 px-3 py-1 rounded-3xl">$${dish.price}</span>
                                </div>
                            </div>
                            <div class="font-semibold text-xl mt-6 leading-none">${dish.name}</div>
                            <div class="text-stone-500 text-sm mt-3 line-clamp-2">${dish.desc}</div>
                        </div>
                    </div>
                `
                container.innerHTML += cardHTML
            })
        }
        
        // Tab switching
        function switchMenuTab(tabIndex) {
            currentTab = tabIndex
            
            // Update tab styles
            for (let i = 0; i < 3; i++) {
                const tabEl = document.getElementById(`tab-${i}`)
                if (i === tabIndex) {
                    tabEl.classList.add("tab-active")
                } else {
                    tabEl.classList.remove("tab-active")
                }
            }
            
            renderDishes(tabIndex)
        }
        
        // Testimonial carousel
        let currentTestimonialIndex = 0
        
        function renderTestimonials() {
            const track = document.getElementById("testimonial-track")
            track.innerHTML = ""
            
            testimonialsData.forEach((t, index) => {
                const div = document.createElement("div")
                div.className = `min-w-full md:min-w-[380px] px-3`
                div.innerHTML = `
                    <div class="bg-white border border-stone-100 shadow p-7 rounded-3xl">
                        <div class="text-4xl mb-4">${t.emoji}</div>
                        <p class="italic text-stone-600">"${t.quote}"</p>
                        <div class="mt-8 flex items-center gap-x-3">
                            <div class="w-9 h-px flex-1 bg-stone-200"></div>
                            <div>
                                <div class="font-semibold text-sm">${t.author}</div>
                                <div class="text-xs text-stone-400">${t.role}</div>
                            </div>
                        </div>
                    </div>
                `
                track.appendChild(div)
            })
        }
        
        function goToTestimonial(index) {
            currentTestimonialIndex = index
            const track = document.getElementById("testimonial-track")
            track.style.transform = `translateX(-${currentTestimonialIndex * 100}%)`
        }
        
        function nextTestimonial() {
            currentTestimonialIndex = (currentTestimonialIndex + 1) % testimonialsData.length
            goToTestimonial(currentTestimonialIndex)
        }
        
        function prevTestimonial() {
            currentTestimonialIndex = (currentTestimonialIndex - 1 + testimonialsData.length) % testimonialsData.length
            goToTestimonial(currentTestimonialIndex)
        }
        
        // Mobile menu
        function initMobileMenu() {
            const btn = document.getElementById("mobile-menu-btn")
            const menu = document.getElementById("mobile-menu")
            const icon = document.getElementById("hamburger-icon")
            
            let isOpen = false
            
            btn.addEventListener("click", () => {
                isOpen = !isOpen
                
                if (isOpen) {
                    menu.classList.remove("hidden")
                    icon.classList.remove("fa-bars")
                    icon.classList.add("fa-xmark")
                } else {
                    menu.classList.add("hidden")
                    icon.classList.add("fa-bars")
                    icon.classList.remove("fa-xmark")
                }
            })
        }
        
        // Quote modal
        function showQuoteModal() {
            const modal = document.getElementById("quote-modal")
            modal.classList.remove("hidden")
            modal.classList.add("flex")
            
            // Reset form
            document.getElementById("quote-form").reset()
        }
        
        function submitQuoteForm(e) {
            e.preventDefault()
            
            // Fake submission
            const modal = document.getElementById("quote-modal")
            modal.classList.add("hidden")
            
            // Show toast
            const toast = document.getElementById("success-toast")
            toast.classList.remove("hidden")
            toast.style.transform = 'translateY(10px)'
            toast.style.opacity = '0'
            
            // Animate in
            setTimeout(() => {
                toast.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)'
                toast.style.transform = 'translateY(0)'
                toast.style.opacity = '1'
            }, 10)
            
            // Hide toast after 4 seconds
            setTimeout(() => {
                toast.style.transitionDuration = '400ms'
                toast.style.opacity = '0'
                toast.style.transform = 'translateY(15px)'
                
                setTimeout(() => {
                    toast.classList.add("hidden")
                    toast.style.transition = ''
                    toast.style.transform = ''
                    toast.style.opacity = ''
                }, 420)
            }, 4200)
        }
        
        // Simple mobile nav click helper
        function mobileNavClick(sectionId) {
            navigateToSection(sectionId)
            // Close mobile menu
            const menu = document.getElementById("mobile-menu")
            const icon = document.getElementById("hamburger-icon")
            menu.classList.add("hidden")
            icon.classList.add("fa-bars")
            icon.classList.remove("fa-xmark")
        }
        
        function mobileQuoteClick() {
            const menu = document.getElementById("mobile-menu")
            const icon = document.getElementById("hamburger-icon")
            menu.classList.add("hidden")
            icon.classList.add("fa-bars")
            icon.classList.remove("fa-xmark")
            showQuoteModal()
        }
        
        // Smooth scroll helper
        function navigateToSection(sectionId) {
            const element = document.getElementById(sectionId)
            if (element) {
                const navHeight = 80
                const elementPosition = element.getBoundingClientRect().top
                const offsetPosition = elementPosition + window.scrollY - navHeight
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                })
            }
        }
        
        // Keyboard escape support for modal
        function addEscapeListener() {
            document.addEventListener("keydown", function(e) {
                if (e.key === "Escape") {
                    const modal = document.getElementById("quote-modal")
                    if (!modal.classList.contains("hidden")) {
                        modal.classList.add("hidden")
                    }
                }
            })
        }
        
        // Initialize everything
        function initializeApp() {
            // Tailwind already active
            
            // Render initial dishes (starters)
            renderDishes(0)
            
            // Render testimonials
            renderTestimonials()
            
            // Mobile menu
            initMobileMenu()
            
            // Escape key
            addEscapeListener()
            
            // Navbar scroll effect
            const navbar = document.getElementById("navbar")
            window.addEventListener("scroll", () => {
                if (window.scrollY > 120) {
                    navbar.style.boxShadow = "0 10px 15px -3px rgb(0 0 0 / 0.05)"
                } else {
                    navbar.style.boxShadow = "none"
                }
            })
            
            // Easter egg: click logo 7 times for confetti (fun)
            let logoClicks = 0
            const logo = document.querySelector(".flex.items-center.gap-x-2.cursor-pointer")
            if (logo) {
                logo.addEventListener("click", () => {
                    logoClicks++
                    if (logoClicks >= 7) {
                        createConfetti()
                        logoClicks = 0
                    }
                })
            }
        }
        
        function createConfetti() {
            const colors = ['#f59e0b', '#10b981', '#eab308']
            for (let i = 0; i < 80; i++) {
                const confetto = document.createElement("div")
                confetto.style.position = "fixed"
                confetto.style.zIndex = "99999"
                confetto.style.left = Math.random() * 100 + "vw"
                confetto.style.top = "-30px"
                confetto.style.fontSize = "13px"
                confetto.style.opacity = Math.random() * 0.8 + 0.6
                confetto.textContent = ["🍃", "🍓", "🥑", "🌟"][Math.floor(Math.random() * 4)]
                document.body.appendChild(confetto)
                
                const duration = Math.random() * 3200 + 2800
                const angle = Math.random() * 75 + 20
                
                confetto.animate([
                    { transform: `translateY(0) rotate(0deg)`, opacity: 1 },
                    { transform: `translateY(${window.innerHeight}px) translateX(${Math.random() * 180 - 60}px) rotate(${Math.random() * 800}deg)`, opacity: 0 }
                ], {
                    duration: duration,
                    easing: "ease-out"
                })
                
                setTimeout(() => {
                    confetto.remove()
                }, duration + 500)
            }
        }
        
        // Boot the app
        window.onload = initializeApp
    </script>
</body>
</html>