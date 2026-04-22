<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LUMINA • @yield('title', 'Feasts')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    * {
        font-family: 'Inter', sans-serif;
    }
    
    .tail-text {
        font-family: 'Playfair Display', serif;
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
        box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
    }
    
    .tab-active {
        border-bottom: 3px solid rgb(245 158 11);
        color: rgb(245 158 11);
    }
    
    .hero-bg {
        background: linear-gradient(135deg, #451a03 0%, #052e16 100%);
    }
    
    .success-toast {
        animation: toastPop 0.4s ease forwards;
    }
    
    @keyframes toastPop {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    /* FIX: Dropdown menu agar tidak kepotong */
    #user-dropdown {
        position: absolute;
        right: 0;
        top: 100%;
        z-index: 9999;
        min-width: 180px;
    }
    
    /* FIX: Mobile menu animation */
    #mobile-menu {
        position: absolute;
        left: 0;
        right: 0;
        top: 100%;
        z-index: 9998;
        max-height: calc(100vh - 70px);
        overflow-y: auto;
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Better touch targets for mobile */
    @media (max-width: 768px) {
        button, 
        a {
            min-height: 44px;
        }
    }
    
    /* Fix for navbar position */
    nav {
        position: sticky;
        top: 0;
        z-index: 9997;
    }
</style>
    
    @stack('styles')
</head>
<body class="bg-stone-50 text-stone-900 font-sans overflow-x-hidden">
    
    <!-- NAVBAR -->
    <!-- NAVBAR -->
<nav id="navbar" class="bg-white border-b border-stone-100 sticky top-0 z-50">
    <div class="max-w-screen-2xl mx-auto px-4 md:px-8">
        <div class="py-3 md:py-5 flex items-center justify-between gap-x-4">
            
            <!-- LOGO - Lebih kecil di mobile -->
            <a href="{{ route('home') }}" class="flex items-center gap-x-2 cursor-pointer flex-shrink-0">
                <div class="w-7 h-7 md:w-9 md:h-9 bg-gradient-to-br from-amber-400 to-emerald-500 rounded-2xl flex items-center justify-center text-white text-xs font-bold shadow-inner">
                    L
                </div>
                <div>
                    <span class="tail-text text-xl md:text-3xl font-semibold tracking-tighter">LUMINA</span>
                </div>
            </a>

            <!-- DESKTOP MENU - Hidden on mobile -->
            <div class="hidden md:flex items-center gap-x-6 lg:gap-x-8 text-sm font-medium">
                <a href="{{ route('home') }}" class="nav-link cursor-pointer text-stone-500 hover:text-stone-900 whitespace-nowrap">HOME</a>
                <a href="#menu" class="nav-link cursor-pointer text-stone-500 hover:text-stone-900 whitespace-nowrap">MENUS</a>
                <a href="#events" class="nav-link cursor-pointer text-stone-500 hover:text-stone-900 whitespace-nowrap">EVENTS</a>
                <a href="#testimonials" class="nav-link cursor-pointer text-stone-500 hover:text-stone-900 whitespace-nowrap">STORIES</a>
                <a href="{{ route('kontak') }}" class="nav-link cursor-pointer text-stone-500 hover:text-stone-900 whitespace-nowrap">KONTAK</a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link cursor-pointer text-amber-600 hover:text-amber-700 whitespace-nowrap">
                            DASHBOARD
                        </a>
                    @endif
                @endauth
            </div>

            <!-- RIGHT SECTION -->
            <div class="flex items-center gap-x-2 md:gap-x-4 flex-shrink-0">
                @guest
                    <a href="{{ route('login') }}" class="hidden sm:block text-xs font-semibold text-stone-600 hover:text-stone-900 whitespace-nowrap">
                        LOGIN
                    </a>
                    <a href="{{ route('register') }}" class="bg-amber-500 text-white text-xs font-semibold px-3 md:px-5 py-2 md:py-2.5 rounded-3xl hover:bg-amber-600 transition-colors whitespace-nowrap">
                        REGISTER
                    </a>
                @else
                    <!-- User Dropdown -->
                    <div class="relative">
                        <button id="user-menu-button" 
                                class="flex items-center gap-x-1 md:gap-x-2 text-sm text-stone-600 hover:text-stone-900 focus:outline-none">
                            <i class="fas fa-user-circle text-lg md:text-xl"></i>
                            <span class="hidden sm:inline max-w-[100px] truncate">{{ auth()->user()->nama }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="chevron-icon"></i>
                        </button>
                        
                        <div id="user-dropdown" 
                             class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-stone-100 z-50">
                            <a href="{{ route('pemesanan.index') }}" class="flex items-center gap-x-3 px-4 py-3 text-sm text-stone-700 hover:bg-stone-50 rounded-t-lg">
                                <i class="fas fa-shopping-bag text-amber-500 w-5"></i>
                                <span>Pesanan Saya</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-x-3 px-4 py-3 text-sm text-red-600 hover:bg-stone-50 w-full text-left rounded-b-lg">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
                
                <!-- GET QUOTE BUTTON -->
                <button onclick="showQuoteModal()" class="bg-white text-xs font-semibold border border-amber-300 hover:border-amber-400 transition-colors px-3 md:px-5 py-2 md:py-2.5 rounded-3xl flex items-center gap-x-1 md:gap-x-2 shadow-sm whitespace-nowrap">
                    <i class="fa-regular fa-calendar text-amber-500 text-xs md:text-sm"></i>
                    <span class="text-xs md:text-sm">GET QUOTE</span>
                </button>

                <!-- MOBILE HAMBURGER -->
                <button id="mobile-menu-btn" class="md:hidden w-8 h-8 md:w-10 md:h-10 flex items-center justify-center text-stone-700 flex-shrink-0">
                    <i id="hamburger-icon" class="fa-solid fa-bars text-lg md:text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU - Full width, better styling -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t shadow-lg">
        <div class="max-w-screen-2xl mx-auto px-4 py-4">
            <div class="flex flex-col gap-y-3">
                <a href="{{ route('home') }}" class="py-3 px-4 text-base font-medium text-stone-700 hover:bg-stone-50 rounded-xl transition">Home</a>
                <a href="#menu" class="py-3 px-4 text-base font-medium text-stone-700 hover:bg-stone-50 rounded-xl transition">Menus</a>
                <a href="#events" class="py-3 px-4 text-base font-medium text-stone-700 hover:bg-stone-50 rounded-xl transition">Events</a>
                <a href="#testimonials" class="py-3 px-4 text-base font-medium text-stone-700 hover:bg-stone-50 rounded-xl transition">Stories</a>
                <a href="{{ route('kontak') }}" class="py-3 px-4 text-base font-medium text-stone-700 hover:bg-stone-50 rounded-xl transition">Kontak</a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="py-3 px-4 text-base font-medium text-amber-600 hover:bg-stone-50 rounded-xl transition">
                            Dashboard
                        </a>
                    @endif
                @endauth
                
                <div class="border-t border-stone-100 my-2"></div>
                
                @guest
                    <a href="{{ route('login') }}" class="py-3 px-4 text-base font-medium text-amber-600 hover:bg-stone-50 rounded-xl transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="py-3 px-4 text-base font-medium bg-amber-500 text-white text-center rounded-xl hover:bg-amber-600 transition">
                        Register
                    </a>
                @else
                    <div class="py-3 px-4 bg-stone-50 rounded-xl">
                        <p class="text-sm text-stone-600">Halo, <strong class="text-stone-900">{{ auth()->user()->nama }}</strong></p>
                        <div class="mt-3 space-y-2">
                            <a href="{{ route('pemesanan.index') }}" class="flex items-center gap-x-3 text-sm text-amber-600 py-2">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Pesanan Saya</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-x-3 text-sm text-red-600 py-2 w-full">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

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
                        <a href="#menu" class="block cursor-pointer hover:text-white">Menus</a>
                        <a href="#events" class="block cursor-pointer hover:text-white">Events</a>
                        <a href="#testimonials" class="block cursor-pointer hover:text-white">Stories</a>
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
                        <button onclick="showQuoteModal()" class="text-xs bg-white text-stone-900 w-full py-3 rounded-3xl font-semibold hover:bg-stone-100 transition">
                            BOOK THIS DATE
                        </button>
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
    <div onclick="if(event.target.id === 'quote-modal') document.getElementById('quote-modal').classList.add('hidden')" 
         id="quote-modal"
         class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[9999] p-4">
        <div onclick="event.stopPropagation()" class="bg-white max-w-lg w-full rounded-3xl shadow-2xl overflow-hidden">
            <div class="px-8 pt-8 pb-2">
                <div class="flex justify-between items-center">
                    <div class="text-xl font-semibold">Tell us about your event</div>
                    <button onclick="document.getElementById('quote-modal').classList.add('hidden')" class="text-stone-400 hover:text-stone-600">
                        ✕
                    </button>
                </div>
            </div>
            
            <form id="quote-form" class="px-8 pb-8" onsubmit="submitQuoteForm(event)">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-stone-500 mb-1">YOUR NAME</label>
                        <input type="text" id="name" name="nama" 
                               class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm"
                               placeholder="Jamie Rivera" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-stone-500 mb-1">EMAIL</label>
                        <input type="email" id="email" name="email" 
                               class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm"
                               placeholder="you@email.com" required>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-xs font-medium text-stone-500 mb-1">EVENT TYPE</label>
                    <select id="event-type" name="event_type" 
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
                        <input type="date" id="date" name="tanggal" 
                               class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-stone-500 mb-1">GUESTS</label>
                        <input type="number" id="guests" name="jumlah_tamu" placeholder="80" 
                               class="w-full border border-stone-200 focus:border-amber-400 rounded-2xl px-4 py-3 outline-none text-sm">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-xs font-medium text-stone-500 mb-1">NOTES / SPECIAL REQUESTS</label>
                    <textarea id="notes" name="catatan" rows="3"
                              class="w-full border border-stone-200 focus:border-amber-400 rounded-3xl px-4 py-3 outline-none text-sm resize-none"
                              placeholder="Vegan options, dietary restrictions, theme ideas..."></textarea>
                </div>
                
                <button type="submit" 
                        class="mt-8 w-full py-5 bg-stone-900 text-white rounded-3xl font-semibold text-sm tracking-widest hover:bg-black transition-colors">
                    SEND INQUIRY • WE RESPOND IN <24H
                </button>
            </form>
        </div>
    </div>

    <!-- SUCCESS TOAST -->
    <div id="success-toast" 
         class="hidden fixed bottom-6 right-6 bg-emerald-600 text-white rounded-3xl shadow-2xl flex items-center gap-x-3 px-5 py-4 z-[10000]">
        <i class="fa-regular fa-circle-check text-xl"></i>
        <div>
            <span class="font-semibold">Thank you!</span><br>
            <span class="text-xs opacity-90">Your inquiry was received.</span>
        </div>
    </div>

    {{-- <script>
    // ==================== MOBILE MENU ====================
   // ==================== MOBILE MENU ====================
function initMobileMenu() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = document.getElementById('hamburger-icon');
    
    if (!btn || !menu) {
        console.log('Mobile menu elements not found');
        return;
    }
    
    // Pastikan menu hidden di awal
    menu.classList.add('hidden');
    
    function closeMenu() {
        menu.classList.add('hidden');
        if (icon) {
            icon.classList.remove('fa-xmark');
            icon.classList.add('fa-bars');
        }
        document.body.style.overflow = '';
    }
    
    function openMenu() {
        menu.classList.remove('hidden');
        if (icon) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-xmark');
        }
        document.body.style.overflow = 'hidden';
    }
    
    // Toggle menu on button click
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        if (menu.classList.contains('hidden')) {
            openMenu();
        } else {
            closeMenu();
        }
    });
    
    // Close menu when clicking on a link
    const mobileLinks = menu.querySelectorAll('a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            closeMenu();
        });
    });
    
    // Close menu when clicking outside (on mobile only)
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!menu.contains(e.target) && !btn.contains(e.target) && !menu.classList.contains('hidden')) {
                closeMenu();
            }
        }
    });
    
    // Prevent menu from closing when clicking inside menu
    menu.addEventListener('click', (e) => {
        e.stopPropagation();
    });
    
    // Close menu on window resize (if screen becomes desktop)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && !menu.classList.contains('hidden')) {
            closeMenu();
        }
    });
}
    // ==================== USER DROPDOWN ====================
