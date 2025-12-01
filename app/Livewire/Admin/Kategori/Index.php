<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\{On, Layout, Title};

class Index extends Component
{
    #[Title('Data Kategori')]
    #[Layout('layouts.app')]

    public $kategori = [];

    public function mount()
    {
        $this->loadKategori();
    }

    public function loadKategori()
    {
        $this->kategori = Category::latest()->get();
    }

    #[On('hapus')]
    public function hapus($id)
    {
        Category::findOrFail($id)->delete();
        $this->loadKategori();
        session()->flash('success', 'Kategori berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.admin.kategori.index');
    }
}
