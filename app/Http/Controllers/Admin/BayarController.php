<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bayar;

class BayarController extends Controller
{
    public function index(){
        $bayars = Bayar::where('status', 'Paid')->latest()->get();
        return view('admin.bayars.index', compact('bayars'));
    }

    public function destroys(Bayar $bayar){
        $bayar->delete();

        return redirect()->back()->with([
            'message' => 'Data berhasil dihapus',
            'alert-type' => 'Bahaya'
        ]);
    }
}
