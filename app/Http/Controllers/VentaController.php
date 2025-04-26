<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use App\Models\Lottery;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;


class VentaController extends Controller
{
    public function store(Request $request)
    {
        $datos = $request->json()->all();
        return response()->json(['message' => 'Datos recibidos correctamente', 'datos' => $datos], 200);
    }

    public function showCardSold()
    {
        $lottery = Lottery::where('status', 'En Curso')->first();
        if ($lottery) {
            $counts = Venta::where('id_lottery', $lottery->id)->count();
            $countsorteos = Lottery::where('status', 'Terminado')->get();
            $cartasSort = DB::table('cartas')
            ->join('lotteries', 'cartas.idcarta', '=', 'lotteries.cartaGanadora')
            ->select('cartas.*')
            ->orderby('lotteries.id','desc')
            ->get();
            return view('welcome', ['count'=>$counts, 'countsorteos'=>$countsorteos, 'cartas'=>$cartasSort]);
        }
        else{
            $countsorteos = Lottery::where('status', 'Terminado')->get();
            $cartasSort = DB::table('cartas')
            ->join('lotteries', 'cartas.idcarta', '=', 'lotteries.cartaGanadora')
            ->select('cartas.*')
            ->orderby('lotteries.id','desc')
            ->get();
            return view('welcome', ['count'=>0, 'countsorteos'=>$countsorteos, 'cartas'=>$cartasSort]);
            //return response()->json($cartasSort);
        }
        
    }
}
