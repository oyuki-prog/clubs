<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubRole;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        return view('clubs.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clubs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $club = new Club($request->all());

        $clubRoleAdmin = new ClubRole();
        $clubRoleAdmin->role_number = 1;
        $clubRoleAdmin->role_name = '管理者';

        $clubRoleRequest = new ClubRole();
        $clubRoleRequest->role_number = 0;
        $clubRoleRequest->role_name = '申請中';

        $clubRoleMember = new ClubRole();
        $clubRoleMember->role_number = 2;
        $clubRoleMember->role_name = 'メンバー';

        $userRole = new UserRole();
        $userRole->user_id = Auth::id();

        DB::beginTransaction();
        try {
            $club->save();
            $clubRoleAdmin->club_id = $club->id;
            $clubRoleRequest->club_id = $club->id;
            $clubRoleMember->club_id = $club->id;
            $clubRoleAdmin->save();
            $clubRoleRequest->save();
            $clubRoleMember->save();
            $userRole->club_role_id = $clubRoleAdmin->id;
            $userRole->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            back()->withErrors(['error' => '保存に失敗しました']);
        }

        return redirect()->route('clubs.show' ,compact('club'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        return view('clubs.show', compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        //
    }
}
