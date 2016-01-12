<?php namespace App\Http\Controllers\Buildings;

use App\Http\Controllers\TaskController;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Building;
use App\City;
use App\HumanResource;
use App\Task;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{

    use BuildingTraits;

    /**
     * @param $city_id
     * @param $slot_num
     */
    public function getMakeWorker($city_id, $slot_num, $building_id)
    {
        $city = City::find($city_id);
        if (!$this->validateOwner($city)) {
            return redirect('/home')->withErrors('Nem a te városod');
        }


        if ($building = $this->buildingCompleted($building_id)) {
            TaskController::checkTasks();

            if ($building->task->where('building_id', $building->id)->first()) {
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['already_training' => 'Az épület használatban van']);
            }

            if ($building->workers > 0) {
                if ($building->type == 7) {
                    $lack_resource = $city->hasEnoughResources(HumanResource::$worker_price[$city->nation]);
                    if (empty($lack_resource)) {
                        if ($city->human_resources->population > 0) {
                            $city->human_resources->population -= 1;
                            $city->human_resources->save();

                            $city->resources->subtract(HumanResource::$worker_price[$city->nation]);
                            TaskController::createTask($building, 1, HumanResource::$worker_time[$city->nation]);

                            return redirect("/city/$city_id/slot/$slot_num/building/$building_id");
                        }
                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_population' => 'Nincs elég népesség']);
                    } else {
                        $messages = [];
                        $resources = [
                            'stone' => 'kő',
                            'lumber' => 'fa',
                            'food' => 'élelmiszer',
                            'iron' => 'vas'
                        ];
                        foreach ($lack_resource as $key => $value) {
                            $messages["not_enough_$key"] = "Még $value $resources[$key] hiányzik";
                        }
                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors($messages);
                    }
                }
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_a_forum' => 'Az épület nem tud munkást képezni']);
            }
            return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_worker' => 'Az épületben nem dolgozik munkás']);
        }
        return redirect("/city/$city_id");
    }


    /**
     * @param $city_id
     * @param $slot_num
     */
    public function getMakeSettler($city_id, $slot_num, $building_id)
    {
        $city = City::find($city_id);
        if (!$this->validateOwner($city)) {
            return redirect('/home')->withErrors('Nem a te városod');
        }


        if ($building = $this->buildingCompleted($building_id)) {
            TaskController::checkTasks();

            if ($building->task->where('building_id', $building->id)->first()) {
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['already_training' => 'Az épület használatban van']);
            }

            if ($building->workers > 0) {
                if ($building->type == 7) {
                    $lack_resource = $city->hasEnoughResources(HumanResource::$settler_price[$city->nation]);
                    if (empty($lack_resource)) {
                        if ($city->resources->workers >= 5) {
                            if ($city->resources->population >= 10) {
                                $city->resources->workers -= 5;
                                $city->resources->population -= 10;
                                $city->resources->save();
                                $city->resources->subtract(HumanResource::$settler_price[$city->nation]);
                                TaskController::createTask($building, 2, HumanResource::$settler_time[$city->nation]);

                                return redirect("/city/$city_id/slot/$slot_num/building/$building_id");
                            }
                            return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_population' => 'Nincs elég népesség']);
                        }
                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_worker' => 'Nincs elég munkás']);
                    } else {
                        $messages = [];
                        $resources = [
                            'stone' => 'kő',
                            'lumber' => 'fa',
                            'food' => 'élelmiszer',
                            'iron' => 'vas'
                        ];
                        foreach ($lack_resource as $key => $value) {
                            $messages["not_enough_$key"] = "Még $value $resources[$key] hiányzik";
                        }

                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors($messages);
                    }

                }
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_a_forum' => 'Az épület nem tud telepest képezni']);
            }
            return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_worker' => 'Az épületben nem dolgozik munkás']);
        }
        return redirect("/city/$city_id");
    }

    /**
     * @param $city_id
     * @param $slot_num
     */
    public function getMakeGeneral($city_id, $slot_num, $building_id)
    {
//        TaskController::checkTasks();
//
        $city = City::where('id', $city_id)->first();

        if ($city->army() && $city->army()->general) {
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['already_has_general' => 'Már van egy tábornok a városban. Egyszerre csak egy lehet egy városban']);
        }

        if (!$this->validateOwner($city)) {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        if ($building = $this->buildingCompleted($building_id)) {

            if ($building->task->where('building_id', $building->id)->first()) {
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['already_training' => 'Az épület használatban van']);
            }

            if ($building->workers > 0) {
                if ($building->type == 7) {
                    $lack_resource = $city->hasEnoughResources(HumanResource::$general_price[$city->nation]);
                    if (empty($lack_resource)) {
                        if ($city->human_resources->population > 0) {
                            $city->human_resources->population -= 1;
                            $city->human_resources->save();

                            $city->resources->subtract(HumanResource::$general_price[$city->nation]);

                            TaskController::createTask($building, 3, HumanResource::$general_time[$city->nation]);
                            return redirect("/city/$city_id/slot/$slot_num/building/$building_id");
                        }
                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_population' => 'Nincs elég népesség']);
                    } else {
                        $messages = [];
                        $resources = [
                            'stone' => 'kő',
                            'lumber' => 'fa',
                            'food' => 'élelmiszer',
                            'iron' => 'vas'
                        ];
                        foreach ($lack_resource as $key => $value) {
                            $messages["not_enough_$key"] = "Még $value $resources[$key] hiányzik";
                        }
                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors($messages);
                    }
                }
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_a_forum' => 'Az épület nem tud tábornokot képezni']);
            }
            return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_worker' => 'Az épületben nem dolgozik munkás']);
        }
        return redirect("/city/$city_id");
    }
}
