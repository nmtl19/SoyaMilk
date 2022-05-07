@extends('Index2')

@section('Title')
    Keuangan
@endsection

@section('Main')
<a href="{{ route('TambahKeuangan') }}" class="float-right font-normal text-sm px-3 py-2 rounded-full bg-[#519259] text-white">Tambah Keuangan</a>

    <div class="px-3 py-2 rounded-xl border mt-3 mb-7 w-[50%]">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="" id="" placeholder="Cari Customer....">
    </div>
    @foreach ($Keuangan as $dt)
    <div class="grid grid-cols-4 gap-1 px-12 py-5 rounded-xl border mb-3">
        <div><p>{{ $dt->keterangan }}</p></div>
        <div><p>{{ $dt->transaksi }}</p></div>
        <div><p>Rp{{ number_format($dt->total_transaksi)}}</p></div>
        <div><a href="{{ url('DetailKeuangan'.'/'.$dt->id) }}" class="px-5 py-1 rounded-full border">LIHAT DETAIL</a></div>
    </div>
    @endforeach
@endsection