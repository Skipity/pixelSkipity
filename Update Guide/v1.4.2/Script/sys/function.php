<?php
function pt_push_channel_notifiations($video_id = 0,$type = "added_video") {
    global $config, $db,$me;
    if (IS_LOGGED == false) {
        return false;
    }
    $get_subscribers = $db->where('user_id', $me['user_id'])->get(T_SUBSCRIPTIONS);
    $userIds         = array();
    if (empty($get_subscribers)) {
        return false;
    }
    if ($type == "added_video") {
        $video_uid = $db->where('post_key', $video_id)->getValue(T_VIDEOS, 'id');
    }
    else{
        $video = $db->where('id', $video_id)->getOne(T_POSTS);
        if (empty($video)) {
            return false;
        }
        $video_uid = $video->id;
        $video_id = $video->post_key;
    }
    
    if (empty($video_uid)) {
        return false;
    }
    foreach ($get_subscribers as $key => $subscriber) {
        $userIds[] = "('{$me['user_id']}', '{$subscriber->subscriber_id}', '$video_uid', '{$type}', 'live/{$video_id}', '" . time() . "')";
    }
    $query_implode       = implode(',', $userIds);
    $query_row           = $db->rawQuery("INSERT INTO " . T_NOTIFICATIONS . " (`notifier_id`, `recipient_id`, `text`, `type`, `url`, `time`) VALUES $query_implode");
    if ($query_row) {
        return true;
    }
}
function PT_RunInBackground($data = array()) {
    if (!empty(ob_get_status())) {
        ob_end_clean();
        header("Content-Encoding: none");
        header("Connection: close");
        ignore_user_abort();
        ob_start();
        if (!empty($data)) {
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush();
        flush();
        session_write_close();
        if (is_callable('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }
}
function PT_GenerateKey($minlength = 20, $maxlength = 20, $uselower = true, $useupper = true, $usenumbers = true, $usespecial = false) {
    $charset = '';
    if ($uselower) {
        $charset .= "abcdefghijklmnopqrstuvwxyz";
    }
    if ($useupper) {
        $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }
    if ($usenumbers) {
        $charset .= "123456789";
    }
    if ($usespecial) {
        $charset .= "~@#$%^*()_+-={}|][";
    }
    if ($minlength > $maxlength) {
        $length = mt_rand($maxlength, $minlength);
    } else {
        $length = mt_rand($minlength, $maxlength);
    }
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $charset[(mt_rand(0, strlen($charset) - 1))];
    }
    return $key;
}
function PT_Markup($text, $link = true) {
    if ($link == true) {
        $link_search = '/\[a\](.*?)\[\/a\]/i';
        if (preg_match_all($link_search, $text, $matches)) {
            foreach ($matches[1] as $match) {
                $match_decode     = urldecode($match);
                $match_decode_url = $match_decode;
                $count_url        = mb_strlen($match_decode);
                if ($count_url > 50) {
                    $match_decode_url = mb_substr($match_decode_url, 0, 30) . '....' . mb_substr($match_decode_url, 30, 20);
                }
                $match_url = $match_decode;
                if (!preg_match("/http(|s)\:\/\//", $match_decode)) {
                    $match_url = 'http://' . $match_url;
                }
                $text = str_replace('[a]' . $match . '[/a]', '<a href="' . strip_tags($match_url) . '" target="_blank" class="hash" rel="nofollow">' . $match_decode_url . '</a>', $text);
            }
        }
    }
    return $text;
}
function PT_Duration($text) {
    $duration_search = '/\[d\](.*?)\[\/d\]/i';

    if (preg_match_all($duration_search, $text, $matches)) {
        foreach ($matches[1] as $match) {
            $time = explode(":", $match);
            $current_time = ($time[0]*60)+$time[1];
            $text = str_replace('[d]' . $match . '[/d]', '<a  class="hash" href="javascript:void(0)" onclick="go_to_duration('.$current_time.')">' . $match . '</a>', $text);
        }
    }
    return $text;
}
function StartCloudRecording($vendor,$region,$bucket,$accessKey,$secretKey,$cname,$uid,$post_id){
    global $config,$db;
    $post_id = Generic::secure($post_id);

    $_data = [
        'vendor' => $vendor,
        'region' => $region,
        'bucket' => $bucket,
        'accessKey' => $accessKey,
        'secretKey' => $secretKey,
        'cname' => $cname,
        'uid' => $uid,
        'post_id' => $post_id
    ];
    //$db->insert('log',['var' => 'data on start record','val' => json_encode($_data, JSON_PRETTY_PRINT),'time' => time()]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.agora.io/v1/apps/".$config['agora_app_id']."/cloud_recording/acquire");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($config['agora_customer_id'].":".$config['agora_customer_certificate']),'Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS,'{
      "cname": "'.$cname.'",
      "uid": "'.(int)$uid.'",
      "clientRequest":{
      }
    }');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response);
    $resourceId = $data->resourceId;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.agora.io/v1/apps/".$config['agora_app_id']."/cloud_recording/resourceid/".$resourceId."/mode/mix/start");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($config['agora_customer_id'].":".$config['agora_customer_certificate']),'Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS,'{
        "cname":"'.$cname.'",
        "uid":"'.$uid.'",
        "clientRequest":{
            "recordingConfig":{
                "channelType":1,
                "streamTypes":2,
                "audioProfile":1,
                "videoStreamType":1,
                "maxIdleTime":120,
                "transcodingConfig":{
                    "width":480,
                    "height":480,
                    "fps":24,
                    "bitrate":800,
                    "maxResolutionUid":"1",
                    "mixedVideoLayout":1
                    }
                },
            "storageConfig":{
                "vendor":'.$vendor.',
                "region":'.$region.',
                "bucket":"'.$bucket.'",
                "accessKey":"'.$accessKey.'",
                "secretKey":"'.$secretKey.'",
                "fileNamePrefix": [
                    "upload",
                    "videos",
                    "'.date('Y').'",
                    "'.date('m').'"
                ]
            }   
        }
    }');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    //$db->insert('log',['var' => 'cur response on start record','val' => $response,'time' => time()]);
    $data = json_decode($response);
    if (!empty($data->sid) && !empty($resourceId)) {
        $db->where('post_id',$post_id)->update(T_POSTS,array('agora_resource_id' => $resourceId,'agora_sid' => $data->sid));
    }
    return true;
}
function StopCloudRecording($data)
{
    global $config,$db;
    if ( empty($data) ||
         $config['agora_live_video'] != 1 || 
         empty($data['resourceId']) || 
         empty($data['sid']) || 
         empty($data['cname']) || 
         empty($data['uid']) || 
         empty($data['post_id'])
        ) {
        return false;
    }
    $post_id = Generic::secure($data['post_id']);

    //$db->insert('log',['var' => 'data on stop record','val' => json_encode($data, JSON_PRETTY_PRINT) ,'time' => time()]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.agora.io/v1/apps/".$config['agora_app_id']."/cloud_recording/resourceid/".$data['resourceId']."/sid/".$data['sid']."/mode/mix/stop");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($config['agora_customer_id'].":".$config['agora_customer_certificate']),'Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS,'{
      "cname": "'.$data['cname'].'",
      "uid": "'.(int)$data['uid'].'",
      "clientRequest":{
      }
    }');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response);

    //$db->insert('log',['var' => 'curl response','val' => $response,'time' => time()]);
    //$db->insert('log',['var' => 'data','val' => json_encode($data, JSON_PRETTY_PRINT),'time' => time()]);

    if (!empty($data) && !empty($data->serverResponse) && !empty($data->serverResponse->fileList)) {
        $db->where('post_id',$post_id)->update(T_POSTS,array('video_location' => $data->serverResponse->fileList));
    }
    return true;
}
function Stream_DeleteVideo($id = 0) {
    global $config, $db;
    if (empty($id)) {
        return false;
    }

    $get_video = $db->where('post_id', $id)->getOne(T_POSTS);
    if (strpos($get_video->thumbnail, 'media/upload/photos') !== false) {
        if ($get_video->thumbnail != 'media/upload/photos/thumbnail.jpg') {
            if (file_exists($get_video->thumbnail)) {
                unlink($get_video->thumbnail);
            }

            if ($config['amazone_s3_2'] == 1) { 
                $media = new Media();
                try{
                  $media->streamdeleteFromFTPorS3($get_video->thumbnail);
                } catch (Exception $e) {

                }
            }  
        }
        
    }
    

    if (!empty($get_video->video_location)) {
        if (file_exists($get_video->video_location)) {
            unlink($get_video->video_location);
        }
        if ($config['amazone_s3_2'] == 1) { 
            $media = new Media();
            try{
                $media->streamdeleteFromFTPorS3($get_video->video_location);
            } catch (Exception $e) {

            }
        }
    }

    $posts   = new Posts();
    $posts->setPostId($id);
    $delete = $posts->deletePost();

    if ($delete) {
        return true;
    }
    return false;
}

