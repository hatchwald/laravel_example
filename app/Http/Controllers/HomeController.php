<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MTR\PostPackage\Models\Post;

class HomeController extends Controller
{
    function index(Request $request){
        $data = Post::create([
            "title" => "something title",
            "body" => "well here its test",
            "author_id" => 666
        ]);
        return redirect("/");
    }
}
