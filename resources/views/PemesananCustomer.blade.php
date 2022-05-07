@extends('Index2')

@section('Title')
Pemesanan
@endsection

@section('Main')
<div class="px-3 py-2 rounded-xl border mt-3 mb-7 w-[50%]">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" name="" id="" placeholder="Cari Customer....">
</div>
<div class="grid grid-cols-3 gap-1 px-12 py-5 rounded-xl border mb-3">
    <div class="w-full">
        <div class="w-full px-3 py-2 rounded-xl"><img src="{{ asset('foot-produk/'.$Pemesanan->gambar) }}" height="40%" width="40%" class="mb-5"></div>
    </div>
    <div class="w-full">
        <div class="w-full px-3 py-2 rounded-xl">
            <p>{{ $Pemesanan->nama_produk }}</p>
            <p>Varian : {{ $Pemesanan->berat }} ml</p>
            <p>Total : <p style="font-size:24px;" class="text-[#017707] text-lg mb-10"><b>Rp {{ number_format($Pemesanan->harga)}}</b></p></p>
        </div>
    </div>
    <div><br><br><a href="{{ url('DetailPemesanan'.'/'.$Pemesanan->id) }}" class="px-5 py-1 rounded-full border bg-[#519259]"><b>LIHAT DETAIL</b></a></div>
</div>
@endsection