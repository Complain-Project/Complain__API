<?php

namespace App\Services\Admins;

use App\Models\Admins\PostTag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostTagService
{
    /**
     * @return false
     */
    public function getAll()
    {
        try {
            return PostTag::orderByDesc("created_at")->get(["name"]);
        } catch (Exception $e) {
            Log::error("Error get all post tag", [
                "method" => __METHOD__,
                "message" => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function store(Request $request){
        try {
            $tag = PostTag::create([
                'name' => $request->input('name'),
            ]);

            return $tag->_id;
        } catch (Exception $e) {
            Log::error("Error store post tag", [
                "method" => __METHOD__,
                "message" => $e->getMessage()
            ]);
            return false;
        }
    }
}
