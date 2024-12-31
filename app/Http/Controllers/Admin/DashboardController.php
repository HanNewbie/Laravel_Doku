<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Models\Message;
use App\Models\bayar;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jumlahMobil = Car::count();
        $jumlahPesan = Message::count();
        $jumlahTransaksi = Bayar::count();

        
        $penjualanPerBulan = DB::table('bayars')
        ->select(DB::raw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(*) as total'))
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun', 'ASC')
        ->orderBy('bulan', 'ASC')
        ->get();

    // Menyusun data agar bisa digunakan dalam grafik
        $years = $penjualanPerBulan->pluck('tahun')->unique(); // Mengambil tahun yang unik
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $dataPerTahun = [];
        foreach ($years as $year) {
            $dataPerTahun[$year] = array_fill(0, 12, 0); // Membuat array untuk 12 bulan
            foreach ($penjualanPerBulan as $record) {
                if ($record->tahun == $year) {
                    $dataPerTahun[$year][$record->bulan - 1] = $record->total;
                }
            }
        }

        return view('admin.dashboard', compact('jumlahMobil', 'jumlahPesan', 'jumlahTransaksi', 'years', 'months', 'dataPerTahun'));
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
