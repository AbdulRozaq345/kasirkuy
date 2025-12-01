<div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                @if (session()->has('error-message'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        {{ session('error-message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow border-0">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block">
                            <img src="{{ asset('mazer/assets/compiled/png/1.png') }}" alt="Login" class="img-fluid h-100 w-100 object-fit-cover rounded-start">
                        </div>
                        
                        <div class="col-md-6 p-4">
                            <h2 class="fw-bold mb-2">Login</h2>
                            <p class="text-muted mb-4">Masukkan email dan password Anda</p>
                            
                            <form wire:submit.prevent="login">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan email" wire:model="email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukkan password" wire:model="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Masuk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
