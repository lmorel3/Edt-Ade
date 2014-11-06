<?php

/*

    Edt - Lyon1 by Laurent MOREL - 2014
    (Licensed under Creative Commons CC-BY-NC)

    Notes :
        $items array is here only for debugging

*/

// RSS Fetching
$ressourceID = (isset($_POST['ressourceId']))?$_POST['ressourceId']:"9300";
$url = "http://adelb.univ-lyon1.fr/direct/gwtdirectplanning/rss?projectId=6&resources=".$ressourceID."&nbDays=15&since=0";
$buffer = file_get_contents($url);

if(!$buffer){ die('Unable to fetch datas'); }

$buffer = simplexml_load_string($buffer);
//$items = array(); // Everything
$rendered = array(); // Only rendered things

$used_id = array();
$colors = array("#e8d174","#e39e54","#d64d4d","#4d7358","#9ed670","#6c2a7d","#9ed8f5","#0093d0","#ef4135","#99d5cf","#009688","#ffdbac","#ff99cc");

$i=0;
foreach ($buffer->channel[0]->item as $a) {

    preg_match("/^<description><!\[CDATA\[<p>(\d+\/\d+\/\d+)\D(\d+h\d+) - (\d+h\d+).*<br ?\/>((G?\d?)(S{1}\d))<br ?\/>(.*)<br ?\/>(.*)<br ?\/>\]]><\/description>$/", $a->description[0]->asXML(), $matches);
    /*
        Extract these elements :
            0: Title
                1: ID
                2: Title
            1: Date
            2: Begining
            3: End
            4: Group
                5: Group No.
                6: Group Semester
            7: Prof
            8: Classroom
            9: Start Timestamp (generated)
            10: End Timestamp (generated)
            11: Color (generated)
    */

    if(!empty($matches)){

        preg_match('/^(M\d+(-?[A-Za-z0-9]+)?(\/M\d+)?) (.*)$/', $a->title[0]->__toString(), $title);

        // Unset useless $title's index
        unset($title[0]); // The useless parsed string

        if(!empty($title[2])){ // Title form : M1000-0
            if((int)$title[2] == 0){ // It's the title
                $title[4] = trim($title[2], '-');
                $title[1] = trim($title[1], '-'.$title[4]);
            }
        }

        if(isset($title[4])){ // It's the title
            $title[2] = $title[4];
            unset($title[3]);
            unset($title[4]);
        }

        // Check for invalid title
        if(empty($title)){ $title[1] = "BLANK"; $title[2] = $a->title[0]->__toString(); }

        // Randomize color
        if(in_array($title[1], $used_id)){
            $color_id = array_search($title[1], $used_id);
            $matches[12] = $colors[$color_id];
        }else{
            array_push($used_id, $title[1]);
            $color_id = array_search($title[1], $used_id);
            $matches[12] = $colors[$color_id];
        }

        $matches[0] = $title;

        // Timestamp generation
        $date = explode('/', $matches[1]);
        $hour = explode('h', $matches[2]); // Beginning
        $matches[9] = mktime($hour[0], $hour[1], 0, $date[1], $date[0], $date[2]);

        $hour = explode('h', $matches[3]); // End
        $matches[10] = mktime($hour[0], $hour[1], 0, $date[1], $date[0], $date[2]);

        // Prof & Classroom invertion checker
        if(preg_match("/^(S\d+)|(Amphi(.*))$/", $matches[7])){
            $tmp = $matches[8];
            $matches[8] = $matches[7];
            $matches[7] = $tmp;
        }

        // Stock everything returned
        //$items[] = $matches;

        // Push it in the $rendered array at index $i
        $rendered[$i]['id'] = $matches[0][1];
        $rendered[$i]['title'] = $matches[0][2].(($matches[0][1]!="BLANK")?' <i>('.$matches[0][1].')</i>':'').'<br><span class="fc-classroom">'.$matches[8].'</span>';
        $rendered[$i]['start'] = date(DATE_ISO8601, $matches[9]);
        $rendered[$i]['end'] = date(DATE_ISO8601, $matches[10]);
        $rendered[$i]['backgroundColor'] = $matches[12];
        //$rendered[$i]['borderColor'] = $matches[12];

        $i++;
    }

}

/*
Sort by timestamp
usort($items, function($a, $b) {
    return $a[1] - $b[1];
});
 */

header("Content-type: text/json");
echo json_encode($rendered);
die();