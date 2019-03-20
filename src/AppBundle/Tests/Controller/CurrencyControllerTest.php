<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CurrencyControllerTest extends WebTestCase
{
    public function testShowallcurrencies()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllCurrencies');
    }

}
