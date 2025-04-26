<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Lottery;
use Illuminate\Support\Facades\DB;


class LotteryController extends Controller
{
    public function index()
    {
        $lotteries = Lottery::all();
        return view('lotteries.index', compact('lotteries'));
    }
    
    public function actuals()
    {
        $lotteries = Lottery::where('status', 'En Curso')->get(); 
        if ($lotteries->isEmpty()) {
            return redirect()->route('lotteries.index')
            ->with('error', 'No hay loterias en curso');
        }else{
            return view('lotteries.actuals', compact('lotteries'));
        }
    }

    public function sell(Request $request)
    { 
        $validated = $request->validate([
            'lotteryId' => 'required',
            'cardNumber' => 'required',
            'buyerName' => 'required',
        ]);
        // Create the sale
        DB::table('ventas')->insert([
            'id_lottery' => $validated['lotteryId'], 
            'number_card' => $validated['cardNumber'],
            'buyer_name' => $validated['buyerName']
        ]); 
        $lotteries = Lottery::where('status', 'En Curso')->get(); 
        return view('lotteries.actuals', compact('lotteries'));
/*         $datos= $request->all();
        return response()->json($datos);
 */
    }
    

    public function create()
    {
        return view('lotteries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'order_cards' => 'required',
            'cost_cards' => 'required',
            'prize_cards' => 'required',
        ]);
        $lotteryV = Lottery::where('status', 'En Curso')->first();
        if ($lotteryV) {
            return redirect()->route('lotteries.index')
                ->with('error', 'Ya existe una loteria en curso');
        }else{
            Lottery::create($validated);
            return redirect()->route('lotteries.index')
            ->with('success', 'Lottery created successfully.');
        }
        
    }

    public function show(Lottery $lottery)
    {
        return view('lotteries.show', compact('lottery'));
    }

    public function edit(Lottery $lottery)
    {
        return view('lotteries.edit', compact('lottery'));
    }

    public function update(int $id, int $carID, string $premio)
    {
        $lottery = Lottery::findOrFail($id);
        $lottery->status = 'Terminado';
        $lottery->cartaGanadora = $carID;
        $lottery->premioCarta = $premio;
        $lottery->save();

        return redirect()->route('lotteries.index')
            ->with('success', 'Sorteo Cerrado Exitósamente');
    }

    public function destroy(Lottery $lottery)
    {
        $lottery->delete();
        return redirect()->route('lotteries.index')
            ->with('success', 'Lottery deleted successfully');
    }

    public function sorteo()
    {
        $results = $this->getWinnerCard(); 
        if (is_null($results)){  
            if(is_null($results->original)){
                return redirect()->route('lotteries.index')
                ->with('error', 'No hay loterias en curso');
            }else {
            return view('lotteries.ejecutarSorteo', [
                    'idCartaGanadora' => $results['winner_card'],
                    'order_card' => $results['order_card'],
                    'price_sorteo' => $results['price_card'],
                    'matching_cards' => $results['matchi_cards'],
                    'sorteoID' => $results['idSorte']
                ]); 
            }
        }else{
            return view('lotteries.ejecutarSorteo', [
                'idCartaGanadora' => $results['winner_card'],
                'order_card' => $results['order_card'],
                'price_sorteo' => $results['price_card'],
                'matching_cards' => $results['matchi_cards'],
                'sorteoID' => $results['idSorte']
            ]); 
        }
        /* $datos= $results;
        return response()->json($datos); */
    }

    // In your controller or service class

    public function getWinnerCard()
    {
       $lotteryV = Lottery::where('status', 'En Curso')->first(); 
       if (!$lotteryV) {
           return redirect()->route('lotteries.index')
               ->with('error', 'No hay loterias en curso');
       }
       else{
            $sortId=$lotteryV->id;
            //datos del sorteo acutal

            $cartasParticipantes = DB::table('ventas')
            ->where('id_lottery', $sortId)
            ->select('number_card')
            ->get();
            $cartasParticipantes = $cartasParticipantes->pluck('number_card')->toArray();

            if (!$cartasParticipantes) {
                return redirect()->route('lotteries.index')
                ->with('error', 'No hay loterias en curso');
           }
           else {
                //cartas vendidas

                $ordenGanador=array();
                $numeros = $cartasParticipantes;
                shuffle($numeros);
                $ordenGanador=$numeros;        
                $sizeArray=count($ordenGanador);
                // array ganador

                //dejar solo las cartas que aparezcan en $cartasParticipantes en $ordenGanador, $lotteryV->order_cards, $lotteryV->prize_cards y $lotteryV->cost_cards
                $cartasFinales = array_intersect($cartasParticipantes,$ordenGanador);
                $cadena1 = $lotteryV->order_cards;
                $ordenSorte=explode(",",$cadena1);
                $ordenSorte = array_map('intval', $ordenSorte);
                //orden actual de las cartas al momento del sorteo

                $cadena2 = explode(",", $lotteryV->prize_cards);
                $priceC = $cadena2[$ordenGanador[$sizeArray-1]];
                //consgiue el premio de la carta ganadora

                $cadena3 = explode(",", $lotteryV->cost_cards);
                $costCard = $cadena3[$ordenGanador[$sizeArray-1]];
                //consigue el precio de la carta ganadora
                        
                $orderCard = $ordenGanador[$sizeArray-1];
                $matchingCards = DB::table('cartas')
                ->where('idcarta', $orderCard)
                ->get();
                //se obtienen los datos de la carta ganadora

                return [
                    'winner_card' => $ordenGanador[$sizeArray-1],
                    //'order_sort_Act' => $orderCardSorteoActual,
                    'order_card' => $ordenGanador,//usando
                    //'order_sort' => $ordenSorte, //usando
                    'price_card' => $priceC, //usando
                    //'cost_Card' => $costCard,
                    'matchi_cards' => $matchingCards, //usando
                    'idSorte'=>$sortId, //usando
                    //'cartasParticipa'=>compact('cartasParticipantes'),
                    //'cartasFinales'=>$cartasFinales
                ];
           }
       }
    }

}
