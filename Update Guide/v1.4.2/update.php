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
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'تبوك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'مدينة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'حالة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'رقم البطاقة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'يدفع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'يرجى التحقق من التفاصيل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'cashfree.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'iyzipay.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'معلومات البطاقة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'ينسخ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'بدأت فيديو مباشر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'فيديو لايف');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'استكشاف المزيد');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'لم يتم العثور على جلسات حية نشطة.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'الذهاب مباشرة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'نهاية مباشرة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'مصدر ميكروفون');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'غير متصل على الانترنت');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'إعدادات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'كوميديا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', 'الاقتصاد والتجارة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'تعليم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', 'الأفلام والرسوم المتحركة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', 'الألعاب');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'التاريخ والحقائق');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'أسلوب حياة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'طبيعي >> صفة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'الأخبار والسياسة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'الناس والأمم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'الحيوانات الأليفة والحيوانات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'الأماكن والمناطق');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'العلوم والتكنولوجيا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'السفر والفعاليات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'مقالة - سلعة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'استكشف بلوق');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'مجرى');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{المستخدم} قد انتهى.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'انضم إلى الجلسة الحية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'غادر الجلسة الحية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'الأرواح');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', 'استكشاف Pixelphoto أشرطة الفيديو الحية، الآن!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'بكرات');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'adres');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'stad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'staat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'zip');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Kaartnummer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'betalen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', 'Even geduld aub..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'Controleer de details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', 'Kies een afbeelding');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Cashfree');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'Kaart details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Kopiëren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'Begonnen met een live video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Leven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Live video\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'Meer ontdekken');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'Geen actieve live-sessies gevonden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Ga leven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Eindigen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'Microfoon');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', 'Nokbron');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Offline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'instellingen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'Komedie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', 'Auto\'s en voertuigen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', 'Economie en handel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'Onderwijs');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', 'Amusement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', 'Films en animatie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', 'Gaming');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'Geschiedenis en feiten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'Levensstijl');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'Natuurlijk');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'Nieuws en politiek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'Mensen en naties');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'Huisdieren en dieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'Plaatsen en regio\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'Wetenschap en technologie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', 'Sport');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'Reizen en evenementen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Ander');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Ontdek blog');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', 'Geen verkoopgeschiedenis gevonden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', 'Live-streams');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', 'Kijk maar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'stroom');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{Gebruiker} Stream is afgelopen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'voegde zich bij de live-sessie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'verliet de live-sessie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'leven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', 'Ontdek nu Pixelphoto Live-video\'s, nu!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'Rollen');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', 'Chèque');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'adresse');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'ville');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'Etat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Zip *: français');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Numéro de carte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'Payer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', 'S\'il vous plaît, attendez..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'S\'il vous plaît vérifier les détails');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', 'Choisissez une image');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Sans argent');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'Détails de la carte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Copie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'a commencé une vidéo en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Habitent');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Vidéos en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'Explore plus');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'Aucune sessions en direct active trouvée.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Aller en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Finir en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'Source micro');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', 'Source de came');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Hors ligne');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'réglages');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'Comédie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', 'Voitures et véhicules');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', 'Économie et commerce');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'Éducation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', 'Divertissement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', 'Films et animation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', 'Gaming');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'Histoire et faits');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'Style de vie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'Naturel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'Nouvelles et politique');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'Personnes et nations');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'Animaux de compagnie et animaux');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'Lieux et régions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'Science et technologie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', 'sport');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'Voyages et événements');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Autre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'explorer le blog');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', 'Aucune histoire de vente trouvée.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', 'Flux en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', 'Regardez');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'flux');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{User} Stream est terminé.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'rejoint la session en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'quitté la session en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'des vies');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', 'Explorez PixelPhoto Live Videos, en ce moment!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'Bobine');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Adresse');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'Stadt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'Zustand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Postleitzahl');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Kartennummer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'Zahlen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', 'Warten Sie mal..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'Bitte überprüfen Sie die Details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', 'Wählen Sie ein Bild aus');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Barrierefrei');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'IYZIPAY.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'Kartendetails');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Kopieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'Ein Live-Video gestartet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Wohnen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Live-Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'Erkunde mehr');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'Keine aktiven Live-Sitzungen gefunden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Geh Leben');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Ende live.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'Mikrofonquelle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', 'Nockenquelle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Offline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'die Einstellungen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'Komödie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', 'Autos und Fahrzeuge');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', 'Wirtschaft und Handel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'Bildung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', 'Unterhaltung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', 'Filme & Animation.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', 'Gaming');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'Geschichte und Fakten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'Lebensstil');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'Natürlich');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'Nachrichten und Politik.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'Menschen und Nationen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'Haustiere und Tiere.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'Orte und Regionen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'Wissenschaft und Technik');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', 'Sport');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'Reisen und Events.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Andere');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'Artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Blog erforschen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', 'Kein Verkaufshistorie gefunden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', 'Live-Streams');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', 'Sehen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'Strom');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{User} Stream ist beendet.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'ist der Live-Sitzung angeschlossen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'verließ die Live-Sitzung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'Leben');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', 'Erkunde Pixelphoto Live-Videos, jetzt!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'Rollen');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2ъечь');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'адрес');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'город');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'государственный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'zip.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Номер карты');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'платить');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', 'Подождите пожалуйста..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'Пожалуйста, проверьте детали');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', 'Выберите изображение');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Кашельство');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'Детали карты');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Скопировать');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'начал живое видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Жить');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Живые видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'Исследуйте больше');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'Не найдено активных живых сессий.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Пойти жить');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Конец жизни');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'Источник микрофона');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', 'CAM Source');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Не в сети');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'настройки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'Комедия');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', 'Автомобили и транспортные средства');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', 'Экономика и торговля');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'Образование');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', 'Развлекательная программа');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', 'Фильмы и анимация');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', 'Игра');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'История и факты');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'Стиль жизни');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'Естественный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'Новости и политика');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'Люди и народы');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'Домашние животные и животные');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'Места и регионы');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'Наука и технология');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', 'Спорт');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'Путешествия и события');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Другой');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'статья');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Исследуйте блог');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', 'Нет не найдена продажа истории.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', 'Живые потоки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', 'Смотреть');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'транслировать');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{user} поток закончился.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'присоединился к живой сессии');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'покинул живой сеанс');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'жизни');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', 'Исследуйте PixelPhoto Live видео, прямо сейчас!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'Катушки');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2Comprar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'dirección');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'ciudad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'Expresar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Código Postal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Número de tarjeta');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'pagar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', 'Espere por favor..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'Por favor revise los detalles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', 'Elige una imagen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'CashFree');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'IYZIPAY');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'Detalles de tarjeta');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Dupdo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'comenzó un video en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Vivir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Videos en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'Explora más');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'No se encontraron sesiones activas en vivo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Ir a vivir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Enérgico');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'Fuente de micrófono');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', 'Fuente de cámara');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Desconectado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'ajustes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'Comedia');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', 'Coches y vehículos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', 'Economía y comercio.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'Educación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', 'Entretenimiento');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', 'Películas y animaciones');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', 'Juego de azar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'HISTORIA Y HECHOS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'Estilo de vida');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'Natural');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'Noticias y Política');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'Personas y naciones');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'Mascotas y animales');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'Lugares y regiones');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'Ciencia y Tecnología');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', 'Deporte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'Viajes y eventos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Otro');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'artículo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'explorar el blog');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', 'No se encontró historia de venta.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', 'Transmisiones en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', 'Reloj');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'Arroyo');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{User} Stream ha terminado.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'se unió a la sesión en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'dejó la sesión en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'vidas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', '¡Explora videos en vivo Pixelphoto, ahora mismo!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'Bobinas');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'adres');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'Kent');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'durum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'zip');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Kart numarası');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'ödemek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', 'Lütfen bekle..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'Lütfen detayları kontrol edin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', 'Bir resim seçin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Cashfree');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'İyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'Kart detayları');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Kopya');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'canlı bir video başlattı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Canlı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Canlı videolar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'Daha fazlasını keşfedin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'Aktif canlı oturum bulunamadı.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Devam etmek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Sonu sonu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'Mikrofon');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', 'Kamera kaynağı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Çevrimdışı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'ayarlar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'Komedi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', 'Arabalar ve Araçlar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'Eğitim');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'Tarih ve gerçekler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'Yaşam tarzı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'Doğal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'Haberler ve Politika');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'İnsanlar ve milletler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'Evcil hayvanlar ve hayvanlar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'Yerler ve bölgeler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'Bilim ve Teknoloji');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', 'Spor');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'Seyahat ve Etkinlikler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Diğer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'makale');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Blog\'u Keşfedin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', 'Satış tarihi bulunamadı.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', 'İzlemek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'Akış');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{user} Stream sona erdi.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'canlı oturumuna katıldı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'canlı oturumdan ayrıldı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'hayatları');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', 'Pixelphoto canlı videolarını keşfedin, şu anda!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'Makaralar');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'address');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'city');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'state');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'zip');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Card number');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'pay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', 'Please wait..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'Please check the details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', 'Choose an image');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Cashfree');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'Card Details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Copy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'started a live video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Live videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'Explore more');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'No active live sessions found.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Go Live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'End live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'Mic source');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', 'Cam source');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Offline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'settings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'Comedy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', 'Cars and Vehicles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', 'Economics and Trade');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'Education');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', 'Entertainment');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', 'Movies &amp; Animation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', 'Gaming');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'History and Facts');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'Live Style');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'Natural');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'News and Politics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'People and Nations');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'Pets and Animals');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'Places and Regions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'Science and Technology');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', 'Sport');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'Travel and Events');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Other');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'explore blog');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', 'No sale history found.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', 'Live streams');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', 'Watch');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'stream');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{user} stream has ended.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'joined the live session');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'left the live session');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'lives');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', 'Explore pixelphoto live videos, right now!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'Reels');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, '2checkout', '2checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'address');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'city');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'state');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'zip');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Card number');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'pay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait..', 'Please wait..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_check_the_details', 'Please check the details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_an_image', 'Choose an image');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'Cashfree');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_details', 'Card Details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Copy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'started a live video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Live videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_more', 'Explore more');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_active_live_found.', 'No active live sessions found.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Go Live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'End live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'mic_source', 'Mic source');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cam_source', 'Cam source');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Offline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'settings', 'settings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comedy', 'Comedy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cars_and_vehicles', 'Cars and Vehicles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'economics_and_trade', 'Economics and Trade');
            $lang_update_queries[] = PT_UpdateLangs($value, 'education', 'Education');
            $lang_update_queries[] = PT_UpdateLangs($value, 'entertainment', 'Entertainment');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies__amp__animation', 'Movies &amp; Animation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'gaming', 'Gaming');
            $lang_update_queries[] = PT_UpdateLangs($value, 'history_and_facts', 'History and Facts');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_style', 'Live Style');
            $lang_update_queries[] = PT_UpdateLangs($value, 'natural', 'Natural');
            $lang_update_queries[] = PT_UpdateLangs($value, 'news_and_politics', 'News and Politics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'people_and_nations', 'People and Nations');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pets_and_animals', 'Pets and Animals');
            $lang_update_queries[] = PT_UpdateLangs($value, 'places_and_regions', 'Places and Regions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'science_and_technology', 'Science and Technology');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sport', 'Sport');
            $lang_update_queries[] = PT_UpdateLangs($value, 'travel_and_events', 'Travel and Events');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Other');
            $lang_update_queries[] = PT_UpdateLangs($value, 'article', 'article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'explore blog');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_sale_history_found.', 'No sale history found.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_streams', 'Live streams');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch', 'Watch');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream', 'stream');
            $lang_update_queries[] = PT_UpdateLangs($value, '_user__stream_has_ended.', '{user} stream has ended.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'joined the live session');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'left the live session');
            $lang_update_queries[] = PT_UpdateLangs($value, 'lives', 'lives');
            $lang_update_queries[] = PT_UpdateLangs($value, 'explore_pixelphoto_lives', 'Explore pixelphoto live videos, right now!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reels', 'Reels');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
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
                     <h2 class="light">Update to v1.4.2 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                            <li>[Added] live system. </li>
                    <li>[Added] more payment  methods.</li>
                    <li>[Added] reels section for videos. </li>
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
    "UPDATE `pxp_config` SET `value`= '1.4.2' WHERE name = 'version';",
    "CREATE TABLE `live_sub_users` (  `id` int(11) NOT NULL,  `user_id` int(11) NOT NULL DEFAULT '0',  `post_id` int(11) NOT NULL DEFAULT '0',  `is_watching` int(11) NOT NULL DEFAULT '0',  `time` int(50) NOT NULL DEFAULT '0') ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    "ALTER TABLE `live_sub_users`  ADD PRIMARY KEY (`id`),  ADD KEY `time` (`time`),  ADD KEY `is_watching` (`is_watching`),  ADD KEY `post_id` (`post_id`),  ADD KEY `user_id` (`user_id`);",
    "ALTER TABLE `live_sub_users`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE pxp_users ROW_FORMAT=DYNAMIC;",
    "ALTER TABLE `pxp_posts` ADD `post_key` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `post_id`;",
    "ALTER TABLE `pxp_posts` ADD `video_location` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL AFTER `link`;",
    "ALTER TABLE `pxp_posts` ADD `thumbnail` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `link`;",
    "ALTER TABLE `pxp_posts` ADD `live_ended` INT(11) UNSIGNED NULL DEFAULT '0' AFTER `boosted`;",
    "ALTER TABLE `pxp_posts` ADD `stream_name` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `boosted`, ADD `live_time` INT(50) UNSIGNED NULL DEFAULT '0' AFTER `stream_name`, ADD `agora_resource_id` TEXT NULL DEFAULT NULL AFTER `live_time`, ADD `agora_sid` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL AFTER `agora_resource_id`;",
    " ALTER TABLE `pxp_post_comments` CHANGE `text` `text` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;",
    "ALTER TABLE `pxp_users` ADD `address` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `uploads`, ADD `city` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `address`, ADD `state` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `city`, ADD `zip` INT(11) UNSIGNED NULL DEFAULT '0' AFTER `state`, ADD `phone_number` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `zip`;",
    "ALTER TABLE `pxp_users` ADD `conversation_id` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `wallet`;",
    " INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_payment', 'yes');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_mode', 'sandbox');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_currency', 'USD');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_seller_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_publishable_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_private_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_payment', 'yes');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_mode', 'sandBox');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_client_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_secret_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_payment', 'yes');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_mode', '1');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_secret_key', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_name', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_surname', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_gsm_number', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_email', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_identity_number', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_address', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_city', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_country', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_zip', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'live_video', '1');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'live_video_save', '1');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'who_use_live', 'all');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_live_video', '1');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_app_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_customer_id', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'agora_customer_certificate', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'amazone_s3_2', '1');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'bucket_name_2', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'amazone_s3_key_2', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'amazone_s3_s_key_2', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'region_2', '');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'upload_reels', 'on');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, '2checkout');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'address');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'city');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'state');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'zip');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'card_number');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'pay');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'please_wait..');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'please_check_the_details');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'choose_an_image');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'cashfree');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'iyzipay');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'card_details');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'copy');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'started_live_video');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'live');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'live_videos');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'explore_more');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'no_active_live_found.');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'go_live');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'end_live');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'mic_source');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'cam_source');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'offline');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'settings');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'comedy');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'cars_and_vehicles');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'economics_and_trade');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'education');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'entertainment');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'movies__amp__animation');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'gaming');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'history_and_facts');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'live_style');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'natural');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'news_and_politics');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'people_and_nations');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'pets_and_animals');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'places_and_regions');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'science_and_technology');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sport');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'travel_and_events');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'other');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'article');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'explore_blog_desc');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'no_sale_history_found.');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'live_streams');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'watch');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'stream');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, '_user__stream_has_ended.');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'joined_live_video');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'left_live_video');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'lives');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'explore_pixelphoto_lives');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'reels');",

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