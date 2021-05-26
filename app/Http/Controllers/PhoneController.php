<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;

class PhoneController extends Controller
{
    //Fungsi untuk get semua data phone dari user
    public function getAllPhone($id){
        $phones = Phone::where('user_id', $id)->get();

        return response()->json(compact('phones'), 200);
    }

    //Fungsi untuk create data (POST)
    public function createPhone($id, Request $request){
        $input = $request->only(['phone_number', 'detail']);
        $phone = new Phone();
        $phone->user_id = $id;
        $phone->phone_number = $input['phone_number'];
        $phone->detail = $input['detail'];
        $phone->save();

        return response()->json(compact('phone'), 200);
    }

    //Fungsi untuk delete data phone
    public function deletePhone($user_id, $id){
        $phone = Phone::find($id);
        $statusDelete = $phone->delete();

        return response()->json(compact('statusDelete'), 200);
    }

}
