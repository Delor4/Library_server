<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Book;
use App\Rents;
use App\Reservations;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }
    
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $users = User::all();
        
        return response()->json([
            'success'=>true,
            'users'=>$users,
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
        
        $user = new User;
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->librarian = $request->librarian;
        
        $user->save();
        
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
    public function show($iduser)
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $user = User::findOrFail($iduser);
        
                    
        $array = [];
        foreach (Rents::where('iduser', $user->id)->get() as $key => $value)
        {
            array_push($array,$value->idbooks);
        }
        $user['rents'] = (object)$array;
        
        $array = [];
        foreach (
            Reservations::where('iduser', $user->id)->get()
            as $key => $value)
        {
            array_push($array,$value->idtitles);
        }
        $user['reservations'] = (object)$array;
        
        
        return response()->json([
            'success'=>true,
            'user'=>$user,
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $iduser)
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $user = User::findOrFail($iduser);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->librarian = $request->librarian;
        
        $user->save();
        
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
    public function destroy($iduser)
    {
        if(!(Auth::user()->librarian)){
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
        $user = User::findOrFail($iduser);
        
        try{
            $user->delete();
        }catch(QueryException $e){
            return response()->json(['error'=>'Conflict',
                'msg'=>'User have reservations or rents',
            ], 409);
        }
        
        return response()->json([
            'success'=>true,
        ]);
       
    }
}
