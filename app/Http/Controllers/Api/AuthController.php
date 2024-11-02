<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:225'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        return response()->json(['message' => 'User registered
successfully.'], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    public function  updateprofil(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' ,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = $request->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'User update successfully.'], 201);
    }

    public function deleteuser($id){
        $user = User::find($id);
       
        if (!$user) {
           return response()->json(['message' => 'User not found'], 404);
       }
       $user->delete();
          return response()->json(['message' => 'User deleted successfully.'], 200);
   
   }

   public function index(){

    $userku = User::all();
    
    
    return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditampilkan',
            'data' => $userku
        ], 200);
    }
}

