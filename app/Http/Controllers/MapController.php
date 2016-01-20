<?php

namespace App\Http\Controllers;

use App\Army;
use App\City;
use App\Grid;
use App\Path;
use App\Task;
use App\User;
use Crypt;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

//use SplPriorityQueue;


//class PriQueue extends SplPriorityQueue
//{
////    protected $direction='asc';
//
////    protected $serial = 0;
////
////    public function insert($value, $priority) {
////        parent::insert($value, array($priority, $this->serial++));
////    }
//
//    public function compare($p1, $p2)
//    {
//        if ($p1 === $p2) return 0;
//        // in ascending order of priority, a lower value
//        // means higher priority
//        return ($p1 > $p2) ? 1 : -1;
//    }
//}

class MapController extends Controller
{

    /**
     * @param $x
     * @param $y
     * @return \Illuminate\View\View
     */
    public function getMap()
    {
        TaskController::checkTasks();

        $cities = Auth::user()->cities;
        foreach ($cities as $city) {
            ResourceController::processProduction($city);
        }

        return view('map', ['help' => '/help/map']);
    }

    public function getData(Request $request)
    {
        TaskController::checkTasks();

        $user = Auth::user();

        $x1 = ($request->input('x1')) - 1;
        $y1 = ($request->input('y1')) - 1;
        $x2 = ($request->input('x2')) + 1;
        $y2 = ($request->input('y2')) + 1;


        $cities =
            Grid::join('users', 'grid.owner', '=', 'users.id')->
            join('cities', 'grid.city_id', '=', 'cities.id')->
            whereBetween('x', [$x1, $x2])->whereBetween('y', [$y1, $y2])->
            where('city_id', '>', 0)->
            select('grid.x', 'grid.y', 'users.id as user_id', 'users.name as user_name', 'users.nation', 'cities.name as city_name', 'cities.capital', 'cities.id')->get();

        foreach ($cities as $city) {
            if ($city->user_id == $user->id){
                $city->owned = true;
            } else {
                $city->owned = false;
            }
        }


        $armies =
            Grid::leftJoin('users', 'grid.owner', '=', 'users.id')->
            whereBetween('x', [$x1, $x2])->whereBetween('y', [$y1, $y2])->
            where('army_id', '>', 0)->
            select('grid.*', 'users.name as user_name', 'users.nation')->get()->toArray();


        foreach ($armies as &$hex) {
            $army = Army::where('id', $hex['army_id'])->first();

            if ($army['user_id'] == $user->id) {
                $hex['army'] = $army->toArray();

                $hex['army']['path'] = Path::join('grid', 'paths.hex_id', '=', 'grid.id')
                    ->where('path_id', $army['path_id'])
                    ->select('paths.finished_at', 'grid.x', 'grid.y')
                    ->get()->toArray();
            }

            $hex['army']['user_name'] = $army->user->name;
            $hex['army']['nation'] = $army->user->nation;

        }

        return ['cities' => $cities, 'armies' => $armies];

    }

    public function getHexData(Request $request)
    {
        TaskController::checkTasks();

        $hex = Grid::
        where("x", $request->input('x'))
            ->where('y', $request->input('y'))
            ->select('type', 'owner')
            ->first()->toArray();

//        foreach ($hex as $key => &$value) {
//            $value = intval($value);
//        }
//
//        if ($hex['owner'] > 0) {
//            $hex['owner'] = User::find($hex['owner'])->name;
//        }
//
//        if ($hex['city_id'] > 0) {
//            $city = City::find($hex['city_id']);
//            $hex['city_nation'] = intval($city->nation);
//            $hex['city_name'] = $city->name;
//            $hex['city_owner'] = User::find($city->owner)->name;
//        }
//
//        if ($hex['army_id'] > 0) {
//            $army = Army::find($hex['army_id']);
//            $user = User::find($army->user_id);
//            $hex['army_id'] = $army->id;
//            $hex['army_owner'] = $user->name;
//            $hex['army_nation'] = intval($user->nation);
//            if ($user == Auth::user()) {
//                $hex['army'] = $army->toArray();
//                if ($army->task) {
//                    $path = $army->task->path->toArray();
//                    $hex['path'] = [];
//                    foreach ($path as $path_point) {
//                        $path_hex = Grid::where('id', $path_point['hex_id'])->first();
//                        $hex['path'][] = ['x' => $path_hex->x, 'y' => $path_hex->y];
//                    }
//                    $hex['path_time'] = $army->task->finished_at->format('Y/m/d/ H:i:s');
//
//                }
//            }
//        }

        return $hex;
    }

