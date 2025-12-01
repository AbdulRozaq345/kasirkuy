<div>
   <div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kategori</h3>
                <p class="text-subtitle text-muted">Kelola semua kategori produk</p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kategori</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="card-title mb-0">Tabel Kategori</h4>
                        <a href="{{ route('kategori.form') }}" class="btn btn-primary btn-sm" wire:navigate>
                            <i class="bi bi-plus-lg me-1"></i> Tambah
                        </a>
                    </div>
                    
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Mobile Card View -->
                            <div class="d-md-none">
                                @forelse($kategori ?? [] as $item)
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $item->nama }}</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('kategori.form', $item->id) }}" class="btn btn-warning btn-sm" wire:navigate>
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <button onclick="konfirmasiHapus({{ $item->id }})" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash2"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info">Tidak ada kategori.</div>
                                @endforelse
                            </div>

                            <!-- Desktop Table View -->
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kategori ?? [] as $item)
                                          <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <a href="{{ route('kategori.form', $item->id) }}" class="btn btn-warning btn-sm" wire:navigate>
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button onclick="konfirmasiHapus({{ $item->id }})" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                          </tr>
                                        @empty
                                          <tr><td colspan="3" class="text-center">Tidak ada kategori.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
