<?php
if (file_exists('./sys/init.php')) {
    require_once('./sys/init.php');
} else {
    die('Please put this file in the home directory !');
}

if (!file_exists('update_langs')) {
    die('Folder ./update_langs is not uploaded and missing, please upload the update_langs folder.');
}

$versionToUpdate = '1.6';
$olderVersion = '1.5';

if ($config['version'] == $versionToUpdate && $config['filesVersion'] == $config['version']) {
    die("Your website is already updated to {$versionToUpdate}, nothing to do.");
}
if ($config['version'] == $versionToUpdate && $config['filesVersion'] != $config['version']) {
    die("Your website is database is updated to {$versionToUpdate}, but files are not uploaded, please upload all the files and make sure to use SFTP, all files should be overwritten.");
}
if ($config['version'] < $olderVersion) {
    die("Please update to {$olderVersion} first version by version, your current version is: " . $config['version']);
}

$updated = false;
if (!empty($_GET['updated'])) {
    $updated = true;
}
if (!empty($_POST['query'])) {
    $query = mysqli_query($mysqli, base64_decode($_POST['query']));
    if ($query) {
        $data['status'] = 200;
    } else {
        $data['status'] = 400;
        $data['error']  = mysqli_error($mysqli);
    }
    header("Content-type: application/json");
    echo json_encode($data);
    exit();
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}
function updateLangs($lang) {
    global $sqlConnect;
    if (!file_exists("update_langs/{$lang}.txt")) {
        $filename = "update_langs/unknown.txt";
    } else {
        $filename = "update_langs/{$lang}.txt";
    }
    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines    = file($filename);
    // Loop through each line
    foreach ($lines as $line) {
        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;
        // Add this line to the current segment
        $templine .= $line;
        $query = false;
        // If it has a semicolon at the end, it's the end of the query
        if (substr(trim($line), -1, 1) == ';') {
            // Perform the query
            $templine = str_replace('`{unknown}`', "`{$lang}`", $templine);
            //echo $templine;
            $query    = mysqli_query($sqlConnect, $templine);
            // Reset temp variable to empty
            $templine = '';
        }
    }
}

