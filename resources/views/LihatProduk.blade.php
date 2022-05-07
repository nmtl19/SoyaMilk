@extends('Index2')

@section('Title')
Produk
@endsection

@section('Main')
<br><br>
<div class="grid grid-cols-3">
    <div class="w-full">
        <div class="w-full px-3 py-2 rounded-xl"><img src="{{ asset('foot-produk/'.$Produk->gambar) }}" height="100%" width="100%" class="mb-5"></div>
    </div>
    <div class="w-full">
        <div class="w-full px-3 py-2 rounded-xl">
            <p style="font-size:30px;" class="text-[#000000] text-lg mb-5"><b>{{ $Produk->nama_produk }}</b></p>
            <p style="font-size:14px;" class="text-justify">Varian : {{ $Produk->berat }} ml</p>
            <p style="font-size:24px;" class="text-[#017707] text-lg mb-10"><b>Rp {{number_format($Produk->harga)}}</b></p>
            <br><br><br><br><br>
            <p style="font-size:12px;" class="text-[#000000] text-lg"><i class="fa-solid fa-map-marker text-[#017707]"></i> Dikirim dari Jember</p>
            <p style="font-size:12px;" class="text-[#000000] text-lg"><i class="fa-solid fa-truck text-[#017707]"></i> Akan diterima -+ 30 menit</p>
        </div>
    </div>
    <div class="w-full">
        <div class="w-full px-3 py-2 rounded-xl">
            <div class="card mt-2">
                <div class="container-fluid">
                    Pilih Varian
                    <br><br>
                    Ukuran :
                    <p class="text-justify" data-harga>{{ $Produk->berat }} ml</p>
                    <br><br>
                    Atur Jumlah Pembelian
                    <form action="/AuthPemesananProduk/{{$Produk->id}}" method="post">
                        @csrf
                    <div class="w-full">
                        <input type="number" name="jumlah_pembelian" min="0" placeholder="Jumlah Pembelian" class="w-full px-3 py-2 rounded-xl" required><br><br>
                        Tanggal Pengiriman
                        <input type="date" name="tanggal_pengantaran" placeholder="Jumlah Pembelian" class="w-full px-3 py-2 rounded-xl" required><br><br>
                        Metode Pembayaran
                        <select class="form-select" name="metode_pembayaran" required>
                            <option value="">Pilih Metode Pembayaran---</option>
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cod">Cash on Delivery</option>
                        </select>
                    </div>
                    <br><br>
                        <input type="hidden" name="produk_id" value="{{$Produk->id}}">
                        <input type="hidden" name="customer_id" value="{{$data->id}}">
                        <input type="hidden" name="total_pembayaran" value="">
                        <div class="text-center">
                            <button type="submit" class="float-center font-normal text-sm px-10 py-2 rounded-full bg-[#519259] text-white">Beli</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="/UlasanProduk/{{$Produk->id}}" class="float-center font-normal text-sm px-10 py-2 rounded-full bg-[#519259] text-white">Ulasan Produk</a>
@endsection