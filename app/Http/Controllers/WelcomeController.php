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
        // $secondaryCategories = SecondaryCategory::all();
        // $primaryCategories = PrimaryCategory::all();
        return view('welcome');
        // return view('welcome', compact('secondaryCategories', 'primaryCategories'));
    }
};
