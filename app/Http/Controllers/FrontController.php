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

    
    public function author(Author $author){
        //data categori
        $categories = Category::all();

        //mengambil semua data di category
        $bannerads = BannerAdvertisement::where('is_active', 'active')
        ->where('type','banner')
        ->inRandomOrder()
        // ->take(1)
        ->first();

        return view('front.author', compact('categories','author','bannerads'));
        
    }


    //fungsi SEARCH (Pencarian)
    public function search(Request $request){

        //validasi keyword
        $request->validate([
            'keyword' => ['required','string','max:255']
        ]);

        //ambil data category
        $categories = Category::all();

        //mengambil nilai keyword simpan di dalam $keyword
        $keyword = $request->keyword;

        //melakukan pencarian pada tabel ArticleNews dengan nilai keyword
        $articles = ArticleNews::with(['category','author'])
        ->where('name','like','%'. $keyword . '%')->paginate(6);

        //mengembalikkan data
        return view('front.search', compact('articles','keyword','categories'));
    }



    public function details($slug) {
        // Find the article by slug, or return a 404 error if not found
        $articleNews = ArticleNews::where('slug', $slug)->first();
    
        if (!$articleNews) {
            abort(404, 'Article not found');
        }
    
        //ambil data category
        $categories = Category::all();
    
        //mengambil data artricle yang berafiliasi juga dengan article
        $articles = ArticleNews::with(['category'])
            //mengambil data yang not_featured saja
            ->where('is_featured', 'not_featured')
            ->where('id', '!=', $articleNews->id)
            ->latest()
            ->take(3)
            ->get();
    
        $bannerads = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            // ->take(1)
            ->first();

        //iklan disamping
        $square_ads = BannerAdvertisement::where('type','square')
        ->where('is_active','active')
        ->inRandomOrder()
        ->take(2)
        ->get();
        //pengkondisian
        if ($square_ads->count() < 2){
            $square_ads_1 = $square_ads->first();
            $square_ads_2 = $square_ads->first();
        }else{
            $square_ads_1 = $square_ads->get(0);
            $square_ads_2 = $square_ads->get(1);
        }

        //iklan tentang penulis ,supaya iklan yang di tampilkan hanya yang penulis buat
        $author_news = ArticleNews::where('author_id', $articleNews->author_id)
        ->where('id','!=',$articleNews->id)
        ->inRandomOrder()
        ->get();




        return view('front.details', compact('author_news','square_ads_1','square_ads_2','articleNews', 'categories', 'articles', 'bannerads'));
    }
}
