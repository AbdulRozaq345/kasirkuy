<?php

namespace App\Livewire\Admin\Kasir;

use App\Models\User; //Pastikan memanggil model user, jika tidak ingin manual, coba CTRL+BACKSPACE+ENTER pada saat USER::where (arahkan cursor ditengah antara USER(cursor disini)::)
use Livewire\Component;
use Livewire\Attributes\{On, Url, Layout, Title, Locked, Validate};

class Index extends Component
{
    #[Title('Data Kasir')] // Menentukan judul halaman
    #[Layout('layouts.app')] // Menggunakan layout 'layouts.app' untuk tampilan
    

    // Properti untuk menyimpan data kasir
    public $kasir;

    // Fungsi yang dijalankan saat komponen di-mount (pertama kali diakses)
    public function mount()
    {
        $this->loadKasir(); // Memuat data kasir dari database
    }

    // Fungsi untuk mengambil data kasir dari database
    public function loadKasir()
    {
        $this->kasir = User::where('role', 'kasir')
        ->latest()->get(); // Mengurutkan data dari yang terbaru dan mengambil semua data kasir
    }

    #[On('hapus')]
    public function hapus($id)
{
    $kasir = User::findOrFail($id); // Mencari kasir berdasarkan ID yang diberikan
    $kasir->delete();
    $this->loadKasir(); // Refresh data
    session()->flash('success', 'Kasir berhasil dihapus');
}

    public function render()
    {
        return view('livewire.admin.kasir.index');
    }
}

