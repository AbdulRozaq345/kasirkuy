<?php

namespace App\Livewire\Admin\Kasir;

//Jangan Lupa untuk mengimpor model User dan Hash
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Livewire\Component;
use Livewire\Attributes\{On, Url, Layout, Title, Locked, Validate};

class Form extends Component
{
    #[Title('Data Kasir')] // Menentukan judul halaman
    #[Layout('layouts.app')] // Menggunakan layout 'layouts.app' untuk tampilan

    // Properti untuk menyimpan data input form
    public $name, $email, $password, $kasirId;

    // Aturan validasi untuk input form
    // Ganti protected $rules dan menjadi method ini:
    public function rules()
    {
        return [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . ($this->kasirId ?? 'NULL'),
            'password' => 'required|min:4',
        ];
    }

    // Pesan error yang lebih ramah saat validasi gagal
    protected $messages = [
        'name.required'     => 'Nama kasir harus diisi.',
        'email.required'    => 'Email kasir harus diisi.',
        'email.email'       => 'Format email tidak valid.',
        'email.unique'      => 'Email sudah digunakan oleh pengguna lain.',
        'password.required' => 'Password harus diisi.',
        'password.min'      => 'Password minimal 4 karakter.',
    ];

    // Fungsi yang dijalankan saat komponen di-mount (pertama kali diakses)
    public function mount($kasirId = NULL)
    {
        if ($kasirId) {
            $user = User::find($kasirId); // Cari user berdasarkan ID
            if ($user) {
                // Isi properti dengan data user yang ditemukan
                $this->kasirId  = $user->id;
                $this->name     = $user->name;
                $this->email    = $user->email;
                $this->password = $user->password;
            }
        }
    }

    // Fungsi untuk menyimpan data kasir
    public function simpan()
    {
        $validation = $this->validate();

        // Hash password baru jika diisi, atau gunakan password lama jika tidak diubah
        $hashPass = $this->password ? Hash::make($validation['password']) : User::find($this->kasirId)?->password;

        // Simpan atau perbarui data kasir di database
        User::updateorCreate(
            ['id' => $this->kasirId], // Cari berdasarkan ID user
            [
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => $hashPass, // Password kasir (hashed) mengambil dari variabel $hashPass
            ]
        );

        // Tampilkan pesan sukses menggunakan session flash
        session()->flash('success', 'Kasir berhasil disimpan.');
        // Redirect ke halaman daftar kasir
        $this->redirectRoute('kasir.index', navigate: true);
    }

    // Fungsi yang dijalankan saat properti diperbarui
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Fungsi untuk memeriksa validasi input dan memberikan kelas Bootstrap
    public function isValid($field)
    {
        if ($this->getErrorBag()->has($field)) {
            return 'is-invalid';
        }

        return isset($this->$field) ? 'is-valid' : '';
    }

#[On('hapus')]
public function hapus($id)
{
    $kasir = User::findOrFail($id);
    $kasir->delete();
    $this->loadKasir(); // Refresh data
    session()->flash('success', 'Kasir berhasil dihapus');
}




    public function render()
    {
        return view('livewire.admin.kasir.form');
    }
}
