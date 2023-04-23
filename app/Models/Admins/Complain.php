<?php

namespace App\Models\Admins;

use App\Models\Clients\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;

    protected $table = "complaint_forms";

    protected $fillable = [
        "code",
        "user_id",
        "district_id",
        "title",
        "content",
        "status",
        "respondent_id",
        "reply",
        "appointment_time",
    ];

    const STATUS = [
        "NO_PROCESS" => 0,
        "PROCESSED" => 1,
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function respondent()
    {
        return $this->belongsTo(Employee::class, "respondent_id", "_id");
    }
}