    public function postPathPrice(Request $request)
    {
        $path = $request->input('path');

        $path_data = [];
        foreach ($path as $hex) {
            $path_data[] = Grid::
            where("x", $hex['x'])
                ->where('y', $hex['y'])
                ->select('type', 'owner', 'city_id', 'army_id')
                ->first();
        }

        $army = Army::where('id', $path_data[0]->army_id)->first();

        $units = [
            1 => intval($army->unit1),
            2 => intval($army->unit2),
            3 => intval($army->unit3),
            4 => intval($army->unit4),
            5 => intval($army->unit5),
            6 => intval($army->unit6),
            7 => intval($army->unit7)
        ];

        $speed = [];

        foreach ($units as $key => $value) {
            if ($value > 0) {
                $speed[] = Army::$unit_speeds[$army->user->nation][$key];
            }
        }

        $speed = max($speed);

        $time = 0;

        array_shift($path_data);

        foreach ($path_data as $hex) {
            $time += Grid::$price[intval($hex->type)] * $speed;
        }

        return $time;

    }





    public function getCities()
    {
        return Grid::where('city_id', '>', 0)->get()->toJson();
    }

    public function getArmies()
    {
        TaskController::checkTasks();

        $hexes = Grid::where("army_id", '>', 0)->select('x', 'y', 'army_id')->get()->toArray();
        $armies = Auth::user()->armies()->get()->toArray();

        foreach ($armies as $army) {
            foreach ($hexes as &$hex) {
                if ($hex['army_id'] == $army['id']) {
                    $hex['army'] = $army;
                }
            }
        }

        return $hexes;
    }

    public function getCityData(Request $request)
    {
        TaskController::checkTasks();

        return City::where('id', $request->input('city'))->first()->toJson();
    }

