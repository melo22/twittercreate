<?php
/*
Plugin Name:TwitterCreate
Plugin URI:
Description: Twitterのつぶやきを自動投稿
Version:     1.0
Author:      melo
Author URI:  https://milkycocoa.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

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
function twittercreate_style() {
    wp_enqueue_style( 'twittercreatestyle', plugins_url() . '/twittercreate/css/style.css', array(), null, 'all');
}
add_action( 'admin_enqueue_scripts', 'twittercreate_style');



function twittercreate_content() {
    wp_enqueue_style( 'twicreatead_content', plugins_url() . '/twittercreate/css/twicreate_content.css', array(), null, 'all');
}
add_action( 'wp_enqueue_scripts', 'twittercreate_content');




require_once(WP_PLUGIN_DIR . '/twittercreate/function.php');



add_action('admin_menu', 'twittercreate_menu');

function twittercreate_menu() {
add_menu_page('TwitterCreate', 'TwitterCreate', 'manage_options', 'twittercreate_menu', 'twittercreate_options_page');
add_action( 'admin_init', 'register_twittercreate_settings' );
}

function register_twittercreate_settings() {
    register_setting('twittercreate-settings-group', 'twittercreate_api' );
    register_setting('twittercreate-settings-group', 'twittercreate_apis' );
    register_setting('twittercreate-settings-group', 'twittercreate_token' );
    register_setting('twittercreate-settings-group', 'twittercreate_tokens' );
    register_setting('twittercreate-settings-group', 'twittercreate_word' );
    register_setting('twittercreate-settings-group', 'twittercreate_num' );
    register_setting('twittercreate-settings-group', 'twittercreate_cate' );
    register_setting('twittercreate-settings-group', 'twittercreate_posttype' );
    register_setting('twittercreate-settings-group', 'twittercreate_kankaku' );
}



function twittercreate_options_page() {

?>



<div class="wrap">
    <h2>Twitterクリエイトの設定</h2>


    <form method="post" action="options.php">
        <?php
        settings_fields( 'twittercreate-settings-group' );
        do_settings_sections( 'twittercreate-settings-group' );
        ?>
        <ul class="form-table">
            <p class="usecase">使い方</p>
            <div class="readme">
                <span class="usetext">・ツイートを取得するためにTwitterAPIの設定をします</span>
                <span class="usetext">・各種設定後に「記事を作成する」を押すと記事が作成されます(1記事)</span>
                <span class="usetext">・予約投稿を選択した場合は動画取得時間から7日後までの時間がランダムで設定されます</span>
                <span class="usetext">・自動投稿の間隔は指定した時間をすぎたあとのアクセスで実行されます(wpの仕様)</span>
                <span class="usetext">・投稿されないことがある場合は設定を変更したり何度か「記事を作成する」を押してください</span>
                <span class="usetext">・ご利用は自己責任でお願いします。</span>
            </div>

            <div class="twittercreatesetting">
                <div class="twittercreatemenu">API設定</div>
                <span class="usetext">APIKey</span>
                <li><input type="text" id="twittercreate_api" class="regular-text" name="twittercreate_api" placeholder="APIキー" value="<?php echo get_option('twittercreate_api'); ?>"></li>
                <span class="usetext">APISecret</span>
                <li><input type="text" id="twittercreate_apis" class="regular-text" name="twittercreate_apis" placeholder="API-SERCRET" value="<?php echo get_option('twittercreate_apis'); ?>"></li>
                <span class="usetext">token</span>
                <li><input type="text" id="twittercreate_token" class="regular-text" name="twittercreate_token" placeholder="token" value="<?php echo get_option('twittercreate_token'); ?>"></li>
                <span class="usetext">tokensecret</span>
                <li><input type="text" id="twittercreate_tokens" class="regular-text" name="twittercreate_tokens" placeholder="token-secret" value="<?php echo get_option('twittercreate_tokens'); ?>"></li>
                <div class="twittercreatemenu">検索ワード</div>
                <li><input type="text" id="twittercreate_word" class="regular-text" name="twittercreate_word" placeholder="晩御飯" value="<?php echo get_option('twittercreate_word'); ?>"></li>




                <div class="twittercreatemenu">取得したいツイート数</div>
            <li><input type="number" id="twittercreate_num" class="regular-text" name="twittercreate_num" placeholder="例　5" max="5" value="<?php echo get_option('twittercreate_num'); ?>"></li>




            <div class="twittercreatemenu">投稿カテゴリ</div>
            <select name="twittercreate_cate">
                <?php $cat_all = get_terms( "category", "fields=all&get=all" );
                foreach($cat_all as $value):
                    if($cat_all){?>
                        <option value="<?php echo $value->term_id; ?>"<?php if(get_option('twittercreate_cate') == $value->term_id){echo "selected";}?>><?php echo $value->name; ?></option>
                    <?php } endforeach;?>
            </select>



            <div class="twittercreatemenu">投稿タイプ</div>
            <li><input type="radio" name="twittercreate_posttype" value="publish" <?php $pub = get_option('twittercreate_posttype');if($pub == "publish"){echo "checked";} ?>> 公開
                <input type="radio" name="twittercreate_posttype" value="future" <?php $pub = get_option('twittercreate_posttype');if($pub == "future"){echo "checked";} ?>> 予約投稿
                   <input type="radio" name="twittercreate_posttype" value="draft" <?php $pub = get_option('twittercreate_posttype');if($pub == "draft"){echo "checked";} ?>> 下書き
                </li>

                <div class="twittercreatemenu">自動投稿の間隔</div>
                <span class="usetext">※cronの指定や手動での投稿の場合は「設定しない」を指定</span>
                <select type="text" id="twittercreate_kankaku" class="regular-text" name="twittercreate_kankaku">
                    <option value="1時間おき" <?php if(get_option('twittercreate_kankaku')=="1時間おき"){echo "selected";}?>>1時間おき</option>
                    <option value="1日おき" <?php if(get_option('twittercreate_kankaku')== "1日おき"){echo "selected";}?>>1日おき</option>
                    <option value="2日に1回" <?php if(get_option('twittercreate_kankaku')== "2日に1回"){echo "selected";}?>>2日に1回</option>
                    <option value="なし" <?php if(get_option('twittercreate_kankaku')== "なし"){echo "selected";}?>>設定しない</option>
                </select>


        </ul>
        <?php submit_button('設定を保存する'); ?>
    </form>


    <form id="twittercreatescform" action="" method="post">
        <input type="submit" name="twittercreatesc" id="twittercreatesc" class="button button-large"  value="記事を作成する"  />
    </form>
    <div id="result"></div>










    <?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST["twittercreatesc"])) {

            global $uid;
            global $pwd;
            global $twittercreatenum;
            global $postcate;
            global $posttype;
            $uid = get_option('twittercreate_uid');
            $pwd = get_option('twittercreate_pwd');
            $twittercreatenum = get_option('twittercreate_num');
            $postcate = get_option('twittercreate_cate');
            $posttype = get_option('twittercreate_posttype');
            require_once(WP_PLUGIN_DIR . '/twittercreate/twittercreate_crawl.php');

        }
    }

    ?>


    <div>

    </div>
</div>




    <?php
}
?>
<?php
if ( !wp_next_scheduled( 'twittercreatesc_add_cron' ) ) {

    wp_schedule_event(time(), 'hourly', 'twittercreatesc_add_cron' );
}

function twisc_post_event() {
    require_once(WP_PLUGIN_DIR . '/twittercreate/twittercreate_crawl.php');





}
add_action ( 'twittercreatesc_add_cron', 'twisc_post_event' );


register_deactivation_hook(__FILE__, 'my_deactivation');

function my_deactivation_twi() {
    wp_clear_scheduled_hook('twittercreatesc_add_cron');
}

if(get_option('twittercreate_kankaku')== "なし"){
    wp_clear_scheduled_hook('twittercreatesc_add_cron');
}
