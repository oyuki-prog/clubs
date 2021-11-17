<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubRole;
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
    public function store(Request $request)
    {
        //
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
    public function edit($club)
    {
        $club = Club::find($club);
        if ($club->isAdmin(Auth::id()) == false) {
            return back()->withErrors(['error' => '役職の編集権限がありません']);
        }
        return view('clubs.members', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClubRole $clubRole)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClubRole $clubRole)
    {
        //
    }

}
