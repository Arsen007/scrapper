<?php
/**
 * Created by PhpStorm.
 * User: Арсен
 * Date: 2015-09-05
 * Time: 2:36 PM
 */

namespace App\Http\Controllers;


use App\AutoAm;
use App\Providers\AppServiceProvider;
use Unikent\Curl\Curl;
use \DOMDocument;
use \DOMXPath;

class AutoAmController extends Controller
{
    private $autoAmBaseUrl = 'http://www.auto.am/am/search/volkswagen/golf/?year_from=2000&year_to=2003';

    public function getAutos()
    {
        $curl = new Curl();
        $html = $curl->simple_get($this->autoAmBaseUrl);
        $dom = new DOMDocument();
        @$dom->loadHTML($html); // the variable $ads contains the HTML code above
        $xpath = new DOMXPath($dom);
        $tbody = $xpath->query('//*[@id="main"]/div[3]/div[1]/table/tr');
        $htmlArr = [];
        foreach ($tbody as $ad) {
            if (isset($ad->firstChild->attributes[0]->textContent) && $ad->firstChild->attributes[0]->textContent == 'autolist_left') {
                $item_uid = substr($ad->firstChild->attributes[1]->textContent,8,10);
                $row = AutoAm::where(['item_id' => $item_uid])->get();
                if(count($row) == 1){
                    continue;
                }

                $autoModel = new AutoAm;
                $autoModel->item_id = $item_uid;
                $autoModel->save();

                $htmlArr []= $this->DOMinnerHTML($ad);
            }
        }
        return view('template',['tr_html_arr' =>$htmlArr ]);
    }

    function DOMinnerHTML($element)
    {
        $innerHTML = "";
        $children  = $element->childNodes;

        foreach ($children as $child)
        {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }
}