    public function getArmyData(Request $request)
    {
        TaskController::checkTasks();

        $army = Army::where('id', $request->input('army_id'))->first()->toArray();

        $hex = Grid::find($army['current_hex_id']);

        // if there's a city on the current hex
        if ($hex->city > 0) {
            $city = City::find($hex->city);
            $army['city_nation'] = intval($city->nation);
            $army['city_name'] = $city->name;
        }

        $army['hex_type'] = $hex->type;
        $army['hex_owner'] = User::find($hex->owner)->name;

        if (Auth::user()->id === $army['user_id']) {
            return $army;
        } else {
            $units = [
                'unit1' => 0,
                'unit2' => 0,
                'unit3' => 0,
                'unit4' => 0,
                'unit5' => 0,
                'unit6' => 0,
                'unit7' => 0];

            $army = array_diff_key($army, $units);
            $user = User::find($army['user_id']);
            $army['army_owner'] = $user->name;
            $army['nation'] = intval($user->nation);

            return $army;
        }
    }








////#####################################################################
////##                      A* Pathfinding                             ##
////#####################################################################
//
//    /**
//     * A* pathfinding
//     *
//     * @param Request $request
//     * @return string
//     */
//    public function getPath(Request $request)
//    {
//        $price = [
//            1 => 100,   //1  wo     Medium Deep Water
//            2 => 2,     //2  ds     Beach Sands
//            3 => 1,     //3  gg     Green Grass
//            4 => 3,     //4  Gs^Fp  Semi-dry Grass Pine Forest
//            5 => 2,     //5  Aa     Snow
//            6 => 3,     //6  Hh     Regular Hills
//            7 => 3,     //7  ha     Snow Hills
//            8 => 6,     //8  mm     Regular Mountains
//            9 => 6,     //9  ww     Medium Shallow Water
//            10 => 2,    //10 ai     Ice
//            11 => 6,    //11 ss     Swamp Water Reed
//        ];
//
//        $startx = $request->input('x1');
//        $starty = $request->input('y1');
//        $start = Grid::where('x', $startx)->where('y', $starty)->select('id', 'x', 'y', 'type')->first();
//
//        $goalx = $request->input('x2');
//        $goaly = $request->input('y2');
//        $goal = Grid::where('x', $goalx)->where('y', $goaly)->select('id', 'x', 'y', 'type')->first();
//
//        $start_cube = $this->offsetToCube($start->x, $start->y);
//        $goal_cube = $this->offsetToCube($goal->x, $goal->y);
//
//        $closed_set = [];
//        $open_set = new PriQueue();
//        $came_from = [];
//
//        $open_set->setExtractFlags(PriQueue::EXTR_BOTH);
//
//        $g_score = [];
//        $g_score[$start->id] = 0 + $price[intval($start->type)];
//
//        $f_score = [];
//        $f_score[$start->id] = -($g_score[$start->id] + $this->cubeDistance($goal_cube, $start_cube));
//
//        $open_set->insert($start, $f_score[$start->id]);
//
//
//        while (!$open_set->isEmpty()) {
//
//            $current = $open_set->extract();
//
//            if ($current['data']->id == $goal->id) {
//                $total_path[] = $goal;
//
//                $directions = [
//                    0 => [
//                        1 => ['x' => +1, 'y' => 0],
//                        2 => ['x' => +1, 'y' => -1],
//                        3 => ['x' => 0, 'y' => -1],
//                        4 => ['x' => -1, 'y' => -1],
//                        5 => ['x' => -1, 'y' => 0],
//                        6 => ['x' => 0, 'y' => +1]
//                    ],
//
//                    1 => [
//                        1 => ['x' => +1, 'y' => +1],
//                        2 => ['x' => +1, 'y' => 0],
//                        3 => ['x' => 0, 'y' => -1],
//                        4 => ['x' => -1, 'y' => 0],
//                        5 => ['x' => -1, 'y' => +1],
//                        6 => ['x' => 0, 'y' => +1]
//                    ],
//                ];
//
//                while (array_key_exists($goal->id, $came_from)) {
//
//                    $before_goal = $came_from[$goal->id];
//
//                    if (isset($came_from[$before_goal->id])) {
//                        $neighbors = false;
//
//                        $before_before_goal = $came_from[$before_goal->id];
//                        $parity = $goal->x & 1;
//
//                        foreach ($directions[$parity] as $dir) {
//                            $nx = $goal->x + $dir['x'];
//                            $ny = $goal->y + $dir['y'];
//
//                            if ($nx == $before_before_goal->x && $ny == $before_before_goal->y) {
//                                $neighbors = true;
//                            }
//
//                        }
//
//                        $goal = $neighbors ? $before_before_goal : $before_goal;
//
//                    } else {
//                        $goal = $before_goal;
//                    }
//
//
//                    $total_path[] = $goal;
//                }
//                return $total_path;
//            }
//
//            $closed_set[$current['data']->id] = $current['data'];
//
//
//            foreach ($this->hexNeighbors($current['data']) as $neighbor) {
//                if ($neighbor === Null) {
//                    continue;
//                }
//
//                if (array_key_exists($neighbor->id, $closed_set)) {
//                    continue;
//                }
//
//                $tentative_g_score = $g_score[$current['data']->id] + $price[intval($neighbor->type)];
//
//                $g_score[$neighbor->id] = $tentative_g_score;
//                $next_cube = $this->offsetToCube($neighbor->x, $neighbor->y);
//
//                $f_score[$neighbor->id] = -($g_score[$neighbor->id] + ($this->cubeDistance($goal_cube, $next_cube)));
//
//
//                $clone_open_set = clone $open_set;
//
//                $foundIt = false;
//                foreach ($clone_open_set as $item) {
//                    if ($item !== $neighbor)
//                        continue;
//
//                    $foundIt = true;
////                    $previous = $item;
//                    break;
//                }
//
//                if (!$foundIt) {
//                    $open_set->insert($neighbor, $f_score[$neighbor->id]);
//                } elseif ($tentative_g_score >= $g_score[$current['data']->id]) {
//                    continue;
//                }
//
//
//                if ($open_set->isEmpty()) {
//                    $open_set->insert($neighbor, $f_score[$neighbor->id]);
//                }
//
//
//                $came_from[$neighbor->id] = $current['data'];
//
//
//            }
//        }
//    }
//
//    public function hexNeighbors(Grid $hex)
//    {
//
//        $x = $hex->x;
//        $y = $hex->y;
//
//        $directions = [
//            0 => [
//                1 => ['x' => +1, 'y' => 0],
//                2 => ['x' => +1, 'y' => -1],
//                3 => ['x' => 0, 'y' => -1],
//                4 => ['x' => -1, 'y' => -1],
//                5 => ['x' => -1, 'y' => 0],
//                6 => ['x' => 0, 'y' => +1]
//            ],
//
//            1 => [
//                1 => ['x' => +1, 'y' => +1],
//                2 => ['x' => +1, 'y' => 0],
//                3 => ['x' => 0, 'y' => -1],
//                4 => ['x' => -1, 'y' => 0],
//                5 => ['x' => -1, 'y' => +1],
//                6 => ['x' => 0, 'y' => +1]
//            ],
//        ];
//
//        $parity = $x & 1;
//
//        $neighbors = [];
//
//        foreach ($directions[$parity] as $dir) {
//
//            $nx = $x + $dir['x'];
//            $ny = $y + $dir['y'];
//
//            $nhex = Grid::where('x', $nx)->where('y', $ny)->select('id', 'x', 'y', 'type')->first();
//
//            array_push($neighbors, $nhex);
//        }
//        return $neighbors;
//    }
//
//    public function offsetToCube($x, $y)
//    {
//        // odd-q to cube
//        $z = $y - ($x - ($x & 1)) / 2;
//        $y = -$x - $z;
//
//        return ['x' => $x, 'y' => $y, 'z' => $z];
//    }
//
//    public function cubeDistance($a, $b)
//    {
//        return (abs($a['x'] - $b['x']) + abs($a['y'] - $b['y']) + abs($a['z'] - $b['z']));
//    }
//
////########################################################################################################
////########################################################################################################
//
//
//    /**
//     * @param Request $request
//     * @return string
//     */
//    public function ajaxMap(Request $request)
//    {
//        $view_width = 9;
//        $view_height = 5;
//
//        $x = $request->input('x');
//        $y = $request->input('y');
//
//        $grid = $this->showMap($x, $y, $view_width, $view_height);
//        return json_encode($grid);
//    }
//
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function showMap($x = 4, $y = 2, $view_width = 9, $view_height = 5)
//    {
//        $map_width = 20;
//        $map_height = 10;
//
//        if ($x < ($view_width - 1) / 2) {
//            $x = ($view_width - 1) / 2;
//        }
//        if ($y < ($view_height - 1) / 2) {
//            $y = ($view_height - 1) / 2;
//        }
//
//        if ($x > $map_width - (($view_width - 1) / 2) - 1) {
//            $x = $map_width - (($view_width - 1) / 2) - 1;
//        }
//        if ($y > $map_height - (($view_height - 1) / 2) - 1) {
//            $y = $map_height - (($view_height - 1) / 2) - 1;
//        }
//
//        $grid = Grid::whereBetween('x', [$x - (($view_width - 1) / 2), $x + (($view_width - 1) / 2)])
//            ->whereBetween('y', [$y - (($view_height - 1) / 2), $y + (($view_height - 1) / 2)])->get()->toArray();
//
//        $ny = 0;
//        $nx = -1;
//
//        foreach ($grid as &$row) {
//
//            $nx++;
//
//            if ($row['owner'] > 0) {
//                $user = User::find($row['owner']);
//                $username = $user->name;
//                $row['owner_name'] = $username;
//                switch ($user->nation) {
//                    case 0:
//                        $row['nation'] = 'nincs';
//                        break;
//                    case 1:
//                        $row['nation'] = 'római';
//                        break;
//                    case 2:
//                        $row['nation'] = 'görög';
//                        break;
//                    case 3:
//                        $row['nation'] = 'germán';
//                        break;
//                    case 4:
//                        $row['nation'] = 'szarmata';
//                        break;
//                }
//            }
//
//
//            if ($row['city_id'] > 0) {
//                $user = User::find($row['owner']);
//                $username = $user->name;
//
//                $row['owner_name'] = $username;
//                $row['city_id'] = City::find($row['city_id'])->name;
//
//                switch ($user->nation) {
//                    case 0:
//                        $nation = '';
//                        break;
//                    case 1:
//                        $row['nation'] = 'római';
//                        break;
//                    case 2:
//                        $row['nation'] = 'görög';
//                        break;
//                    case 3:
//                        $row['nation'] = 'germán';
//                        break;
//                    case 4:
//                        $row['nation'] = 'szarmata';
//                        break;
//                }
//            }
//
//
//            $row['nx'] = $nx;
//            $row['ny'] = $ny;
//
//
//            if ($nx == $view_width - 1) {
//                $ny++;
//                $nx = -1;
//            }
//        }
//
//        return $grid;
//    }
//
//
//    /**
//     * @param Request $request
//     */
//    public function ajaxArmy(Request $request)
//    {
//
//        if($request->input('army') == 0){
//            return json_encode([
//            'könnyűgyalogos' => 0,
//            'nehézgyalogos' => 0,
//            'pikás' => 0,
//            'könnyűlovas' => 0,
//            'nehézlovas' => 0,
//            'íjász' => 0,
//            'katapult' => 0
//        ]);
//
//        }
//
//        $army = Army::where('id', $request->input('army'))->first();
//
//
////
//
//
////        if($city->hex->army_id > 0) {
//            $units = [
////                'telepes' => $city->resources->settlers,
//                'könnyűgyalogos' => $army->unit1,
//                'nehézgyalogos' => $army->unit2,
//                'pikás' => $army->unit3,
//                'könnyűlovas' => $army->unit4,
//                'nehézlovas' => $army->unit5,
//                'íjász' => $army->unit6,
//                'katapult' => $army->unit7
//            ];
////        }
//        return json_encode($units);
//    }
}
