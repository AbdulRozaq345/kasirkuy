<div>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $kategoriId ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>
                    <p class="text-subtitle text-muted">{{ $kategoriId ? 'Ubah data kategori' : 'Tambahkan kategori baru' }}</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Kategori</h4>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="simpan">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control {{ $this->isValid('nama') }}" id="nama" placeholder="Masukkan nama kategori" wire:model="nama">
                                    @error('nama')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary" wire:navigate>Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
