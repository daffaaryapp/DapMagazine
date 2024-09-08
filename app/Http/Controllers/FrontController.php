<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        //mengambil semua data di category
        $categories = Category::all();
        //mengembalikan ke halaman front, dan membyuat array berisi $categories
        return view('front.index', compact('categories'));
    }
}
