<?php

namespace App\BankIntegration;

use App\User;
use \ReflectionClass;

class BankIntegrationFactory
{
    public function getBankIntegrations(User $user) : Array
    {
        $integrations = [];
        $banks = $user->banks()->get();

        foreach ($banks as $bank) {
            $className = "App\BankIntegration\\{$bank->name}";
            $class = new ReflectionClass($className);

            $instance = $class->newInstanceArgs([
                $bank->pivot->user,
                $bank->pivot->password,
                $bank->pivot->current_account_number
            ]);

            $integrations[] = $instance;
         }

        return $integrations;
    }
}
