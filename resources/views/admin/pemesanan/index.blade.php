@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Kelola Pemesanan</h1>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pemesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Event</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pemesanans as $index => $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm font-medium">{{ $p->no_pemesanan }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->user->nama }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->tanggal_event->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->paket->nama_paket }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($p->total_biaya, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <select class="status-select text-xs px-2 py-1 rounded-full border-0 
                            @if($p->status == 'selesai') bg-green-100 text-green-800
                            @elseif($p->status == 'dibatalkan') bg-red-100 text-red-800
                            @elseif($p->status == 'disetujui') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800 @endif"
                            data-id="{{ $p->id }}">
                            <option value="menunggu" {{ $p->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ $p->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="disetujui" {{ $p->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $p->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.pemesanan.show', $p->id) }}" class="text-amber-600 hover:text-amber-800">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $pemesanans->links() }}
</div>

<script>
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const status = this.value;
            
            fetch(`/admin/pemesanan/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update class based on status
                    this.className = 'status-select text-xs px-2 py-1 rounded-full border-0';
                    if (status == 'selesai') this.classList.add('bg-green-100', 'text-green-800');
                    else if (status == 'dibatalkan') this.classList.add('bg-red-100', 'text-red-800');
                    else if (status == 'disetujui') this.classList.add('bg-blue-100', 'text-blue-800');
                    else this.classList.add('bg-yellow-100', 'text-yellow-800');
                    
                    alert('Status berhasil diupdate');
                }
            });
        });
    });
</script>
@endsection