function px_StripSlashes($value) {
    if (!get_magic_quotes_gpc()) return $value;
    if (is_array($value)) {
        return array_map('px_StripSlashes', $value);
    } else {
        return stripslashes($value);
    }
}
function IsBanned($value = '') {
    global $mysqli;
    $query_one    = mysqli_query($mysqli, "SELECT COUNT(`id`) as count FROM " . T_BLACKLIST . " WHERE `value` = '{$value}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    if ($fetched_data['count'] > 0) {
        return true;
    }
    return false;
}
function IsSharedPost($post_id) {
    global $mysqli;
    $query_one    = mysqli_query($mysqli, "SELECT COUNT(`id`) as count FROM " . T_NOTIF . " WHERE `type` = 'shared_your_post' AND `url` LIKE '%/post/{$post_id}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    if ($fetched_data['count'] > 0) {
        return true;
    }
    return false;
}
function GetSharedPostOwner($post_id) {
    global $mysqli, $db;
    $query_one    = mysqli_query($mysqli, "SELECT `recipient_id` FROM " . T_NOTIF . " WHERE `type` = 'shared_your_post' AND `url` LIKE '%/post/{$post_id}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    if ($fetched_data['recipient_id'] > 0) {
        $user = $db->arrayBuilder()->where('user_id',$fetched_data['recipient_id'])->get(T_USERS,null,array('*'));
        return (isset($user[0])) ? $user[0] : array();
    }
    return '';
}
function RemoveXSS($val) {
    $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
        $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
    }
    $ra =  array('javascript', 'vbscript', 'expression', '<applet', '<meta', '<xml', '<blink', '<link', '<style', '<script', '<embed', '<object', '<iframe', '<frame', '<frameset', '<ilayer', '<layer', '<bgsound', '<title', '<base', 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $found = true;
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                    $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                    $pattern .= ')?';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
            $val = preg_replace($pattern, $replacement, $val);
            if ($val_before == $val) {
                $found = false;
            }
        }
    }
    return $val;
}
function isVideo($file) {
    return is_file($file) && (0 === strpos(mime_content_type($file), 'video/'));
}
function blog_categories(){
    global $db,$context;
    $lang = $context['language'];//'english';
    $blog_categories = $db->arrayBuilder()->where('ref','blog_categories')->get(T_LANGS,null,array('lang_key',$lang));
    $data = array();
    foreach ($blog_categories as $key => $value) {
        if(isset($value[$lang])) {
            $data[$value['lang_key']] = $value[$lang];
        }
    }
    return $data;
}
function store_categories(){
    global $db,$context;
    $lang = $context['language'];//'english';
    $blog_categories = $db->arrayBuilder()->where('ref','store_categories')->get(T_LANGS,null,array('lang_key',$lang));
    $data = array();
    foreach ($blog_categories as $key => $value) {
        if(isset($value[$lang])) {
            $data[$value['lang_key']] = $value[$lang];
        }
    }
    return $data;
}
function GetBlogArticles() {
    global $sqlConnect;
    $data          = array();
    $query_one     = "SELECT * FROM `".T_BLOG."` ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($sqlConnect, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql_query_one)) {
        $data[] = GetArticle($fetched_data['id']);
    }
    return $data;
}
function GetArticle($page_name) {
    global $sqlConnect;
    if (empty($page_name)) {
        return false;
    }
    $data          = array();
    $page_name     = Generic::secure($page_name);
    $query_one     = "SELECT * FROM `".T_BLOG."` WHERE `id` = '{$page_name}'";
    $sql_query_one = mysqli_query($sqlConnect, $query_one);
    $fetched_data  = mysqli_fetch_assoc($sql_query_one);
    return $fetched_data;
}
function RegisterNewBlogPost($registration_data) {
    global $sqlConnect;
    if (empty($registration_data)) {
        return false;
    }
    $fields = '`' . implode('`, `', array_keys($registration_data)) . '`';
    $data   = '\'' . implode('\', \'', $registration_data) . '\'';
    $query  = mysqli_query($sqlConnect, "INSERT INTO `".T_BLOG."` ({$fields}) VALUES ({$data})");
    if ($query) {
        return true;
    }
    return false;
}
function PublishArticle($id) {
    global $sqlConnect;
    if (Generic::isLogged_() == false) {
        return false;
    }
    $id    = Generic::secure($id);
    $query = mysqli_query($sqlConnect, "UPDATE `".T_BLOG."` SET `posted` = 1 WHERE `id` = {$id}");
    if ($query) {
        return true;
    }
    return false;
}
function UnPublishArticle($id) {
    global $sqlConnect;
    if (Generic::isLogged_() == false) {
        return false;
    }
    $id    = Generic::secure($id);
    $query = mysqli_query($sqlConnect, "UPDATE `".T_BLOG."` SET `posted` = 0 WHERE `id` = {$id}");
    if ($query) {
        return true;
    }
    return false;
}
function DeleteArticle($id, $thumbnail) {
    global $sqlConnect;
    if (Generic::isLogged_() == false) {
        return false;
    }
    $id    = Generic::secure($id);
    $query = mysqli_query($sqlConnect, "DELETE FROM `".T_BLOG."` WHERE `id` = {$id}");
    if ($query) {
        $media = new Media();
        $cthumbnail = str_replace('_image','_image_c',$thumbnail);
        $media->deleteFromFTPorS3($thumbnail);
        if(file_exists($thumbnail)){
            @unlink($thumbnail);
        }
        $media->deleteFromFTPorS3($cthumbnail);
        if(file_exists($cthumbnail)){
            @unlink($cthumbnail);
        }
        return true;
    }
    return false;
}
function LangsNamesFromDB($lang = 'english') {
    global $sqlConnect;
    $data  = array();
    $query = mysqli_query($sqlConnect, "SHOW COLUMNS FROM `".T_LANGS."`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[] = $fetched_data['Field'];
    }
    unset($data[0]);
    unset($data[1]);
    unset($data[2]);
    return $data;
}
function GetLangDetails($lang_key = '') {
    global $sqlConnect;
    if (empty($lang_key)) {
        return false;
    }
    $lang_key = Generic::secure($lang_key);
    $data     = array();
    $query    = mysqli_query($sqlConnect, "SELECT * FROM `".T_LANGS."` WHERE `lang_key` = '{$lang_key}'");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        unset($fetched_data['lang_key']);
        unset($fetched_data['id']);
        unset($fetched_data['ref']);
        $data[] = $fetched_data;
    }
    return $data;
}
function update_store_image_view($id){
    global $db;
    $cookie_value = null;
    if( !in_array( $id, explode( ',', $_COOKIE['store_views'] ) ) ) {
        if (isset($_COOKIE['store_views'])) {
            $cookie_value = $_COOKIE['store_views'] . ',' . $id;
        } else {
            $cookie_value = $id;
        }
    }
    if( NULL !== $cookie_value ){
        $db->where('id', $id)->update(T_STORE, array('views' => $db->inc(1)));
        setcookie("store_views", $cookie_value, time() + (10 * 365 * 24 * 60 * 60), "/");
    }
}
function update_store_image_downloads($id){
    global $db;
    $cookie_value = null;
    if( !in_array( $id, explode( ',', $_COOKIE['store_downloads'] ) ) ) {
        if (isset($_COOKIE['store_downloads'])) {
            $cookie_value = $_COOKIE['store_downloads'] . ',' . $id;
        } else {
            $cookie_value = $id;
        }
    }
    if( NULL !== $cookie_value ){
        $db->where('id', $id)->update(T_STORE, array('downloads' => $db->inc(1)));
        setcookie("store_downloads", $cookie_value, time() + (10 * 365 * 24 * 60 * 60), "/");
    }
}
function is_store_item_purchased($id,$_license){
    global $db, $user,$context;
    $transaction = $db->arrayBuilder()
                      ->where('item_license',$_license)
                      ->where('type', 'store')
                      ->where('user_id', $context['user']['user_id'])
                      ->where('item_store_id', Generic::secure($id))
                      ->getOne(T_TRANSACTIONS);
    if($transaction){
        return true;
    }else{
        return false;
    }
}