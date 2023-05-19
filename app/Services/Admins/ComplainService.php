<?php

namespace App\Services\Admins;

use App\Models\Admins\Complain;
use App\Models\Admins\District;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Storage;

class ComplainService
{
    public function index(Request $request) {
        try {
            $employee = Auth::guard("admins")->user();

            $perPage = $request->per_page ?: config('constants.per_page');

            $complains = Complain::query()->with(
                [
                    "user",
                    "respondent",
                    "district",
                ]
            );
            if ($request->filled("q")) {
                $keyword = $request->q;
                $complains->where("title", "LIKE", "%" . $keyword . "%")
                    ->orWhere("code", "LIKE", "%" . $keyword . "%")
                    ->orWhereHas("user", function ($q) use ($keyword){
                        $q->where("name", "LIKE", "%" . $keyword. "%");
                    });
            }
            if($request->filled("district")){
                $district = $request->district;
                $complains->whereHas("district", function ($q) use ($district){
                    $q->where("_id", $district);
                });
            }
            if($request->has("status")){
                $complains->where("status", (int)$request->status);
            }
            if(!$employee->is_admin){
                $complains->where('district_id', $employee->district_id);
            }
            if($request->has('start') && $request->has('end')){
                $start = Carbon::parse((int)$request->start)
                    ->timezone('Asia/Ho_Chi_Minh')->startOfDay();
                $end = Carbon::parse((int)$request->end)
                    ->timezone('Asia/Ho_Chi_Minh')->endOfDay();
                $complains->whereBetween('created_at', [$start, $end]);
            }

            return $complains->latest()->paginate($perPage);
        }catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách khiếu nại", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage(),
                "data" => $request->all()
            ]);

            return false;
        }
    }

    public function show($id) {
        try {
            $complain = Complain::query()->with([
                "user",
                "respondent",
                "district",
            ])->find($id);
            return $complain;
        }catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi xem chi tiết khiếu nại", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function reply(Request $request, $id){
        try {
            $complain = Complain::find($id);
            $complain->reply = $request->reply;
            $complain->respondent_id = Auth::guard("admins")->user()->_id;
            $complain->status = Complain::STATUS['PROCESSED'];
            if($request->filled("appointment_time")){
                $complain->appointment_time = $request->appointment_time;
            }
            $complain->save();
            return true;
        } catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi phản hồi khiếu nại", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function downloadFile($id){
        try {
            $complain = Complain::find($id);
            if($complain->attachment){
                $rawData = url(Storage::url($complain->attachment));
                return response($rawData, 200)
                    ->header('Content-Type', 'docx')
                    ->header('Content-Disposition', "attachment; filename='File khieu nai'");
            }else{
                return false;
            }

        } catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi phản hồi khiếu nại", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function getAllDistrict()
    {
        try {
            return District::all();
        } catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách huyện", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage()
            ]);

            return false;
        }
    }
}