function initUserDropdown() {
    const button = document.getElementById('user-menu-button');
    const dropdown = document.getElementById('user-dropdown');
    const chevron = document.getElementById('chevron-icon');
    
    if (!button || !dropdown) {
        console.log('User dropdown elements not found');
        return;
    }
    
    // Pastikan dropdown hidden di awal
    dropdown.classList.add('hidden');
    
    function showDropdown() {
        dropdown.classList.remove('hidden');
        if (chevron) {
            chevron.style.transform = 'rotate(180deg)';
        }
    }
    
    function hideDropdown() {
        dropdown.classList.add('hidden');
        if (chevron) {
            chevron.style.transform = 'rotate(0deg)';
        }
    }
    
    // Toggle on click
    button.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        if (dropdown.classList.contains('hidden')) {
            // Close other dropdowns if any
            const allDropdowns = document.querySelectorAll('#user-dropdown');
            allDropdowns.forEach(d => {
                if (d !== dropdown) d.classList.add('hidden');
            });
            showDropdown();
        } else {
            hideDropdown();
        }
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
            hideDropdown();
        }
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !dropdown.classList.contains('hidden')) {
            hideDropdown();
        }
    });
    
    // Prevent dropdown from closing when clicking inside
    dropdown.addEventListener('click', (e) => {
        e.stopPropagation();
    });
}
    
    // ==================== QUOTE MODAL ====================
    function showQuoteModal() {
        @guest
            window.location.href = "{{ route('login') }}";
        @else
            const modal = document.getElementById('quote-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                
                // Pre-fill form with user data
                const nameInput = document.getElementById('name');
                const emailInput = document.getElementById('email');
                
                if (nameInput) nameInput.value = "{{ auth()->user()->nama ?? '' }}";
                if (emailInput) emailInput.value = "{{ auth()->user()->email ?? '' }}";
            }
        @endguest
    }
    
    function closeQuoteModal() {
        const modal = document.getElementById('quote-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
    
    // ==================== SUBMIT QUOTE FORM ====================
    function submitQuoteForm(event) {
        event.preventDefault();
        
        const formData = {
            nama: document.getElementById('name')?.value || '',
            email: document.getElementById('email')?.value || '',
            event_type: document.getElementById('event-type')?.value || '',
            tanggal: document.getElementById('date')?.value || '',
            jumlah_tamu: document.getElementById('guests')?.value || '',
            catatan: document.getElementById('notes')?.value || '',
            _token: document.querySelector('meta[name="csrf-token"]')?.content || ''
        };
        
        fetch('{{ route("get.quote") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': formData._token,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                closeQuoteModal();
                
                // Reset form
                document.getElementById('quote-form')?.reset();
                
                // Show success toast
                const toast = document.getElementById('success-toast');
                if (toast) {
                    toast.classList.remove('hidden');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 3000);
                }
            } else if (data.message) {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
        
        return false;
    }
    
    // ==================== TESTIMONIAL CAROUSEL ====================
    let currentTestimonialIndex = 0;
    let testimonialTrack = null;
    let testimonials = [];
    let autoSlideInterval = null;
    
    function initTestimonials() {
        testimonialTrack = document.getElementById('testimonial-track');
        if (testimonialTrack) {
            testimonials = document.querySelectorAll('#testimonial-track > div');
            startAutoSlide();
        }
    }
    
    function nextTestimonial() {
        if (testimonials.length === 0) return;
        currentTestimonialIndex = (currentTestimonialIndex + 1) % testimonials.length;
        if (testimonialTrack) {
            testimonialTrack.style.transform = `translateX(-${currentTestimonialIndex * 100}%)`;
        }
    }
    
    function prevTestimonial() {
        if (testimonials.length === 0) return;
        currentTestimonialIndex = (currentTestimonialIndex - 1 + testimonials.length) % testimonials.length;
        if (testimonialTrack) {
            testimonialTrack.style.transform = `translateX(-${currentTestimonialIndex * 100}%)`;
        }
    }
    
    function startAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(nextTestimonial, 5000);
    }
    
    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
            autoSlideInterval = null;
        }
    }
    
    // ==================== LOAD MENU (AJAX) ====================
    function loadMenu(kategori) {
        fetch(`/api/menu/${kategori}`)
            .then(response => response.json())
            .then(data => {
                const grid = document.getElementById('menu-grid');
                if (!grid) return;
                
                grid.innerHTML = '';
                
                data.forEach(menu => {
                    grid.innerHTML += `
                        <div class="dish-card bg-white border border-transparent hover:border-amber-200 rounded-3xl overflow-hidden">
                            <div class="h-2 bg-gradient-to-r from-amber-400 to-emerald-400"></div>
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div class="text-4xl">${menu.emoji || '🍽️'}</div>
                                    <div class="text-right">
                                        <span class="text-xs font-medium uppercase bg-stone-100 text-stone-400 px-3 py-1 rounded-3xl">
                                            Rp ${new Intl.NumberFormat('id-ID').format(menu.harga)}
                                        </span>
                                    </div>
                                </div>
                                <div class="font-semibold text-xl mt-6 leading-none">${menu.nama_menu}</div>
                                <div class="text-stone-500 text-sm mt-3">${menu.deskripsi}</div>
                            </div>
                        </div>
                    `;
                });
            })
            .catch(error => console.error('Error loading menu:', error));
        
        // Update active tab
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('tab-active');
        });
        const activeTab = document.getElementById(`tab-${kategori}`);
        if (activeTab) {
            activeTab.classList.add('tab-active');
        }
    }
    
    // ==================== INITIALIZE EVERYTHING ====================
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Loaded - Initializing...');
        initMobileMenu();
        initUserDropdown();
        initTestimonials();
        
        // Pause auto slide on hover
        const testimonialContainer = document.getElementById('testimonial-container');
        if (testimonialContainer) {
            testimonialContainer.addEventListener('mouseenter', stopAutoSlide);
            testimonialContainer.addEventListener('mouseleave', startAutoSlide);
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeQuoteModal();
            }
        });
    });
    
