<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\ClubRole;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use Illuminate\Support\Facades\Crypt;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = collect();
        $userRoles = UserRole::where('user_id', $request->user()->id)->get();
        foreach ($userRoles as $userRole) {
            $clubRole = ClubRole::find($userRole->club_role_id);
            $club = Club::find($clubRole->club_id);

            $items->push(["club" => $club, "role" => $clubRole]);
        }
        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->password != $request->confirm) {
            return $message = ["message" => "パスワードと確認が一致しません"];
        }

        $club = new Club;

        // 値の用意
        $club->name = $request->name;
        $club->unique_name = $request->unique_name;
        $club->password = encrypt($request->password);

        // インスタンスに値を設定して保存
        $club->save();

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

        $clubRoleAdmin->club_id = $club->id;
        $clubRoleMember->club_id = $club->id;
        $clubRoleRequest->club_id = $club->id;

        $clubRoleAdmin->save();
        $clubRoleMember->save();
        $clubRoleRequest->save();

        $userRole->club_role_id = $clubRoleAdmin->id;
        $userRole->save();
        // 登録後のデータを返す(idが追加される)
        $item = ["club" => $club, "role" => $clubRoleAdmin];
        return $item;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $club = Club::find($id);
        $plans = Plan::where('club_id', $id)->get();
        $item = ["club" => $club, "plan" => $plans, "user" => $request->user()];
        return $item;
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
        if ($request->password != $request->confirm) {
            return $message = ["message" => "パスワードと確認が一致しません"];
        }

        $user = $request->user();
        $club = Club::find($id);
        $clubRole = ClubRole::where('club_id', $id)
                        ->where('role_number', config('const.adminNum'))->first();
        $userRole = UserRole::where('user_id', $user->id)
                        ->where('club_role_id', $clubRole->id)->first();

        if(empty($userRole)) {
            return $message = ["message" => "管理者以外は編集できません"];
        }

        // 値の用意
        $club->name = $request->name;
        $club->unique_name = $request->unique_name;
        $club->password = encrypt($request->password);

        // インスタンスに値を設定して保存
        $club->save();

        // 登録後のデータを返す(idが追加される)
        $item = ["club" => $club];
        return $item;
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



    public function request(Request $request)
    {
        $user = $request->user();
        //クラブIDと一致するクラブを取得
        $club = Club::where('unique_name', $request->unique_name)->first();

        //クラブIDと一致しなければエラー
        if ($club == null) {
            $message = ["message" => "クラブIDに誤りがあります"];
            return $message;
        } else {

            //クラブと紐付いたクラブロールを取得
            $clubRoles = ClubRole::where('club_id', $club->id)->get();

            //参加中、申請中を確認する
            $isMember = false;
            foreach ($clubRoles as $clubRole) {
                $userRole = UserRole::where('club_role_id', $clubRole->id)
                    ->where('user_id', $user->id)->get();
                if ($userRole->count() == 1) {
                    $isMember = true;
                }
            }
            if ($isMember == true) {
                $message = ["message" => "既に参加、もしくは申請中のグループです"];
                return $message;
            }



            //クラブIDと一致するが、パスワードが違うときはエラー
            if ($request->password != decrypt($club->password)) {
                $message = ["message" => "パスワードに誤りがあります"];
                return $message;
            }

            //クラブロールの中で、申請中のものを$requestRoleIdとして取得
            foreach ($clubRoles as $clubRole) {
                if ($clubRole->role_number == config('const.defaultRequestNum')) {
                    $requestRoleId = $clubRole->id;
                }
            }

            //新しいメンバー情報を作成
            $userRole = new UserRole;
            $userRole->name = $request->name;
            $userRole->user_id = $user->id;
            $userRole->club_role_id = $requestRoleId;

            $userRole->save();

            $message = ["message" => "参加を申請しました"];
            return $message;
        }
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

    public function decrypt($value)
    {
        return Crypt::decrypt($value);
    }
}
