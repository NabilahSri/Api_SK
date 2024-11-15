<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'nisn' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $credential = $request->only('nisn','password');
        $token = auth()->guard('api')->attempt($credential);
        $user = auth()->guard('api')->user();
        tap(User::where(['nisn' => $request->nisn]))->update(['token' => $token])->first();
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'NISN atau password anda salah'
            ],404);
        }else{
            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $token
            ],200);
        }
    }

    public function showUserId(Request $request, $id){
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $user = User::where('id',$id)->first();
            if ($user) {
                $data_siswa = [
                    'nisn' => $user->nisn,
                    'name' => $user->name,
                    'email' => $user->email,
                    'foto' => $user->foto ? asset('storage/'.$user->foto) : null,
                ];
                return response()->json([
                    'success' => true,
                    'user' => $data_siswa
                ],200);
            }else{
                return response()->json(['message' => 'User tidak ditemukan'],404);
            }
        }
    }

    public function createUser(Request $request){
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $validator = Validator::make($request->all(),[
                'nisn' => 'required',
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(),422);
            }
            $user = User::create([
                'nisn' => $request->nisn,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            if ($request->hasFile('foto')) {
                $filename = $request->file('foto')->storeAs('foto_user', $request->nisn . '_' . $request->name . '.' . $request->file('foto')->getClientOriginalExtension());
                $user->foto = $filename;
                $user->save();
            }
            if ($user) {
                return response()->json([
                    'success' => true,
                    'user' => $user
                ],200);
            }else{
                return response()->json(['message' => 'User tidak ditemukan'],404);
            }
        }
    }
}
