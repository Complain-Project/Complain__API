<?php

namespace App\Models\Clients;

use App\Models\Admins\District;
use App\Models\Admins\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\Operation\FindOneAndUpdate;

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

    public function getAttachmentAttribute($value) {
        return url(Storage::url($value));
    }

    /**
     * @return void
     */
    public function nextCode()
    {
        $this->code = self::getCode();
    }

    /**
     * @return string
     */
    private static function getCode()
    {
        $seq = DB::connection("mongodb")
            ->getCollection("counters")
            ->findOneAndUpdate(
                ["ref" => "ref"],
                ['$inc' => ["order_code" => 1]],
                [
                    "new" => true,
                    "upsert" => true,
                    "returnDocument" => FindOneAndUpdate::RETURN_DOCUMENT_AFTER
                ]
            );

        $graft = "000000" . $seq->order_code;
        $code = "KN-" . Str::substr($graft, -7);

        return $code;
    }
}