@extends('Index2')

@section('Title')
Detail Pemesanan
@endsection

@section('Main')
<br><br>
<div class="grid grid-cols-3">
    <div class="w-full">
        <div class="w-full px-3 py-2 rounde d-xl"><img src="{{ asset('foot-produk/'.$Pemesanan->gambar) }}" height="100%" width="100%" class="mb-5"></div>
    </div>
    <div class="w-full">
        <div class="w-full px-3 py-2 rounded-xl">
            <p style="font-size:18;" class="text-[#000000] text-lg mb-5"><b>Data Produk</b></p><br>
            <p style="font-size:30px;" class="text-[#000000] text-lg mb-5"><b>{{ $Pemesanan->nama_produk }}</b></p>
            <p style="font-size:14px;" class="text-justify">Varian : {{ $Pemesanan->berat }} ml</p>
            <p style="font-size:24px;" class="text-[#017707] text-lg mb-10"><b>Rp {{number_format($Pemesanan->harga)}}</b></p>
            <br><br><br><br><br>
        </div>
    </div>
    <div class="w-full">
        <div class="w-full px-3 py-2 rounded-xl">
            <p style="font-size:18;" class="text-[#000000] text-lg mb-5"><b>Data Pembeli</b></p><br>
            <p style="font-size:30px;" class="text-[#000000] text-lg mb-5"><b>{{ $Pemesanan->nama }}</b></p>
            <p style="font-size:18px;" class="text-justify">Pengantaran : {{ $Pemesanan->tanggal_pengantaran }}</p>
            <p style="font-size:14px;" class="text-justify">Metode Pembayaran : {{ $Pemesanan->metode_pembayaran }}</p>
            <p style="font-size:24px;" class="text-[#012762] text-lg mb-10"><b>Total = Rp {{number_format($Pemesanan->total_pembayaran)}}</b></p>
            <br><br><br><br><br>
        </div>
    </div>
</div>
@endsection