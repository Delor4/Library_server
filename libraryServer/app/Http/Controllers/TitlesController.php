<?php

namespace App\Http\Controllers;

use App\Book;
use App\Titles;
use App\User;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Titles  $titles
     * @return \Illuminate\Http\Response
     */
    public function show($idtitle)
    {
        $title = Titles::find($idtitle);
        
        if(Auth::user()->librarian){
            
            $object = [];
            foreach (Book::where('idtitles', $title->idtitles)->get() as $key => $value)
            {
                array_push($object,$value->idbooks);
            }
            $title['books'] = (object)$object;
            
        }
        
        
            return response()->json([
                'success'=>true,
                'titles'=>$title,
            ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Titles  $titles
     * @return \Illuminate\Http\Response
     */
    public function edit(Titles $titles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Titles  $titles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Titles $titles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Titles  $titles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Titles $titles)
    {
        //
    }
}
