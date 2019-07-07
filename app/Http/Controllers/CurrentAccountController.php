<?php

namespace App\Http\Controllers;

use App\User;
use App\BankIntegration\BankIntegrationFactory;
// use Goutte\Client;
// use GuzzleHttp\Client as GuzzleClient;

class CurrentAccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sync()
    {
        $bankIntegrationFty = new BankIntegrationFactory();
        $user = User::find(auth()->id());
        $integrations = $bankIntegrationFty->getBankIntegrations($user);

        foreach ($integrations as $integration) {
            $integration->connect();
            $movements = $integration->getCurrentAccountMovements();
            dd($movements);
        }
    }
}
