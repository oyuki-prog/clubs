<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubRole;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubRoleController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $club)
    {
        $club = Club::find($club);
        $clubRoles = $club->clubRoles;
        for ($i = 1; $i <= $clubRoles->count(); $i++) {
            foreach ($clubRoles as $clubRole) {
                if ($clubRole->role_number == $i) {
                    continue;
                } else {
                    $roleNumber = $i;
                    break;
                }
            }
        }
        $clubRole = new ClubRole();
        $clubRole->club_id = $club->id;
        $clubRole->role_number = $roleNumber;
        $clubRole->role_name = $request->role_name;
        $clubRole->save();

        $id = $club->id;
        return redirect()->route('clubs.clubroles.edit', compact('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Http\Response
     */
    public function show(ClubRole $clubRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Http\Response
     */
    public function edit($clubId)
    {
        $club = Club::find($clubId);
        if ($club->isAdmin(Auth::id()) == false) {
            return back()->withErrors(['error' => '役職の編集権限がありません']);
        }
        return view('clubs.roles', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $club)
    {
        foreach($request->clubRole as $id => $role_name) {
            $targetClubRole = ClubRole::find($id);
            $targetClubRole->role_name = $role_name;
            $targetClubRole->save();
        }
        return redirect()->route('clubs.show', compact('club'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($clubId,$clubRoleId)
    {
        // dd($clubRoleId);
        $clubRole = ClubRole::find($clubRoleId);
        if(UserRole::where('club_role_id', $clubRoleId)->first()) {
            return back()->withErrors(['error' => 'その役割についている人がいます']);
        }
        $clubRole->delete();
        $id = $clubId;
        return redirect()->route('clubs.clubroles.edit', compact('id'));
    }

}
