<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title, Validate};

class Login extends Component
{
    #[Title('Login')]
    #[Layout('layouts.auth')]

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required|min:4')]
    public $password = '';

   public function login()
{
    $this->validate();

    if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) { 
        session()->flash('success-message', 'Berhasil Login!'); 

       
        if (Auth::user()->role == 'admin') {
            $this->redirectIntended('produk', navigate: true); 
        } else {
            $this->redirectIntended('transaksi'); 
        }

    } else {
        session()->flash('error-message', 'Login gagal, periksa email atau password anda');
    }
}

    public function render()
    {
        return view('livewire.auth.login');
    }
}
