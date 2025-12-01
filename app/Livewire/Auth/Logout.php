<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth; 

class Logout extends Component
{
// Tambahkan use untuk Auth Facades

// Fungsi Logout
public function logout()
{
    // Logout pengguna yang sedang login
    Auth::logout();
    // Menghapus semua data sesi pengguna
    session()->invalidate();
    // Membuat ulang token CSRF untuk keamanan
    session()->regenerateToken();

    // Redirect pengguna ke halaman login
    $this->redirectRoute('login');
}
}
