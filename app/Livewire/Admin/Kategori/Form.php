<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title};

class Form extends Component
{
    #[Title('Form Kategori')]
    #[Layout('layouts.app')]

    public $nama = '';
    public $kategoriId = null;

    protected $rules = [
        'nama' => 'required|string|max:255',
    ];

    public function mount($kategoriId = null)
    {
        if ($kategoriId) {
            $this->kategoriId = $kategoriId;
            $c = Category::findOrFail($kategoriId);
            $this->nama = $c->nama;
        }
    }

    public function simpan()
    {
        $this->validate();
        Category::updateOrCreate(['id' => $this->kategoriId], ['nama' => $this->nama]);
        session()->flash('success', 'Kategori berhasil disimpan.');
        $this->redirectRoute('kategori.index', navigate: true);
    }

    public function isValid($field)
    {
        return $this->getErrorBag()->has($field) ? 'is-invalid' : (isset($this->$field) && $this->$field !== '' ? 'is-valid' : '');
    }

    public function render()
    {
        return view('livewire.admin.kategori.form');
    }
}