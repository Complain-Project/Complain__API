<?php

use App\Http\Controllers\Admins;
use App\Http\Controllers\Clients;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(["middleware" => "api"], function () {
    /* Admin::start */
    Route::group(["prefix" => "admins"], function () {
        /* Auth::start */
        Route::group(["prefix" => "auth"], function () {
            Route::post("/sign-in", [Admins\AuthController::class, "signIn"]);
        });
        /* Auth::end */

	    Route::group(["middleware" => ["auth:admins"]], function () {
			/* Self::start */
		    Route::group(["prefix" => "self"], function () {
			    Route::post("/logout", [Admins\AuthController::class, "logout"]);
			    Route::post("/refresh", [Admins\AuthController::class, "refresh"]);
			    Route::post("/me", [Admins\AuthController::class, "me"]);
			    Route::patch("/", [Admins\AuthController::class, "updateInfo"]);
			    Route::patch("/password", [Admins\AuthController::class, "updateAuthPassword"]);
		    });
		    /* Self::end */

		    /* Auth::start */
		    Route::group(["prefix" => "admins"], function () {
			    Route::post("/logout", [Admins\AuthController::class, "logout"]);
			    Route::post("/refresh", [Admins\AuthController::class, "refresh"]);
			    Route::post("/me", [Admins\AuthController::class, "me"]);
		    });
		    /* Auth::end */

		    /* Role::start */
		    Route::group(["prefix" => "roles"], function () {
			    Route::get("/", [Admins\RoleController::class, "index"]);
			    Route::get("/{id}/employees", [Admins\RoleController::class, "getAdminsRole"]);
			    Route::get("/permission-types", [Admins\RoleController::class, "getPermissionTypes"]);
			    Route::post("/action", [Admins\RoleController::class, "rolesAction"]);
			    Route::post("/update-role-for-employees/{id}", [Admins\RoleController::class, "updateRoleForEmployees"]);
			    Route::post("/", [Admins\RoleController::class, "store"]);
			    Route::patch("/sync-permissions/{id}", [Admins\RoleController::class, "syncPermissions"]);
			    Route::patch("/{id}", [Admins\RoleController::class, "update"]);
			    Route::delete("/{id}", [Admins\RoleController::class, "destroy"]);
		    });
		    /* Role::end */

            /* Permission::start */
            Route::group(["prefix" => "permissions"], function () {
	            Route::get("/", [Admins\PermissionController::class, "index"]);
                Route::get("/{id}/employees", [Admins\RoleController::class, "getAdminsRole"]);
            });
            /* Permission::end */

		    /* Employee::start */
		    Route::group(["prefix" => "employees"], function () {
			    Route::get("/", [Admins\EmployeeController::class, "index"]);
			    Route::get("/roles", [Admins\EmployeeController::class, "getAllRole"]);
			    Route::get("/districts", [Admins\EmployeeController::class, "getAllDistrict"]);
			    Route::post("/", [Admins\EmployeeController::class, "store"]);
			    Route::patch("/{id}/status", [Admins\EmployeeController::class, "updateStatus"]);
			    Route::patch("/{id}/password", [Admins\EmployeeController::class, "updatePassword"]);
			    Route::patch("/{id}", [Admins\EmployeeController::class, "update"]);
			    Route::delete("/{id}", [Admins\EmployeeController::class, "destroy"]);
		    });
		    /* Employee::end */
	    });
    });
    /* Admin::end */

	/* Client::start */
	Route::group(["prefix" => "clients"], function () {
		/* Auth::start */
		Route::group(["prefix" => "auth"], function () {
			Route::post("/sign-in", [Clients\AuthController::class, "signIn"]);
			Route::post("/sign-up", [Clients\AuthController::class, "signUp"]);
		});
		/* Auth::end */

		Route::group(["middleware" => ["auth:clients"]], function () {
			/* Self::start */
			Route::group(["prefix" => "self"], function () {
				Route::post("/logout", [Clients\AuthController::class, "logout"]);
				Route::post("/refresh", [Clients\AuthController::class, "refresh"]);
				Route::post("/me", [Clients\AuthController::class, "me"]);
			});
			/* Self::end */
		});
	});
	/* Client::end */

	Route::group(["prefix" => "errors"], function () {
		Route::get("401", function () {
			return ResponseTrait::responseError(
				"Unauthorized", [],
				Response::HTTP_UNAUTHORIZED,
				Response::HTTP_UNAUTHORIZED,
			);
		})->name("401");
	});
});
