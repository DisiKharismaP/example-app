<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //get user berdasarkan id
    public function getUserById($id){
        //temukan id
        $users = User::find($id);
        return response()->json(compact('users', 200));
    }

    //get all user
    public function getAllUsers(){
        $users = User::all();
        return response()->json(compact('users', 200));
    }

    //create user
    public function createUser(Request $request){
        $input = $request ->all();

        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);

        //save untuk menyimpan data ke database
        $user->save();
        return response()->json(compact('user', 200));
    }

    //update user
    public function updateUser($id, Request $request){
        $user = User::find($id);
        $input = $request ->all();

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);

        //save untuk menyimpan data ke database
        $user->save();
        return response()->json(compact('user', 200));
    }

    public function addPhotoProfile($id, Request $request){
        //cari user berdasarkan id
        $user = User::find($id);

        //jika ada file sebelumnya, maka hapus dulu
        if(isset($user->profile_photo_path)){
            storage::disk('public')->delete($user->profile_photo_path);
        }

        //upload ke link storage
        $filePath = $request->file('photo')->store('images/user/'.$id, 'public');

        //tambahkan filepath ke user
        $user->profile_photo_path = $filePath;
        $user->save();
        return response()->json(compact('user', 200));
    }

}
