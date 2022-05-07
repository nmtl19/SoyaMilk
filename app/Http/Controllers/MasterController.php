<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\Mitra;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\UlasanProduk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MasterController extends Controller
{
    public function Landing()
    {
        return view('Landing');
    }
    public function Registrasi()
    {
        if (Session::has('Login')) {
            return redirect()->route('Beranda');
        }
        return view('Registrasi');
    }
    public function AuthRegistrasi(Request $req)
    {
        $userid = User::select('id')->orderBy('id', 'desc')->first();
        $userid = $userid['id'] + 1;
        $Mitra = DB::table('mitra')->where('email', $req->email)->count();
        $Customer = DB::table('customer')->where('email', $req->email)->count();
        if ($Mitra == 0 && $Customer == 0) {
            DB::table('users')->insert([
                'name' => $req->nama,
                'email' => $req->email,
                'password' => $req->password,
                'role' => 'customer'
            ]);

            DB::table('customer')->insert([
                'user_id' => $userid,
                'nama' => $req->nama,
                'email' => $req->email,
                'password' => $req->password,
                'no_telp' => $req->noTelp,
                'alamat' => $req->alamat,
                'desa' => $req->desa,
                'kecamatan' => $req->kecamatan,
                'jenis_kelamin' => $req->kelamin
            ]);
            Session::flash('alertSuccess', 'Registrasi Berhasil');
            return back();
        } else {
            Session::flash('alertError', 'Email Telah Digunakan');
            return back();
        }
    }
    public function Login()
    {
        if (Session::has('Login')) {
            return redirect()->route('Beranda');
        }
        return view('Login');
    }
    public function AuthLogin(Request $req)
    {
        $Customer = DB::table('customer')->where('email', $req->email);
        $Mitra = DB::table('mitra')->where('email', $req->email);
        if ($Customer->count() == 1) {
            if ($Customer->first()->password == $req->password) {
                Session::put('Login', TRUE);
                Session::put('Id', $Customer->first()->id);
                Session::put('Email', $req->email);
                Session::put('Level', 'Customer');
                return redirect()->route('Beranda');
            } else {
                Session::flash('alertInfo', 'Password Salah');
                return back();
            }
        } elseif ($Mitra->count() == 1) {
            if ($Mitra->first()->password == $req->password) {
                Session::put('Login', TRUE);
                Session::put('Email', $req->email);
                Session::put('Level', 'Mitra');
                return redirect()->route('Beranda');
            } else {
                Session::flash('alertInfo', 'Password Salah');
                return back();
            }
        } else {
            Session::flash('alertInfo', 'Username Belum Terdaftar');
            return back();
        }
    }
    public function Logout()
    {
        Session::forget('Login');
        Session::forget('Email');
        Session::forget('Level');
        return redirect()->route('Login');
    }
    public function Beranda()
    {
        $Artikel = DB::table('artikel')->get();
        return view('Beranda', compact('Artikel'));
    }
    public function BiodataDiri()
    {
        if (Session::get('Level') == 'Mitra') {
            $Biodata = DB::table('mitra')->where('email', Session::get('Email'))->first();
        } else {
            $Biodata = DB::table('customer')->where('email', Session::get('Email'))->first();
        }
        return view('BiodataDiri', compact('Biodata'));
    }
    public function AuthBiodataDiri(Request $req)
    {
        if (Session::get('Level') == 'Mitra') {
            $Biodata = DB::table('mitra')->where('email', Session::get('Email'));
            $Biodata2 = DB::table('users')->where('email', Session::get('Email'));
        } else {
            $Biodata = DB::table('customer')->where('email', Session::get('Email'));
            $Biodata2 = DB::table('users')->where('email', Session::get('Email'));
        }
        $Biodata2->update([
            'name' => $req->nama,
            'email' => $req->email,
            'password' => $req->password
        ]);
        $Biodata->update([
            'nama' => $req->nama,
            'password' => $req->password,
            'no_telp' => $req->noTelp,
            'alamat' => $req->alamat,
            'desa' => $req->desa,
            'kecamatan' => $req->kecamatan,
            'jenis_kelamin' => $req->kelamin
        ]);
        Session::flash('alertSuccess', 'Biodata Diri Berhasil Diubah');
        return back();
    }
    public function BiodataMitra()
    {
        $Biodata = DB::table('mitra')->first();
        return view('BiodataMitra', compact('Biodata'));
    }
    public function AkunCustomer()
    {
        $Customer = DB::table('customer')->get();
        return view('AkunCustomer', compact('Customer'));
    }
    public function BiodataCustomer($id)
    {
        $Biodata = DB::table('customer')->where('id', $id)->first();
        return view('BiodataCustomer', compact('Biodata'));
    }
    public function LihatArtikel($id)
    {
        $Artikel = DB::table('artikel')->where('id', $id)->first();
        return view('LihatArtikel', compact('Artikel'));
    }
    public function TambahArtikel()
    {
        return view('TambahArtikel');
    }
    public function AuthTambahArtikel(Request $req)
    {
        $NamaFile = time() . '.' . $req->file->getClientOriginalExtension();
        $req->file->move('../public/artikel', $NamaFile);
        DB::table('artikel')->insert([
            'judul' => $req->judul,
            'penulis' => $req->penulis,
            'penerbit' => $req->penerbit,
            'isi' => $req->isi,
            'gambar' => $NamaFile,
            'mitra_id' => 1
        ]);
        Session::flash('alertSuccess', 'Artikel Berhasil Ditambah');
        return back();
    }
    public function EditArtikel($id)
    {
        $Artikel = DB::table('artikel')->where('id', $id)->first();
        return view('EditArtikel', compact('Artikel'));
    }
    public function AuthEditArtikel(Request $req)
    {
        DB::table('artikel')->where('id', $req->id)->update([
            'judul' => $req->judul,
            'penulis' => $req->penulis,
            'penerbit' => $req->penerbit,
            'isi' => $req->isi
        ]);
        Session::flash('alertSuccess', 'Artikel Berhasil Diubah');
        return back();
    }
    public function HapusArtikel($id)
    {
        $Data = DB::table('artikel')->where('id', $id);
        unlink('artikel/' . $Data->first()->gambar);
        $Data->delete();
        Session::flash('alertSuccess', 'Artikel Berhasil Dihapus');
        return back();
    }

    public function Produk()
    {
        $Produk = DB::table('produk')->get();
        return view('Produk', compact('Produk'));
    }

    public function TambahProduk()
    {
        return view('TambahProduk');
    }

    public function AuthTambahProduk(Request $req)
    {
        $NamaFile = time() . '.' . $req->file->getClientOriginalExtension();
        $req->file->move('../public/foot-produk', $NamaFile);
        DB::table('produk')->insert([
            'nama_produk' => $req->nama_produk,
            'harga' => $req->harga,
            'berat' => $req->berat,
            'gambar' => $NamaFile,
            'mitra_id' => 1
        ]);
        Session::flash('alertSuccess', 'Produk Berhasil Ditambah');
        return back();
    }

    public function LihatProduk($id)
    {
        if (Session::get('Level') == 'Customer') {
            $data = DB::table('customer')->where('email', Session::get('Email'))->first();
        }else{
            $data = DB::table('mitra')->where('email', Session::get('Email'))->first();
        }
        $Produk = DB::table('produk')->where('id', $id)->first();
        return view('LihatProduk', compact('Produk', 'data'));
    }

    public function EditProduk($id)
    {
        $Produk = DB::table('produk')->where('id', $id)->first();
        return view('EditProduk', compact('Produk'));
    }

    public function AuthEditProduk(Request $req)
    {
        DB::table('produk')->where('id', $req->id)->update([
            'nama_produk' => $req->nama_produk,
            'harga' => $req->harga,
            'berat' => $req->berat
        ]);
        Session::flash('alertSuccess', 'Produk Berhasil Diubah');
        return back();
    }
    public function HapusProduk($id)
    {
        $Data = DB::table('produk')->where('id', $id);
        unlink('foto-produk/' . $Data->first()->gambar);
        $Data->delete();
        Session::flash('alertSuccess', 'Produk Berhasil Dihapus');
        return back();
    }

    public function AuthPemesananProduk(Request $req, $id)
    {
        $data = Produk::select('harga')->where('id', $id)->first();
        $data = $data['harga'];
        $harga = intval($data);
        Pemesanan::create([
            'produk_id' => $req->produk_id,
            'customer_id' => $req->customer_id,
            'total_pembayaran' => intval($req->jumlah_pembelian) * $harga,
            'metode_pembayaran' => $req->metode_pembayaran,
            'tanggal_pengantaran' => $req->tanggal_pengantaran
        ]);
        Keuangan::create([
            'keterangan' => 'masuk',
            'transaksi' => 'Penjualan',
            'jumlah_transaksi' => $req->jumlah_pembelian,
            'harga_satuan' => $harga,
            'total_transaksi' => intval($req->jumlah_pembelian) * $harga
        ]);
        Session::flash('alertSuccess', 'Pemesanan Berhasil Dibuat');
        return back();
    }

    public function Pemesanan()
    {
        if (Session::get('Level') == 'Mitra') {
            $data = DB::table('mitra')->where('email', Session::get('Email'))->first();

            $Pemesanan = DB::table('pemesanan_produk')->join('customer','pemesanan_produk.customer_id','=','customer.id')->join('produk','pemesanan_produk.produk_id','=','produk.id')->select('customer.nama','customer.no_telp','customer.alamat','produk.nama_produk','produk.harga','produk.berat','produk.gambar','pemesanan_produk.id','pemesanan_produk.produk_id','pemesanan_produk.customer_id','pemesanan_produk.total_pembayaran','pemesanan_produk.metode_pembayaran','pemesanan_produk.tanggal_pengantaran','pemesanan_produk.customer_id')->get();
        
            return view('Pemesanan', compact('Pemesanan'));
        }else{
            $data = DB::table('customer')->where('email', Session::get('Email'))->first();
            $data_id = $data->id;

            $Pemesanan = DB::table('pemesanan_produk')->join('customer','pemesanan_produk.customer_id','=','customer.id')->join('produk','pemesanan_produk.produk_id','=','produk.id')->select('customer.nama','customer.no_telp','customer.alamat','produk.nama_produk','produk.harga','produk.berat','produk.gambar','pemesanan_produk.id','pemesanan_produk.produk_id','pemesanan_produk.customer_id','pemesanan_produk.total_pembayaran','pemesanan_produk.metode_pembayaran','pemesanan_produk.tanggal_pengantaran','pemesanan_produk.customer_id')->where('pemesanan_produk.customer_id',$data_id)->first();

            return view('PemesananCustomer', compact('Pemesanan'));
        }
    }

    public function DetailPemesanan($id)
    {
        $Pemesanan = DB::table('pemesanan_produk')->join('customer','pemesanan_produk.customer_id','=','customer.id')->join('produk','pemesanan_produk.produk_id','=','produk.id')->select('customer.nama','customer.no_telp','customer.alamat','produk.nama_produk','produk.harga','produk.berat','produk.gambar','pemesanan_produk.id','pemesanan_produk.produk_id','pemesanan_produk.customer_id','pemesanan_produk.total_pembayaran','pemesanan_produk.metode_pembayaran','pemesanan_produk.tanggal_pengantaran')->where('pemesanan_produk.id', $id)->first();

        return view('DetailPemesanan', compact('Pemesanan'));
    }

    public function UlasanProduk($id)
    {
        $Produk = Produk::where('id', $id)->first();
        if (Session::get('Level') == 'Customer') {
            $data = DB::table('customer')->where('email', Session::get('Email'))->first();
            
            $Ulasan = UlasanProduk::join('produk','ulasan_produk.produk_id','=','produk.id')->join('customer','ulasan_produk.customer_id','=','customer.id')->select('ulasan_produk.produk_id','ulasan_produk.customer_id','ulasan_produk.deskripsi','ulasan_produk.gambar','produk.nama_produk','produk.harga','produk.berat','produk.gambar','customer.nama','ulasan_produk.id')->where('ulasan_produk.produk_id', $id)->get();
            
            return view('UlasanProduk', compact('Produk','Ulasan','data'));
        }else{
            $Ulasan = UlasanProduk::join('produk','ulasan_produk.produk_id','=','produk.id')->join('customer','ulasan_produk.customer_id','=','customer.id')->select('ulasan_produk.produk_id','ulasan_produk.customer_id','ulasan_produk.deskripsi','ulasan_produk.gambar','produk.nama_produk','produk.harga','produk.berat','produk.gambar','customer.nama','ulasan_produk.id')->where('ulasan_produk.produk_id', $id)->get();
            
            return view('UlasanProdukAdmin', compact('Produk','Ulasan'));
        }
    }

    public function AuthUlasanProduk(Request $req, $id)
    {
        UlasanProduk::insert([
            'produk_id' => $req->produk_id,
            'customer_id' => $req->customer_id,
            'deskripsi' => $req->deskripsi
        ]);
        Session::flash('alertSuccess', 'Ulasan Berhasil Dibuat');
        return back();
    }

    public function HapusUlasan($id)
    {
        $Data = DB::table('ulasan_produk')->where('id', $id);
        $Data->delete();
        Session::flash('alertSuccess', 'Ulasan Berhasil Dihapus!');
        return back();
    }

    public function Keuangan()
    {
        $Keuangan = Keuangan::all();
        return view('Keuangan', compact('Keuangan'));
    }

    public function TambahKeuangan()
    {
        return view('TambahKeuangan');
    }

    public function AuthTambahKeuangan(Request $req)
    {
        Keuangan::create([
            'keterangan' => $req->keterangan,
            'transaksi' => $req->transaksi,
            'jumlah_transaksi' => $req->jumlah_transaksi,
            'harga_satuan' => $req->harga_satuan,
            'total_transaksi' => intval($req->jumlah_transaksi) * intval($req->harga_satuan)
        ]);
        Session::flash('alertSuccess', 'Data Keuangan Berhasil Ditambah!');
        return back();
    }

}
