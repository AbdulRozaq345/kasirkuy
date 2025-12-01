<?php

namespace App\Livewire\Admin\Produk;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Livewire\Attributes\{On, Layout, Title};
use Livewire\Component;

class Index extends Component
{
    #[Title('Data Produk')]
    #[Layout('layouts.app')]

    public $produk = [];

    public function mount()
    {
        $this->loadProduk();
    }

    public function loadProduk()
    {
        $this->produk = Product::with('kategori')->latest()->get();
    }

    #[On('hapus')]
    public function hapus($id)
    {
        $produk = Product::findOrFail($id);
        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }
        $produk->delete();
        $this->loadProduk();
        session()->flash('success', 'Produk berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.admin.produk.index');
    }
}
