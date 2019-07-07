<?php

namespace App\BankIntegration;

interface BankInterface
{
    public function connect();
    public function getCurrentAccountMovements();
}
