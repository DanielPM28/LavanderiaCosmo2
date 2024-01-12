<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(){

        $user = auth()->user();
        return view('profile',compact('user'));
    }

    public function update(Request $request){
       $user = auth()->user();
        $user->name = $request->name;
        $user->cedula = $request->cedula;
        $user->address = $request->address;
        $user->save();

        $notification = 'Los datos de usauario se han guardado correctamente';
        return back()->with(compact('notification'));
    }
}
