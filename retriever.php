<?php

    date_default_timezone_set('Europe/Paris');

    $ressourceID = (isset($_POST['ressourceId']))?$_POST['ressourceId']:"9303";

    $projectId = 6;
    $firstDate = "2015-04-10";
    $lastDate = "2015-06-30";

    $file = fopen("http://adelb.univ-lyon1.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=" . $ressourceID . "&projectId=" . $projectId . "&calType=ical&firstDate=" . $firstDate . "&lastDate=" . $lastDate . "", "r") or exit("Unable to open file!");
    $edt = array();


    /***
        A row corresponds to :
            title -> title + room
            start
            end
    ****/

    /* Tab used for coloration */
    $used_id = array(); // Contains the pair [color, title]
    // You can add many colors
    $colors = array("#e8d174","#e39e54","#d64d4d","#4d7358","#9ed670","#6c2a7d","#9ed8f5","#0093d0","#ef4135","#99d5cf","#009688","#ffdbac","#ff99cc","#ff3e96","#6959cd","#4682B4","#00BFFF","#00113a","#f7f7f7","#313131","#31ef78","#3df249","#d6a2fd","#eabcff","#8cceff","#0092ff","#bca7d2","#e1e2df","#c3c6c0","#d2d6d7","#eaeeef","#ee4400","#333377","#336644","#335566","#b4155d","#d3ffce","#ffaddf","#9be466","#92e9ff","#99d9fa","#d3ffce","#39697e","#008000","#0000ff","#fff7dd","#f0cebb","#f2c8b2","#66ffff","#4df1ff","#00ebff","#ffe4e1","#d3ffce","#9be466","#999999","#e5b451","#a9f114",);

    $current = -1;
    while(!feof($file)){

        $line = fgets($file); // separate the ""
        $l = explode(':', $line);

        $description = trim($l[1]); // debug \n\r ... of the line

        // Create a new row
        if($l[0] == 'BEGIN' && $description == 'VEVENT'){
            $current++;
            $edt[$current]['id'] = $current;
        }

        //
        switch ($l[0]) {
            case 'DTSTART': // Event beginning (start)
                $edt[$current]['start'] = date('Y-m-d\TH:i:s', strtotime($l[1]));
                break;

            case 'DTEND': // Event end (end)
                $edt[$current]['end'] = date('Y-m-d\TH:i:s', strtotime($l[1]));
                break;

            case 'SUMMARY': // Event title (title)
                $edt[$current]['title'] = str_replace("\\", "", $l[1]);

                /*
                    Color attribution for a specific event, based on the "title"
                */
                $color_id = 0;
                $color_used = "";
                if(in_array($l[1], $used_id)){ // The  "title" corresponds already to a color
                    $color_id = array_search($l[1], $used_id);
                    $color_used = $colors[$color_id];
                }else{
                    array_push($used_id, $l[1]);
                    $color_id = array_search($l[1], $used_id);
                    $color_used = $colors[$color_id];
                }
                $edt[$current]['backgroundColor'] = $color_used; // set the color

                break;

            case 'LOCATION': // Event location (room)
                $edt[$current]['title'] .= "<br><i>".str_replace("\\", "", $l[1])."</i>";
                break;

            default:
                // Nothing special to do here :)
                break;
        }

    }

    fclose($file);

    header("Content-type: text/json");
    echo json_encode($edt);
    die();