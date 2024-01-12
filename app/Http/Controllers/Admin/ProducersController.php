<?php

namespace App\Http\Controllers\admin;

use App\Models\Producers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProducersController extends Controller
{

    


    public function index(){
        $producers = Producers::all();
        return view('producers.index', compact('producers'));
    }

    public function create(){
        return view('producers.create');
    }
    public function sendData(Request $request){
        $rules = [
            'name'=> 'required|min:3'
        ];
        $messages =['name.required' => 'El nombre de la produccion es obligatorio.',
         'name.min' => 'El nombre debe tener mas de 3 caracteres'
          ];
        $this->validate($request, $rules, $messages);

        $producers = new Producers();
        $producers->name = $request->input('name');
        $producers->description = $request->input('description');
        $producers->save();
        $notification = 'La Produccion se a creado correctamente.';

        return redirect('/productoras')->with(compact('notification'));
    }

    public function edit(Producers $producers){
        return view('producers.edit', compact('producers'));
    }
    public function update(Request $request, Producers $producers){
        $rules = [
            'name'=> 'required|min:3'
        ];
        $messages =['name.required' => 'El nombre de la produccion es obligatorio.',
         'name.min' => 'El nombre debe tener mas de 3 caracteres'
          ];
        $this->validate($request, $rules, $messages);

       
        $producers->name = $request->input('name');
        $producers->description = $request->input('description');
        $producers->save();
        $notification = 'La Produccion se a creado correctamente.';

        return redirect('/productoras')->with(compact('notification'));
    }

    public function destroy(Producers $producers){
         $deletename = $producers->name;
         $producers->delete();
         $notification = 'La Produccion'.$deletename.' se a Eliminado correctamente.';
         return redirect('/productoras')->with(compact('notification'));
    }
}