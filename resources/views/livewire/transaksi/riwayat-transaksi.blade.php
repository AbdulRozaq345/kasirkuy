<div>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Riwayat Transaksi</h3>
                    <p class="text-subtitle text-muted">Kelola dan pantau semua transaksi penjualan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-12 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon purple me-3">
                            <i class="iconly-boldChart"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="text-muted font-semibold mb-1">Total Penjualan</h6>
                            <h6 class="font-extrabold mb-0 text-truncate">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon blue me-3">
                            <i class="iconly-boldActivity"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="text-muted font-semibold mb-1">Transaksi Hari Ini</h6>
                            <h6 class="font-extrabold mb-0 text-truncate">{{ $transaksiHariIni }} Transaksi</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-3 g-2">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Cari Transaksi</label>
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Cari berdasarkan kode transaksi atau kasir...">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Filter Tanggal</label>
                        <select wire:model.live="filterTanggal" class="form-select">
                            <option value="">Semua Waktu</option>
                            <option value="hari_ini">Hari Ini</option>
                            <option value="minggu_ini">Minggu Ini</option>
                            <option value="bulan_ini">Bulan Ini</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="d-md-none">
                @forelse($transactions as $transaction)
                    <div class="card mb-3 border">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0">{{ $transaction->kode }}</h6>
                                <span class="badge bg-success">Selesai</span>
                            </div>
                            <p class="mb-1">
                                <small class="text-muted">Tanggal:</small><br>
                                <small>{{ $transaction->created_at->format('d/m/Y H:i') }}</small>
                            </p>
                            <p class="mb-1">
                                <small class="text-muted">Kasir:</small><br>
                                <small>{{ $transaction->kasir->name ?? '-' }}</small>
                            </p>
                            <p class="mb-3">
                                <small class="text-muted">Total:</small><br>
                                <strong class="text-success">Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong>
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                <button data-bs-toggle="modal" data-bs-target="#detail{{ $transaction->id }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                                <button wire:click="cetakStruk({{ $transaction->id }})" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-printer"></i> Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">
                        <i class="bi bi-inbox"></i>
                        <p class="mt-2 mb-0">Tidak ada transaksi ditemukan</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $transaction->kode }}</span>
                                </td>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $transaction->kasir->name ?? '-' }}</td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge bg-success">Selesai</span>
                                </td>
                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#detail{{ $transaction->id }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                    <button wire:click="cetakStruk({{ $transaction->id }})" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-printer"></i> Cetak
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mt-2">Tidak ada transaksi ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>

@foreach ($transactions as $item)
        <div class="modal fade text-left" id="detail{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Detail Transaksi</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            x
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-primary">
                            <h5 class="alert-heading mb-2">Informasi Transaksi</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Kode Transaksi:</strong><br>
                                    <span class="badge bg-primary">{{ $item->kode }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Tanggal & Waktu:</strong>{{ date('d m Y H:i', strtotime($item->created_at)) }}<br>
                                    <span></span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <strong>Kasir:</strong>{{ $item->kasir->name }}<br>
                                    <span id="modal-kasir"></span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <strong>Total Transaksi:</strong><br>
                                    <span class="fw-bold text-light fs-5" id="modal-total">{{ $item->total }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Produk -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Detail Produk</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Harga Satuan</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->transactionDetail as $detail)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->produk->nama }}</td>
                                                    <td>{{ $detail->produk->harga_jual }}</td>
                                                    <td>{{ $detail->qty }}</td>
                                                    <td>{{ $detail->subtotal }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <td colspan="4" class="fw-bold text-end">TOTAL KESELURUHAN: Rp {{ number_format($item->total) }}</td>
                                                <td class="fw-bold fs-6 text-success" id="modal-grand-total"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    @endforeach

</div>