</script> --}}
    <script>
    // SIMPLE MOBILE MENU
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const icon = document.getElementById('hamburger-icon');
    
    if (mobileBtn && mobileMenu) {
        mobileBtn.onclick = function(e) {
            e.preventDefault();
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                if (icon) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                }
            } else {
                mobileMenu.classList.add('hidden');
                if (icon) {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            }
        };
    }
    
    // SIMPLE USER DROPDOWN
    const userBtn = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    const chevron = document.getElementById('chevron-icon');
    
    if (userBtn && userDropdown) {
        userBtn.onclick = function(e) {
            e.preventDefault();
            if (userDropdown.classList.contains('hidden')) {
                userDropdown.classList.remove('hidden');
                if (chevron) chevron.style.transform = 'rotate(180deg)';
            } else {
                userDropdown.classList.add('hidden');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        };
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        });
    }
    
    // QUOTE MODAL
    function showQuoteModal() {
        @guest
            window.location.href = "{{ route('login') }}";
        @else
            const modal = document.getElementById('quote-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.getElementById('name').value = "{{ auth()->user()->nama ?? '' }}";
                document.getElementById('email').value = "{{ auth()->user()->email ?? '' }}";
            }
        @endguest
    }
    
    function closeQuoteModal() {
        const modal = document.getElementById('quote-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
    
    function submitQuoteForm(event) {
        event.preventDefault();
        const formData = {
            nama: document.getElementById('name')?.value,
            email: document.getElementById('email')?.value,
            event_type: document.getElementById('event-type')?.value,
            tanggal: document.getElementById('date')?.value,
            jumlah_tamu: document.getElementById('guests')?.value,
            catatan: document.getElementById('notes')?.value,
            _token: document.querySelector('meta[name="csrf-token"]')?.content
        };
        
        fetch('{{ route("get.quote") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': formData._token },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeQuoteModal();
                document.getElementById('quote-form')?.reset();
                const toast = document.getElementById('success-toast');
                if (toast) {
                    toast.classList.remove('hidden');
                    setTimeout(() => toast.classList.add('hidden'), 3000);
                }
            }
        });
        return false;
    }
    
    // TESTIMONIAL CAROUSEL
    let currentIndex = 0;
    const track = document.getElementById('testimonial-track');
    let slides = [];
    
    function initCarousel() {
        if (track) {
            slides = document.querySelectorAll('#testimonial-track > div');
            if (slides.length > 0) {
                setInterval(() => {
                    currentIndex = (currentIndex + 1) % slides.length;
                    track.style.transform = `translateX(-${currentIndex * 100}%)`;
                }, 5000);
            }
        }
    }
    
    function nextTestimonial() {
        if (slides.length === 0) return;
        currentIndex = (currentIndex + 1) % slides.length;
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
    
    function prevTestimonial() {
        if (slides.length === 0) return;
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
    
    // LOAD MENU
    function loadMenu(kategori) {
        fetch(`/api/menu/${kategori}`)
            .then(res => res.json())
            .then(data => {
                const grid = document.getElementById('menu-grid');
                if (grid) {
                    grid.innerHTML = data.map(menu => `
                        <div class="dish-card bg-white border border-transparent hover:border-amber-200 rounded-3xl overflow-hidden">
                            <div class="h-2 bg-gradient-to-r from-amber-400 to-emerald-400"></div>
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div class="text-4xl">${menu.emoji || '🍽️'}</div>
                                    <div class="text-right">
                                        <span class="text-xs font-medium uppercase bg-stone-100 text-stone-400 px-3 py-1 rounded-3xl">
                                            Rp ${new Intl.NumberFormat('id-ID').format(menu.harga)}
                                        </span>
                                    </div>
                                </div>
                                <div class="font-semibold text-xl mt-6 leading-none">${menu.nama_menu}</div>
                                <div class="text-stone-500 text-sm mt-3">${menu.deskripsi}</div>
                            </div>
                        </div>
                    `).join('');
                }
            });
        
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('tab-active'));
        document.getElementById(`tab-${kategori}`)?.classList.add('tab-active');
    }
    
    // INIT
    initCarousel();
</script>
    @stack('scripts')
</body>
</html>