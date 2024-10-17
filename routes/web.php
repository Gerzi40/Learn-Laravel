<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home',['title' => 'Home Page']);
});

Route::get('/about', function(){
    return view('about', ['nama' => 'Garry', 'title' => 'About Page']);
});

Route::get('/contact', function(){
    return view('contact', ['title' => 'Contact Page']);
});

// Route::get('/posts', function(){
//     // $posts = Post::latest()->get(); untuk ada query tambahan
//     // $posts = Post::with(['author', 'category'])->latest()->get();

//     return view('posts', ['title' => 'Blog Page', 'posts' => Post::filter(request(['search']))->latest()->get()]);
// });

Route::get('/posts', function () {
    // $posts = Post::with(['author', 'category'])
    //              ->filter(request(['search', 'category']))
    //              ->latest()
    //              ->get();

    // return view('posts', [
    //     'title' => 'Blog Page',
    //     'posts' => $posts
    // ]);
    return view('posts', ['title' => 'Blog Page', 'posts' => Post::filter(request(['search', 'category', 'author']))->latest()->paginate(10)->withQueryString()]);
});

Route::get('/posts/{post:slug}', function(Post $post){
    return view('post', ['title' => 'Single Post', 'post' => $post]);
});

Route::get('/authors/{user:username}', function(User $user){
    // $posts = $user->posts->load('category', 'author');
    return view('posts', ['title' => count($user->posts) . ' Articles by ' . $user->name, 'posts' => $user->posts]);
});

Route::get('/categories/{category:slug}', function(Category $category){
    // $posts = $category->posts->load('category', 'author');
    return view('posts', ['title' => 'Articles in : ' . $category->name, 'posts' => $category->posts]);
});