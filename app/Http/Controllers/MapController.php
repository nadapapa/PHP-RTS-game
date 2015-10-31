<?php

namespace App\Http\Controllers;

use App\City;
use App\Grid;
use App\User;
use Crypt;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MapController extends Controller
{

    /**
     * @param $x
     * @param $y
     * @return \Illuminate\View\View
     */
    public function getMap($x, $y)
    {
        // the shown map dimensions in numbers of hexes
        $view_width = 9;
        $view_height = 5;

        $grid = $this->showMap($x, $y, $view_width, $view_height);

//        print_r(var_dump($grid));
        return view('map', ['grid' => $grid, 'view_width' => $view_width, 'view_height' => $view_height])->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));;
    }

    public function ajaxMap(Request $request)
    {
        $view_width = 9;
        $view_height = 5;

        $x = $request->input('x');
        $y = $request->input('y');

        $grid = $this->showMap($x, $y, $view_width, $view_height);
        return json_encode($grid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMap($x = 4, $y = 2, $view_width = 9, $view_height = 5)
    {
        $map_width = 20;
        $map_height = 10;

        if ($x < ($view_width - 1) / 2) {
            $x = ($view_width - 1) / 2;
        }
        if ($y < ($view_height - 1) / 2) {
            $y = ($view_height - 1) / 2;
        }

        if ($x > $map_width - (($view_width - 1) / 2) - 1) {
            $x = $map_width - (($view_width - 1) / 2) - 1;
        }
        if ($y > $map_height - (($view_height - 1) / 2) - 1) {
            $y = $map_height - (($view_height - 1) / 2) - 1;
        }

        $grid = Grid::whereBetween('x', [$x - (($view_width - 1) / 2), $x + (($view_width - 1) / 2)])
            ->whereBetween('y', [$y - (($view_height - 1) / 2), $y + (($view_height - 1) / 2)])->get()->toArray();

        $ny = 0;
        $nx = -1;

        foreach ($grid as &$row) {

            $nx++;

            if ($row['owner'] > 0) {
                $user = User::find($row['owner']);
                $username = $user->name;

                $city = City::find($row['city']);
                $cityname = $city->name;

                $nation = $city->nation;

                $row['owner_name'] = $username;
                $row['city'] = $cityname;

                switch ($nation) {
                    case 0:
                        $nation = '';
                        break;
                    case 1:
                        $nation = 'római';
                        break;
                    case 2:
                        $nation = 'görög';
                        break;
                    case 3:
                        $nation = 'germán';
                        break;
                    case 4:
                        $nation = 'szarmata';
                        break;
                }

                $row['nation'] = $nation;
            }
            $row['nx'] = $nx;
            $row['ny'] = $ny;


            if ($nx == $view_width - 1) {
                $ny++;
                $nx = -1;
            }
        };

        return $grid;
    }
}
