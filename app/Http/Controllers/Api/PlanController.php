<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\ClubRole;
use App\Models\DisclosureRange;
use App\Models\Plan;
use App\Models\Thread;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id, $year, $month)
    {
        $user = $request->user();
        $isMember = false;
        $isAdmin = false;
        $clubRoles = ClubRole::where('club_id', $id)->get();
        foreach ($clubRoles as $clubRole) {
            $userRoles = UserRole::where('club_role_id', $clubRole->id)->get();
            foreach ($userRoles as $userRole) {


                if ($userRole->user_id == $user->id) {
                    $clubRoleId = $clubRole->id;
                    $isMember = true;

                    if ($clubRole->role_number == config('const.adminNum')) {
                        $isAdmin = true;
                    }
                    break;
                }
            }

            if ($isMember == true) {
                break;
            }
        }

        if ($isMember == false) {
            return $message = ["message" => "クラブの閲覧権限がありません"];
        }
        $items = collect();
        // $dates = $this->getCalendarDates($year, $month);
        $plans = Plan::where('club_id', $id)->get();
        foreach ($plans as $plan) {
            $disclosureRanges = DisclosureRange::where('plan_id', $plan->id)->get();
            if ($disclosureRanges->count() == 0) {
                $items->push(["id" => $plan->id, "club_id" => $id, "name" => "予定あり", "meeting_time" => $plan->meeting_time, "dissolution_time" => $plan->disslution_time]);
            }
            foreach ($disclosureRanges as $disclosureRange) {
                if ($disclosureRange->club_role_id == $clubRoleId || $isAdmin == true) {
                    if ($this->year($plan->meeting_time) == $year && $this->month($plan->meeting_time) == $month) {
                        $items->push($plan);
                    }
                } else {
                    $items->push(["id" => $plan->id, "club_id" => $id, "name" => "予定あり", "meeting_time" => $plan->meeting_time, "dissolution_time" => $plan->disslution_time]);
                }
            }
        }

        $items = ["plans" => $items, "clubRoles" => $clubRoles];
        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user = $request->user();
        $isAdmin = false;
        $clubRoles = ClubRole::where('club_id', $id)->get();
        foreach ($clubRoles as $clubRole) {
            $userRoles = UserRole::where('club_role_id', $clubRole->id)->get();
            foreach ($userRoles as $userRole) {


                if ($userRole->user_id == $user->id) {
                    if ($clubRole->role_number == config('const.adminNum')) {
                        $isAdmin = true;
                    }
                    break;
                }
            }

            if ($isAdmin == true) {
                break;
            }
        }

        if ($isAdmin == false) {
            return $message = ["message" => "予定の追加は管理者のみが行えます"];
        }

        $plan = new Plan;
        $plan->name = $request->name;
        $plan->club_id = $id;
        $plan->meeting_time = $request->meeting_time;
        $plan->dissolution_time = $request->dissolution_time;
        $plan->place = $request->place;
        if ($request->remarks) {
            $plan->remarks = $request->remarks;
        }
        $plan->save();

        foreach ($request->public as $public) {
            $roleExist = false;
            foreach ($clubRoles as $clubRole) {
                if ($clubRole->id == $public) {
                    $roleExist = true;
                }
            }

            if ($roleExist == true) {
                $disclosureRange = new DisclosureRange();
                $disclosureRange->plan_id = $plan->id;
                $disclosureRange->club_role_id = $public;
                $disclosureRange->save();
            }
        }

        return $plan;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $clubId, $planId)
    {
        $user = $request->user();
        $isMember = false;
        $clubRoles = ClubRole::where('club_id', $clubId)->get();
        foreach ($clubRoles as $clubRole) {
            $userRoles = UserRole::where('club_role_id', $clubRole->id)->get();
            foreach ($userRoles as $userRole) {
                if ($userRole->user_id == $user->id)
                    $isMember = true;
                break;
            }

            if ($isMember == true) {
                break;
            }
        }

        if ($isMember == false) {
            return $message = ["message" => "閲覧権限がありません"];
        }

        $plan = Plan::find($planId);
        $threads = Thread::where('plan_id', $planId)->get();
        return $items = ["plan" => $plan, "threads" => $threads];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCalendarDates($year, $month)
    {
        $dateStr = sprintf('%04d-%02d-01', $year, $month);
        $date = new Carbon($dateStr);
        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $date->subDay($date->dayOfWeek);
        // 同上。右下の隙間のための計算。
        $count = 31 + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            // copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $date->copy();
        }
        return $dates;
    }

    public function month($date)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m');
        return $date;
    }

    public function year($date)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y');
        return $date;
    }
}
