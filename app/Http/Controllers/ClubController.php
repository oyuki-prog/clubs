<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubRole;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

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
        $club->password = encrypt($request->password);

        $clubRoleAdmin = new ClubRole();
        $clubRoleAdmin->role_number = config('const.adminNum');
        $clubRoleAdmin->role_name = '管理者';

        $clubRoleMember = new ClubRole();
        $clubRoleMember->role_number = config('const.defaultMemberNum');
        $clubRoleMember->role_name = 'メンバー';

        $clubRoleRequest = new ClubRole();
        $clubRoleRequest->role_number = config('const.defaultRequestNum');
        $clubRoleRequest->role_name = '申請中';

        $userRole = new UserRole();
        $userRole->user_id = Auth::id();

        DB::beginTransaction();
        try {
            $club->save();

            $clubRoleAdmin->club_id = $club->id;
            $clubRoleMember->club_id = $club->id;
            $clubRoleRequest->club_id = $club->id;

            $clubRoleAdmin->save();
            $clubRoleMember->save();
            $clubRoleRequest->save();

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
        if ($club->isMember(Auth::id()) == false) {
            return back()->withErrors(['error' => 'クラブの閲覧権限がありません']);
        }

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
        if ($club->isMember(Auth::id()) == false) {
            return back()->withErrors(['error' => 'クラブの編集権限がありません']);
        }

        return view('clubs.edit', compact('club'));
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

    public function requestCreate() {
        return view('clubs.request');
    }

    public function request(Request $request) {
        $club = Club::where('unique_name', $request->unique_name)->first();
        $members = $club->members();
        foreach($members as $member) {
            if ($member->id == Auth::id()) {
                return back()->withErrors(['error' => '既に参加、もしくは申請中のグループです']);
            }
        }
        if ($club == null) {
            return back()->withErrors(['error' => 'クラブIDに誤りがあります']);
        }

        foreach ($club->clubRoles as $clubRole) {
            if ($clubRole->role_number == config('const.defaultRequestNum')) {
                $requestRoleId = $clubRole->id;
            }
        }

        if ($requestRoleId == null) {
            return back()->withErrors(['error' => 'エラー']);
        }

        if ($request->password != decrypt($club->password)) {
            return back()->withErrors(['error' => 'パスワードに誤りがあります']);
        }

        $userRole = new UserRole;
        $userRole->name = $request->name;
        $userRole->user_id = Auth::id();
        $userRole->club_role_id = $requestRoleId;

        $userRole->save();

        return redirect()->route('clubs.index')->with(['message' => '参加を申請しました']);
    }

    /**
     * 復号化処理
     *
     * @param $value 復号化前の値
     * @return 復号化後の値
     */
    public function decrypt($value)
    {
        return Crypt::decrypt($value);
    }

    /**
     * 暗号化処理
     *
     * @param $value 暗号化前の値
     * @return 暗号化後の値
     */
    public function encrypt($value)
    {
        return Crypt::encrypt($value);
    }
}
