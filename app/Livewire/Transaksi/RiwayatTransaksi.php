<?php

namespace App\Livewire\Transaksi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Livewire\Attributes\{Layout, Title};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksi extends Component
{
    use WithPagination;

    #[Title('Riwayat Transaksi')]
    #[Layout('layouts.app')]

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterTanggal = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterTanggal' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterTanggal()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = Transaction::with(['kasir', 'transactionDetail.produk'])
            ->when(Auth::user()->role === 'kasir', function ($query) {
                // Jika kasir, hanya tampilkan transaksi miliknya
                $query->where('id_kasir', Auth::id());
            })
            ->when($this->search, function ($query) {
                $query->where('kode', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kasir', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filterTanggal, function ($query) {
                if ($this->filterTanggal == 'hari_ini') {
                    $query->whereDate('created_at', today());
                } elseif ($this->filterTanggal == 'minggu_ini') {
                    $query->whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                } elseif ($this->filterTanggal == 'bulan_ini') {
                    $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.transaksi.riwayat-transaksi', [
            'transactions' => $transactions,
            'totalPenjualan' => $this->getTotalPenjualan(),
            'transaksiHariIni' => $this->getTransaksiHariIni(),
        ]);
    }

    private function getTotalPenjualan()
    {
        return Transaction::sum('total');
    }



    private function getTransaksiHariIni()
    {
        return Transaction::whereDate('created_at', today())->count();
    }
    
    public function cetakStruk($transactionId)
{
    $transaction = Transaction::with(['transactionDetail.produk', 'kasir'])
        ->find($transactionId);

    $this->dispatch('printReceipt', [
        'transaction' => $transaction->toArray(),
        'details' => $transaction->transactionDetail->map(function ($item) {
            return [
                'qty' => $item->qty,
                'harga_jual' => $item->produk->harga_jual,
                'subtotal' => $item->subtotal,
                'produk' => [
                    'nama' => $item->produk->nama
                ]
            ];
        })->toArray()
    ]);
}
}