<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\DisclosureRange;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\PlanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Club $club, $year, $month)
    {
        $dates = $this->getCalendarDates($year, $month);
        $plans = [];
        foreach ($club->plans as $plan) {

            if ($plan->year() == $year && $plan->month() == $month) {
                array_push($plans, $plan);
            }
        }
        return view('plans.index', compact('club', 'dates', 'plans', 'year', 'month'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Club $club)
    {
        return view('plans.create', compact('club'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PlanRequest;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request, $club)
    {
        $club = Club::find($club);
        $plan = new Plan($request->all());
        $plan->meeting_time = $request->meeting_date . ' ' . $request->meeting_time . ':00';
        $plan->dissolution_time = $request->dissolution_date . ' ' . $request->dissolution_time . ':00';
        $plan->club_id = $club->id;

        DB::beginTransaction();
        try {
            $plan->save();
            $year = $plan->year();
            $month = $plan->month();
            if($request->public != null){
                foreach ($request->public as $public) {
                    $disclosureRange = new DisclosureRange();
                    $disclosureRange->plan_id = $plan->id;
                    $disclosureRange->club_role_id = $public;
                    $disclosureRange->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withErrors(['error' => 'プランの登録に失敗しました']);
        }

        return redirect()->route('clubs.plans.index', compact(['club', 'year', 'month']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club, Plan $plan)
    {
        return view('plans.show', compact(['club', 'plan']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club, Plan $plan)
    {
        return view('plans.edit', compact(['club', 'plan']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PlanRequest;  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $club, Plan $plan)
    {
        $club = Club::find($club);
        $plan->meeting_time = $request->meeting_date . ' ' . $request->meeting_time . ':00';
        $plan->dissolution_time = $request->dissolution_date . ' ' . $request->dissolution_time . ':00';
        $plan->club_id = $club->id;

        $disclosureRanges = $plan->disclosureRanges;

        DB::beginTransaction();
        try {
            $plan->save();
            foreach ($disclosureRanges as $disclosureRange) {
                $disclosureRange->delete();
            }
            $year = $plan->year();
            $month = $plan->month();
            if ($request->public != null) {
                foreach ($request->public as $public) {
                    $disclosureRange = new DisclosureRange();
                    $disclosureRange->plan_id = $plan->id;
                    $disclosureRange->club_role_id = $public;
                    $disclosureRange->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withErrors(['error' => 'プランの更新に失敗しました']);
        }

        return redirect()->route('clubs.plans.index', compact(['club', 'year', 'month']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club,Plan $plan)
    {
        foreach ($plan->threads as $thread) {
            if ($thread->file) {
                Storage::delete('thread_image/'. $thread->file);
            }
        }
        $year = $plan->year();
        $month = $plan->month();
        $plan->delete();

        return redirect()->route('clubs.plans.index', compact(['club', 'year', 'month']));
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
}
