<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        return view('admin.users.users');
    }
    public function sliders()
    {
        return view('admin.slides.slider');
    }
    public function coupons()
    {
        return view('admin.coupons.coupons');
    }
    public function category()
    {
        return view('admin.categories.categories');
    }
    public function orders()
    {
        return view('admin.orders.orders');
    }
    public function settings()
    {
        return view('admin.settings');
    }
}
