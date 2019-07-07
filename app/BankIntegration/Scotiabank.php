<?php

namespace App\BankIntegration;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;

class Scotiabank implements BankInterface
{
    private $goutteClient;
    private $loginUrl = 'https://www.scotiabankchile.cl/';
    private $currentAccountUrl = 'https://www.scotiabank.cl/cgi-bin/transac/dotrxajax';
    private $user;
    private $password;
    private $currentAccountNumber;

    public function __construct(String $user, String $password, String $currentAccountNumber)
    {
        $this->goutteClient = new GoutteClient();
        $guzzleClient = new GuzzleClient([
            'timeout' => 60,
        ]);

        $this->goutteClient->setClient($guzzleClient);
        $this->user = $user;
        $this->password = $password;
        $this->currentAccountNumber = $currentAccountNumber;
    }

    public function setUrl(String $url)
    {
        $this->url = $url;
    }

    public function connect()
    {
        $crawler = $this->goutteClient->request('GET', $this->loginUrl);
        $crawler = $this->goutteClient->click($crawler->selectLink('Ingreso Personas')->link());

        $form = $crawler->selectButton('Ingresar a Scotiaweb')->form();
        $this->goutteClient->submit(
            $form,
            [
                'rut' => $this->user,
                'usu' => $this->user,
                'pin' => $this->password,
                'TRANS' => 'vt_logon',
            ]
        );
    }

    public function getCurrentAccountMovements() : Array
    {
        $movements = [];

        $this->goutteClient->request('GET', $this->computeCurrentAccountUrl());

        $content = json_decode($this->goutteClient->getResponse()->getContent());
        $movements = $content->lstCartolaCtaCte->movimientos;

        return $movements;
    }

    private function computeCurrentAccountUrl() : String
    {
        return "{$this->currentAccountUrl}?TMPL=%2Fctacte%2Fcartola.json&TRANS=vt_CartolaCtaCte"
            . "&cta={$this->currentAccountNumber}"
            . '&codprd=01000'
            . '&codtrs=T00500'
            . '&xls=0';
    }
}
