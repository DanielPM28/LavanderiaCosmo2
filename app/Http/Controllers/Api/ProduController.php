<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\producers;
use Illuminate\Http\Request;

class ProduController extends Controller
{
    public function index(){
        return producers::all(['id','name']);
    }

    public function drivers(producers $producers){
       return $producers->users()->get([
        'users.id',
        'users.name'
       ]);
    }
}
