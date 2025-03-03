<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rents;
use App\Reservations;
use App\User;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->librarian){
            $reservations = Reservations::all();
        }else{
            $reservations = Reservations::where('iduser','=',Auth::user()->id);
        }
        
        return response()->json([
            'success'=>true,
            'reservations'=>$reservations,
        ]);
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'idtitles' => 'required',
        ]);
        
        $for_id = Auth::user()->id;
        if(Auth::user()->librarian ){
            $for_id = $request->input('iduser', Auth::user()->id);
        }
        
        $idtitles = $request->idtitles;
        
        if(Rents::join('books','rents.idbooks','books.idbooks')->where('iduser',$for_id)->where('idtitles',$idtitles)->count()>0){
            return response()->json(['error'=>'Forbidden',
                'msg' => 'Already rented',
            ], 403);
        }
        
        if(Reservations::where('iduser',$for_id)->where('idtitles',$idtitles)->count()>0){
            return response()->json(['error'=>'Forbidden',
                'msg' => 'Already reserved',
            ], 403);
        }
        
        
        if(User::find($for_id)->reservations_limit <= Reservations::where('iduser',$for_id)->count()){
            return response()->json(['error'=>'Forbidden',
                'msg' => 'Max reservations reached',
            ], 403);
        }

        $reservation = new Reservations;
        
        $reservation->iduser = $for_id;
        $reservation->idtitles = $idtitles;
        
        $reservation->save();
        
        return response()->json([
            'success'=>true,
            'reservation' => $reservation,
        ]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($idreservation)
    {
        $reservation = Reservations::findOrFail($idreservation);
        
        if($reservation->iduser!=Auth::user()->id and !(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        return response()->json([
            'success'=>true,
            'reservation'=>$reservation,
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($idreservation)
    {
        $reservation = Reservations::findOrFail($idreservation);
        
        if($reservation->iduser!=Auth::user()->id and !(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $reservation->delete();
        
        return response()->json([
            'success'=>true,
        ]);
    }
}
