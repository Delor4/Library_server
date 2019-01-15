<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::join('titles', 'books.idtitles', '=', 'titles.idtitles')->get();
        
        return response()->json([
            'success'=>true,
            'books'=>$books,
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
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $book = new Book;
        
        $book->idtitles = $request->idtitles;
        
        $book->save();
        
        return response()->json([
            'success'=>true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($idbook)
    {
        $book = Book::find($idbook);
        
        return response()->json([
            'success'=>true,
            'book'=>$book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $idbook)
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $book = Book::find($idbook);
        
        $book->idtitles = $request->idtitles;
        
        $book->save();
        
        return response()->json([
            'success'=>true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($book)
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        Book::destroy($book);
        
        return response()->json([
            'success'=>true,
        ]);
    }
}
