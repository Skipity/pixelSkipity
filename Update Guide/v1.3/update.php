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
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'كل شهر');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'كوميديا');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'السيارات والمركبات');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'الاقتصاد والتجارة');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'التعليم');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'وسائل الترفيه');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'أفلام');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'الألعاب');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'التاريخ والحقائق');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'نمط الحياة');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'طبيعي &gt;&gt; صفة');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'الأخبار والسياسة');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'الناس والأمم');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'الحيوانات الأليفة والحيوانات');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'الأماكن والمناطق');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'العلوم والتكنولوجيا');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'رياضة');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'السفر والأحداث');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'آخر');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'مدونة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'استكشاف جميع المشاركات بلوق.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'الاقسام');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'نبذة مختصرة');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'الحيوانات / الحياة البرية');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'فنون');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'خلفيات / القوام');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'الجمال / الموضة');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'المباني / معالم');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'تمويل الأعمال التجارية');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'مشاهير');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'التعليم');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'طعام و شراب');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'الرعاية الصحية طب /');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'العطل');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'صناعي');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'الداخلية');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'متنوع');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'طبيعة');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'شاء');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'الحدائق / في الهواء الطلق');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'اشخاص');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'دين');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'علم');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'علامات / الرموز');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'الرياضة / الترفيه');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'تقنية');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'وسائل النقل');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'عتيق');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'متجر');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'رفع');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'متجري');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'السعر');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'نوع الرخصة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'الحقوق المدارة (RM) الترخيص');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'رخصة استخدام التحرير');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'الاتاوات الحرة رخصة (RF)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'الاتاوات الحرة الرخصة الموسعة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'رخصة المشاع الإبداعي');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'المجال العام');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'لا شيء');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'الكلمات');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'الفئة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'يجب أن يكون حجم الصورة أكبر من: {0} بكسل ، الارتفاع: {1} بكسل');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'تم تحميل صورتك بنجاح.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'التنزيلات');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'يشترى');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'يبيع');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'تحميل');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'ماكس');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'اشترى واحدة من الصور الخاصة بك');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'تاريخ المبيعات');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'مجموع عمليات البيع');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'مشتر');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'تاريخ الصفقة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'لجنة الادارية');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'صافي ربح');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'ترتيب حسب');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'بلدي التنزيلات');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'نوع الصورة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'القرار');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'تبديل الوضع');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'per maand');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'Komedie');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'Auto&#39;s en voertuigen');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'Economie en handel');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'Opleiding');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'vermaak');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'Films');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'gaming');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'Geschiedenis en feiten');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'Levensstijl');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'natuurlijk');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'Nieuws en politiek');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'Mensen en naties');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'Huisdieren en dieren');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'Plaatsen en regio&#39;s');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'Wetenschap en technologie');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'Sport');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'Reizen en evenementen');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'anders');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'blog');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Ontdek alle blogberichten.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'Categorieën');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'Abstract');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'Animals / Wildlife');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'Arts');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'Achtergronden / Structuren');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'Beauty / Mode');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'Gebouwen / Monumenten');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'Bedrijfsfinanciering');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'Beroemdheden');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'Opleiding');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'Eten en drinken');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'Gezondheidszorg / Medisch');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'Vakantie');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'industrieel');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'Interiors');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'Diversen');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'Natuur');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'Voorwerpen');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'Parken / Buiten');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'Mensen');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'Religie');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'Wetenschap');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'Signs / Symbols');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'Sport / Recreatie');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'Technologie');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'vervoer');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'Wijnoogst');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'Winkel');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'Uploaden');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'Mijn winkel');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'Prijs');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Licentie type');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Rights Managed (RM) -licentie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Licentie voor redactioneel gebruik');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Royalty-vrije licentie (RF)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty Free Uitgebreide Licentie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons-licentie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Publiek domein');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Geen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'Tags');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'Categorie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'Afbeeldingsdimensie moet groter zijn dan: {0} px, hoogte: {1} px');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'Uw afbeelding is succesvol geüpload.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'downloads');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'Kopen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'Sells');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'Download');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'Max');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'kocht een van je afbeeldingen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'Verkoopgeschiedenis');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'Totaal verkoopt');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'Koper');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Transactie datum');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'Administratiecommissie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'Netto inkomsten');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Sorteer op');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'Mijn downloads');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'Beeldtype');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'Resolutie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'Schakelmodus');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'par mois');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'La comédie');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'Voitures et véhicules');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'Économie et commerce');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'Éducation');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'Divertissement');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'Films');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'Gaming');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'Histoire et faits');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'Style de vie');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'Naturel');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'Actualités et politique');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'Les gens et les nations');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'Animaux et animaux');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'Lieux et régions');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'Science et technologie');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'Sport');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'Voyages et événements');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'Autre');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'Blog');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Explorez tous les articles de blog.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'Les catégories');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'Abstrait');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'Animaux / Faune');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'Arts');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'Arrière-plans / textures');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'Beauté / Mode');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'Bâtiments / Monuments');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'Business/Finance');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'Célébrités');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'Éducation');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'Nourriture et boisson');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'Santé / Médical');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'Vacances');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'Industriel');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'Intérieurs');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'Divers');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'Nature');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'Objets');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'Parcs / Extérieur');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'Gens');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'Religion');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'Science');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'Signes / symboles');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'Sports/Recreation');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'La technologie');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'Transport');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'Ancien');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'le magasin');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'Télécharger');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'Mon magasin');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'Prix');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'License type');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Licence Rights Managed (RM)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Licence d&#39;utilisation éditoriale');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Licence libre de droits (RF)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Licence étendue libre de droits');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Licence Creative Commons');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Public Domain');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Aucun');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'Tags');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'Catégorie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'La dimension de l&#39;image doit être supérieure à: {0} px, hauteur: {1} px');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'Votre image a été téléchargée avec succès.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'Téléchargements');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'Acheter');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'Vend');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'Télécharger');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'Max');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'acheté une de vos images');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'Historique des ventes');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'Total des ventes');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'Acheteur');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Transaction date');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'Admin commission');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'Gain net');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Trier par');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'Mes Téléchargements');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'Image Type');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'Résolution');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'Toggle Mode');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'pro Monat');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'Komödie');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'Autos und Fahrzeuge');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'Wirtschaft und Handel');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'Bildung');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'Unterhaltung');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'Filme');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'Gaming');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'Geschichte und Fakten');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'Lebensstil');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'Natürlich');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'Nachrichten und Politik');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'Menschen und Nationen');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'Haustiere und Tiere');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'Orte und Regionen');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'Wissenschaft und Technik');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'Sport');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'Reisen und Veranstaltungen');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'Andere');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'Blog');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Entdecken Sie alle Blog-Beiträge.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'Kategorien');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'Abstrakt');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'Tiere / Wildlife');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'Kunst');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'Hintergründe / Texturen');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'Schönheit / Mode');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'Gebäude / Sehenswürdigkeiten');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'Unternehmensfinanzierung');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'Prominente');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'Bildung');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'Essen und Trinken');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'Gesundheitswesen / Medizin');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'Ferien');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'Industrie');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'Innenräume');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'Sonstiges');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'Natur');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'Objekte');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'Parks / Im Freien');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'Menschen');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'Religion');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'Wissenschaft');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'Zeichen / Symbole');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'Sport &amp; Erholung');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'Technologie');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'Transport');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'Jahrgang');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'Geschäft');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'Hochladen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'Mein Laden');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'Preis');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Lizenz-Typ');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Lizenz für Rights Managed (RM)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Lizenz zur redaktionellen Nutzung');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Royalty Free Lizenz (RF)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty Free Erweiterte Lizenz');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Public Domain');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Keiner');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'Stichworte');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'Kategorie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'Die Bildgröße muss größer sein als: {0} px, die Höhe: {1} px');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'Ihr Bild wurde erfolgreich hochgeladen.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'Downloads');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'Kaufen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'Verkauft');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'Herunterladen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'Max');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'kaufte eines Ihrer Bilder');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'Verkaufsgeschichte');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'Gesamtverkäufe');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'Käufer');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Transaktionsdatum');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'Verwaltungskommission');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'Nettoeinkommen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Sortiere nach');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'Meine Downloads');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'Bildtyp');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'Auflösung');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'Toggle Mode');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'в месяц');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'комедия');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'Автомобили и Транспорт');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'Экономика и торговля');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'образование');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'Развлечения');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'Кино');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'азартные игры');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'История и факты');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'Стиль жизни');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'натуральный');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'Новости и Политика');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'Люди и народы');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'Домашние животные и животные');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'Места и Регионы');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'Наука и технология');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'Sport');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'Путешествия и События');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'Другие');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'Блог');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Изучите все сообщения в блоге.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'категории');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'Аннотация');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'Животные / Дикая природа');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'искусства');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'Фоны / Текстуры');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'Красота / Мода');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'Здания / достопримечательности');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'Деловые финансы');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'Знаменитости');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'образование');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'Еда и напитки');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'Здоровье / Медицина');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'каникулы');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'промышленные');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'Интерьеры');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'Разнообразный');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'Природа');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'Объекты');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'Парки / Открытый');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'люди');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'религия');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'Наука');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'Знаки / Символы');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'Спорт / Отдых');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'Технология');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'Транспорт');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'марочный');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'хранить');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'Загрузить');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'Мой магазин');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'Цена');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Тип лицензии');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Лицензия с управлением правами (RM)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Лицензия на использование в редакции');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Роялти Фри Лицензия (РФ)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Бесплатная лицензия');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Лицензия Creative Commons');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Всеобщее достояние');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Никто');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'Теги');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'категория');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'Размер изображения должен быть больше чем: {0} px, высота: {1} px');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'Ваше изображение было успешно загружено.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'Загрузки');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'купить');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'Продает');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'Скачать');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'Максимум');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'купил одно из ваших изображений');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'История продаж');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'Всего продано');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'Покупатель');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Дата сделки');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'Комиссия администратора');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'Чистый доход');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Сортировать по');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'Мои Загрузки');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'Тип изображения');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'разрешение');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'Режим переключения');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'por mes');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'Comedia');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'Autos y vehiculos');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'Economía y comercio');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'Educación');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'Entretenimiento');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'Películas');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'Juego de azar');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'Historia y hechos');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'Estilo de vida');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'Natural');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'Noticias y politica');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'Pueblos y naciones');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'Mascotas y animales');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'Lugares y Regiones');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'Ciencia y Tecnología');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'Deporte');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'Viajes y eventos');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'Otro');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'Blog');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Explore todas las publicaciones de blog.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'Categorías');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'Abstracto');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'Animales / Fauna');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'Letras');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'Fondos / Texturas');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'Belleza / moda');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'Edificios / Monumentos');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'Financiación de las empresas');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'Famosos');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'Educación');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'Comida y bebida');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'Asistencia sanitaria / médica');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'Vacaciones');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'Industrial');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'Interiores');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'Diverso');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'Naturaleza');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'Objetos');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'Parques / al aire libre');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'Personas');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'Religión');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'Ciencia');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'Signos / Símbolos');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'Deportes y Recreación');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'Tecnología');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'Transporte');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'Vendimia');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'Almacenar');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'Subir');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'Mi tienda');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'Precio');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Tipo de licencia');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Licencia de derechos gestionados (RM)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Licencia de uso editorial');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Licencia libre de derechos (RF)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Licencia Extendida Libre de Derechos');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Licencia Creative Commons');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Dominio publico');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Ninguna');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'Etiquetas');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'Categoría');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'La dimensión de la imagen debe ser mayor que: {0} px, altura: {1} px');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'Su imagen se cargó correctamente.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'Descargas');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'Comprar');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'Vende');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'Descargar');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'Max');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'compró una de tus imágenes');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'Historial de ventas');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'Ventas totales');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'Comprador');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Fecha de Transacción');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'Comisión administrativa');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'Ganancia neta');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Ordenar por');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'Mis descargas');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'Tipo de imagen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'Resolución');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'Modo de alternar');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'her ay');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'Komedi');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'Otomobiller ve Araçlar');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'Ekonomi ve Ticaret');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'Eğitim');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'Eğlence');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'filmler');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'kumar');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'Tarihçe ve Gerçekler');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'Yaşam tarzı');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'Doğal');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'Haberler ve Politika');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'İnsanlar ve Milletler');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'Evcil Hayvanlar ve Hayvanlar');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'Yerler ve Bölgeler');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'Bilim ve Teknoloji');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'Spor');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'Seyahat ve Etkinlikler');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'Diğer');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'Blog');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Tüm blog gönderilerini keşfedin.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'Kategoriler');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'soyut');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'Hayvanlar / Vahşi Yaşam');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'Sanat');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'Arka / Dokular');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'Güzellik / Moda');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'Binalar / Simgesel');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'İş finansı');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'Ünlüler');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'Eğitim');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'Yiyecek ve içecek');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'Sağlık / Tıbbi');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'Bayram');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'Sanayi');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'İç');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'Çeşitli');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'Doğa');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'Nesneler');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'Parks / Açık');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'İnsanlar');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'Din');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'Bilim');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'İşaretler / Simgeler');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'Spor ve yenilenme');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'teknoloji');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'taşımacılık');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'bağbozumu');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'mağaza');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'Yükleme');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'Benim hikayem');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'Fiyat');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Lisans türü');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Yönetilen Haklar (RM) Lisansı');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Editoryal Kullanım Lisansı');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Telif Ücretsiz Lisansı (RF)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty Free Genişletilmiş Lisans');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Kamu malı');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Yok');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'Etiketler');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'Kategori');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'Resim boyutu: {0} px, yükseklik: {1} px&#39;den büyük olmalıdır');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'Resminiz başarıyla yüklendi.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'İndirilenler');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'Satın');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'Satıyor');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'İndir');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'maksimum');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'resimlerinden birini satın aldı');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'Satış geçmişi');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'Toplam Satıyor');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'Alıcı');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'İşlem günü');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'Admin commission');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'Net kazanç');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Göre sırala');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'İndirdiklerim');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'Resim türü');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'çözüm');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'Geçiş Modu');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'per month');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'Comedy');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'Cars and Vehicles');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'Economics and Trade');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'Education');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'Entertainment');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'Movies &amp; Animation');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'Gaming');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'History and Facts');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'Live Style');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'Natural');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'News and Politics');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'People and Nations');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'Pets and Animals');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'Places and Regions');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'Science and Technology');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'Sport');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'Travel and Events');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'Other');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'Blog');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Explore all blog posts.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'Categories');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'Abstract');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'Animals/Wildlife');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'Arts');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'Backgrounds/Textures');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'Beauty/Fashion');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'Buildings/Landmarks');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'Business/Finance');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'Celebrities');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'Education');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'Food and drink');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'Healthcare/Medical');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'Holidays');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'Industrial');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'Interiors');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'Miscellaneous');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'Nature');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'Objects');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'Parks/Outdoor');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'People');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'Religion');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'Science');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'Signs/Symbols');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'Sports/Recreation');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'Technology');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'Transportation');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'Vintage');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'Store');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'Upload');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'My Store');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'Price');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'License type');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Rights Managed (RM) License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Editorial Use License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Royalty Free License (RF)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty Free Extended License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Public Domain');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'None');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'Tags');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'Category');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'Image dimension must be more than: {0}px , height : {1}px');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'Your image was successfully uploaded. ');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'Downloads');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'Buy');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'Sells');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'Download');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'Max');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'bought one of your images');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'Sales History');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'Total Sells');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'Buyer');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Transaction date');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'Admin commission');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'Net earning');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Sort by');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'My Downloads');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'Image Type');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'Resolution');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'Toggle Mode');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'per_month', 'per month');
    $lang_update_queries[] = PT_UpdateLangs($value, '1309', 'Comedy');
    $lang_update_queries[] = PT_UpdateLangs($value, '1310', 'Cars and Vehicles');
    $lang_update_queries[] = PT_UpdateLangs($value, '1311', 'Economics and Trade');
    $lang_update_queries[] = PT_UpdateLangs($value, '1312', 'Education');
    $lang_update_queries[] = PT_UpdateLangs($value, '1313', 'Entertainment');
    $lang_update_queries[] = PT_UpdateLangs($value, '1314', 'Movies &amp; Animation');
    $lang_update_queries[] = PT_UpdateLangs($value, '1315', 'Gaming');
    $lang_update_queries[] = PT_UpdateLangs($value, '1316', 'History and Facts');
    $lang_update_queries[] = PT_UpdateLangs($value, '1317', 'Live Style');
    $lang_update_queries[] = PT_UpdateLangs($value, '1318', 'Natural');
    $lang_update_queries[] = PT_UpdateLangs($value, '1319', 'News and Politics');
    $lang_update_queries[] = PT_UpdateLangs($value, '1320', 'People and Nations');
    $lang_update_queries[] = PT_UpdateLangs($value, '1321', 'Pets and Animals');
    $lang_update_queries[] = PT_UpdateLangs($value, '1322', 'Places and Regions');
    $lang_update_queries[] = PT_UpdateLangs($value, '1323', 'Science and Technology');
    $lang_update_queries[] = PT_UpdateLangs($value, '1324', 'Sport');
    $lang_update_queries[] = PT_UpdateLangs($value, '1325', 'Travel and Events');
    $lang_update_queries[] = PT_UpdateLangs($value, '1326', 'Other');
    $lang_update_queries[] = PT_UpdateLangs($value, 'blog', 'Blog');
    $lang_update_queries[] = PT_UpdateLangs($value, 'explore_blog_desc', 'Explore all blog posts.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'categories', 'Categories');
    $lang_update_queries[] = PT_UpdateLangs($value, '491', 'Abstract');
    $lang_update_queries[] = PT_UpdateLangs($value, '492', 'Animals/Wildlife');
    $lang_update_queries[] = PT_UpdateLangs($value, '493', 'Arts');
    $lang_update_queries[] = PT_UpdateLangs($value, '494', 'Backgrounds/Textures');
    $lang_update_queries[] = PT_UpdateLangs($value, '495', 'Beauty/Fashion');
    $lang_update_queries[] = PT_UpdateLangs($value, '496', 'Buildings/Landmarks');
    $lang_update_queries[] = PT_UpdateLangs($value, '497', 'Business/Finance');
    $lang_update_queries[] = PT_UpdateLangs($value, '498', 'Celebrities');
    $lang_update_queries[] = PT_UpdateLangs($value, '499', 'Education');
    $lang_update_queries[] = PT_UpdateLangs($value, '500', 'Food and drink');
    $lang_update_queries[] = PT_UpdateLangs($value, '501', 'Healthcare/Medical');
    $lang_update_queries[] = PT_UpdateLangs($value, '502', 'Holidays');
    $lang_update_queries[] = PT_UpdateLangs($value, '503', 'Industrial');
    $lang_update_queries[] = PT_UpdateLangs($value, '504', 'Interiors');
    $lang_update_queries[] = PT_UpdateLangs($value, '505', 'Miscellaneous');
    $lang_update_queries[] = PT_UpdateLangs($value, '506', 'Nature');
    $lang_update_queries[] = PT_UpdateLangs($value, '507', 'Objects');
    $lang_update_queries[] = PT_UpdateLangs($value, '508', 'Parks/Outdoor');
    $lang_update_queries[] = PT_UpdateLangs($value, '509', 'People');
    $lang_update_queries[] = PT_UpdateLangs($value, '510', 'Religion');
    $lang_update_queries[] = PT_UpdateLangs($value, '511', 'Science');
    $lang_update_queries[] = PT_UpdateLangs($value, '512', 'Signs/Symbols');
    $lang_update_queries[] = PT_UpdateLangs($value, '513', 'Sports/Recreation');
    $lang_update_queries[] = PT_UpdateLangs($value, '514', 'Technology');
    $lang_update_queries[] = PT_UpdateLangs($value, '515', 'Transportation');
    $lang_update_queries[] = PT_UpdateLangs($value, '516', 'Vintage');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store', 'Store');
    $lang_update_queries[] = PT_UpdateLangs($value, 'upload', 'Upload');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_store', 'My Store');
    $lang_update_queries[] = PT_UpdateLangs($value, 'price', 'Price');
    $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'License type');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Rights Managed (RM) License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Editorial Use License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Royalty Free License (RF)');
    $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty Free Extended License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons License');
    $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Public Domain');
    $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'None');
    $lang_update_queries[] = PT_UpdateLangs($value, 'tags', 'Tags');
    $lang_update_queries[] = PT_UpdateLangs($value, 'category', 'Category');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_dimension_error', 'Image dimension must be more than: {0}px , height : {1}px');
    $lang_update_queries[] = PT_UpdateLangs($value, 'img_upload_success', 'Your image was successfully uploaded. ');
    $lang_update_queries[] = PT_UpdateLangs($value, 'downloads', 'Downloads');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buy', 'Buy');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sells', 'Sells');
    $lang_update_queries[] = PT_UpdateLangs($value, 'download', 'Download');
    $lang_update_queries[] = PT_UpdateLangs($value, 'max', 'Max');
    $lang_update_queries[] = PT_UpdateLangs($value, 'store_purchase', 'bought one of your images');
    $lang_update_queries[] = PT_UpdateLangs($value, 'history', 'Sales History');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_sell', 'Total Sells');
    $lang_update_queries[] = PT_UpdateLangs($value, 'buyer', 'Buyer');
    $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Transaction date');
    $lang_update_queries[] = PT_UpdateLangs($value, 'admin_commission', 'Admin commission');
    $lang_update_queries[] = PT_UpdateLangs($value, 'net_earning', 'Net earning');
    $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Sort by');
    $lang_update_queries[] = PT_UpdateLangs($value, 'my_downloads', 'My Downloads');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image_type', 'Image Type');
    $lang_update_queries[] = PT_UpdateLangs($value, 'resolution', 'Resolution');
    $lang_update_queries[] = PT_UpdateLangs($value, 'toggle_mode', 'Toggle Mode');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
        }
    }
    $query = mysqli_query($mysqli, "UPDATE `pxp_static_pages` SET `content` = '" . htmlspecialchars_decode('<form id="contact_us_form" class="form row pp_sett_form"><div class="col-md-3">&nbsp;</div><div class="col-md-6"><div class="pp_mat_input"><input class="form-control" name="first_name" required="true" type="text"> <label>First Name*</label></div><div class="pp_mat_input"><input class="form-control" name="last_name" required="true" type="text"> <label>Last Name*</label></div><div class="pp_mat_input" style="margin-bottom: 1.7em;" data-mce-style="margin-bottom: 1.7em;"><input class="form-control" name="email" required="true" type="email"> <label>Email*</label></div><div class="pp_mat_input"><textarea class="form-control" name="message" rows="3"></textarea> <label>Messages</label></div><div class="pp_terms"><input id="terms" name="terms" type="checkbox" onchange="activate_Button(this)" > <label for="terms"> I agree to the <a href="http://localhost/pixelphoto/terms-of-use" data-ajax="ajax_loading.php?app=terms&amp;apph=terms&amp;page=terms-of-use">Terms of use</a></label></div><div class="col-md-3">&nbsp;</div><div class="pp_load_loader"><button id="contact_submit" class="btn btn-info pp_flat_btn" disabled="disabled" type="submit">Send</button></div><div class="clear">&nbsp;</div></div><div class="col-md-3">&nbsp;</div></form>') . "' WHERE `page_name` = 'contact_us';");
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
                     <h2 class="light">Update to v1.3 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                            <li>[Added] store system, users can sell images. </li>
                    <li>[Added] blog system.</li>
                    <li>[Added] new APIs.</li>
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
    "UPDATE `pxp_config` SET `value`= '1.3' WHERE name = 'version';",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'clickable_url', 'on');",
    "ALTER TABLE `pxp_langs` ADD `ref` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `id`;",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'blog_system', 'on');",
    "CREATE TABLE IF NOT EXISTS `pxp_blog` (`id` int(11) NOT NULL,`title` varchar(120) NOT NULL DEFAULT '',`content` text,`description` text,`posted` varchar(300) DEFAULT '0',`category` int(255) DEFAULT '0',`thumbnail` varchar(255) DEFAULT 'media/upload/photos/d-blog.jpg',`view` int(11) DEFAULT '0',`shared` int(11) DEFAULT '0',`tags` varchar(300) DEFAULT '',`created_at` int(11) NOT NULL DEFAULT '0') ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `pxp_blog` ADD PRIMARY KEY (`id`), ADD KEY `title` (`title`), ADD KEY `category` (`category`);",
    "ALTER TABLE `pxp_blog` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;",
    "CREATE TABLE IF NOT EXISTS `pxp_store` (`id` int(11) NOT NULL,`user_id` int(11) unsigned DEFAULT NULL,`title` varchar(250) DEFAULT '',`category` int(11) unsigned DEFAULT NULL,`price` int(11) unsigned DEFAULT NULL,`license` varchar(50) DEFAULT '',`tags` text,`small_file` varchar(250) DEFAULT '',`full_file` varchar(255) DEFAULT '',`sells` int(11) unsigned DEFAULT '0',`views` int(11) unsigned DEFAULT '0',`downloads` int(11) unsigned DEFAULT '0',`created_date` int(11) unsigned NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;",
    "ALTER TABLE `pxp_store` ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `pxp_store` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'image_sell_system', 'on');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'min_image_height', '768');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'min_image_width', '1024');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'watermark_anchor', 'top center');",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'watermark_opacity', '0.5');",
    "ALTER TABLE `pxp_transactions` ADD `item_store_id` INT(11) UNSIGNED NULL DEFAULT '0' AFTER `type`;",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'per_month');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1309');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1310');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1311');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1312');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1313');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1314');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1315');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1316');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1317');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1318');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1319');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1320');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1321');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1322');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1323');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1324');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1325');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'blog_categories', '1326');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'blog');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'explore_blog_desc');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'categories');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '491');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '492');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '493');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '494');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '495');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '496');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '497');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '498');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '499');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '500');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '501');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '502');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '503');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '504');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '505');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '506');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '507');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '508');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '509');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '510');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '511');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '512');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '513');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '514');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '515');",
"INSERT INTO `pxp_langs` (`id`, `ref`, `lang_key`) VALUES (NULL, 'store_categories', '516');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'store');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'upload');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'my_store');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'price');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'license_type');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'rights_managed_license');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'editorial_use_license');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'royalty_free_license');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'royalty_free_extended_license');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'creative_commons_license');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'public_domain');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'none');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'tags');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'category');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'image_dimension_error');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'img_upload_success');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'downloads');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'buy');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sells');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'download');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'max');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'store_purchase');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'history');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'total_sell');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'buyer');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'date');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'admin_commission');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'net_earning');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sort_by');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'my_downloads');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'image_type');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'resolution');",
"INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'toggle_mode');",
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