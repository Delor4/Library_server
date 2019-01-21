<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rents;
use App\Reservations;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->librarian){
            $rents = Rents::all();
        }else{
            $rents = Rents::where('iduser','=',Auth::user()->id);
        }
        
        return response()->json([
            'success'=>true,
            'rents'=>$rents,
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
        //only librarian alowed
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $request->validate([
            'idbooks' => 'required',
            'iduser' => 'required',
        ]);
        
        $for_user = User::findOrFail($request->iduser);
        $idbook = $request->idbooks;
        
        //check book (not alowed)
        if(Rents::where('idbooks',$idbook)->count()>0){
            return response()->json(['error'=>'Forbidden',
                'msg' => 'Book already rented',
            ], 403);
        }
        
        //check user similar titles (not alowed)
        if(Rents::join('books as b1', 'b1.idbooks','rents.idbooks')
            ->join('books as b2', 'b2.idtitles','b1.idtitles')
            ->where('iduser',$for_user->id)
            ->where('b2.idbooks', $idbook)
            ->count()>0){
            return response()->json(['error'=>'Forbidden',
                'msg' => 'Title already rented by user',
            ], 403);
        }

        //check user reservations (required)
        if(Reservations::join('books','books.idtitles','reservations.idtitles')->
            where('iduser',$for_user->id)->where('idbooks',$idbook)->count()==0){
            return response()->json(['error'=>'Forbidden',
                'msg' => 'Not reserved',
            ], 403);
        }
        
        //check user limit
        if($for_user->rents_limit <= Rents::where('iduser',$for_user->id)->count()){
            return response()->json(['error'=>'Forbidden',
                'msg' => 'Max rents reached',
            ], 403);
        }
        
        //lock rents?
        //books in storage
        $not_rented_count=Book::join('books as b2','books.idtitles','b2.idtitles')->
        leftjoin('rents','rents.idbooks','b2.idbooks')->
        where('books.idbooks',$idbook)->
        whereNull('idrent')->
        count();
        
        //lock reservations?
        //head of queue
        $reservations=Book::join('reservations', 'reservations.idtitles', 'books.idtitles')->
        where('idbooks',$idbook)->
        orderBy('reservations.created_at')->
        take($not_rented_count)->
        get();
        
        //if user in queue head then rent
        foreach ($reservations as $reservation) {
            if($reservation->iduser == $for_user->id)
            {
                $rent = new Rents();
                $rent->iduser = $for_user->id;
                $rent->idbooks = $idbook;
                //transaction start?
                $rent->save();
                
                Reservations::destroy($reservation->idreservation);
                //transaction commit?
                //unlocks
                return response()->json([
                    'success'=>true,
                    'rent' => $rent,
                ]);
            }
        }
        //unlocks?
        return response()->json(['error'=>'Forbidden',
            'msg' => 'Too far in queue.',
            'dupa' => $not_rented_count,
        ], 403);
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($idrent)
    {
        $rent = Rents::findOrFail($idrent);
        
        if($rent->iduser != Auth::user()->id and !(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        return response()->json([
            'success'=>true,
            'rent'=>$rent,
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($idrent)
    {
        $rent = Rents::findOrFail($idrent);
        
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $rent->delete();
        
        return response()->json([
            'success'=>true,
        ]);
    }
}
