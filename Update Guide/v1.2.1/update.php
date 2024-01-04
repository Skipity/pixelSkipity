<?php
if (file_exists('./sys/init.php')) {
    require_once('./sys/init.php');
} else {
    die('Please put this file in the home directory !');
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
if (!empty($_POST['update_langs'])) {
    $remove_files = array(
    "./sys/import3p/smarty-3.1.30/libs/debug.tpl",
    "./sys/import3p/smarty-3.1.30/demo/templates/header.tpl",
    "./sys/import3p/smarty-3.1.30/demo/templates/index.tpl",
    "./sys/import3p/smarty-3.1.30/demo/templates/footer.tpl",
    "./apps/default/home/templates/home/includes/upload-image.tpl",
    "./apps/default/home/templates/home/includes/story.tpl",
    "./apps/default/home/templates/home/includes/embed-video.tpl",
    "./apps/default/home/templates/home/includes/post-image.tpl",
    "./apps/default/home/templates/home/includes/no-posted.tpl",
    "./apps/default/home/templates/home/includes/comments.tpl",
    "./apps/default/home/templates/home/includes/sidebar.tpl",
    "./apps/default/home/templates/home/includes/post-youtube.tpl",
    "./apps/default/home/templates/home/includes/post-vimeo.tpl",
    "./apps/default/home/templates/home/includes/post-dailymotion.tpl",
    "./apps/default/home/templates/home/includes/create-story.tpl",
    "./apps/default/home/templates/home/includes/follow.tpl",
    "./apps/default/home/templates/home/includes/import-gifs.tpl",
    "./apps/default/home/templates/home/includes/ffmpeg-upload-video.tpl",
    "./apps/default/home/templates/home/includes/upload-video.tpl",
    "./apps/default/home/templates/home/includes/post-video.tpl",
    "./apps/default/home/templates/home/js/script.add.story.tpl",
    "./apps/default/home/templates/home/js/script.view.story.tpl",
    "./apps/default/home/templates/home/js/script.upload.images.tpl",
    "./apps/default/home/templates/home/js/script.import.images.tpl",
    "./apps/default/home/templates/home/js/script.embed.video.tpl",
    "./apps/default/home/templates/home/js/publisher-box.tpl",
    "./apps/default/home/templates/home/js/script.upload.video.tpl",
    "./apps/default/home/templates/home/index.tpl",
    "./apps/default/messages/templates/messages/includes/messages-list.tpl",
    "./apps/default/messages/templates/messages/js/script.tpl",
    "./apps/default/messages/templates/messages/index.tpl",
    "./apps/default/notactive/templates/notactive/index.tpl",
    "./apps/default/terms/templates/terms/index.tpl",
    "./apps/default/confirm/templates/confirm/index.tpl",
    "./apps/default/404/templates/404/index.tpl",
    "./apps/default/settings/templates/settings/includes/delete.tpl",
    "./apps/default/settings/templates/settings/includes/notifications.tpl",
    "./apps/default/settings/templates/settings/includes/profile.tpl",
    "./apps/default/settings/templates/settings/includes/blocked-users.tpl",
    "./apps/default/settings/templates/settings/includes/password.tpl",
    "./apps/default/settings/templates/settings/includes/privacy.tpl",
    "./apps/default/settings/templates/settings/includes/blocked.tpl",
    "./apps/default/settings/templates/settings/includes/general.tpl",
    "./apps/default/settings/templates/settings/js/script.tpl",
    "./apps/default/settings/templates/settings/index.tpl",
    "./apps/default/welcome/templates/welcome/forgot.tpl",
    "./apps/default/welcome/templates/welcome/index.tpl",
    "./apps/default/welcome/templates/welcome/reset.tpl",
    "./apps/default/explore/templates/explore/includes/no-users-found.tpl",
    "./apps/default/explore/templates/explore/includes/no-posts-found.tpl",
    "./apps/default/explore/templates/explore/includes/row.tpl",
    "./apps/default/explore/templates/explore/includes/list.tpl",
    "./apps/default/explore/templates/explore/people.tpl",
    "./apps/default/explore/templates/explore/index.tpl",
    "./apps/default/explore/templates/explore/tags.tpl",
    "./apps/default/posts/templates/posts/includes/comments.tpl",
    "./apps/default/posts/templates/posts/view-post.tpl",
    "./apps/default/profile/templates/profile/includes/no-posted.tpl",
    "./apps/default/profile/templates/profile/includes/followers-ls-item.tpl",
    "./apps/default/profile/templates/profile/includes/list.tpl",
    "./apps/default/profile/templates/profile/includes/following-ls-item.tpl",
    "./apps/default/profile/templates/profile/favourites.tpl",
    "./apps/default/profile/templates/profile/js/script.tpl",
    "./apps/default/profile/templates/profile/following.tpl",
    "./apps/default/profile/templates/profile/index.tpl",
    "./apps/default/profile/templates/profile/followers.tpl",
    "./apps/default/profile/templates/profile/posts.tpl",
    "./apps/default/signup/templates/signup/index.tpl",
    "./apps/default/main/templates/includes/timeago.tpl",
    "./apps/default/main/templates/includes/lightbox.tpl",
    "./apps/default/main/templates/includes/lazy-load.tpl",
    "./apps/default/main/templates/js/extra-js.tpl",
    "./apps/default/main/templates/js/h-script.tpl",
    "./apps/default/main/templates/header/notifications.tpl",
    "./apps/default/main/templates/header/header.tpl",
    "./apps/default/main/templates/header/search-usrls.tpl",
    "./apps/default/main/templates/header/search-posts.tpl",
    "./apps/default/main/templates/container.tpl",
    "./apps/default/main/templates/footer/footer.tpl",
    "./apps/default/main/templates/footer/sidebar-footer.tpl",
    "./apps/default/main/templates/modals/delete-story.tpl",
    "./apps/default/main/templates/modals/clear-chat.tpl",
    "./apps/default/main/templates/modals/unblock-user.tpl",
    "./apps/default/main/templates/modals/view-post-likes.tpl",
    "./apps/default/main/templates/modals/delete-post.tpl",
    "./apps/default/main/templates/modals/edit-post.tpl",
    "./apps/default/main/templates/modals/delete-comment.tpl",
    "./apps/default/main/templates/modals/delete-chat.tpl",
    "./apps/default/main/templates/modals/block-user.tpl",
    "./apps/default/main/templates/modals/delete-messages.tpl",
    "./apps/default/404/setup.php",
    "./apps/default/explore/setup.php",
    "./apps/default/home/models.php",
    "./apps/default/home/setup.php",
    "./apps/default/messages/models.php",
    "./apps/default/messages/setup.php",
    "./apps/default/notactive/setup.php",
    "./apps/default/posts/setup.php",
    "./apps/default/profile/models.php",
    "./apps/default/profile/setup.php",
    "./apps/default/settings/setup.php",
    "./apps/default/signup/setup.php",
    "./apps/default/startup/setup.php",
    "./apps/default/welcome/setup.php",
    "./sys/app_core/PxPSmarty.php",
);

$templates_c = array(
    "./apps/default/home/templates/templates_c",
    "./apps/default/settings/templates/templates_c",
    "./apps/default/welcome/templates/templates_c",
    "./apps/default/explore/templates/templates_c",
    "./apps/default/profile/templates/templates_c",
    "./apps/default/signup/templates/templates_c",
    "./sys/import3p/smarty-3.1.30",
    "./templates"
);


foreach ($remove_files as $file_path) {
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}



function recursive_rmdir($source, $removeOnlyChildren = false) {
    if(empty($source) || file_exists($source) === false) {
        return false;
    }

    if(is_file($source) || is_link($source)) {
        return unlink($source);
    }

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),RecursiveIteratorIterator::CHILD_FIRST);

    //$fileinfo as SplFileInfo
    foreach($files as $fileinfo) {
        if($fileinfo->isDir()) {
            if(recursive_rmdir($fileinfo->getRealPath()) === false) {
                return false;
            }
        }

        else {
            if(unlink($fileinfo->getRealPath()) === false)
            {
                return false;
            }
        }
    }

    if($removeOnlyChildren === false) {
        return rmdir($source);
    }

    return true;
}


