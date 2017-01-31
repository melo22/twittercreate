<?php


function youtubecreate_func(){
    $a8adlist = array();
    $a8_ad = get_option('youtubecreate_adurl');
    $a8_ad2 = get_option('youtubecreate_adurl2');
    $a8_ad3 = get_option('youtubecreate_adurl3');
    $a8_ad4 = get_option('youtubecreate_adurl4');
    $a8_ad5 = get_option('youtubecreate_adurl5');
    $a8_ads = get_option('youtubecreate_adsitaurl');
    $a8_ads2 =get_option('youtubecreate_adsitaurl2');
    $a8_ads3 =get_option('youtubecreate_adsitaurl3');
    $a8_ads4 =get_option('youtubecreate_adsitaurl4');
    $a8_ads5 =get_option('youtubecreate_adsitaurl5');

    if(!empty($a8_ad)){
        $a8adlist[] = $a8_ad;
    }
    if(!empty($a8_ad2)){
        $a8adlist[] = $a8_ad2;
    }
    if(!empty($a8_ad3)){
        $a8adlist[] = $a8_ad3;
    }
    if(!empty($a8_ad4)){
        $a8adlist[] = $a8_ad4;
    }
    if(!empty($a8_ad5)){
        $a8adlist[] = $a8_ad5;
    }

    shuffle($a8adlist);
//    foreach ($a8adlist as $ad){
//         $adpub = '<div class="a8ad_area">'.$ad.'</div>';
//    }
    $adpub = '<div class="a8ad_area">'.$a8adlist[0].'</div>';

    return $adpub;
}
add_shortcode( 'a8ad', 'youtubecreate_func' );


$adset = get_option('youtubecreate_adset');

if($adset == "set") {
    function add_youtubecreate_ad($adpub)
    {
        if (is_single()) {
            $a8adlist = array();
            $a8_ad = get_option('youtubecreate_adurl');
            $a8_ad2 = get_option('youtubecreate_adurl2');
            $a8_ad3 = get_option('youtubecreate_adurl3');
            $a8_ad4 = get_option('youtubecreate_adurl4');
            $a8_ad5 = get_option('youtubecreate_adurl5');
            $a8_ads = get_option('youtubecreate_adsitaurl');
            $a8_ads2 = get_option('youtubecreate_adsitaurl2');
            $a8_ads3 = get_option('youtubecreate_adsitaurl3');
            $a8_ads4 = get_option('youtubecreate_adsitaurl4');
            $a8_ads5 = get_option('youtubecreate_adsitaurl5');

            if (!empty($a8_ad)) {
                $a8adlist[] = $a8_ad;
            }
            if (!empty($a8_ad2)) {
                $a8adlist[] = $a8_ad2;
            }
            if (!empty($a8_ad3)) {
                $a8adlist[] = $a8_ad3;
            }
            if (!empty($a8_ad4)) {
                $a8adlist[] = $a8_ad4;
            }
            if (!empty($a8_ad5)) {
                $a8adlist[] = $a8_ad5;
            }

            shuffle($a8adlist);
//            foreach ($a8adlist as $ad) {
//                $adpub .= '<div class="a8ad_area">' . $ad . '</div>';
//            }

            $adpub .= '<div class="a8ad_area">'.$a8adlist[0].'</div>';
            return $adpub;
        }
    }

    add_filter('the_content', 'add_youtubecreate_ad');
}