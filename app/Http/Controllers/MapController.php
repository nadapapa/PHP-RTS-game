<?php

namespace App\Http\Controllers;

use App\Grid;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MapController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMap()
    {
        $grid = Grid::all()->toArray();
//
        return view('map', ['grid' => $grid]);
    }
}
