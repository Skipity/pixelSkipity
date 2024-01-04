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
    $data  = array();
    $query = mysqli_query($mysqli, "SHOW COLUMNS FROM `pxp_langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[] = $fetched_data['Field'];
    }
    unset($data[0]);
    unset($data[1]);
    unset($data[2]);
    function PT_UpdateLangs($lang, $key, $value) {
        global $mysqli;
        $update_query         = "UPDATE pxp_langs SET `{lang}` = '{lang_text}' WHERE `lang_key` = '{lang_key}'";
        $update_replace_array = array(
            "{lang}",
            "{lang_text}",
            "{lang_key}"
        );
        return str_replace($update_replace_array, array(
            $lang,
            $value,
            $key
        ), $update_query);
    }
    $lang_update_queries = array();
    foreach ($data as $key => $value) {
        $value = ($value);
        if ($value == 'arabic') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'دعوة صوتية جديدة');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'يريد الدردشة الصوت معك.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'يتحدث مع');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'دفع من المحفظة');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'أنت لا تملك ما يكفي من المال يرجى توبيخ محفظتك');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'دفع بنجاح');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'أذن');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', 'كمية لا يمكن أن تكون فارغة');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', 'هناك شئ خاطئ، يرجى المحاولة فى وقت لاحق!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'securionpay.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'بدين');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', 'تحميل الفيديو 360 درجة');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'بيتكوين');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'coinbase.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'ضع سعر');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'هذا المنصب ليس للبيع');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'قمت بإلغاء تأمين هذا المنصب بالفعل.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'دفع لرؤية مشاركتك.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'دفع لرؤية مشاركتك.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'تم إغلاق هذا المنشور أو شراء أو اشترك في الكشف عن المحتوى.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'الغاء القفل');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'سعر الاشتراك الشهري');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', 'أنت على وشك الترقية إلى الموالية، تابع؟');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', 'أنت على وشك التبرع، المضي قدما؟');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'أنت على وشك الشراء، هل تريد المتابعة؟');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', 'أنت على وشك فتح هذا المحتوى، تابع؟');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', 'أنت على وشك الاشتراك، المضي قدما؟');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'ليس لدى المستخدم أي خطط اشتراكات حتى الآن.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'لقد اشتركت بالفعل.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'المشترك في حسابك.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'مشترك');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', 'هل أنت متأكد أنك تريد إلغاء الاشتراك؟ ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'انتهت صلاحية اشتراكك');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', 'الاشتراكات');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'إعلانات');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'cashfree.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'iyzipay.');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'إنها حقيقة ثابتة طويلة أن القارئ سوف يصرف');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'عرض اشتراكاتي؟');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'إرسال تقرير');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'اكتب تقرير هنا');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', 'ترقية post.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'مؤمن البريد');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', 'استكشاف أحدث بكرات، ومشاهدة أشرطة الفيديو');
        } else if ($value == 'dutch') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'Nieuwe audio-oproep');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'Wil Audio Chat met jou.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'praten met');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Betaal van portemonnee');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'Je hebt niet genoeg geld, vul je portemonnee aan');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Betaling succesvol gedaan');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Toestemming geven');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', 'Bedrag kan niet leeg zijn');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', 'Iets ging fout, probeer het later opnieuw!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Securionpay');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'Payu');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', 'Upload 360-graden video');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'Bitcoin');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'Prijs');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'Dit bericht is niet voor verkoop');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'Je hebt dit bericht al ontgrendeld.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'betaald om je bericht te zien.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'betaald om je bericht te zien.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'Dit bericht is vergrendeld, aanschaffen of abonneren om de inhoud te onthullen.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'Ontgrendelen');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'Maandelijkse abonnementsprijs');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', 'Je staat op het punt om naar Pro te upgraden, door te gaan?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', 'Je staat op het punt te doneren, door te gaan?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'Je gaat kopen, wil je doorgaan?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', 'U staat op het punt deze inhoud te ontgrendelen, door te gaan?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', 'Je staat op het punt zich te abonneren, door te gaan?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'Gebruiker heeft nog geen abonnementenplannen.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'Je hebt al geabonneerd.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'geabonneerd op uw account.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'Ingeschreven');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', 'Afmelden');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', 'Weet je zeker dat je je wilt afmelden? ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', 'Uw abonnement is vernieuwd');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'Uw abonnement is verlopen');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', 'Vernieuwd zijn abonnement');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', 'Abonnementen');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'Advertenties');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', 'Het is een lang gevestigd feit dat een lezer wordt afgeleid door de leesbare inhoud van een pagina wanneer u naar de lay-out kijkt');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Cashfree');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'Het is een lang gevestigd feit dat een lezer zal worden afgeleid');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'Laat mijn abonnementen zien?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'Verzend rapport');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'Schrijf hier een rapport');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', 'Bevorderde post');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'Vergrendelde post');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', 'Ontdek de nieuwste rollen, bekijk trending-video\'s!');
        } else if ($value == 'french') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'Nouveau appel audio');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'Veut une discussion audio avec vous.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'parler avec');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Payer du portefeuille');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'Vous n\'avez pas assez d\'argent s\'il vous plaît recharger votre portefeuille');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Paiement effectué avec succès');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Autoriser');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', 'Montant ne peut pas être vide');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', 'Quelque chose c\'est mal passé. Merci d\'essayer plus tard!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'SecurionPay');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'Paie');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', 'Télécharger une vidéo à 360 degrés');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'Bitcoin');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'Fixer le prix');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'Cet article n\'est pas à vendre');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'Vous avez déjà déverrouillé ce post.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'payé pour voir votre message.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'payé pour voir votre message.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'Cet article est verrouillé, achète ou abonnez-vous pour dévoiler le contenu.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'Ouvrir');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'Prix ​​d\'abonnement mensuel');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', 'Vous êtes sur le point de passer à Pro, continuez?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', 'Vous êtes sur le point de faire un don, continuez?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'Vous êtes sur le point d\'acheter, voulez-vous continuer?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', 'Vous êtes sur le point de déverrouiller ce contenu, continuez?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', 'Vous êtes sur le point de vous abonner, continuez?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'L\'utilisateur n\'a pas encore aucun plan d\'abonnement.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'Vous avez déjà abonné.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'abonné à votre compte.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'Souscrit');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', 'Se désabonner');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', 'Êtes-vous sûr de vouloir vous désabonner? ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', 'Votre abonnement a été renouvelé');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'Votre abonnement a été expiré');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', 'Renouvelé son abonnement');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', 'Abonnements');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'Les publicités');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', 'C\'est un fait établi depuis longtemps qu\'un lecteur sera distrait par le contenu lisible d\'une page lorsqu\'il examine sa mise en page.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Sans argent');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', 'Cochonnerie');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'C\'est un fait établi depuis longtemps qu\'un lecteur sera distrait');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'Montrer mes abonnements?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'Envoyer un rapport');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'Écrire un rapport ici');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', 'Poste promu');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'Poteau verrouillé');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', 'Explorez les dernières nouvelles, surveillez les vidéos de tendance!');
        } else if ($value == 'german') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'Neuer Audioanruf');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'Will einen Audio-Chat mit Ihnen chatten.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'sprechen mit');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Bezahlen Sie von der Brieftasche');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'Sie haben nicht genug Geld, bitte tippen Sie Ihre Brieftasche auf');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Zahlung erfolgreich erledigt');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Autorisieren');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', 'Betrag kann nicht leer sein');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', 'Etwas ging schief, bitte versuchen Sie es später noch einmal!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'SecurionPay.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'Payu.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', 'Laden Sie 360-Grad-Video hoch');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'Bitcoin');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'Preis festsetzen');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'Dieser Beitrag ist nicht zum Verkauf');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'Sie haben diesen Beitrag bereits freigeschaltet.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'bezahlt, um Ihren Beitrag zu sehen.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'bezahlt, um Ihren Beitrag zu sehen.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'Dieser Beitrag ist gesperrt, kauft oder abonnieren, um den Inhalt enthüllen.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'Freischalten');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'Monatlicher Abonnementpreis.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', 'Sie sind dabei, um ein Upgrade auf Pro zu aktualisieren.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', 'Du bist dabei zu spenden, gehen weiter?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'Du bist dabei zu kaufen, willst du fortfahren?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', 'Sie dürfen diesen Inhalt freischalten, gehen fort?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', 'Sie sind dabei, abonnieren, vorzugehen?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'Der Benutzer hat noch keine Abonnementspläne.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'Sie haben bereits abonniert.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'Ihrem Konto abonniert.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'Gezeichnet');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', 'Abbestellen');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', 'Möchten Sie sicher, dass Sie abbestellen möchten? ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'Ihr Abonnement wurde abgelaufen');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', 'Erneuert sein Abonnement');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'Anzeigen');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Barrierefrei');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'IYZIPAY.');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2Check.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'Es ist eine lange etablierte Tatsache, dass ein Leser abgelenkt wird');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'Meine Abonnements zeigen?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'Bericht senden');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'Schreibbericht hier schreiben.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', 'Geförderter Beitrag');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'Gesperrter Beitrag');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', 'Erkunden Sie die neuesten Rollen, schauen Sie sich Videos an!');
        } else if ($value == 'russian') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'Новый звуковой звонок');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'Хочет аудиоквать с тобой.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'говорить с');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'У вас не хватает денег, пожалуйста, пополните свой кошелек');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Оплата успешно сделана');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Разрешать');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', 'Сумма не может быть пустой');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', 'Что-то пошло не так. Пожалуйста, повторите попытку позже!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Securionpay.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'Окупаемость');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', 'Загрузить видео 360 градусов');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'Биткойн');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'Установить цену');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'Этот пост не для продажи');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'Вы уже разблокировали этот пост.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'платят, чтобы увидеть ваш пост.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'платят, чтобы увидеть ваш пост.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'Этот пост заблокирован, покупка или подписаться на раскрытие контента.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'Разблокировать');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'Ежемесячная цена подписки');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', 'Вы собираетесь обновить до про, продолжить?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', 'Вы собираетесь пожертвовать, продолжить?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'Вы собираетесь купить, вы хотите продолжить?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', 'Вы собираетесь разблокировать этот контент, продолжить?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', 'Вы собираетесь подписаться, продолжить?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'У пользователя еще нет планов подписок.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'Вы уже подписались.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'подписан на ваш счет.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'Подписаться');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', 'Отписаться');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', 'Вы уверены, что хотите отписаться? ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', 'Ваша подписка была возобновлена');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'Ваша подписка была истек');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', 'Возобновил его подписку');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', 'Подписки');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'Объявления');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', 'Долго установлен факт, что читатель будет отвлечен на читаемый контент страницы при рассмотрении его макета');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Кашельство');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2ъечь');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'Это давно установлена ​​факт, что читатель будет отвлечен');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'Покажите мои подписки?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'Отправить жалобу');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'Написать отчет здесь');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', 'Продвигается пост');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'Заблокирован пост');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', 'Исследуйте последние барабаны, смотрите на трендовые видео!');
        } else if ($value == 'spanish') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'Nueva llamada de audio');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'Quiere chatear audio contigo.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'Hablando con');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Pagar de billetera');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'No tienes suficiente dinero, por favor recarga tu billetera');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Pago realizado con éxito');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Autorizar');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', 'La cantidad no puede estar vacía');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', '¡Algo salió mal, por favor, inténtalo de nuevo más tarde!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'PAYO DE SECURION');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'Payu');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', 'Subir video de 360 ​​grados');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'Bitcoin');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'Fijar precio');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'Esta publicación no es para la venta.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'Ya desbloqueaste esta publicación.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'Pagado para ver tu publicación.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'Pagado para ver tu publicación.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'Esta publicación está bloqueada, compra o suscríbase para revelar el contenido.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'desbloquear');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'Suscripción mensual Price');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', '¿Está a punto de actualizar a Pro, continúe?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', '¿Estás a punto de donar, proceder?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'Está a punto de comprar, ¿desea proceder?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', '¿Está a punto de desbloquear este contenido, continúe?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', '¿Está a punto de suscribirse, proceder?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'El usuario aún no tiene ningún plan de suscripciones.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'Ya te has suscrito.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'Suscrito a su cuenta.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'Suscrito');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', 'Darse de baja');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', '¿Estás seguro de que quieres cancelar la suscripción? ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', 'Su suscripción ha sido renovada.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'Su suscripción ha sido expirada.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', 'Renovó su suscripción');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', 'Suscripciones');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'Anuncios');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', 'Es un hecho prolongado que un lector se distraerá por el contenido legible de una página al mirar su diseño');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'CashFree');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'IYZIPAY');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2Comprar');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'Es un hecho prolongado que un lector será distraído.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'Mostrar mis suscripciones?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'Enviar reporte');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'Escribir informe aquí');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'Poste cerrado');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', '¡Explora los últimos carretes, ver videos de tendencia!');
        } else if ($value == 'turkish') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'Yeni ses araması');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'Sizinle sohbet etmek istiyor.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'ile konuşmak');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Cüzdandan ödeme');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'Yeterince param yok, lütfen cüzdanını doldur');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Ödeme başarıyla yapıldı');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Yetki vermek');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', 'Bir şeyler yanlış oldu. Lütfen sonra tekrar deneyiniz!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Securionpay');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'Ötesi');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', '360 derece video yükleyin');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'Bitcoin');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Sikke');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'Ayarlamak');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'Bu yazı satmak için değil');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'Bu yazıyı zaten açtın.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'gönderinizi görmek için ödedi.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'gönderinizi görmek için ödedi.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'Bu gönderi, içeriği açıklamak için kilitli, satın alınır veya abone olun.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'Kilidini aç');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'Aylık abonelik Fiyat');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', 'Pro\'ya yükseltmek üzeresin, devam mı ediyorsun?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', 'Bağışlamak üzeresin?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'Satın almak üzeresiniz, devam etmek ister misiniz?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', 'Bu içeriğin kilidini açmak üzeresiniz, devam et?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', 'Abone olmak üzeresiniz, devam mı ediyorsunuz?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'Kullanıcının henüz hiçbir abonelik planı yok.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'Zaten abone oldunuz.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'Hesabınıza abone olun.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'Abone olundu');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', 'Abonelikten çıkmak');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', '');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', 'Aboneliğiniz yenilendi');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'Aboneliğinizin süresi doldu');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', 'Aboneliğini yeniledi');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', 'Abonelikler');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'Reklamlar');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', 'Bir okuyucunun, düzenine bakarken bir sayfanın okunabilir içeriği ile dikkatini dağıtacağı uzun zamandır kurulmuştur.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Cashfree');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'İyzipay');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'Bir okuyucunun dikkatini dağıtacağı uzun zamandır kurulmuş bir gerçektir.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'Aboneliklerimi göster?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'Rapor gönder');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'Burada Rapor Yaz');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', 'Terfi');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'Kilitli yazı');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', 'En son makaraları keşfedin, trendleri izleyin!');
        } else if ($value == 'english') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'New audio call');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'wants to audio chat with you.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'talking with');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Pay from wallet');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'You don`t have enough money please top up your wallet');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Payment successfully done');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Authorize');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', 'Amount can not be empty');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', 'Something went wrong, Please try again later!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Securionpay');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', 'Upload 360-Degree video');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'Bitcoin');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'Set Price');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'This post is not for sell');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'You already unlocked this post.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'paid to see your post.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'paid to see your post.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'This post is locked, purchase or subscribe to unveil the content.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'Unlock');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'Monthly Subscription Price');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', 'You are about to upgrade to PRO, proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', 'You are about to donate, proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'You are about to purchase, do you want to proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', 'You are about to unlock this content, proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', 'You are about to subscribe, proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'User doesn\'t have any subscriptions plans yet.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'You have already subscribed.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'subscribed to your account.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'Subscribed');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', 'Unsubscribe');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', 'Are you sure you want to unsubscribe? This action can`t be undo.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', 'Your subscription has been renewed');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'Your subscription has been expired');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', 'Renewed his subscription');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', 'Subscriptions');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'Ads');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Cashfree');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2Checkout');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'It is a long established fact that a reader will be distracted');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'Show my subscriptions?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'Send Report');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'Write report here');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', 'Promoted Post');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'Locked Post');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', 'Explore latest reels, watch trending videos!');
        } else if ($value != 'english') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'new_audio_call', 'New audio call');
          $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_audio_call', 'wants to audio chat with you.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'audio_call_desc', 'talking with');
          $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Pay from wallet');
          $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'You don`t have enough money please top up your wallet');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Payment successfully done');
          $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Authorize');
          $lang_update_queries[] = PT_UpdateLangs($value, 'amount_empty', 'Amount can not be empty');
          $lang_update_queries[] = PT_UpdateLangs($value, 'something_went_wrong_please_try_again_later_', 'Something went wrong, Please try again later!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Securionpay');
          $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
          $lang_update_queries[] = PT_UpdateLangs($value, 'upload_360_videos', 'Upload 360-Degree video');
          $lang_update_queries[] = PT_UpdateLangs($value, 'bitcoin', 'Bitcoin');
          $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = PT_UpdateLangs($value, 'set_price', 'Set Price');
          $lang_update_queries[] = PT_UpdateLangs($value, 'post_not_for_sell', 'This post is not for sell');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_bought_this_post', 'You already unlocked this post.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_image', 'paid to see your post.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock_user_video', 'paid to see your post.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post_text', 'This post is locked, purchase or subscribe to unveil the content.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unlock', 'Unlock');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price', 'Monthly Subscription Price');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_upgrade_to_pro', 'You are about to upgrade to PRO, proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_donate', 'You are about to donate, proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_purchase', 'You are about to purchase, do you want to proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unlock', 'You are about to unlock this content, proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_subscribe_unlock', 'You are about to subscribe, proceed?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'user_dont_have_subscribe', 'User doesn\'t have any subscriptions plans yet.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'you_already_subscribed', 'You have already subscribed.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'have_new_subscriber', 'subscribed to your account.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed', 'Subscribed');
          $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe', 'Unsubscribe');
          $lang_update_queries[] = PT_UpdateLangs($value, 'sure_to_unsubscribe', 'Are you sure you want to unsubscribe? This action can`t be undo.');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscription_has_been_renewed', 'Your subscription has been renewed');
          $lang_update_queries[] = PT_UpdateLangs($value, 'your_subscription_has_been_expired', 'Your subscription has been expired');
          $lang_update_queries[] = PT_UpdateLangs($value, 'renewed_his_subscription', 'Renewed his subscription');
          $lang_update_queries[] = PT_UpdateLangs($value, 'subscriptions', 'Subscriptions');
          $lang_update_queries[] = PT_UpdateLangs($value, 'ads', 'Ads');
          $lang_update_queries[] = PT_UpdateLangs($value, 'private_text', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout');
          $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Cashfree');
          $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
          $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2Checkout');
          $lang_update_queries[] = PT_UpdateLangs($value, 'monthly_subscribe_price_text', 'It is a long established fact that a reader will be distracted');
          $lang_update_queries[] = PT_UpdateLangs($value, 'show_my_subscriptions', 'Show my subscriptions?');
          $lang_update_queries[] = PT_UpdateLangs($value, 'send_report', 'Send Report');
          $lang_update_queries[] = PT_UpdateLangs($value, 'write_report_here', 'Write report here');
          $lang_update_queries[] = PT_UpdateLangs($value, 'promoted_post', 'Promoted Post');
          $lang_update_queries[] = PT_UpdateLangs($value, 'locked_post', 'Locked Post');
          $lang_update_queries[] = PT_UpdateLangs($value, 'explore_reels_subtitle', 'Explore latest reels, watch trending videos!');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
        }
        $users = $db->get(T_USERS);
        if (!empty($users)) {
        	foreach ($users as $key => $user) {
        		if (empty($user->time)) {
        			$array = explode('/', $user->registered);
        			$time = strtotime($array[1].'/'.$array[0].'/01');
        			if ($array[1] == '0000' || $array[0] == '00') {
        				$time = time();
        			}
        			$db->where('user_id',$user->user_id)->update(T_USERS,array('time' => $time));
        		}
        	}
        }
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
                     <h2 class="light">Update to v1.5 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                          <li>[Added] LinkedIn, Vkontakte, Instagram, QQ, WeChat, Discord & Mailru social login.. </li>
                          <li>[Added] more payment methods.</li>
                          <li>[Added] Agora live & video chats. </li>
                          <li>[Added] the ability to upload 360-degree video. </li>
                          <li>[Added] the ability to unlock images and videos. (pay or subscribe) </li>
                          <li>[Added] currency system. </li>
                          <li>[Added] new admin panel, v2 .</li>
                          <li>[Added] new welcome page design.</li>
                          <li>[Added] submit button to comment box.</li>
                          <li>[Added] audio chat.</li>
                          <li>[Added] support for PHP 8.0+ and MySQL 8.0+</li>
                          <li>[Updated] default theme design.</li>
                          <li>[Fixed] 20+ reported bugs</li>
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
    "UPDATE `pxp_config` SET `value`= '1.5' WHERE name = 'version';",
    "ALTER TABLE `pxp_users` ADD `time` INT(11) NOT NULL DEFAULT '0' AFTER `registered`, ADD INDEX (`time`);",
    "ALTER TABLE `pxp_notifications` ADD `admin` INT(11) NOT NULL DEFAULT '0' AFTER `sent_push`, ADD INDEX (`admin`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'linkedin_login', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'vkontakte_login', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'instagram_login', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'qq_login', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'wechat_login', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'discord_login', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'mailru_login', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'linkedinAppId', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'linkedinAppKey', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'VkontakteAppId', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'VkontakteAppKey', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'instagramAppId', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'instagramAppkey', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'qqAppId', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'qqAppkey', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'WeChatAppId', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'WeChatAppkey', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'DiscordAppId', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'DiscordAppkey', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'MailruAppId', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'MailruAppkey', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'twilio_video_chat', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_chat_video', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_chat_app_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_chat_app_certificate', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_chat_customer_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_chat_customer_certificate', '');",
    "CREATE TABLE `pxp_agoravideocall` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `from_id` int(11) NOT NULL DEFAULT 0,  `to_id` int(11) NOT NULL DEFAULT 0,  `type` varchar(50) NOT NULL DEFAULT 'video',  `room_name` varchar(50) NOT NULL DEFAULT '0',  `time` int(11) NOT NULL DEFAULT 0,  `status` varchar(20) NOT NULL DEFAULT '',  `active` int(11) NOT NULL DEFAULT 0,  `called` int(11) NOT NULL DEFAULT 0,  `declined` int(11) NOT NULL DEFAULT 0,  `access_token` text CHARACTER SET utf8 DEFAULT NULL,  `access_token_2` text CHARACTER SET utf8 DEFAULT NULL,  PRIMARY KEY (`id`),  KEY `from_id` (`from_id`),  KEY `to_id` (`to_id`),  KEY `type` (`type`),  KEY `room_name` (`room_name`),  KEY `time` (`time`),  KEY `status` (`status`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",
    "CREATE TABLE `pxp_audiocalls` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `call_id` varchar(30) NOT NULL DEFAULT '0',  `access_token` text DEFAULT NULL,  `call_id_2` varchar(30) NOT NULL DEFAULT '',  `access_token_2` text DEFAULT NULL,  `from_id` int(11) NOT NULL DEFAULT 0,  `to_id` int(11) NOT NULL DEFAULT 0,  `room_name` varchar(50) NOT NULL DEFAULT '',  `active` int(11) NOT NULL DEFAULT 0,  `called` int(11) NOT NULL DEFAULT 0,  `time` int(11) NOT NULL DEFAULT 0,  `declined` int(11) NOT NULL DEFAULT 0,  PRIMARY KEY (`id`),  KEY `to_id` (`to_id`),  KEY `from_id` (`from_id`),  KEY `call_id` (`call_id`),  KEY `called` (`called`),  KEY `declined` (`declined`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'paypal_payment', 'off');",
    "ALTER TABLE `pxp_users` ADD `StripeSessionId` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `phone_number`, ADD INDEX (`StripeSessionId`);",
    "ALTER TABLE `pxp_users` ADD `paystack_ref` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `StripeSessionId`, ADD INDEX (`paystack_ref`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'authorize_payment', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'authorize_test_mode', 'SANDBOX');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'authorize_login_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'authorize_transaction_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'securionpay_payment', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'securionpay_public_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'securionpay_secret_key', '');",
    "ALTER TABLE `pxp_users` ADD `securionpay_key` INT(30) NOT NULL DEFAULT '0' AFTER `paystack_ref`, ADD INDEX (`securionpay_key`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'payu_payment', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'payu_mode', '1');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'payu_merchant_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'payu_secret_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'payu_buyer_name', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'payu_buyer_surname', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'payu_buyer_gsm_number', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'payu_buyer_email', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'upload_360_videos', 'on');",
    "ALTER TABLE `pxp_posts` ADD `video_type` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `live_ended`, ADD INDEX (`video_type`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'coinpayments', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'coinpayments_secret', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'coinpayments_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'coinbase_payment', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'coinbase_key', '');",
    "ALTER TABLE `pxp_users` ADD `coinbase_hash` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `securionpay_key`, ADD `coinbase_code` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `coinbase_hash`, ADD INDEX (`coinbase_hash`), ADD INDEX (`coinbase_code`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'private_photos', 'on');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'private_photos_commission', '0');",
    "ALTER TABLE `pxp_media_files` ADD `blured_file` VARCHAR(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `extra`;",
    "ALTER TABLE `pxp_posts` ADD `price` INT(11) NOT NULL DEFAULT '0' AFTER `video_type`, ADD INDEX (`price`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'photo_blurred_number', '100');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'downsize_blurred_photo', '4');",
    "ALTER TABLE `pxp_transactions` ADD `post_id` INT(11) NOT NULL DEFAULT '0' AFTER `user_id`, ADD INDEX (`post_id`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'private_videos', 'off');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'private_videos_commission', '0');",
    "ALTER TABLE `pxp_users` ADD `subscribe_price` INT(11) NOT NULL DEFAULT '0' AFTER `coinbase_code`, ADD INDEX (`subscribe_price`);",
    "CREATE TABLE `pxp_subscribers` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `subscriber_id` INT(11) NOT NULL DEFAULT '0' , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`subscriber_id`), INDEX (`time`)) ENGINE = InnoDB;",
    "ALTER TABLE `pxp_transactions` ADD `subscription_id` INT(11) NOT NULL DEFAULT '0' AFTER `post_id`, ADD INDEX (`subscription_id`);",
    "ALTER TABLE `pxp_users` ADD `show_subscribers` INT(2) NOT NULL DEFAULT '0' AFTER `search_engines`, ADD INDEX (`show_subscribers`);",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'locked_content_explore_page', 'on');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'paypal_currency', 'USD');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'currency_array', '[\"USD\",\"EUR\",\"JPY\",\"TRY\",\"GBP\",\"RUB\",\"PLN\",\"ILS\",\"BRL\",\"INR\"]');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'currency_symbol_array', '{\"USD\":\"&#36;\",\"EUR\":\"&#8364;\",\"JPY\":\"&#165;\",\"TRY\":\"&#8378;\",\"GBP\":\"&#163;\",\"RUB\":\"&#8381;\",\"PLN\":\"&#122;&#322;\",\"ILS\":\"&#8362;\",\"BRL\":\"&#82;&#36;\",\"INR\":\"&#8377;\"}');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'exchange_update', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'exchange', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'stripe_currency', 'USD');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'paystack_currency', 'NGN');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_currency', 'INR');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_currency', 'TL');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'monthly_subscribers_commission', '0');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'new_audio_call');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'want_to_audio_call');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'audio_call_desc');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'pay_from_wallet');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'please_top_up_wallet');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'payment_successfully_done');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'authorize');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'amount_empty');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'something_went_wrong_please_try_again_later_');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'securionpay');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'payu');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'upload_360_videos');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'bitcoin');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'coinbase');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'set_price');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'post_not_for_sell');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'you_already_bought_this_post');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'unlock_user_image');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'unlock_user_video');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'locked_post_text');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'unlock');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'monthly_subscribe_price');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sure_upgrade_to_pro');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sure_to_donate');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sure_to_purchase');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sure_to_unlock');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sure_to_subscribe_unlock');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'user_dont_have_subscribe');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'you_already_subscribed');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'have_new_subscriber');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'subscribed');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'unsubscribe');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sure_to_unsubscribe');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'subscription_has_been_renewed');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'your_subscription_has_been_expired');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'renewed_his_subscription');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'subscriptions');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'ads');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'private_text');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'cashfree');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'iyzipay');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, '2checkout');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'monthly_subscribe_price_text');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'show_my_subscriptions');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'send_report');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'write_report_here');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'promoted_post');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'locked_post');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'explore_reels_subtitle');",
    "ALTER IGNORE TABLE pxp_langs ADD UNIQUE INDEX idx_name (lang_key);",

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
