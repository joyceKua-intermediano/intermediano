<?php

use Illuminate\Support\Facades\Route;
use Spatie\WelcomeNotification\WelcomesNewUsers;
use App\Http\Controllers\Auth\MyWelcomeController;
use Illuminate\Support\Facades\Storage;

Route::middleware(['auth:employee,web'])->get('/signatures/{type}/{id}/{filepath}', function ($type, $id, $filepath) {
    if (!in_array($type, ['admin', 'employee', 'customer'])) {
        abort(400, 'Invalid type');
    }
    $filename = "{$filepath}_{$id}.webp";

    switch ($filepath) {
        case 'admin':
            $path = "private/signatures/admin/{$filename}";
            break;
        case 'employee':
            $path = "private/signatures/employee/{$filename}";
            break;
        case 'customer':
            $path = "private/signatures/clients/{$filename}";
            break;
        case 'partner':
            $path = "private/signatures/clients/{$filename}";
            break;
        default:
            # code...
            break;
    }



    $user = auth('web')->user() ?? auth('employee')->user();
    if (!Storage::disk('local')->exists($path)) {
        abort(404, message: "{$type} signature not found.");
    }

    if ($user instanceof \App\Models\User) {
        return response()->file(storage_path("app/{$path}"));
    }
    if ($user instanceof \App\Models\Employee) {
        if ($filepath === 'employee') {
            if ($type !== 'employee' || $user->id != $id) {
                abort(403, 'Unauthorized');
            }
        }

        return response()->file(storage_path("app/{$path}"));
    }


    abort(403, 'Unauthorized');
})->name('signature.secure');

Route::get('/', function () {
    return redirect('/admin');
});

Route::get("login", function () {
    return redirect("admin/login");
})->name("login");

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [MyWelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [MyWelcomeController::class, 'savePassword']);
});
