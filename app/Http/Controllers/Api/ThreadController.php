<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClubRole;
use App\Models\Plan;
use App\Models\Thread;
use App\Models\UserRole;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $clubId, $planId)
    {
        $user = $request->user();
        $isMember = false;
        $clubRoles = ClubRole::where('club_id', $clubId)->get();
        foreach ($clubRoles as $clubRole) {
            $userRoles = UserRole::where('club_role_id', $clubRole->id)->get();
            foreach ($userRoles as $userRole) {


                if ($userRole->user_id == $user->id) {
                    $isMember = true;
                    break;
                }
            }

            if ($isMember == true) {
                break;
            }
        }

        if ($isMember == false)  {
            return $message = collect(["message" => "投稿権限がありません"]);
        }

        // if ($request->body == null && $request->file == null) {
        //     return $message = (["message" => "本文と画像どちらかは送信してください"]);
        // }
        $plan = Plan::find($planId);
        $thread = new Thread();
        $thread->plan_id = $plan->id;
        $thread->user_id = $user->id;
        $thread->body = $request->body;
        $thread->file = $request->file;
        $thread->save();
        $items = collect();
        $items->push(["thread" => $thread, "user" => $user]);
        return $items;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
