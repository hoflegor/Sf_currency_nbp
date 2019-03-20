<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller
{
    /**
     * @Route("/showAllCurrencies", name="showAllCurrencies")
     */
    public function showAllCurrenciesAction()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.nbp.pl/api/exchangerates/tables/a');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resp = curl_exec($ch);

        $data = json_decode($resp, true);

//        return new Response(var_dump($data[0]['rates']));

        return $this->render(
            'AppBundle:Currency:show_all_currencies.html.twig',
            array('data'=>$data[0]['rates'])
        );
    }

}
