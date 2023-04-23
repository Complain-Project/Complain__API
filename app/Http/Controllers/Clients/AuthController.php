<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        try {
            $account = $request->input('username');
            $user = User::where('phone', $account)
                ->orWhere('account_name', $account)
                ->first();

            if (!empty($user)) {
                if($user->status === User::STATUS['DEACTIVATE']){
                    return back()->with('error', 'Tài khoản của bạn đã bị khóa.');
                }

                $data1 = [
                    'phone' => $user->phone,
                    'password' => $request->password,
                ];

                $data2 = [
                    'account_name' => $user->account_name,
                    'password' => $request->password,
                ];

                if (Auth::guard('clients')->attempt($data1) || Auth::guard('clients')->attempt($data2)) {
                    $request->session()->regenerate();
                    return redirect()->route('home')->with('success', 'Đăng nhập thành công.');
                }
            }

            return back()->with('error', 'Đăng nhập thất bại.');
        } catch (Exception $e) {
            Log::error('Error login user', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
                'data' => request(['email', 'password']),
            ]);
            return back()->with('error', 'Đăng nhập thất bại.');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
	{
		try {
            $user = User::where('phone', $request->phone)
                ->orWhere('account_name', $request->account_name)
                ->first();

            if($user) {
                return back()->with('error', 'Người dùng đã tồn tại.');
            }

			User::create([
				"name" => $request->name,
				"aliases" => $request->aliases,
				"phone" => $request->phone,
				"email" => $request->email,
				"birthday" => Carbon::parse($request->birthday)->timestamp,
				"account_name" => $request->account_name,
				"password" => Hash::make($request->password),
				"status" => User::STATUS['ACTIVATE'],
			]);

			return redirect()->route('loginForm');
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi đăng ký tài khoản người dùng", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"data" => $request->all(),
			]);

			return back()->with('error', 'Đăng ký thất bại.');
		}
	}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
	public function logout()
	{
		try {
			Auth::guard("clients")->logout();

			return redirect()->route('home')->with('success', 'Đăng xuất thành công.');
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi đăng xuất", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => Auth::guard("clients")->id(),
			]);

            return redirect()->route('home')->with('error', 'Đăng xuất thất bại.');
		}
	}
}
