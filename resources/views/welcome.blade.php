{{-- resources/views/home.blade.php --}}

@extends('layouts.app')

@section('content')
<!-- MENU SECTION -->
<section id="menu" class="max-w-screen-2xl mx-auto px-8 py-24">
    <div class="text-center mb-12">
        <span class="px-4 py-1.5 text-xs font-semibold bg-amber-100 text-amber-700 rounded-3xl">
            SIGNATURE MENUS
        </span>
        <h2 class="tail-text text-5xl font-semibold tracking-tighter mt-3">
            Our Culinary Collections
        </h2>
    </div>
    
    <!-- TABS -->
    <div class="flex justify-center mb-12 border-b border-stone-200">
        <div onclick="switchMenuTab('pembuka')" 
             class="tab px-8 py-4 font-medium cursor-pointer tab-active">
            STARTERS
        </div>
        <div onclick="switchMenuTab('utama')" 
             class="tab px-8 py-4 font-medium cursor-pointer">
            MAINS
        </div>
        <div onclick="switchMenuTab('penutup')" 
             class="tab px-8 py-4 font-medium cursor-pointer">
            DESSERTS
        </div>
    </div>
    
    <!-- MENU GRID -->
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
                <div class="text-stone-500 text-sm mt-3 line-clamp-2">{{ $menu->deskripsi }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- EVENTS SECTION -->
<section id="events" class="bg-white py-24">
    <div class="max-w-screen-2xl mx-auto px-8">
        <div class="grid md:grid-cols-12 gap-12 items-center">
            <div class="md:col-span-5">
                <span class="text-emerald-600 text-sm font-semibold">FOR EVERY CELEBRATION</span>
                <h2 class="tail-text text-5xl font-semibold tracking-tighter mt-2">
                    We bring the feast to you
                </h2>
                <p class="text-stone-600 mt-6 max-w-md">
                    Whether it's an intimate dinner for 10 or a grand wedding for 300, our team handles every detail.
                </p>
                
                <ul class="mt-10 space-y-6">
                    @foreach($events as $event)
                    <li class="flex gap-x-5">
                        <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                            @switch($event->tipe_event)
                                @case('pernikahan') 💒 @break
                                @case('kantor') 💼 @break
                                @case('ulang_tahun') 🎂 @break
                                @default 🎉
                            @endswitch
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
                    <div class="bg-stone-50 p-8 rounded-3xl dish-card">
                        <div class="text-4xl mb-6">
                            @switch($paket->event->tipe_event)
                                @case('pernikahan') 💒 @break
                                @case('kantor') 💼 @break
                                @case('ulang_tahun') 🎂 @break
                                @default 🎉
                            @endswitch
                        </div>
                        <div class="font-semibold mb-1">{{ $paket->nama_paket }}</div>
                        <div class="text-sm text-stone-500">{{ $paket->deskripsi }}</div>
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

<!-- TESTIMONIALS -->
<section id="testimonials" class="max-w-screen-2xl mx-auto px-8 py-24">
    <div class="flex flex-col md:flex-row items-center justify-between mb-12">
        <div>
            <span class="text-xs uppercase font-semibold text-amber-600">Real moments, real praise</span>
            <h2 class="tail-text text-5xl font-semibold tracking-tighter">What our clients say</h2>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($testimoni as $t)
        <div class="bg-white border border-stone-100 shadow p-7 rounded-3xl">
            <div class="text-4xl mb-4">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $t->rating)
                        <span class="text-amber-400">★</span>
                    @else
                        <span class="text-stone-300">★</span>
                    @endif
                @endfor
            </div>
            <p class="italic text-stone-600">"{{ $t->isi_testimoni }}"</p>
            <div class="mt-8 flex items-center gap-x-3">
                <div class="w-9 h-px flex-1 bg-stone-200"></div>
                <div>
                    <div class="font-semibold text-sm">{{ $t->user->nama }}</div>
                    <div class="text-xs text-stone-400">{{ $t->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<script>
// Switch menu tab dengan AJAX
function switchMenuTab(kategori) {
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
                            <div class="text-stone-500 text-sm mt-3 line-clamp-2">${menu.deskripsi}</div>
                        </div>
                    </div>
                `;
            });
        });
    
    // Update active tab
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('tab-active'));
    event.target.classList.add('tab-active');
}
// Update submitQuoteForm function
function submitQuoteForm(e) {
    e.preventDefault();
    
    const formData = {
        nama: document.getElementById('name').value,
        email: document.getElementById('email').value,
        event_type: document.getElementById('event-type').value,
        tanggal: document.getElementById('date').value,
        jumlah_tamu: document.getElementById('guests').value,
        catatan: document.getElementById('notes').value,
        _token: '{{ csrf_token() }}'
    };
    
    fetch('/get-quote', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide modal
            document.getElementById('quote-modal').classList.add('hidden');
            
            // Show success toast
            const toast = document.getElementById('success-toast');
            toast.classList.remove('hidden');
            toast.style.transform = 'translateY(10px)';
            toast.style.opacity = '0';
            
            setTimeout(() => {
                toast.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
                toast.style.transform = 'translateY(0)';
                toast.style.opacity = '1';
            }, 10);
            
            setTimeout(() => {
                toast.style.transitionDuration = '400ms';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(15px)';
                
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.style.transition = '';
                    toast.style.transform = '';
                    toast.style.opacity = '';
                }, 420);
            }, 4200);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>
@endsection