if (!empty($_POST['update_langs'])) {
    $data  = array();
    $query = mysqli_query($mysqli, "SHOW COLUMNS FROM `pxp_langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[] = $fetched_data['Field'];
    }
    unset($data[0]);
    unset($data[1]);
    unset($data[2]);
    $lang_update_queries = array();
    foreach ($data as $key => $value) {
        updateLangs($value);
    }
    $deleteFile = deleteDirectory("update_langs");
    $files = array(
        'sys/import3p',
    );
    foreach ($files as $key => $value) {
        if (file_exists($value)) {
            if (is_dir($value)) {
                deleteDirectory($value);
            }
            else{
                @unlink($value);
            }
        }
    } 
    $db->where('name', 'version')->update(T_CONFIG, ['value' => $versionToUpdate]);
    $name = md5(microtime()) . '_updated.php';
    rename('update.php', $name);
}
?>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1"/>
      <title>Updating PixelPhoto</title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <style>
         @import url('https://fonts.googleapis.com/css?family=Roboto:400,500');
         @media print {
            .wo_update_changelog {max-height: none !important; min-height: !important}
            .btn, .hide_print, .setting-well h4 {display:none;}
         }
         * {outline: none !important;}
         body {background: #f3f3f3;font-family: 'Roboto', sans-serif;}
         .light {font-weight: 400;}
         .bold {font-weight: 500;}
         .btn {height: 52px;line-height: 1;font-size: 16px;transition: all 0.3s;border-radius: 2em;font-weight: 500;padding: 0 28px;letter-spacing: .5px;}
         .btn svg {margin-left: 10px;margin-top: -2px;transition: all 0.3s;vertical-align: middle;}
         .btn:hover svg {-webkit-transform: translateX(3px);-moz-transform: translateX(3px);-ms-transform: translateX(3px);-o-transform: translateX(3px);transform: translateX(3px);}
         .btn-main {color: #ffffff;background-color: #00BCD4;border-color: #00BCD4;}
         .btn-main:disabled, .btn-main:focus {color: #fff;}
         .btn-main:hover {color: #ffffff;background-color: #0dcde2;border-color: #0dcde2;box-shadow: -2px 2px 14px rgba(168, 72, 73, 0.35);}
         svg {vertical-align: middle;}
         .main {color: #00BCD4;}
         .wo_update_changelog {
          border: 1px solid #eee;
          padding: 10px !important;
         }
         .content-container {display: -webkit-box; width: 100%;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-flex-direction: column;flex-direction: column;min-height: 100vh;position: relative;}
         .content-container:before, .content-container:after {-webkit-box-flex: 1;box-flex: 1;-webkit-flex-grow: 1;flex-grow: 1;content: '';display: block;height: 50px;}
         .wo_install_wiz {position: relative;background-color: white;box-shadow: 0 1px 15px 2px rgba(0, 0, 0, 0.1);border-radius: 10px;padding: 20px 30px;border-top: 1px solid rgba(0, 0, 0, 0.04);}
         .wo_install_wiz h2 {margin-top: 10px;margin-bottom: 30px;display: flex;align-items: center;}
         .wo_install_wiz h2 span {margin-left: auto;font-size: 15px;}
         .wo_update_changelog {padding:0;list-style-type: none;margin-bottom: 15px;max-height: 440px;overflow-y: auto; min-height: 440px;}
         .wo_update_changelog li {margin-bottom:7px; max-height: 20px; overflow: hidden;}
         .wo_update_changelog li span {padding: 2px 7px;font-size: 12px;margin-right: 4px;border-radius: 2px;}
         .wo_update_changelog li span.added {background-color: #4CAF50;color: white;}
         .wo_update_changelog li span.changed {background-color: #e62117;color: white;}
         .wo_update_changelog li span.improved {background-color: #9C27B0;color: white;}
         .wo_update_changelog li span.compressed {background-color: #795548;color: white;}
         .wo_update_changelog li span.fixed {background-color: #2196F3;color: white;}
         input.form-control {background-color: #f4f4f4;border: 0;border-radius: 2em;height: 40px;padding: 3px 14px;color: #383838;transition: all 0.2s;}
input.form-control:hover {background-color: #e9e9e9;}
input.form-control:focus {background: #fff;box-shadow: 0 0 0 1.5px #a84849;}
         .empty_state {margin-top: 80px;margin-bottom: 80px;font-weight: 500;color: #6d6d6d;display: block;text-align: center;}
         .checkmark__circle {stroke-dasharray: 166;stroke-dashoffset: 166;stroke-width: 2;stroke-miterlimit: 10;stroke: #7ac142;fill: none;animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;}
         .checkmark {width: 80px;height: 80px; border-radius: 50%;display: block;stroke-width: 3;stroke: #fff;stroke-miterlimit: 10;margin: 100px auto 50px;box-shadow: inset 0px 0px 0px #7ac142;animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;}
         .checkmark__check {transform-origin: 50% 50%;stroke-dasharray: 48;stroke-dashoffset: 48;animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;}
         @keyframes stroke { 100% {stroke-dashoffset: 0;}}
         @keyframes scale {0%, 100% {transform: none;}  50% {transform: scale3d(1.1, 1.1, 1); }}
         @keyframes fill { 100% {box-shadow: inset 0px 0px 0px 54px #7ac142; }}
      </style>
   </head>
   <body>
      <div class="content-container container">
         <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
               <div class="wo_install_wiz">
                 <?php if ($updated == false) { ?>
                  <div>
                     <h2 class="light">Update to v1.6 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                        <li>[Added] FFMPEG debugger.</li>
                    <li>[Added] SMTP debugger.</li>
                    <li>[Added] Flutterwave payment method.</li>
                    <li>[Added] wasabi storage system. </li>
                    <li>[Added] backblaze storage system. </li>
                    <li>[Added] the ability to choose withdrawal method. </li>
                    <li>[Added] developer mode to admin panel. </li>
                    <li>[Added] the ability to set minimum withdrawal request.</li>
                    <li>[Added] Yoomoney payment method.</li>
                    <li>[Added] login with TikTok.</li>
                    <li>[Added] the ability to create and generate sitemap.</li>
                    <li>[Added] the ability to import reels from TikTok.</li>
                    <li>[Added] Google Vision API to filter nude posts.</li>
                    <li>[Added] two authentication system.</li>
                    <li>[Added] CDN support.</li>
                    <li>[Added] the support to translate terms of use pages.</li>
                    <li>[Added] the ability to disable terms pages.</li>
                    <li>[Added] 3 SMS providers.</li>
                    <li>[Added] FFMPEG conversation speed settings.</li>
                    <li>[Added] support for image/webp.</li>
                    <li>[Added] more APIs.</li>
                    <li>[Updated] All PHP libs.</li>
                    <li>[Fixed] sharing posts with hashtags appear distorted on the main feed.</li>
                    <li>[Fixed] the avatar on the profile page shows double url and cannot be displayed once remote storage like amazon s3 is turned on.</li>
                    <li>[Fixed] If amazon s3 enabled gifs appear broken.</li>
                    <li>[Fixed] showing broken social links in settings page.</li>
                    <li>[Fixed] agora live and video calls.</li>
                    <li>[Fixed] few issues in blog system.</li>
                    <li>[Fixed] explore page showing old posts if there are boosted posts.</li>
                    <li>[Fixed] if s3 is enabled, social login doesn't work.</li>
                    <li>[Fixed] user can't resend </li>
                    <li>[Fixed] can't change "Boosted Post" value from admin panel.</li>
                    <li>[Fixed] contact us form not sending emails.</li>
                    <li>[Fixed] only first Navigation works in "Manage Site Advertisements" in admin panel.</li>
                    <li>[Fixed] copy and paste using right click doesn't work in admin panel.</li>
                    <li>[Fixed] some files are loaded remotly, now all files are loaded from the same server.</li>
                    <li>[Fixed] can't login to site again if maintenance mode is enabled + two auth.</li>
                    <li>[Fixed] email validation system, user was getting empty string in email.</li>
                    <li>[Fixed] files are not deleting from Digitalocean.</li>
                    <li>[Fixed] coinpayments system.</li>
                    <li>[Fixed] can't edit languages from admin panel.</li>
                    <li>[Fixed] when user share a locked post, it shows unlocked on user's profile for everyone to see.</li>
                    <li>[Fixed] Twilio calls.</li>
                    <li>[Fixed] If you enabled pro on sign up, all links will stop working using ajax load.</li>
                    <li>[Fixed] 20+ minor bugs</li>
                    <li>[Improved] speed.</li>
                        </ul>
                        <p class="hide_print">Note: The update process might take few minutes.</p>
                        <p class="hide_print">Important: If you got any fail queries, please copy them, open a support ticket and send us the details.</p>
                        <br>
                             <button class="pull-right btn btn-default" onclick="window.print();">Share Log</button>
                             <button type="button" class="btn btn-main" id="button-update">
                             Update
                             <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                <path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path>
                             </svg>
                          </button>
                     </div>
                     <?php }?>
                     <?php if ($updated == true) { ?>
                      <div>
                        <div class="empty_state">
                           <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                           </svg>
                           <p>Congratulations, you have successfully updated your site. Thanks for choosing WoWonder.</p>
                           <br>
                           <a href="<?php echo $wo['config']['site_url'] ?>" class="btn btn-main" style="line-height:50px;">Home</a>
                        </div>
                     </div>
                     <?php }?>
                  </div>
               </div>
            </div>
            <div class="col-md-1"></div>
         </div>
      </div>
   </body>
</html>
<script>
var queries = [
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'yoomoney_payment', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'yoomoney_wallet_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'yoomoney_notifications_secret', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'convert_speed', 'fast');",
    "CREATE TABLE `pending_payments` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL DEFAULT 0,  `payment_data` varchar(500) CHARACTER SET utf8 NOT NULL DEFAULT '',  `method_name` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',  `time` int(11) NOT NULL DEFAULT 0,  PRIMARY KEY (`id`),  KEY `user_id` (`user_id`),  KEY `payment_data` (`payment_data`),  KEY `method_name` (`method_name`),  KEY `time` (`time`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",
    "ALTER TABLE `pxp_posts` ADD `parent_id` INT(11) NOT NULL DEFAULT '0' AFTER `price`, ADD INDEX (`parent_id`);",
    "ALTER TABLE `pxp_posts` ADD `agora_token` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `stream_name`, ADD INDEX (`agora_token`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_app_certificate', '');",
    "ALTER TABLE `pxp_messages` ADD `reply_id` INT(11) NOT NULL DEFAULT '0' AFTER `extra`, ADD INDEX (`reply_id`);",
    "ALTER TABLE `pxp_messages` ADD `story_id` INT(11) NOT NULL DEFAULT '0' AFTER `extra`, ADD INDEX (`story_id`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'fluttewave_payment', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'fluttewave_secret_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_storage', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_bucket_name', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_access_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_secret_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_endpoint', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_bucket_region', 'us-west-1');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'backblaze_storage', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'backblaze_bucket_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'backblaze_bucket_name', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'backblaze_bucket_region', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'backblaze_access_key_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'backblaze_access_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'backblaze_endpoint', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'withdrawal_payment_method', '{\"paypal\":1,\"bank\":0,\"skrill\":0,\"custom\":0}');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'custom_name', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'm_withdrawal', '50');",
    "ALTER TABLE `pxp_withdrawal_requests` ADD `iban` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `currency`, ADD `country` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `iban`, ADD `full_name` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `country`, ADD `swift_code` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `full_name`, ADD `address` VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `swift_code`, ADD `type` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `address`, ADD `transfer_info` VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `type`, ADD INDEX (`iban`), ADD INDEX (`country`), ADD INDEX (`full_name`), ADD INDEX (`swift_code`), ADD INDEX (`address`), ADD INDEX (`type`), ADD INDEX (`transfer_info`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'developer_mode', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'adult_images', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'vision_api_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'twilio_provider', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'sms_twilio_username', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'sms_twilio_password', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'sms_twilio_phone', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'twilio_test_phone', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'bulksms_provider', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'bulksms_username', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'bulksms_password', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'bulksms_test_phone', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'messagebird_provider', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'messagebird_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'messagebird_test_phone', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'msg91_provider', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'msg91_authKey', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'msg91_dlt_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'msg91_test_phone', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'infobip_provider', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'infobip_api_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'infobip_base_url', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'infobip_test_phone', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'account_validation', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'validation_method', 'mail');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'two_factor_type', 'email');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'two_factor', '0');",
    "ALTER TABLE `pxp_users` ADD `two_factor` INT(11) NOT NULL DEFAULT '0' AFTER `subscribe_price`, ADD INDEX (`two_factor`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'tiktok_import', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'tiktok_login', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'tiktok_client_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'tiktok_client_secret', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'amazone_cloudfront_distribution', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'digital_ocean_cdn', '0');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'cloud_file_path', '');",
    "ALTER TABLE `pxp_config` CHANGE `value` `value` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'yoomoney');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'click_to_see');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'resend_code');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'email_not_sent');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'terms_of_use_page');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'privacy_policy_page');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'about_page');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'first_name');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'last_name');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'i_agree');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'coinpayments_canceled');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'coinpayments_approved');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'fluttewave');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'withdraw_method');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'bank');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'transfer_to');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'iban');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'full_name');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'swift_code');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'please_select_payment_method');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'skrill');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'adult_image_file');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'phone_number_empty');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'worng_phone_number');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'phone_already_used');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'successfully_joined_created_sms');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'activate_account');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_code');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'activate');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_code_empty');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'wrong_confirmation_code');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'account_activated');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'two_factor');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'enable');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'disable');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'please_select_enable_two_factor');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'we_have_sent_you_code');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'two_factor_disabled');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_message_email_sent');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_email_sent');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_message_sent');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_email_message_text');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_email_text');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_message_text');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'verify');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'two_factor_enabled');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'two_factor_already_enabled');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'import_video_error');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'import_vid');",
];

$('#input_code').bind("paste keyup input propertychange", function(e) {
    if (isPurchaseCode($(this).val())) {
        $('#button-update').removeAttr('disabled');
    } else {
        $('#button-update').attr('disabled', 'true');
    }
});

function isPurchaseCode(str) {
    var patt = new RegExp("(.*)-(.*)-(.*)-(.*)-(.*)");
    var res = patt.test(str);
    if (res) {
        return true;
    }
    return false;
}

$(document).on('click', '#button-update', function(event) {
    if ($('body').attr('data-update') == 'true') {
        window.location.href = '<?php echo $site_url?>';
        return false;
    }
    $(this).attr('disabled', true);
    $('.wo_update_changelog').html('');
    $('.wo_update_changelog').css({
        background: '#1e2321',
        color: '#fff'
    });
    $('.setting-well h4').text('Updating..');
    $(this).attr('disabled', true);
    RunQuery();
});

var queriesLength = queries.length;
var query = queries[0];
var count = 0;
function b64EncodeUnicode(str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}
function RunQuery() {
    var query = queries[count];
    $.post('?update', {
        query: b64EncodeUnicode(query)
    }, function(data, textStatus, xhr) {
        if (data.status == 200) {
            $('.wo_update_changelog').append('<li><span class="added">SUCCESS</span> ~$ mysql > ' + query + '</li>');
        } else {
            $('.wo_update_changelog').append('<li><span class="changed">FAILED</span> ~$ mysql > ' + query + '</li>');
        }
        count = count + 1;
        if (queriesLength > count) {
            setTimeout(function() {
                RunQuery();
            }, 1500);
        } else {
            $('.wo_update_changelog').append('<li><span class="added">Updating Langauges</span> ~$ languages.sh, Please wait, this might take some time..</li>');
            $.post('?run_lang', {
                update_langs: 'true'
            }, function(data, textStatus, xhr) {
              $('.wo_update_changelog').append('<li><span class="fixed">Finished!</span> ~$ Congratulations! you have successfully updated your site. Thanks for choosing PixelPhoto.</li>');
              $('.setting-well h4').text('Update Log');
              $('#button-update').html('Home <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"> <path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path> </svg>');
              $('#button-update').attr('disabled', false);
              $(".wo_update_changelog").scrollTop($(".wo_update_changelog")[0].scrollHeight);
              $('body').attr('data-update', 'true');
            });
        }
        $(".wo_update_changelog").scrollTop($(".wo_update_changelog")[0].scrollHeight);
    });
}
</script>
