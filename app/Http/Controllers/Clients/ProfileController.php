<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\Profile\ChangePasswordRequest;
use App\Http\Requests\Clients\Profile\UpdateInformationRequest;
use App\Models\Clients\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function getProfile() {
        return view('pages.profile.personal_information');
    }

    public function getUpdatePage() {
        return view('pages.profile.change_password');
    }

    public function updateInfo(UpdateInformationRequest $request)
    {
        try {
            $id = Auth::guard('clients')->id();
            $user = User::find($id);
            $user->name = $request->name;
            $user->aliases = $request->aliases;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->birthday = Carbon::parse($request->birthday)->timestamp;
            $user->save();

            return back()->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            Log::error('Error update profile', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
                'data' => $request->all(),
            ]);
            return back()->with('error', 'Cập nhật thất bại.');
        }
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        try {
            User::find(Auth::guard('clients')->id())->update([
                "password" => Hash::make($request->new_password)
            ]);

            return redirect()->route("profile")->with('success', 'Thay đổi mật khẩu thành công.');
        } catch (\Exception $e) {
            Log::error("Error change password user", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage(),
            ]);

            return redirect()->back()->with("error", 'Thay đổi mật khẩu thất bại');
        }
    }
}
