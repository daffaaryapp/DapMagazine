<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        //mengambil semua data di category
        $categories = Category::all();

        //mengambil data artricle yang berafiliasi juga dengan article
        $articles = ArticleNews::with(['category'])
        //mengambil data yang not_featured saja
        ->where('is_featured','not_featured')
        ->latest()
        ->take(3)
        ->get();

        $authors = Author::all();
        //mengembalikan ke halaman front, dan membyuat array berisi $categories
        return view('front.index', compact('categories','articles','authors'));
    }
}