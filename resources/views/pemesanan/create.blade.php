@extends('layouts.app')

@section('title', 'Form Pemesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-8">
        <a href="{{ route('home') }}#events" class="text-amber-600 hover:text-amber-800">← Kembali ke Paket</a>
        <h1 class="text-3xl font-bold text-stone-800 mt-4">Form Pemesanan Catering</h1>
        <p class="text-stone-500 mt-1">Isi data berikut untuk memesan paket catering</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Paket Info -->
        <div class="bg-gradient-to-r from-amber-50 to-emerald-50 p-6 border-b">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-4xl mb-2">
                        @if($paket->event->tipe_event == 'pernikahan') 💒
                        @elseif($paket->event->tipe_event == 'kantor') 💼
                        @elseif($paket->event->tipe_event == 'ulang_tahun') 🎂
                        @else 🎉
                        @endif
                    </div>
                    <h2 class="text-2xl font-bold text-stone-800">{{ $paket->nama_paket }}</h2>
                    <p class="text-stone-600 mt-1">{{ $paket->event->nama_event }}</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-stone-500">Harga per orang</div>
                    <div class="text-2xl font-bold text-amber-600">Rp {{ number_format($paket->harga_per_orang, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('pemesanan.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
            <input type="hidden" name="event_id" value="{{ $paket->event_id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal Event -->
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-2">Tanggal Event *</label>
                    <input type="date" name="tanggal_event" required
                           min="{{ date('Y-m-d', strtotime('+7 days')) }}"
                           class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:border-amber-500">
                </div>

                <!-- Waktu Mulai -->
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-2">Waktu Mulai *</label>
                    <input type="time" name="waktu_mulai" required
                           class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:border-amber-500">
                </div>

                <!-- Jumlah Tamu -->
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-2">Jumlah Tamu *</label>
                    <input type="number" name="jumlah_tamu" required min="{{ $paket->min_pax }}" max="{{ $paket->max_pax ?? 1000 }}"
                           placeholder="Minimal {{ $paket->min_pax }} orang"
                           class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:border-amber-500">
                    <p class="text-xs text-stone-500 mt-1">Minimal {{ $paket->min_pax }} orang</p>
                </div>

                <!-- Kota Event -->
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-2">Kota Event *</label>
                    <select name="kota_event" required class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:border-amber-500">
                        <option value="">Pilih Kota</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Bali">Bali</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Lokasi Event -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-stone-700 mb-2">Lokasi Event (Alamat Lengkap) *</label>
                    <textarea name="lokasi_event" required rows="2"
                              class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:border-amber-500"
                              placeholder="Masukkan alamat lengkap venue event"></textarea>
                </div>

                <!-- Catatan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-stone-700 mb-2">Catatan / Permintaan Khusus</label>
                    <textarea name="catatan" rows="3"
                              class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:border-amber-500"
                              placeholder="Contoh: Menu tidak pedas, ada tamu vegetarian, dll"></textarea>
                </div>
            </div>

            <!-- Ringkasan Biaya -->
            <div class="bg-stone-50 rounded-xl p-6 mt-6">
                <h3 class="font-semibold text-stone-800 mb-4">Ringkasan Biaya</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-stone-600">Harga per orang</span>
                        <span class="font-medium">Rp {{ number_format($paket->harga_per_orang, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between" id="total-tamu-display">
                        <span class="text-stone-600">Jumlah tamu</span>
                        <span class="font-medium">0 orang</span>
                    </div>
                    <div class="flex justify-between border-t pt-2 mt-2">
                        <span class="font-semibold text-stone-800">Subtotal</span>
                        <span class="font-bold text-amber-600" id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-500">PPN 11%</span>
                        <span class="text-stone-500" id="pajak">Rp 0</span>
                    </div>
                    <div class="flex justify-between border-t pt-2 mt-2">
                        <span class="font-bold text-stone-800 text-lg">Total</span>
                        <span class="font-bold text-amber-600 text-xl" id="total">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm text-stone-500">
                        <span>DP 30%</span>
                        <span id="dp">Rp 0</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-amber-500 text-white font-semibold py-3 rounded-xl hover:bg-amber-600 transition">
                    Pesan Sekarang
                </button>
                <a href="{{ route('home') }}#events" class="flex-1 border border-stone-300 text-stone-700 font-semibold py-3 rounded-xl text-center hover:bg-stone-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const hargaPerOrang = {{ $paket->harga_per_orang }};
    const jumlahTamuInput = document.querySelector('input[name="jumlah_tamu"]');
    const totalTamuDisplay = document.getElementById('total-tamu-display');
    const subtotalSpan = document.getElementById('subtotal');
    const pajakSpan = document.getElementById('pajak');
    const totalSpan = document.getElementById('total');
    const dpSpan = document.getElementById('dp');
    
    function hitungBiaya() {
        let jumlah = parseInt(jumlahTamuInput.value) || 0;
        let subtotal = hargaPerOrang * jumlah;
        let pajak = subtotal * 0.11;
        let total = subtotal + pajak;
        let dp = total * 0.3;
        
        totalTamuDisplay.querySelector('span:last-child').innerText = jumlah + ' orang';
        subtotalSpan.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        pajakSpan.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(pajak);
        totalSpan.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        dpSpan.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(dp);
    }
    
    jumlahTamuInput.addEventListener('input', hitungBiaya);
</script>
@endsection