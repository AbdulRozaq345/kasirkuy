<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kasir</h3>
                <p class="text-subtitle text-muted">Kelola Data Kasir</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kasir</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="card-title mb-0">Tabel Kasir</h4>
                        <a href="{{ Route('kasir.form') }}" class="btn btn-primary btn-sm" wire:navigate>
                            <i class="bi bi-plus-lg me-1"></i> Tambah
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Mobile Card View -->
                            <div class="d-md-none">
                                @forelse($kasir ?? [] as $item)
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $item->name }}</h6>
                                            <p class="mb-2">
                                                <small class="text-muted">Email:</small><br>
                                                <strong>{{ $item->email }}</strong>
                                            </p>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ Route('kasir.form', $item->id) }}" wire:navigate class="btn btn-warning btn-sm text-white">
                                                    <i class="bi bi-pencil"></i> Ubah
                                                </a>
                                                <button onclick="konfirmasiHapus({{ $item->id }})" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash2"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info">Tidak ada kasir.</div>
                                @endforelse
                            </div>

                            <!-- Desktop Table View -->
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-lg table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kasir ?? [] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    <a href="{{ Route('kasir.form', $item->id) }}" wire:navigate class="btn btn-warning btn-sm text-white">
                                                        <i class="bi bi-pencil"></i> Ubah
                                                    </a>
                                                    <button onclick="konfirmasiHapus({{ $item->id }})" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash2"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Tidak ada kasir</td>
                                            </tr>
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