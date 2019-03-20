<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Currency;

class CurrencyController extends Controller
{
    /**
     * @Route("/showAllCurrencies", name="showAllCurrencies")
     */
    public function showAllCurrenciesAction()
    {



        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('AppBundle:Currency');


        $last = $repo->getLastDate();

        $last->format('Y-m-d H:i:s');

//        return new Response(var_dump($last));

        $current = new \DateTime();

        $diff = date_diff($last, $current)->days;

        $currencies = [];

        if ($diff > 0) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://api.nbp.pl/api/exchangerates/tables/a');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/xml'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $resp = curl_exec($ch);

            curl_close($ch);

            $data = json_decode($resp);


            foreach ($data[0]->rates as $rate) {

                $name = $rate->currency;
                $code = $rate->code;
                $mid = $rate->mid;

                $currencies[] = ['name' => $name, 'code' => $code, 'mid' => $mid];

                $newCurrency = new Currency();

                $newCurrency->setName($name);
                $newCurrency->setCode($code);
                $newCurrency->setMidCourse($mid);
                $newCurrency->setDate(new \DateTime());

                $em->persist($newCurrency);
                $em->flush();

            }

            $update = $current;


        } else {
            $update = $last;

            $currencyTable= $repo->findAll();



            foreach ($currencyTable as $item){

                $currencies[] = ['name'=>$item->getName(),  'code'=>$item->getCode(), 'mid'=>$item->getMidCourse()];


            }



        }

        $update = $update->format('Y-m-d H:i:s');

/// ////////////////////////

        return $this->render(
            'AppBundle:Currency:show_all_currencies.html.twig',
            array('currencies' => $currencies, 'update' => $update)
        );
    }

    /**
     * @Route("/showCurrency/{code}", name="showCurrency", requirements={"code"="[A-Z]+"} )
     */
    public function showCurrency($code)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.nbp.pl/api/exchangerates/rates/a/'.$code);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/xml'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resp = curl_exec($ch);

        curl_close($ch);

        $curCourse = json_decode($resp)->rates[0]->mid;

        $em = $this->getDoctrine()->getManager();
        $firstDate = $em->getRepository('AppBundle:Currency')->findFirstDateByCode($code);
        $firstDate = $firstDate->format('Y-m-d H:i:s');

        $avgCourse = $em->getRepository('AppBundle:Currency')->getAverageCourseByCode($code);
        $avgCourse = $avgCourse[0][1];

//        return new Response(var_dump($avgCourse));

        return $this->render(
            'AppBundle:Currency:show_currency.html.twig',
            array('code' => $code, 'curCourse' => $curCourse, 'firstDate' => $firstDate, 'avgCourse' => $avgCourse)
        );

    }

}
