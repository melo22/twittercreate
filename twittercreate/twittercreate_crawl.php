<?php
/*  Copyright 2016 melo (email : info@milkycocoa.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
set_time_limit(180);
error_reporting(0);
require_once( dirname(dirname(dirname(dirname( __FILE__ )))) . '/wp-load.php' );
require_once(WP_PLUGIN_DIR . '/twittercreate/vendor/autoload.php');
require (WP_PLUGIN_DIR . '/twittercreate/TwistOAuth.phar');

use Goutte\Client;
//use Symfony\Component\BrowserKit\Cookie;



$uid = get_option('twittercreate_uid');
$pwd = get_option('twittercreate_pwd');
global $twittercreatenum;
 $twittercreatenum = get_option('twittercreate_num');

    global $title;
global $content;
    global $cli;




function twi()
{

    $twittercreate_api = get_option('twittercreate_api');
    $twittercreate_apis = get_option('twittercreate_apis');
    $twittercreate_token = get_option('twittercreate_token');
    $twittercreate_tokens = get_option('twittercreate_tokens');

    $consumer_key = $twittercreate_api;
    $consumer_secret = $twittercreate_apis;
    $access_token = $twittercreate_token;
    $access_token_secret = $twittercreate_tokens;
    $twiword = get_option('twittercreate_word');
    $twittercreatenum = get_option('twittercreate_num');

    $connection = new TwistOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
    $tweets_params = ['q' => $twiword, 'count' => $twittercreatenum, 'include_entities' => true];
    $tweets = $connection->get('search/tweets', $tweets_params)->statuses;
    $screen_name = array();
    $updated = array();
    $tweet_id = array();
    $url = array();
    $twiurl = array();
    $moment = array();
    $n = 0;
    foreach ($tweets as $value){
       //echo $icon_url = '<img src="'.$value->user->profile_image_url.'">';
        //echo $screen_name = $value->user->screen_name;

        $img2 = null;

         $value->entities->media[0]->media_url;



         $img2 = $value->entities->media[0]->media_url;

         //$img2 = "'".$imgsrc."'";

         $upload_dir = wp_upload_dir();
         $arr = explode('.', $img2);
         $ext = end($arr);

         $filename = date('Ymdhis');
         static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
         $str = '';
         for ($i = 0; $i < 2; ++$i) {
             $str .= $chars[mt_rand(0, 61)];
         }
        $fileNameTmp = explode( '/', $img2 );
        $fileNameTmp = array_reverse( $fileNameTmp );
        $fileName = $fileNameTmp[ 0 ];


         $img_save = $upload_dir['path']. "/".$fileName;
        // $src = $upload_dir['url'] . "/" . $filename;
      //  $img_save = "../../uploads/" . $filename . $str . "." . $ext;
        // $srcsv = file_get_contents($node->nodeValue);
       // $client = new Client();

//        $client->getClient()->get($img2, ['save_to' => $img_save,
//            'headers' => ['content-type' => 'image/jpg,image/jpeg, image/png, image/gif']
//        ]);




        $src = $upload_dir['url'] . "/" . $fileName;

             // Echo out a sample image


             $data = file_get_contents($img2);
             file_put_contents($img_save, $data);





        if (!empty($img2)) {
            global $src;
            $imgtwi = '<img src="' . $src . '">';


            $screen_name[] = $value->user->screen_name . "\n";
            $updated[] = date('Y/m/d H:i', strtotime($value->created_at));
            $tweet_id[] = $value->id_str;
            $url[] = 'https://twitter.com/' . $screen_name[$n] . '/status/' . $tweet_id[$n];
            $twiurl[] = '<a href="'.$url[$n].'">'.$twiurl[$n].'</a>';
        $momentes = $value->text.$imgtwi;
        $moment[] = $momentes;
            $n++;
    }else{
            $screen_name[] = $value->user->screen_name . "\n";
            $updated[] = date('Y/m/d H:i', strtotime($value->created_at));
            $tweet_id[] = $value->id_str;
            $url[] = 'https://twitter.com/' . $screen_name[$n] . '/status/' . $tweet_id[$n];
            $twiurl[] = '<a href="'.$url[$n].'">'.$url[$n].'</a>';
        $moment[] = $value->text;
            $n++;
    }
}
$title = null;
    $titlec = $moment[0];
    if(strpos($titlec,'http') === false){
        global $title;
        $title = $moment[0];
    }else{
        global $title;
        $title = strstr($titlec, "http", TRUE);

        //$title = $moment[0];

    }


    $content = '';
    $content .= '<div class="twilist"><div class="twiname">'.$screen_name[0].$updated[0].$twiurl[0].'</div><div class="twicontent">'.$moment[0].'</div></div>';
    $content .= '<div class="twilist"><div class="twiname">'.$screen_name[1].$updated[1].$twiurl[1].'</div><div class="twicontent">'.$moment[1].'</div></div>';
    $content .= '<div class="twilist"><div class="twiname">'.$screen_name[2].$updated[2].$twiurl[2].'</div><div class="twicontent">'.$moment[2].'</div></div>';
    $content .= '<div class="twilist"><div class="twiname">'.$screen_name[3].$updated[3].$twiurl[3].'</div><div class="twicontent">'.$moment[3].'</div></div>';
    $content .= '<div class="twilist"><div class="twiname">'.$screen_name[4].$updated[4].$twiurl[4].'</div><div class="twicontent">'.$moment[4].'</div></div>';


    global $wpdb;

         $posttype = get_option('twittercreate_posttype');
         $twi_pst = "'" . $posttype . "'";
         $postcate = get_option('twittercreate_cate');


        $titleopen = $wpdb->get_results("
   SELECT post_title
   FROM $wpdb->posts
   ");
        $timerand = mt_rand(1, 10080);

        $timestamp = strtotime("+" . $timerand . "minute");
        $postdate = date("Y-m-d H:i:s", $timestamp);
        $has_title = false;
        foreach ($titleopen as $post) {
            $titlelist = $post->post_title;
            if (preg_match("/$title/", $titlelist) ) {
                $has_title = "yes";

            }
        }
        if ($has_title == true) {


        } elseif ($posttype == "future") {
            $post_value = array(
                'post_author' => 1,
                'post_title' => $title,
                'post_content' => $content,
                'post_category' => array($postcate),
                'tags_input' => array('', ''),
                'post_status' => $twi_pst,
                'post_date' => $postdate
            );
            wp_insert_post($post_value);

        } else {
            $post_value = array(
                'post_author' => 1,
                'post_title' => $title,
                'post_content' => $content,
                'post_category' => array($postcate),
                'tags_input' => array('', ''),
                'post_status' => $twi_pst
            );
            wp_insert_post($post_value);

        }



}



try {

    twi();


    echo '<div class="updated">投稿しました。</div>';
    function echo_message() {
        echo '<div class="updated">投稿しました。</div>';
    }
    add_action( 'admin_notices','echo_message' );
}catch (Exception $e) {

    echo $er = "取得エラー" ."\n";
    echo $er = "設定を見直してください" ."\n";
};

?>
