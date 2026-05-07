<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StokBeras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokoController extends Controller
{
    /** Daftar produk beras yang tersedia */
    private function getProducts()
    {
        return [
            [
                'slug' => 'pandan-wangi',
                'nama' => 'Beras Pandan Wangi',
                'deskripsi' => 'Beras premium dengan aroma pandan alami yang khas. Cocok untuk nasi putih sehari-hari.',
                'harga' => 15000, // per kg
                'emoji' => '🌾',
            ],
            [
                'slug' => 'ketan',
                'nama' => 'Beras Ketan',
                'deskripsi' => 'Beras ketan berkualitas tinggi untuk kue tradisional dan olahan ketan lainnya.',
                'harga' => 18000,
                'emoji' => '🍚',
            ],
            [
                'slug' => 'beras-coklat',
                'nama' => 'Beras Coklat',
                'deskripsi' => 'Beras coklat organik kaya serat dan nutrisi. Pilihan sehat untuk keluarga.',
                'harga' => 22000,
                'emoji' => '🌿',
            ],
        ];
    }

    /** Landing page publik */
    public function index()
    {
        $products = $this->getProducts();
        $stok = StokBeras::first();
        $cart = session('cart', []);
        return view('toko.index', compact('products', 'stok', 'cart'));
    }

    /** Tambah ke keranjang (session-based) */
    public function addToCart(Request $request)
    {
        $request->validate([
            'slug' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        $products = $this->getProducts();
        $product = collect($products)->firstWhere('slug', $request->slug);

        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = session('cart', []);
        $slug = $request->slug;

        if (isset($cart[$slug])) {
            $cart[$slug]['jumlah'] += $request->jumlah;
        } else {
            $cart[$slug] = [
                'nama' => $product['nama'],
                'harga' => $product['harga'],
                'jumlah' => $request->jumlah,
                'slug' => $slug,
            ];
        }

        session(['cart' => $cart]);
        return back()->with('success', $product['nama'] . ' berhasil ditambahkan ke keranjang!');
    }

    /** Hapus item dari keranjang */
    public function removeFromCart(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->slug]);
        session(['cart' => $cart]);
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    /** Update jumlah item */
    public function updateCart(Request $request)
    {
        $request->validate([
            'slug' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        if (isset($cart[$request->slug])) {
            $cart[$request->slug]['jumlah'] = $request->jumlah;
        }
        session(['cart' => $cart]);
        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /** Halaman checkout — wajib login pelanggan */
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('toko')->with('error', 'Keranjang Anda kosong.');
        }

        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['jumlah']);
        return view('toko.checkout', compact('cart', 'total'));
    }

    /** Proses checkout → simpan transaksi */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti_transfer.required' => 'Bukti transfer wajib diunggah.',
            'bukti_transfer.image' => 'File harus berupa gambar.',
            'bukti_transfer.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('toko')->with('error', 'Keranjang Anda kosong.');
        }

        $pelangganId = session('pelanggan_id');
        $totalJumlahKg = collect($cart)->sum('jumlah');

        try {
            DB::beginTransaction();

            // Cek stok
            $stok = StokBeras::first();
            if (!$stok || $stok->ketersediaan_stok < $totalJumlahKg) {
                return back()->with('error', 'Maaf, stok beras tidak mencukupi untuk pesanan Anda.');
            }

            // Upload bukti transfer
            $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

            // Kurangi stok sementara
            $stok->ketersediaan_stok -= $totalJumlahKg;
            $stok->save();

            // Buat transaksi untuk setiap item
            foreach ($cart as $item) {
                Transaksi::create([
                    'id_pelanggan' => $pelangganId,
                    'jenis_beras' => $item['nama'],
                    'harga_satuan' => $item['harga'],
                    'tanggal_pesanan' => now()->toDateString(),
                    'jumlah_pesanan' => $item['jumlah'],
                    'total_harga' => $item['harga'] * $item['jumlah'],
                    'bukti_transfer' => $buktiPath,
                    'status_pesanan' => Transaksi::STATUS_MENUNGGU,
                ]);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('toko.pesanan')->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi dari staf penjualan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /** Halaman riwayat pesanan pelanggan */
    public function pesanan()
    {
        $pelangganId = session('pelanggan_id');
        $transaksis = Transaksi::where('id_pelanggan', $pelangganId)->latest()->get();
        return view('toko.pesanan', compact('transaksis'));
    }
}
