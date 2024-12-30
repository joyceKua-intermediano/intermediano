<?php 

namespace App\Http\Controllers\Auth;


use Spatie\WelcomeNotification\WelcomeController as BaseWelcomeController;
use Symfony\Component\HttpFoundation\Response;

class MyWelcomeController extends BaseWelcomeController
{
    public function sendPasswordSavedResponse(): Response

    {
        return redirect()->route('filament.admin.pages.dashboard');
    }

    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:6'
        ];
    }
}