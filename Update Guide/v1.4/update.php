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
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'لا توجد تنزيلات حتى الان.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'الملف غير مدعوم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'إدارة طلبات التمويل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'حذف طلب التمويل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', 'هل أنت متأكد أنك تريد حذف طلب التمويل هذا؟');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'أبلغ عن طلب التمويل هذا.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'موفر البريد الإلكتروني مدرج في القائمة السوداء وغير مسموح به ، يرجى اختيار مزود بريد إلكتروني آخر.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'يجب عليك الاشتراك باستخدام {0} فقط.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'شارك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'لقد تجاوزت حد التخزين. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'إنشاء مشاركة مدونة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'تمت إضافة مشاركتك بنجاح ، وسيراجع الفريق مقالك ، بمجرد الانتهاء من ذلك ، سيتم إعلامك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'المحتوى');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'رسالة قصيرة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'الدفع باستخدام Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'مكالمة فيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'لا اجابة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'الرجاء معاودة المحاولة في وقت لاحق.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'جارٍ الاتصال');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'من فضلك انتظر رد صديقك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'إلغاء');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', 'مجاب!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'ارجوك انتظر..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'تم رفض المكالمة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'رفض المستلم المكالمة ، يرجى المحاولة مرة أخرى في وقت لاحق.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'مكالمة فيديو جديدة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'يريد الدردشة معك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'القبول والبدء');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'انخفاض');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'إنهاء المكالمة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'الحصول على حق الوصول الكامل إلى الموقع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'نشر مشاركتك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'لا يمكنك نشر مشاركاتك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'شارك {post}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'تحديث منشور المدونة');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'Er zijn nog geen downloads.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'Bestand wordt niet ondersteund');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'Beheer financieringsverzoeken');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'Financieringsverzoek verwijderen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', 'Weet u zeker dat u dit fondsverzoek wilt verwijderen?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'Rapporteer dit fondsverzoek.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'De e-mailprovider staat op de zwarte lijst en is niet toegestaan. Kies een andere e-mailprovider.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'u moet zich alleen aanmelden met {0}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'Delen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'U overschrijdt de opslaglimiet. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'Maak een blogpost');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'Uw bericht is met succes toegevoegd, het team zal uw artikel beoordelen, zodra u klaar bent, ontvangt u een melding.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'Inhoud');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'sms');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Betaal met Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'Video-oproep');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'Geen antwoord');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'Probeer het later opnieuw.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'Roeping');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'Wacht alstublieft op het antwoord van uw vriend.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'Annuleer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', 'Beantwoord!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'Wacht alsjeblieft..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'Oproep geweigerd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'De ontvanger heeft het gesprek geweigerd, probeer het later opnieuw.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'Nieuw videogesprek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'wil videochatten met jou.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'Accepteren en starten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'Afwijzen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'Ophangen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'Krijg volledige toegang tot de site');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'heeft je post gedeeld');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'Je kunt je berichten niet delen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'heeft een {post} gedeeld.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'Blogpost bijwerken');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'Il n\'y a pas encore de téléchargements.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'Le fichier n\'est pas pris en charge');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'Gérer les demandes de financement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'Supprimer la demande de financement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', 'Voulez-vous vraiment supprimer cette demande de fonds?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'Signalez cette demande de fonds.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'Le fournisseur de messagerie est sur liste noire et n\'est pas autorisé, veuillez choisir un autre fournisseur de messagerie.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'vous devez vous inscrire en utilisant uniquement {0}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'Partager');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'Vous dépassez la limite de stockage. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'Créer un article de blog');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'Votre message a été ajouté avec succès, l\'équipe examinera votre article, une fois terminé, vous en serez informé.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'Contenu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'SMS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Payer avec Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'Appel vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'Pas de réponse');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'Veuillez réessayer plus tard.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'Appel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'Veuillez attendre la réponse de votre ami.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'Annuler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', 'Répondu!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'S\'il vous plaît, attendez..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'Appel refusé');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'Le destinataire a refusé l\'appel, veuillez réessayer plus tard.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'Nouvel appel vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'souhaite discuter par vidéo avec vous.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'Accepter et démarrer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'Déclin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'Fin d\'appel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'Accédez pleinement au site');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'a partagé votre message');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'Vous ne pouvez pas partager vos messages.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'a partagé un {post}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'Mettre à jour le billet de blog');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'Es gibt noch keine Downloads.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'Datei wird nicht unterstützt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'Finanzierungsanfragen verwalten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'Finanzierungsantrag löschen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', 'Möchten Sie diese Fondsanfrage wirklich löschen?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'Melden Sie diese Fondsanfrage.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'Der E-Mail-Anbieter ist auf der schwarzen Liste und nicht zulässig. Bitte wählen Sie einen anderen E-Mail-Anbieter.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'Sie müssen sich nur mit {0} anmelden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'Aktie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'Sie überschreiten das Speicherlimit. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'Erstellen Sie einen Blog-Beitrag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'Ihr Beitrag wurde erfolgreich hinzugefügt. Das Team überprüft Ihren Artikel. Sobald Sie fertig sind, werden Sie benachrichtigt.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'Inhalt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'SMS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Zahlen Sie mit Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'Videoanruf');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'Keine Antwort');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'Bitte versuchen Sie es später noch einmal.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'Berufung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'Bitte warten Sie auf die Antwort Ihres Freundes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'Stornieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', 'Antwortete!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'Warten Sie mal..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'Anruf abgelehnt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'Der Empfänger hat den Anruf abgelehnt. Bitte versuchen Sie es später erneut.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'Neuer Videoanruf');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'möchte mit dir per Video chatten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'Akzeptieren & starten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'Ablehnen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'Anruf beenden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'Erhalten Sie vollen Zugriff auf die Website');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'hat deinen Beitrag geteilt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'Sie können Ihre Beiträge nicht teilen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'hat einen {Beitrag} geteilt.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'Blog-Beitrag aktualisieren');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'Еще нет загрузок.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'Файл не поддерживается');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'Управление запросами на финансирование');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'Удалить запрос на финансирование');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', 'Вы уверены, что хотите удалить этот запрос фонда?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'Сообщить об этом запросе фонда.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'Поставщик электронной почты занесен в черный список и не допускается, выберите другого поставщика электронной почты');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'Вы должны зарегистрироваться, используя только {0}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'доля');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'Вы превысили лимит хранения. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'Создать блог');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'Ваше сообщение было успешно добавлено, команда рассмотрит вашу статью, как только вы закончите, вы получите уведомление.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'содержание');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'смс');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Оплатить с помощью Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'Видеозвонок');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'Нет ответа');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'Пожалуйста, попробуйте позже.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'призвание');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'Пожалуйста, дождитесь ответа вашего друга.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'Отмена');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', 'Ответил!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'Пожалуйста, подождите..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'Звонок отклонен');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'Получатель отклонил звонок, повторите попытку позже.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'Новый видеозвонок');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'хочет с тобой видеочат');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'Принять и начать');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'снижение');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'Конец вызова');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'Получить полный доступ к сайту');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'поделился своим постом');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'Вы не можете поделиться своими сообщениями.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'поделился {post}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'Обновить сообщение в блоге');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'Aún no hay descargas.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'El archivo no es compatible');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'Gestionar solicitudes de financiación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'Eliminar solicitud de financiación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', '¿Seguro que quieres eliminar esta solicitud de fondo?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'Informe esta solicitud de fondo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'El proveedor de correo electrónico está en la lista negra y no está permitido, elija otro proveedor de correo electrónico.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'debes registrarte usando {0} solamente.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'Compartir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'Superas el límite de almacenamiento. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'Crear publicación de blog');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'Su publicación se agregó con éxito, el equipo revisará su artículo, una vez hecho esto se le notificará.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'Contenido');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'SMS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Pague con Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'Videollamada');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'Sin respuesta');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'Por favor, inténtelo de nuevo más tarde.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'Vocación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'Por favor espera la respuesta de tu amigo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'Cancelar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', '¡Contestado!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'Por favor espera..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'Llamada rechazada');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'El destinatario ha rechazado la llamada. Vuelve a intentarlo más tarde.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'Nueva videollamada');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'quiere chatear por video contigo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'Aceptar y comenzar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'Disminución');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'Finalizar llamada');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'Obtenga acceso completo al sitio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'ha compartido tu publicación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'No puedes compartir tus publicaciones.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'ha compartido una {publicación}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'Actualizar publicación de blog');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'Henüz indirme yok.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'Dosya desteklenmiyor');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'Finansman Taleplerini Yönetin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'Finansman talebini sil');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', 'Bu fon talebini silmek istediğinizden emin misiniz?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'Bu fon talebini bildirin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'E-posta sağlayıcısı kara listeye alındı ​​ve izin verilmiyor, lütfen başka bir e-posta sağlayıcısı seçin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'yalnızca {0} kullanarak kaydolmanız gerekir.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'Paylaş');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'Depolama sınırını aştınız. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'Blog yayını oluştur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'Yayınınız başarıyla eklendi, ekip makalenizi inceleyecek, işiniz bittiğinde size bildirilecektir.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'içerik');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'SMS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay kullanarak ödeme yapın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'Görüntülü arama');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'Cevapsız');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'Lütfen daha sonra tekrar deneyiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'çağrı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'Lütfen arkadaşınızın cevabını bekleyin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'İptal etmek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', 'Yanıtlanmış!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'Lütfen bekle..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'Çağrı reddedildi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'Alıcı çağrıyı reddetti, lütfen daha sonra tekrar deneyin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'Yeni video görüşmesi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'sizinle görüntülü sohbet etmek istiyor.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'Kabul Et ve Başlat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'düşüş');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'Son Arama');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'Siteye tam erişim sağlayın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'yayınınızı paylaştı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'Yayınlarınızı paylaşamazsınız.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'bir {post} paylaştı.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'Blog yayınını güncelle');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'There are no downloads yet.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'File is not supported');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'Manage Funding Requests');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'Delete funding request');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', 'Are you sure you want to delete this fund request?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'Report this fund request.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'The email provider is blacklisted and not allowed, please choose another email provider.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'you must signup using {0} only.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'Share');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'You exceed the storage limit. please upgrade your account.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'Create blog bost');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'Your post was added successfully, the team will review your article, once done you\'ll be notified. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'Content');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'SMS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Pay using Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'Video call');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'No answer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'Please try again later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'Calling');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'Please wait for your friend answer.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'Cancel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', 'Answered!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'Please wait..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'Call declined');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'The recipient has declined the call, please try again later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'New video call');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'wants to video chat with you.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'Accept & Start');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'Decline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'End Call');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'Get full access to the site');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'shared your post');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'You can&#039;t share your posts.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'shared a {post}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'Update blog post');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_downloads', 'There are no downloads yet.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_is_not_support', 'File is not supported');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_funding', 'Manage Funding Requests');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_funding', 'Delete funding request');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_del_fund', 'Are you sure you want to delete this fund request?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_fund', 'Report this fund request.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'The email provider is blacklisted and not allowed, please choose another email provider.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_specific_mail', 'you must signup using {0} only.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share', 'Share');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_limit_storage', 'You exceed the storage limit. please upgrade your account.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_blog_bost', 'Create blog bost');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_success', 'Your post was added successfully, the team will review your article, once done you\'ll be notified. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article_html', 'Content');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sms', 'SMS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Pay using Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_call', 'Video call');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_answer', 'No answer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'try_again_later', 'Please try again later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'calling', 'Calling');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait_answer', 'Please wait for your friend answer.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cancel', 'Cancel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'answered', 'Answered!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_wait', 'Please wait..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'call_declined', 'Call declined');
            $lang_update_queries[] = PT_UpdateLangs($value, 'recipient_has_declined', 'The recipient has declined the call, please try again later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_video_call', 'New video call');
            $lang_update_queries[] = PT_UpdateLangs($value, 'want_to_video_chat', 'wants to video chat with you.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'accept_start', 'Accept & Start');
            $lang_update_queries[] = PT_UpdateLangs($value, 'decline', 'Decline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_call', 'End Call');
            $lang_update_queries[] = PT_UpdateLangs($value, 'get_full_access', 'Get full access to the site');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shared_your_post', 'shared your post');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_share_own', 'You can&#039;t share your posts.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'share_post', 'shared a {post}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'update_blog_post', 'Update blog post');
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
                     <h2 class="light">Update to v1.4 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                            <li>[Added] more payment methods for example paysera, indian payment gateway and paystack. </li>
                    <li>[Added] Ability to edit or delete photos from store.</li>
                    <li>[Added] Add digital ocean for storage.</li>
                    <li>[Added] ability to set and choose multi license types for store while uploading image and set price for each license type. </li>
                    <li>[Added] ability to share posts within sites. </li>
                    <li>[Added] video calls. </li>
                    <li>[Added] ability to require subscription on sign up with (enable/disable). </li>
                    <li>[Added] ability to limit storage for free users.</li>
                    <li>[Added] allow signs ups from specific Email only for example users having gmail.com ID could sign up only. </li>
                    <li>[Added] ability to post comments on blog.</li>
                    <li>[Added] ability for users could also create blogs (enable/disable). </li>
                    <li>[Added] ability to set light/dark mode by default </li>
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
    "UPDATE `pxp_config` SET `value`= '1.4' WHERE name = 'version';",
    "CREATE TABLE IF NOT EXISTS `pxp_blog_likes` (`id` int(11) NOT NULL,`post_id` int(30) NOT NULL DEFAULT '0',`user_id` int(30) NOT NULL DEFAULT '0',`type` varchar(20) NOT NULL DEFAULT 'up',`time` varchar(50) NOT NULL DEFAULT '0') ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `pxp_blog_likes` ADD PRIMARY KEY (`id`),ADD KEY `post_id` (`post_id`),ADD KEY `user_id` (`user_id`),ADD KEY `type` (`type`);",
    "ALTER TABLE `pxp_blog_likes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;",
    "ALTER TABLE `pxp_blog_likes` ADD CONSTRAINT `pxp_blog_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `pxp_blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION, ADD CONSTRAINT `pxp_blog_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pxp_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;",
    "CREATE TABLE IF NOT EXISTS `pxp_blog_comments` (`id` int(30) NOT NULL,`post_id` int(20) NOT NULL DEFAULT '0',`user_id` int(20) NOT NULL DEFAULT '0',`text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,`time` varchar(100) NOT NULL DEFAULT '0') ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `pxp_blog_comments` ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `post_id` (`post_id`);",
    "ALTER TABLE `pxp_blog_comments` MODIFY `id` int(30) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;",
    "ALTER TABLE `pxp_blog_comments` ADD CONSTRAINT `pxp_blog_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `pxp_blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;",
    "CREATE TABLE IF NOT EXISTS `pxp_fund_reports` (`id` int(11) NOT NULL,`fund_id` int(30) NOT NULL DEFAULT '0',`user_id` int(11) NOT NULL DEFAULT '0',`text` varchar(1000) NOT NULL DEFAULT '',`time` varchar(50) NOT NULL DEFAULT '0') ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    "ALTER TABLE `pxp_fund_reports` ADD PRIMARY KEY (`id`), ADD KEY `post_id` (`fund_id`), ADD KEY `user_id` (`user_id`);",
    "ALTER TABLE `pxp_fund_reports` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `pxp_fund_reports` ADD CONSTRAINT `pxp_fund_reports_ibfk_1` FOREIGN KEY (`fund_id`) REFERENCES `pxp_funding` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION, ADD CONSTRAINT `pxp_fund_reports_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pxp_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'site_display_mode', 'day'), (NULL, 'specific_email_signup', ''), (NULL, 'subscription_on_signup', 'off'), (NULL, 'free_user_storage_limit', '0'), (NULL, 'allow_user_create_blog', 'off'), (NULL, 'digital_ocean', '0'), (NULL, 'digital_ocean_key', ''), (NULL, 'digital_ocean_s_key', ''), (NULL, 'digital_ocean_region', 'nyc3'), (NULL, 'digital_ocean_space_name', ''), (NULL, 'google_cloud_storage', '0'), (NULL, 'google_cloud_storage_service_account', ''), (NULL, 'google_cloud_storage_bucket_name', ''), (NULL, 'paysera', 'off'), (NULL, 'paysera_project_id', ''), (NULL, 'paysera_password', ''), (NULL, 'paysera_test_mode', ''), (NULL, 'paystack', 'off'), (NULL, 'paystack_secret_key', ''), (NULL, 'paystack_public_key', ''), (NULL, 'razorpay', 'off'), (NULL, 'razorpay_key', ''), (NULL, 'razorpay_secret', ''), (NULL, 'video_chat', '1'), (NULL, 'audio_chat', '1'), (NULL, 'video_accountSid', ''), (NULL, 'video_apiKeySid', ''), (NULL, 'video_apiKeySecret', '');",
    "ALTER TABLE `pxp_users` ADD `uploads` INT(11) UNSIGNED NULL DEFAULT '0' AFTER `b_site_action`;",
    "ALTER TABLE `pxp_blog` ADD `user_id` INT(11) UNSIGNED NULL DEFAULT '0' AFTER `id`;",
    "ALTER TABLE `pxp_transactions` ADD `item_license` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' AFTER `item_store_id`;",
    "CREATE TABLE `videocalles` (`id` int(11) NOT NULL,`access_token` text DEFAULT NULL,`access_token_2` text DEFAULT NULL,`from_id` int(11) NOT NULL DEFAULT 0,`to_id` int(11) NOT NULL DEFAULT 0,`room_name` varchar(50) NOT NULL DEFAULT '',`active` int(11) NOT NULL DEFAULT 0,`called` int(11) NOT NULL DEFAULT 0,`time` int(11) NOT NULL DEFAULT 0,`declined` int(11) NOT NULL DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=latin1;",
    "ALTER TABLE `videocalles` ADD PRIMARY KEY (`id`), ADD KEY `to_id` (`to_id`), ADD KEY `from_id` (`from_id`), ADD KEY `called` (`called`), ADD KEY `declined` (`declined`);",
    "ALTER TABLE `videocalles` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `pxp_store` ADD `license_options` TEXT NULL AFTER `created_date`;",
    "INSERT INTO `pxp_config` (`id`, `name`, `value`) VALUES (NULL, 'share_system', 'on');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'no_more_downloads');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'file_is_not_support');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'manage_funding');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'delete_funding');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'confirm_del_fund');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'report_fund');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'email_provider_banned');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'email_provider_specific_mail');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'share');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'free_limit_storage');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'create_blog_bost');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'create_article_success');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'create_article_html');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'sms');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'paystack');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'razorpay');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'video_call');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'no_answer');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'try_again_later');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'calling');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'please_wait_answer');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'cancel');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'answered');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'please_wait');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'call_declined');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'recipient_has_declined');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'new_video_call');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'want_to_video_chat');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'accept_start');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'decline');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'end_call');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'get_full_access');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'shared_your_post');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'cant_share_own');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'share_post');",
    "INSERT INTO `pxp_langs` (`id`, `lang_key`) VALUES (NULL, 'update_blog_post');",
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