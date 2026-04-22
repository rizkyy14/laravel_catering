@extends('layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-6">
        <a href="{{ route('pemesanan.index') }}" class="text-amber-600 hover:text-amber-800">← Kembali ke Riwayat</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-amber-500 to-emerald-500 p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-sm opacity-90">Nomor Pemesanan</div>
                    <div class="text-2xl font-bold">{{ $pemesanan->no_pemesanan }}</div>
                </div>
                <div>
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                        {{ $pemesanan->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Paket Info -->
            <div class="border-b pb-4">
                <h3 class="font-semibold text-stone-800 mb-3">Detail Paket</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-stone-500">Paket:</span>
                        <p class="font-medium">{{ $pemesanan->paket->nama_paket }}</p>
                    </div>
                    <div>
                        <span class="text-stone-500">Jenis Event:</span>
                        <p class="font-medium">{{ $pemesanan->event->nama_event }}</p>
                    </div>
                    <div>
                        <span class="text-stone-500">Harga per orang:</span>
                        <p class="font-medium">Rp {{ number_format($pemesanan->harga_per_orang, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-stone-500">Jumlah Tamu:</span>
                        <p class="font-medium">{{ $pemesanan->jumlah_tamu }} orang</p>
                    </div>
                </div>
            </div>

            <!-- Event Info -->
            <div class="border-b pb-4">
                <h3 class="font-semibold text-stone-800 mb-3">Informasi Event</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-stone-500">Tanggal:</span>
                        <p class="font-medium">{{ $pemesanan->tanggal_event->format('d F Y') }}</p>
                    </div>
                    <div>
                        <span class="text-stone-500">Waktu:</span>
                        <p class="font-medium">{{ $pemesanan->waktu_mulai ? date('H:i', strtotime($pemesanan->waktu_mulai)) : '-' }}</p>
                    </div>
                    <div>
                        <span class="text-stone-500">Kota:</span>
                        <p class="font-medium">{{ $pemesanan->kota_event }}</p>
                    </div>
                    <div class="col-span-2">
                        <span class="text-stone-500">Lokasi:</span>
                        <p class="font-medium">{{ $pemesanan->lokasi_event }}</p>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if($pemesanan->catatan)
            <div class="border-b pb-4">
                <h3 class="font-semibold text-stone-800 mb-3">Catatan</h3>
                <p class="text-sm text-stone-600">{{ $pemesanan->catatan }}</p>
            </div>
            @endif

            <!-- Biaya -->
            <div class="border-b pb-4">
                <h3 class="font-semibold text-stone-800 mb-3">Rincian Biaya</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-500">Subtotal</span>
                        <span>Rp {{ number_format($pemesanan->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-500">PPN 11%</span>
                        <span>Rp {{ number_format($pemesanan->pajak, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t">
                        <span class="text-stone-800">Total</span>
                        <span class="text-amber-600">Rp {{ number_format($pemesanan->total_biaya, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="pt-4">
                @if($pemesanan->status == 'menunggu')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <p class="text-yellow-800 text-sm">
                            ⚠️ Pemesanan Anda menunggu konfirmasi dari admin. 
                            Silakan lakukan pembayaran DP sebesar 30% dari total biaya.
                        </p>
                    </div>
                    
                    <!-- Tombol Pembayaran (simulasi) -->
                    <button onclick="alert('Demo: Silakan transfer ke BCA 1234567890 a.n. LUMINA Catering')" 
                            class="w-full bg-green-500 text-white font-semibold py-3 rounded-xl hover:bg-green-600 transition mb-3">
                        💳 Konfirmasi Pembayaran
                    </button>
                    
                    <button onclick="showCancelModal()" 
                            class="w-full border border-red-300 text-red-600 font-semibold py-3 rounded-xl hover:bg-red-50 transition">
                        Batalkan Pemesanan
                    </button>
                @elseif($pemesanan->status == 'disetujui')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-green-800 text-sm">
                            ✅ Pemesanan telah disetujui! Kami akan menghubungi Anda untuk detail selanjutnya.
                        </p>
                    </div>
                @elseif($pemesanan->status == 'selesai')
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-blue-800 text-sm">
                            🎉 Event telah selesai! Terima kasih telah menggunakan layanan kami.
                        </p>
                    </div>
                @elseif($pemesanan->status == 'dibatalkan')
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-800 text-sm">
                            ❌ Pemesanan dibatalkan.
                            @if($pemesanan->alasan_batal)
                                <br>Alasan: {{ $pemesanan->alasan_batal }}
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Batal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold mb-4">Batalkan Pemesanan</h3>
        <p class="text-stone-600 mb-4">Apakah Anda yakin ingin membatalkan pemesanan ini?</p>
        <form action="{{ route('pemesanan.batal', $pemesanan->id) }}" method="POST">
            @csrf
            <textarea name="alasan_batal" required rows="3" 
                      class="w-full border border-stone-300 rounded-lg px-4 py-2 mb-4"
                      placeholder="Alasan pembatalan..."></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="closeCancelModal()" 
                        class="flex-1 border border-stone-300 py-2 rounded-lg hover:bg-stone-50">
                    Kembali
                </button>
                <button type="submit" 
                        class="flex-1 bg-red-500 text-white py-2 rounded-lg hover:bg-red-600">
                    Ya, Batalkan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showCancelModal() {
        document.getElementById('cancelModal').classList.remove('hidden');
    }
    
    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
    }
</script>
@endsection