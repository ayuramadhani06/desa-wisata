<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        // Total pemasukan bulan ini
        $monthlyIncome = Reservasi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_bayar');

        // Total pemasukan tahun ini
        $yearlyIncome = Reservasi::whereYear('created_at', now()->year)
            ->sum('total_bayar');

        // Pelanggan yang pernah reservasi
        $customers = Pelanggan::whereIn('id', Reservasi::pluck('id_pelanggan')->unique())
            ->withCount('reservasis')
            ->orderBy('reservasis_count', 'desc')
            ->limit(5)
            ->get();

        // Data reservasi terbaru
        $latestReservations = Reservasi::with(['pelanggan', 'paketWisata'])
            ->latest()
            ->limit(10)
            ->get();

        // Statistik bulanan
        $monthlyStats = $this->getMonthlyStats();

        return view('owner.index', [
            'title' => 'Dashboard Owner',
            'monthlyIncome' => $monthlyIncome,
            'yearlyIncome' => $yearlyIncome,
            'customers' => $customers,
            'reservations' => $latestReservations,
            'monthlyStats' => $monthlyStats
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
    public function exportPdf()
    {
        $reservations = Reservasi::with(['pelanggan', 'paketWisata'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('owner.report_pdf', ['reservations' => $reservations]);

        return $pdf->download('laporan_reservasi_'.now()->format('Ymd_His').'.pdf');
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
