<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SellCar;

class SellCarController extends Controller
{
    public function index()
    {
        $topics = SellCar::latestFirst()->paginate(10);
        $topicsCollection = $topics->getCollection();

    }

    public function show($id)
    {

    }
}
