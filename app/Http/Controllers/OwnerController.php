<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pelanggan;
use App\Models\PaketWisata;
use Carbon\Carbon;
use PDF;


class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ========================
        // FILTER TANGGAL
        // ========================
        $start = $request->start_date;
        $end   = $request->end_date;
        $status = $request->status;

        $query = Reservasi::query();

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($status) {
            $query->where('status_reservasi', $status);
        }

        // ========================
        // PEMASUKAN
        // ========================
        $monthlyIncome = (clone $query)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_bayar');

        $yearlyIncome = (clone $query)
            ->whereYear('created_at', now()->year)
            ->sum('total_bayar');

        // ========================
        // CUSTOMER
        // ========================
        $customers = Pelanggan::whereIn('id', Reservasi::pluck('id_pelanggan')->unique())
            ->withCount('reservasis')
            ->orderBy('reservasis_count', 'desc')
            ->limit(5)
            ->get();

        $totalReservasi = (clone $query)->count();

        // ========================
        // RESERVASI TERBARU
        // ========================
        $latestReservations = $query->with(['pelanggan', 'paketWisata'])
            ->latest()
            ->get();

        // ========================
        // TAMBAHAN DATA BARU 🔥
        // ========================
        $paketWisatas = PaketWisata::latest()->limit(5)->get();
        $obyekWisatas = \App\Models\ObyekWisata::latest()->limit(5)->get();

        // ========================
        // STATISTIK
        // ========================
        $monthlyStats = $this->getMonthlyStats();

        return view('owner.index', [
            'title' => 'Dashboard Owner',
            'monthlyIncome' => $monthlyIncome,
            'yearlyIncome' => $yearlyIncome,
            'customers' => $customers,
            'reservations' => $latestReservations,
            'monthlyStats' => $monthlyStats,

            // kirim ke blade
            'paketWisatas' => $paketWisatas,
            'obyekWisatas' => $obyekWisatas,
            'totalReservasi' => $totalReservasi,

            'start' => $start,
            'end' => $end
        ]);
    }

    private function getMonthlyStats()
    {
        $stats = [];
        $months = [];

        // Data 12 bulan terakhir
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M Y');
            $months[] = $monthName;

            $stats[$monthName] = [
                'count' => Reservasi::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'income' => Reservasi::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('total_bayar')
            ];
        }

        return [
            'months' => array_reverse($months),
            'counts' => array_reverse(array_column($stats, 'count')),
            'incomes' => array_reverse(array_column($stats, 'income'))
        ];
    }

    public function exportPdf(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;
        $status = $request->status;

        $query = Reservasi::with([
            'pelanggan',
            'paketWisata',
            'diskon',
            'penginapan',
            'jenisPembayaran'
        ]);

        // 🔥 FILTER IKUT DASHBOARD
        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($status) {
            $query->where('status_reservasi', $status);
        }

        $reservations = $query->orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        $printedAt = now();

        $pdf = PDF::loadView('owner.report_pdf', [
            'reservations' => $reservations,
            'start' => $start,
            'end' => $end,
            'user' => $user,
            'printedAt' => $printedAt
        ]);

        return $pdf->download('laporan_reservasi_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
