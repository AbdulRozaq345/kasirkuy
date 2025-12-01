<?php

namespace App\Livewire\Transaksi;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\{On, Layout, Title};

class Transaksi extends Component
{
    // Menetapkan judul halaman dan layout yang digunakan
    #[Title('Transaksi')]
    #[Layout('layouts.app')]

    // Properti Livewire untuk menyimpan data transaksi
    public $keranjang = [], $total = 0, $diskon = 0, $tunai, $kembalian = 0;
    public $search = '', $barcode_input, $scanning = true;

    // Listener untuk event barcode yang dikirim dari JS (kamera scanner)
    protected $listeners = ['barcodeScanned'];

    // Handler untuk event barcodeScanned
    #[On('barcodeScanned')]
    public function barcodeScanned($barcode)
    {
        if (!$this->scanning) return; // Cegah pemrosesan dobel saat scanning aktif

        $this->scanning = false;
        $this->tambahByBarcode(trim($barcode)); // Tambah produk berdasarkan barcode
        $this->dispatch('resetScanner'); // Dispatch event JS untuk reset scanner
    }

    public function mount()
    {
        // No special mount behavior required
        // (categories filter removed to restore previous behavior)
    }

    // Cari produk berdasarkan barcode
    private function tambahByBarcode($barcode)
    {
        $produk = Product::where('barcode', $barcode)->first();

        if (!$produk) {
            session()->flash('error', 'Produk tidak ditemukan!');
            $this->scanning = true;
            return;
	        }elseif ($produk->stok <= 0) {
            session()->flash('error', 'Stok Produk Habis!');
            $this->scanning = true;
            return;
        }

        $this->tambahKeKeranjang($produk); // Jika produk ditemukan, tambahkan ke keranjang
        $this->scanning = true;
    }

    // Tambahkan produk secara manual ke keranjang berdasarkan ID
    public function tambahProduk($produkId)
		{
	    $produk = Product::find($produkId);
	
	    if ($produk->stok <= 0) { // Cek stok produk
	        session()->flash('error', 'Stok Produk Habis!');
	        return;
	    }
	
	    $this->tambahKeKeranjang($produk); // Tambahkan produk ke keranjang
		}

    // Tambahkan produk ke keranjang atau update qty jika sudah ada
    private function tambahKeKeranjang($produk)
    {
        foreach ($this->keranjang as &$item) {
            if ($item['id'] == $produk->id) {
                $item['qty']++;
                $item['subtotal'] = $item['qty'] * $item['harga'];
                $this->hitungTotal();
                return;
            }
        }

        // Tambah item baru ke keranjang
        $this->keranjang[] = [
            'id' => $produk->id,
            'nama' => $produk->nama,
            'qty' => 1,
            'harga' => $produk->harga_jual,
            'subtotal' => $produk->harga_jual,
        ];
        $this->hitungTotal();
    }

    // Tambah qty produk di keranjang
    public function tambahQty($produkId)
    {
        foreach ($this->keranjang as &$item) {
            if ($item['id'] == $produkId) {
                $item['qty']++;
                $item['subtotal'] = $item['qty'] * $item['harga'];
                break;
            }
        }
        $this->hitungTotal();
    }

    // Kurangi qty produk di keranjang, hapus jika qty <= 0
    public function kurangiQty($produkId)
    {
        foreach ($this->keranjang as $key => &$item) {
            if ($item['id'] == $produkId) {
                $item['qty']--;
                if ($item['qty'] <= 0) {
                    unset($this->keranjang[$key]);
                } else {
                    $item['subtotal'] = $item['qty'] * $item['harga'];
                }
                break;
            }
        }
        $this->hitungTotal();
    }

    // Clear input pencarian
    public function clearSearch()
    {
        $this->search = '';
    }

    // Hitung total dan diskon berdasarkan isi keranjang
    public function hitungTotal()
    {
        $this->total = collect($this->keranjang)->sum('subtotal');
        $this->diskon = ($this->total >= 50000) ? 5000 : 0;
    }

    // Update nilai kembalian berdasarkan uang tunai yang diinput
    public function updatedTunai()
    {
        $this->kembalian = (int) $this->tunai - ($this->total - $this->diskon);
    }

    // Simpan transaksi ke database
    public function simpanTransaksi()
    {
        DB::beginTransaction();
        
        $today = now()->format('Ymd');

        // Hitung jumlah transaksi hari ini
        $countToday = Transaction::whereDate('created_at', today())->count() + 1;
        $urutan = str_pad($countToday, 3, '0', STR_PAD_LEFT); // jadi 001, 002, dst

        $kode = 'TRX-' . $today . '-' . $urutan;

        // Simpan transaksi utama
        $trx = Transaction::create([
            'id_kasir'  => Auth::id(),
            'total'     => $this->total,
            'diskon'    => $this->diskon,
            'tunai'     => $this->tunai,
            'kembalian' => $this->kembalian,
            'kode'      => $kode
        ]);

        if ($trx) {
            // Simpan detail produk yang dibeli
            foreach ($this->keranjang as $item) {
                TransactionDetail::create([
                    'id_transaksi' => $trx->id,
                    'id_produk'    => $item['id'],
                    'qty'          => $item['qty'],
                    'harga'        => $item['harga'],
                    'subtotal'     => $item['subtotal'],
                ]);
            }
            
            // Kurangi stok produk
            $produk = Product::find($item['id']);
            if ($produk) {
                $produk->decrement('stok', $item['qty']);
            }

            DB::commit(); // Simpan transaksi
            $this->resetKeranjang(); // Reset data input
            session()->flash('success', 'Transaksi berhasil disimpan!');
        } else {
            DB::rollBack(); // Gagal, rollback transaksi
            session()->flash('error', 'Gagal menyimpan transaksi!');
        }
    }

    // Reset semua input transaksi dan keranjang
    public function resetKeranjang()
    {
        $this->keranjang = [];
        $this->total = $this->diskon = $this->tunai = $this->kembalian = 0;
    }

    // Render view dan ambil daftar produk berdasarkan pencarian
	public function render()
	{
	    $query = Product::query();
	
        // No category filter: keep the original behavior (show products based on search or all)

        if (!empty($this->search)) {
            // Jika ada pencarian, tampilkan semua hasil yang cocok (dengan kategori bila dipilih)
            $barang = $query->where('nama', 'like', '%' . $this->search . '%')
                ->orderByRaw("CASE WHEN nama LIKE ? THEN 0 ELSE 1 END", [$this->search . '%'])
                ->orderBy('nama')
                ->get();
        } else {
            // Jika tidak ada pencarian, tampilkan semua barang (dengan kategori bila dipilih)
            $barang = $query->orderBy('nama')
                ->get();
        }
	

        return view('livewire.transaksi.transaksi', [
            'barang' => $barang,
        ]);
	}
}