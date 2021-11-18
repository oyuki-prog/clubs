<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'place',
        'remarks',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function disclosureRanges() {
        return $this->hasMany(DisclosureRange::class);
    }

    public function threads() {
        return $this->hasMany(Thread::class);
    }

    public function check($userId) {
        $userRoles = User::find($userId)->userRoles;
        $clubRoleIds = [];
        foreach ($userRoles as $userRole) {
            array_push($clubRoleIds,$userRole->club_role_id);
        }
        $disclosureRangeIds = [];
        foreach ($this->disclosureRanges as $disclosureRange) {
            array_push($disclosureRangeIds, $disclosureRange->club_role_id);
        }
        foreach ($clubRoleIds as $clubRoleId) {
            foreach ($disclosureRangeIds as $disclosureRangeId) {
                if ($clubRoleId == $disclosureRangeId) {
                    return true;
                }
            }
        }

        return false;
    }

    public function day()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->meeting_time)->format('d');
        return $date;
    }

    public function month()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->meeting_time)->format('m');
        return $date;
    }

    public function year()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->meeting_time)->format('Y');
        return $date;
    }
}
