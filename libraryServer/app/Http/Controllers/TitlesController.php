<?php

namespace App\Http\Controllers;

use App\Book;
use App\Titles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TitlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = Titles::all();
        
        return response()->json([
            'success'=>true,
            'books'=>$titles]
            );
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $title = new Titles;
        
        $title->title = $request->title;
        
        $title->save();
        
        return response()->json([
            'success'=>true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Titles  $titles
     * @return \Illuminate\Http\Response
     */
    public function show($idtitle)
    {
        $title = Titles::findOrFail($idtitle);
        
        if(Auth::user()->librarian){
            
            $array = [];
            foreach (Book::where('idtitles', $title->idtitles)->get() as $key => $value)
            {
                array_push($array,$value->idbooks);
            }
            
            $title['books'] = (object)$array;
            
        }
        
        return response()->json([
            'success'=>true,
            'titles'=>$title,
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Titles  $titles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $titles)
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $title = Book::findOrFail($titles);
        
        $title->title = $request->title;
        
        $title>save();
        
        return response()->json([
            'success'=>true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Titles  $titles
     * @return \Illuminate\Http\Response
     */
    public function destroy($titles)
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $title = Book::findOrFail($titles);
        $title->delete();
        
        return response()->json([
            'success'=>true,
        ]);
    }
}
