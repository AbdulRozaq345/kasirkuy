<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Form Kasir</h3>
                <p class="text-subtitle text-muted">Tambah atau Edit Kasir</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kasir</li>
                        <li class="breadcrumb-item active" aria-current="page">Form</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="card-title mb-0">Form Kasir</h4>
                        <a href="{{ Route('kasir.index') }}" class="btn btn-secondary btn-sm" wire:navigate>
                            <i class="bi bi-box-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="card-body">
                        <form wire:submit.prevent='simpan'>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kasir</label>
                                <input type="text" class="form-control {{ $this->isValid('name') }}" id="name" wire:model.live='name' placeholder="Masukkan Nama Kasir">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control {{ $this->isValid('email') }}" id="email" wire:model.live='email' placeholder="Masukkan Email Kasir">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control {{ $this->isValid('password') }}" id="password" wire:model.live='password' placeholder="Masukkan Password">
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="{{ Route('kasir.index') }}" class="btn btn-secondary" wire:navigate>Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>