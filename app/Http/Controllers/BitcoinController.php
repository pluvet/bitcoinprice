<?php

namespace App\Http\Controllers;

use App\Models\Bitcoin;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

function request($start){

    $client = new Client();
    $authorization = env('Authorization', '');
    $res = $client->get("https://api.tiingo.com/tiingo/crypto/prices?tickers=btcusd,fldcbtc&startDate=$start&resampleFreq=1440min", [
        'headers' => [
        'Content-type' =>  'application/json',
        'Authorization'     => $authorization
        ]
    ]);

    $string = json_decode($res->getBody()->getContents());
    $array = json_decode(json_encode($string), true);
    return $array;
}

class BitcoinController extends Controller
{
    private $bitcoin = array();

    public function show(Request $request){

        if (isset($request->start)) {
            $start = $request->start;
            $end = $request->end;

        }else{
            $start = '2020-12-12';
            $end = '2021-01-27';
        }
        $bitcoins = request($start, $end);

        $this->end($bitcoins, $end);

        $this->insert($start, $end);

        return $this->bitcoin;
    }

    private function end($bitcoinPrice, $end){

        $end = $end  . 'T00:00:00+00:00';
        $this->bitcoin['items'] = array();

        foreach ($bitcoinPrice as $index => $objeto) {

            foreach ($objeto['priceData'] as $i => $obj) {
                $item = array(
                    'price' => $obj['close'],
                    'date' => $obj['date']
                );
                array_push($this->bitcoin['items'], $item);
                if ($obj['date'] == $end) {

                    break;
                }

            }
        }
    }

    private function insert($start, $end){

        $insert = new Bitcoin();

        $insert->start = $start;
        $insert->end = $end;

        $insert->save();

    }

}
