<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    #[Title('Form Produk')]
    #[Layout('layouts.app')]

    public $nama = '';
    public $stok = 0;
    public $harga_beli = 0;
    public $harga_jual = 0;
    public $id_kategori = null;
    public $foto;
    public $existingFoto = null;
    public $produkId = null;
    public $kategori = [];

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'id_kategori' => 'required|integer|min:1|exists:categories,id',
            'foto' => 'nullable|image|max:2048',
        ];
    }

    public function mount($produkId = null)
    {
        $this->kategori = Category::orderBy('nama')->get();
        if ($produkId) {
            $this->produkId = $produkId;
            $p = Product::findOrFail($produkId);
            $this->nama = $p->nama;
            $this->stok = $p->stok;
            $this->harga_beli = $p->harga_beli;
            $this->harga_jual = $p->harga_jual;
            $this->id_kategori = $p->id_kategori;
            $this->existingFoto = $p->foto;
        }
    }

    public function simpan()
    {
        $this->validate();

        $fotoPath = $this->existingFoto;
        if ($this->foto) {
            if ($this->existingFoto) {
                Storage::disk('public')->delete($this->existingFoto);
            }
            $fotoPath = $this->foto->store('produk', 'public');
        }

        $data = [
            'nama' => $this->nama,
            'stok' => $this->stok,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'id_kategori' => $this->id_kategori,
            'foto' => $fotoPath,
        ];

        // tambahkan barcode hanya saat create (produk baru)
        if (!$this->produkId) {
            $data['barcode'] = 'PROD-' . strtoupper(Str::random(8));
        }

        Product::updateOrCreate(['id' => $this->produkId], $data);

        session()->flash('success', 'Produk berhasil disimpan.');
        $this->redirectRoute('produk.index', navigate: true);
    }

    public function isValid($field)
    {
        return $this->getErrorBag()->has($field) ? 'is-invalid' : (isset($this->$field) && $this->$field !== '' ? 'is-valid' : '');
    }

    public function render()
    {
        return view('livewire.admin.produk.form');
    }
}
