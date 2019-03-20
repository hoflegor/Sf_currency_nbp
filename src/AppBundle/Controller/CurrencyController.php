<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\currency;

class CurrencyController extends Controller
{
    /**
     * @Route("/showAllCurrencies", name="showAllCurrencies")
     */
    public function showAllCurrenciesAction()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.nbp.pl/api/exchangerates/tables/a');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/xml'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resp = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($resp);

        $currencies = [];

        foreach ($data[0]->rates as $rate) {

            $currencies[] = ['name'=>$rate->currency, 'code'=>$rate->code, 'mid'=>$rate->mid];

            $newCurrency = new currency();

            $newCurrency->setName($rate->currency);
            $newCurrency->setCode($rate->code);
            $newCurrency->setMidCourse($rate->mid);
            $newCurrency->setDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($newCurrency);
            $em->flush();


        }

//        return new Response(var_dump($currencies));

        return $this->render(
            'AppBundle:Currency:show_all_currencies.html.twig',
            array('currencies' => $currencies)
        );
    }

    /**
     * @Route("/showCurrency/{code}", name="showCurrency", requirements={"code"="[A-Z]+"} )
     */
    public function showCurrency($code)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.nbp.pl/api/exchangerates/rates/a/' . $code);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/xml'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resp = curl_exec($ch);

        curl_close($ch);

        $currency = json_decode($resp)->rates[0]->mid;

        return new Response(var_dump( $currency));

    }

}
