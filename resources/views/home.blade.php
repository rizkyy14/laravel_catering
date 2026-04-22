@extends('layouts.app')

@section('content')
<style>
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

    .success-toast {
        animation: toastPop 0.4s ease forwards;
    }
</style>

<!-- HERO -->
<header class="hero-bg min-h-screen flex items-center relative overflow-hidden">
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
                <a href="#menu" class="bg-white text-stone-900 font-semibold px-10 py-6 rounded-3xl flex items-center gap-x-3 hover:shadow-2xl transition-all active:scale-95">
                    <span>EXPLORE MENUS</span>
                    <i class="fa-solid fa-arrow-right text-lg"></i>
                </a>
                
                <button onclick="showQuoteModal()" class="border border-white border-opacity-40 hover:border-opacity-70 text-white font-medium px-8 py-6 rounded-3xl transition-all">
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
        
        <div class="md:col-span-5 hidden md:flex justify-end">
            <div class="relative">
                <div class="w-80 h-80 bg-white bg-opacity-10 backdrop-blur-3xl rounded-[4rem] flex items-center justify-center border border-white border-opacity-20">
                    <div class="text-center">
                        <div class="text-8xl mb-3">🍽️</div>
                        <div class="text-white text-sm font-medium tracking-widest">CURATED FOR YOU</div>
                    </div>
                </div>
                
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
    
    <div class="flex justify-center mb-12 border-b border-stone-200">
        <button onclick="loadMenu('pembuka')" id="tab-pembuka" class="tab px-8 py-4 font-medium cursor-pointer tab-active">
            STARTERS
        </button>
        <button onclick="loadMenu('utama')" id="tab-utama" class="tab px-8 py-4 font-medium cursor-pointer">
            MAINS
        </button>
        <button onclick="loadMenu('penutup')" id="tab-penutup" class="tab px-8 py-4 font-medium cursor-pointer">
            DESSERTS
        </button>
    </div>
    
    <div id="menu-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($menuPembuka as $menu)
        <div class="dish-card bg-white border border-transparent hover:border-amber-200 rounded-3xl overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-amber-400 to-emerald-400"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="text-4xl">{{ $menu->emoji ?? '🍽️' }}</div>
                    <div class="text-right">
                        <span class="text-xs font-medium uppercase bg-stone-100 text-stone-400 px-3 py-1 rounded-3xl">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                <div class="font-semibold text-xl mt-6 leading-none">{{ $menu->nama_menu }}</div>
                <div class="text-stone-500 text-sm mt-3">{{ $menu->deskripsi }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- EVENTS WE CATER -->
<section id="events" class="bg-white py-24">
    <div class="max-w-screen-2xl mx-auto px-8">
        <div class="grid md:grid-cols-12 gap-12 items-center">
            <div class="md:col-span-5">
                <span class="text-emerald-600 text-sm font-semibold">FOR EVERY CELEBRATION</span>
                <h2 class="tail-text text-5xl font-semibold tracking-tighter mt-2">We bring the feast to you</h2>
                <p class="text-stone-600 mt-6 max-w-md">
                    Whether it's an intimate dinner for 10 or a grand wedding for 300, our team handles every detail.
                </p>
                
                <ul class="mt-10 space-y-6">
                    @foreach($events as $event)
                    <li class="flex gap-x-5">
                        <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                            @if($event->tipe_event == 'pernikahan') 💒
                            @elseif($event->tipe_event == 'kantor') 💼
                            @elseif($event->tipe_event == 'ulang_tahun') 🎂
                            @else 🎉
                            @endif
                        </div>
                        <div>
                            <div class="font-semibold">{{ $event->nama_event }}</div>
                            <div class="text-sm text-stone-500">{{ $event->deskripsi }}</div>
                            <div class="text-xs text-amber-600 mt-1">
                                Mulai Rp {{ number_format($event->harga_min_per_orang, 0, ',', '.') }}/orang
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="md:col-span-7">
                <div class="grid grid-cols-2 gap-6">
                    @foreach($paketPopuler as $paket)
                    <div class="bg-stone-50 p-8 rounded-3xl dish-card cursor-pointer hover:shadow-xl transition-all" onclick="location.href='{{ route('pemesanan.create', ['paket' => $paket->id]) }}'">
                        <div class="text-4xl mb-6">
                            @if($paket->event->tipe_event == 'pernikahan') 💒
                            @elseif($paket->event->tipe_event == 'kantor') 💼
                            @elseif($paket->event->tipe_event == 'ulang_tahun') 🎂
                            @else 🎉
                            @endif
                        </div>
                        <div class="font-semibold mb-1">{{ $paket->nama_paket }}</div>
                        <div class="text-sm text-stone-500">{{ Str::limit($paket->deskripsi, 50) }}</div>
                        <div class="mt-8 text-xs uppercase font-medium text-emerald-500 flex items-center gap-x-2">
                            <span class="flex-1 h-px bg-emerald-200"></span>
                            <span>FROM Rp {{ number_format($paket->harga_per_orang, 0, ',', '.') }}/GUEST</span>
                        </div>
                    </div>
                    @endforeach
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
<section id="testimonials" class="max-w-screen-2xl mx-auto px-8 py-24">
    <div class="flex flex-col md:flex-row items-center justify-between mb-12">
        <div>
            <span class="text-xs uppercase font-semibold text-amber-600">Real moments, real praise</span>
            <h2 class="tail-text text-5xl font-semibold tracking-tighter">What our clients say</h2>
        </div>
    </div>
    
    <div id="testimonial-container" class="overflow-hidden">
        <div id="testimonial-track" class="flex transition-transform duration-700 ease-out">
            @foreach($testimonis as $testimoni)
            <div class="min-w-full md:min-w-[380px] px-3">
                <div class="bg-white border border-stone-100 shadow p-7 rounded-3xl">
                    <div class="text-4xl mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimoni->rating)
                                <span class="text-amber-400">★</span>
                            @else
                                <span class="text-stone-300">★</span>
                            @endif
                        @endfor
                    </div>
                    <p class="italic text-stone-600">"{{ $testimoni->isi_testimoni }}"</p>
                    <div class="mt-8 flex items-center gap-x-3">
                        <div class="w-9 h-px flex-1 bg-stone-200"></div>
                        <div>
                            <div class="font-semibold text-sm">{{ $testimoni->user->nama }}</div>
                            <div class="text-xs text-stone-400">{{ $testimoni->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="flex justify-center gap-x-3 mt-8">
        <button onclick="prevTestimonial()" class="w-11 h-11 border border-stone-300 hover:border-stone-400 rounded-3xl flex items-center justify-center transition-colors">
            ←
        </button>
        <button onclick="nextTestimonial()" class="w-11 h-11 border border-stone-300 hover:border-stone-400 rounded-3xl flex items-center justify-center transition-colors">
            →
        </button>
    </div>
</section>

<!-- FINAL CTA -->
<div class="bg-gradient-to-r from-amber-400 to-emerald-500 py-16">
    <div class="max-w-screen-2xl mx-auto px-8 text-center">
        <h2 class="text-white text-4xl font-semibold tracking-tighter">Ready to make your next event unforgettable?</h2>
        <button onclick="showQuoteModal()" class="mt-8 bg-white text-stone-950 font-semibold text-lg px-16 py-7 rounded-3xl shadow-2xl shadow-emerald-800/30 hover:scale-105 transition-transform">
            START PLANNING YOUR FEAST
        </button>
    </div>
</div>

<script>
let currentTestimonialIndex = 0;
const testimonialTrack = document.getElementById('testimonial-track');
let testimonials = [];

function initTestimonials() {
    if (testimonialTrack) {
        testimonials = document.querySelectorAll('#testimonial-track > div');
    }
}

function nextTestimonial() {
    if (testimonials.length === 0) return;
    currentTestimonialIndex = (currentTestimonialIndex + 1) % testimonials.length;
    testimonialTrack.style.transform = `translateX(-${currentTestimonialIndex * 100}%)`;
}

function prevTestimonial() {
    if (testimonials.length === 0) return;
    currentTestimonialIndex = (currentTestimonialIndex - 1 + testimonials.length) % testimonials.length;
    testimonialTrack.style.transform = `translateX(-${currentTestimonialIndex * 100}%)`;
}

function loadMenu(kategori) {
    fetch(`/api/menu/${kategori}`)
        .then(response => response.json())
        .then(data => {
            const grid = document.getElementById('menu-grid');
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
        .catch(error => console.error('Error:', error));
    
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('tab-active');
    });
    document.getElementById(`tab-${kategori}`).classList.add('tab-active');
}

// Auto slide testimoni setiap 5 detik
let autoSlide = setInterval(nextTestimonial, 5000);

// Pause auto slide on hover
const testimonialContainer = document.getElementById('testimonial-container');
if (testimonialContainer) {
    testimonialContainer.addEventListener('mouseenter', () => clearInterval(autoSlide));
    testimonialContainer.addEventListener('mouseleave', () => {
        autoSlide = setInterval(nextTestimonial, 5000);
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    initTestimonials();
});
</script>
@endsection