<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Services\Admins\ComplainService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    private ComplainService $complainService;

    public function __construct(ComplainService $complainService)
    {
        $this->complainService = $complainService;
    }

    public function index(Request $request){
        $complains = $this->complainService->index($request);

        return $complains ? ResponseTrait::responseSuccess($complains) : ResponseTrait::responseError();
    }

    public function show($id){
        $complain = $this->complainService->show($id);

        return $complain ? ResponseTrait::responseSuccess($complain) : ResponseTrait::responseError();
    }
    public function reply(Request $request, $id){
        $complain = $this->complainService->reply($request, $id);

        return $complain ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
    }

    public function downloadFile($id){
        $file = $this->complainService->downloadFile($id);
        return $file ? response()->download($file, "download.xlsx") : ResponseTrait::responseError();
    }

    public function getAllDistrict()
    {
        $districts = $this->complainService->getAllDistrict();

        return $districts ? ResponseTrait::responseSuccess($districts) : ResponseTrait::responseError();
    }
}
