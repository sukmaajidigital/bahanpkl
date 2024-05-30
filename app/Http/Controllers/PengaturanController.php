<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $stok = Pengaturan::where('id', 1)->first();
        return view('pengaturan.index', compact('stok'));
    }

    public function on($id)
    {
        $on = Pengaturan::findOrFail($id);
        $on->update([
            'status' => 'on'
        ]);

        if($on){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
    public function off($id)
    {
        $off = Pengaturan::findOrFail($id);
        $off->update([
            'status' => 'off'
        ]);

        if($off){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
