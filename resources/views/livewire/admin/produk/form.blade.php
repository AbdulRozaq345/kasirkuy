<div>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $produkId ? 'Edit Produk' : 'Tambah Produk' }}</h3>
                    <p class="text-subtitle text-muted">{{ $produkId ? 'Ubah data produk' : 'Tambahkan produk baru' }}</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Produk</h4>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="simpan">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Produk</label>
                                            <input type="text" class="form-control {{ $this->isValid('nama') }}" id="nama" placeholder="Masukkan nama produk" wire:model="nama">
                                            @error('nama')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="id_kategori" class="form-label">Kategori</label>
                                            <select class="form-select {{ $this->isValid('id_kategori') }}" id="id_kategori" wire:model="id_kategori">
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach($kategori as $item)
                                                    <option value="{{ $item->id }}" @selected($this->id_kategori == $item->id)>{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_kategori')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="stok" class="form-label">Stok</label>
                                            <input type="number" class="form-control {{ $this->isValid('stok') }}" id="stok" placeholder="Masukkan stok" wire:model="stok">
                                            @error('stok')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="harga_beli" class="form-label">Harga Beli</label>
                                            <input type="number" class="form-control {{ $this->isValid('harga_beli') }}" id="harga_beli" placeholder="Masukkan harga beli" wire:model="harga_beli" step="0.01">
                                            @error('harga_beli')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="harga_jual" class="form-label">Harga Jual</label>
                                            <input type="number" class="form-control {{ $this->isValid('harga_jual') }}" id="harga_jual" placeholder="Masukkan harga jual" wire:model="harga_jual" step="0.01">
                                            @error('harga_jual')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Foto Produk</label>
                                            <input type="file" class="form-control" id="foto" wire:model="foto" accept="image/*">
                                            @if($existingFoto)
                                                <small class="d-block mt-2">Foto saat ini:</small>
                                                <img src="{{ Storage::url($existingFoto) }}" alt="Foto" style="max-width: 150px;" class="mt-2 rounded">
                                            @endif
                                            @error('foto')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('produk.index') }}" class="btn btn-secondary" wire:navigate>Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>