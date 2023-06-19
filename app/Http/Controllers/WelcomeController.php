<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Item;
use App\Models\SizeDetail;
use App\Models\SecondaryCategory;
use App\Models\PrimaryCategory;
use Illuminate\Support\Facades\Session;


class WelcomeController extends Controller
{
    public function index()
    {
        $imageFiles = scandir(public_path('images/hero'));
        $images = [];

        foreach ($imageFiles as $file) {
            if ($file !== '.' && $file !== '..') {
                $images[] = asset('images/hero/' . $file);
            }
        }


        return view('welcome', compact('images'));
    }
};
