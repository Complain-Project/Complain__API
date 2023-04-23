<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Admins\District;
use App\Models\Clients\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ComplainController extends Controller
{
    public function index(Request $request)
    {
        $districtId = '';
        $q = $request->q;
        $district_code = $request->district;
        $district = District::where('code', $district_code)->first();
        if($district) {
            $districtId = $district->_id;
        }

        $query = Complain::with(['user']);

        if ($q && strlen($q) > 0) {
            $query->where('code', 'LIKE', "%" . $q . "%")
                ->orWhere('title', 'LIKE', '%' . $q . '%');
        }

        if ($districtId && strlen($districtId) > 0) {
            $query->where('district_id', $districtId);
        }
        $complains = $query->orderByDesc('created_at')->paginate(10);

        return view('pages.home', [
            'complains' => $complains,
            'q' => $q,
            'district' => $district_code,
        ]);
    }

    public function history(Request $request)
    {
        $districtId = '';
        $q = $request->q;
        $district_code = $request->district;
        $district = District::where('code', $district_code)->first();
        if($district) {
            $districtId = $district->_id;
        }

        $query = Complain::with(['user']);

        if ($q && strlen($q) > 0) {
            $query->where('code', 'LIKE', "%" . $q . "%")
                ->orWhere('title', 'LIKE', '%' . $q . '%');
        }

        if ($districtId && strlen($districtId) > 0) {
            $query->where('district_id', $districtId);
        }

        $complains = $query->where('user_id', Auth::guard('clients')->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pages.history_complain', [
            'complains' => $complains,
            'q' => $q,
            'district' => $district_code,
        ]);
    }

    public function show($id)
    {
        $complain = Complain::find($id);

        if (!$complain) {
            return redirect()->route('home')->with('error', 'Không tìm thấy khiếu nại.');
        }

        return view('pages.detail_complain', [
            'complain' => $complain,
        ]);
    }
    public function submitComplainForm()
    {
        return view('pages.submit_complain');
    }

    public function store(Request $request)
    {
        try {
            $complain = new Complain();
            $complain->nextCode();
            $complain->user_id = Auth::guard('clients')->user()->_id;
            $complain->district_id = $request->district_id;
            $complain->title = $request->title;
            $complain->content = $request->input('content');
            $complain->status = Complain::STATUS['NO_PROCESS'];
            $complain->respondent_id = null;
            $complain->reply = null;
            $complain->appointment_time = null;

            if($request->hasFile('attachment')) {
                $path = Storage::disk('public')->put('upload/attachments', $request->file('attachment'));
                $complain->attachment = $path;
            }

            $complain->save();

            return redirect()->route('home')->with('success', 'Gửi khiếu nại thành công.');
        } catch (\Exception $e) {
            Log::error('Error submit complain', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
                'data' => $request->all(),
            ]);
            return back()->with('error', 'Gửi khiếu nại thất bại.');
        }
    }

    public function getAllDistrict()
    {
        $districts = District::get(['name', 'code']);

        return response()->json([
            'data' => $districts,
        ]);
    }
}