foreach ($templates_c as $dir) {
    recursive_rmdir($dir);
}
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
                     <h2 class="light">Update to v1.2.1 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                            <li>[Added] earnigns page in admin panel. </li>
                            <li>[Fixed] bugs</li>
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
    "UPDATE `pxp_config` SET `value`= '1.2.1' WHERE name = 'version';",
    "ALTER TABLE `pxp_bank_receipts` ADD `funding_id` INT(11) NOT NULL DEFAULT '0' AFTER `user_id`;",
    "ALTER TABLE `pxp_funding` ADD `hashed_id` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `id`;",
    "ALTER TABLE `pxp_funding` ADD INDEX(`hashed_id`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'donate_percentage', '1');",
    "CREATE TABLE `pxp_transactions` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_id` int(11) NOT NULL DEFAULT '0',`amount` varchar(50) NOT NULL DEFAULT '0',`admin_com` varchar(50) NOT NULL DEFAULT '0',`type` varchar(100) NOT NULL DEFAULT '',`time` varchar(100) NOT NULL DEFAULT '',PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `pxp_transactions` ADD INDEX(`admin_com`);",
    "ALTER TABLE `pxp_transactions` ADD INDEX(`amount`);",
    "ALTER TABLE `pxp_messages` ADD `media_name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `media_type`;",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'logo_extension', 'png');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'favicon_extension', 'png');"
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