<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;
use App\Models\Author;
use App\Models\BannerAdvertisement;
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

        $featured_articles = ArticleNews::with(['category'])
        //mengambil data yang not_featured saja
        ->where('is_featured','featured')
        ->inRandomOrder()
        ->take(3)
        ->get();

        $authors = Author::all();

        $bannerads = BannerAdvertisement::where('is_active', 'active')
        ->where('type','banner')
        ->inRandomOrder()
        // ->take(1)
        ->first();




        //**LATEST FOR YOU**//
        //entertainment
        $entertainment_articles = ArticleNews::whereHas('category',function ($query){
            $query->where('name','Entertainment');
        })
        ->where('is_featured','not_featured')
        ->latest()
        ->take(3)
        ->get();

        $entertainment_featured_articles = ArticleNews::whereHas('category',function ($query){
            $query->where('name','Entertainment');
        })
        ->where('is_featured','featured')
        ->inRandomOrder()
        // ->take(1)
        ->first();


        //f&b
        $fnb_articles = ArticleNews::whereHas('category',function ($query){
            $query->where('name','F&B');
        })
        ->where('is_featured','not_featured')
        ->latest()
        ->take(3)
        ->get();

        $fnb_featured_articles = ArticleNews::whereHas('category',function ($query){
            $query->where('name','F&B');
        })
        ->where('is_featured','featured')
        ->inRandomOrder()
        // ->take(1)
        ->first();


        //finance
        $finance_articles = ArticleNews::whereHas('category',function ($query){
            $query->where('name','Finance');
        })
        ->where('is_featured','not_featured')
        ->latest()
        ->take(3)
        ->get();

        $finance_featured_articles = ArticleNews::whereHas('category',function ($query){
            $query->where('name','Finance');
        })
        ->where('is_featured','featured')
        ->inRandomOrder()
        // ->take(1)
        ->first();



        //**FINISHING**//
        //mengirim data ke halaman front, dan membyuat array berisi $categories
        return view('front.index', compact('categories','articles','authors','featured_articles','bannerads',
        'entertainment_articles','entertainment_featured_articles',
        'fnb_articles','fnb_featured_articles',
        'finance_articles','finance_featured_articles'
    ));
    }


    public function category(Category $category){
        //mengambil semua data di category
        $categories = Category::all();
        
        //mengambil semua data di category
        $bannerads = BannerAdvertisement::where('is_active', 'active')
        ->where('type','banner')
        ->inRandomOrder()
        // ->take(1)
        ->first();
        

        //**FINISHING**//
        //mengirim data ke halaman category , dan membyuat array berisi $categories   
        return view('front.category', compact('category', 'categories','bannerads'));
    }

}
