<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'auth_lenauth', language 'ru'
 *
 * @package   auth_lenauth
 * @author    Igor Sazonov
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'LenAuth';
$string['auth_lenauthdescription'] = 'Данный модуль авторизации позволяет пользователям авторизовываться в Вашем Moodle через OAuth-протокол популярных социальных сетей и поисковиков: Фейсбук, Google, Yahoo, Twitter, Вконтакте, Яндекс, Мейл.ру. При первой авторизации пользователя, он автоматически регистрируется в системе, а при дальнейших попытках входа, система автоматически определяет зарегистрированного пользователя.';
$string['main_settings'] = 'Общие настройки';
$string['enabled_key'] = 'Включено';
$string['buttontext_key'] = 'Текст кнопки';
$string['button_div_width'] = 'Ширина (<em>0 = авто</em>)';
$string['binding_key'] = 'Привязка';
$string['output_settings'] = 'Настройки визуализации';
$string['user_prefix_key'] = 'Префикс';
$string['user_prefix_desc'] = 'Префикс у никнейма пользователя';
$string['default_country_key'] = 'Страна по-умолчанию';
$string['locale_en_key'] = 'Международные логотипы';
$string['locale_ru_key'] = 'Российские логотипы';
$string['static_html'] = 'Статичный HTML-код';
$string['style_not_defined'] = 'Данный стиль не является стилем плагина';
$string['locale_desc'] = 'Некоторые сервисы имеют локальные и международные логотипы, например, ВКонтакте и Яндекс.';
$string['default_country_desc'] = 'У каждый впервые регистрируемого пользователя, который первый раз авторизовывается через LenAuth будет выбрана данная страна по-умолчанию';
//$string['can_change_password'] = 'Пользователь может менять пароль';
$string['can_reset_password_key'] = 'Пользователь может сбрасывать/менять внутренний пароль (<em>рекомендуется</em>)';
$string['can_reset_password_desc'] = 'Если включить опцию, то пользователь сможет поменять заданный внутренний пароль (<strong>по-умолчанию он не задан</strong>) и авторизовываться через обычную форму логина';
//$string['password_expire_key'] = 'Время жизни пароля (дни)';
//$string['password_expire_desc'] = 'Период жизни пароля, необходимо будет создать новый через определенное Вами количество дней. 0 &mdash; значит пароль можно оставить навсегда.';
$string['can_confirm_key'] = 'Модерация новых пользователей';
$string['can_confirm_desc'] = 'Все новые пользователи, зарегистрированные через LenAuth должны будут быть одобрены администратором Moodle';

$string['empty_code_param'] = 'Что-то пошло не так, GET-параметр code пустой. Проверьте настройки приложений в LenAuth';

$string['buttons_settings'] = 'Настройки кнопок';

$string['buttons_location'] = 'Расположение кнопок';
$string['display_inline'] = 'В строку';
$string['display_block'] = 'Блочно (друг под другом)';

$string['margin_top_key'] = 'Отступ сверху (px)';
$string['margin_right_key'] = 'Отступ справа (px)';
$string['margin_bottom_key'] = 'Отступ снизу (px)';
$string['margin_left_key'] = 'Отступ слева (px)';

$string['div_settings'] = 'Настройки области кнопок';
$string['div_location'] = 'Расположение области';
$string['output_style_key'] = 'Стиль как на сайте';
$string['output_php_code_key'] = 'PHP-код для шаблона';

/**
 * Facebook Russian locale
 */
$string['facebook_settings'] = 'Настройки Facebook';
$string['facebook_dashboard'] = 'Панель управления приложением';
$string['facebook_app_id'] = 'ID приложения';
$string['facebook_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://www.facebook.com/" target="_blank">Facebook</a></li>
        <li><a href="https://developers.facebook.com/apps/" target="_blank">Зарегистрируйтесь</a> как разработчик Facebook. <em>Процедура ни к чему не обязывает.</em></li>
        <li>В консоли разработчика необходимо создать приложение (кнопка <strong>+ Add a New App</strong>) с категорией <strong>WWW Веб-сайт</strong> и произвольным названием</li>
        <li>Заполните в процессе настройки приложения <strong>Site URL</strong> как <strong>' . $CFG->wwwroot . '</strong>. Далее нажмите ссылку <strong><a href="https://developers.facebook.com/apps/" target="_blank">Skip to Developer Dashboard</a></strong></li>
        <li>В результате Вам будут выданы <strong>App ID</strong> и <strong>App Secret</strong> (чтобы он стал виден нажмите <strong>Show</strong>). Скопируйте их сюда.</li>
        <li><strong>ВАЖНО!</strong> в консоли приложения зайдите во вкладку <strong>Advanced</strong> и заполните поле <strong>Valid OAuth redirect URIs</strong>: впишите там <strong style="color:red">' . $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=facebook</strong></li>
    </ol>';
$string['facebook_app_secret'] = 'Секретный ключ приложения (App Secret)';
$string['facebook_button_text_default'] = 'Фейсбук';
$string['facebook_binding'] = 'ID Фейсбука';

/**
 * Google Russian locale
 */
$string['google_settings'] = 'Настройки Google';
$string['google_dashboard'] = 'Настройки приложения';
$string['google_client_id_key'] = 'CLIENT ID';
$string['google_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в <a href="https://accounts.google.com/SignUp" target="_blank">Google</a></li>
        <li><a href="https://console.developers.google.com/" target="_blank">Создайте приложение</a> (<strong>Create Project</strong>) в консоли разработчиков Google</li>
        <li>В консоли разработчика в разделе <strong>APIs &amp; auth &raquo; Credentials</strong> создайте <strong>OAuth Client ID</strong></li>
        <li><strong>ВНИМАНИЕ!</strong> Приложение Google позволяет вводить несколько <strong>Redirect URI</strong>, Вам же необходимо ввести только один, а именно &mdash; <strong style="color:red">' . $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=google</strong></li>
        <li>В приложении в разделе <strong>APIs &amp; auth &raquo; Credentials</strong> скопируйте сюда <strong>CLIENT ID</strong> и <strong>CLIENT SECRET</strong></li>
        <li>Параметр <strong>Project ID</strong> не обязателен, его Вы можете скопировать из пункта меню <strong>Overview</strong> в консоли сверху страницы</li>
    </ol>';
$string['google_client_secret_key'] = 'CLIENT SECRET';
$string['google_project_id_key'] = 'Project ID';
$string['google_button_text_default'] = 'Google';
$string['google_binding'] = 'ID Гугл';

/**
 * Yahoo Russian locale
 */
$string['yahoo_settings'] = 'Настройки Yahoo';
$string['yahoo_application_id'] = 'Application ID';
$string['yahoo_consumer_key'] = 'Consumer Key';
$string['yahoo_consumer_secret'] = 'Consumer Secret';
$string['yahoo_button_text_default'] = 'Yahoo';
$string['yahoo_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в <a href="https://edit.yahoo.com/registration" target="_blank">Yahoo</a></li>
        <li>
            <ul><a href="https://developer.apps.yahoo.com/dashboard/createKey.html" target="_blank">Создайте приложение</a> (<strong>Create An App</strong>) в <a href="https://developer.apps.yahoo.com/projects" target="_blank">консоли разработчиков Yahoo (YDN)</a>
                <li>Application Type: <strong>Web-based</strong></li>
                <li>Home Page URL: <strong>' . $CFG->wwwroot . '</strong></li>
                <li>Access Scopes: <strong>This app requires access to private user data.</strong></li>
                <li>Callback Domain: <strong style="color:red">' . $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=yahoo</strong></li>
                <li>Select APIs for private user data access: отметьте галочку <strong>Social Directory (Profiles)</strong>, а под ней отметьте последний пункт <strong>Read/Write Public and Private</strong></li>
                <li>Terms of Use: <em>отметьте галочку</em></li>
            </ul>
        </li>
        <li>Из настроек приложения скопируйте сюда: <strong>Consumer Key</strong>, <strong>Consumer Secret</strong></li>
        <li><em>Необязательно</em>: скопируйте сюда <strong>Application ID</strong>, сверху страницы приложения</li>
    </ol>';
$string['yahoo_binding'] = 'ID Yahoo';

/**
 * Twitter Russian locale
 */
$string['twitter_settings'] = 'Настройки Twitter';
$string['twitter_dashboard'] = 'Настройки приложения';
$string['twitter_application_id'] = 'ID приложения';
$string['twitter_consumer_key'] = 'Consumer Key';
$string['twitter_consumer_secret'] = 'Consumer Secret';
$string['twitter_button_text_default'] = 'Твиттер';
$string['twitter_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в <a href="https://twitter.com" target="_blank">Twitter</a></li>
        <li>
            <ul><a href="https://apps.twitter.com/app/new" target="_blank">Создайте приложение</a>
                <li>Name: <strong>Назовите Ваше приложение</strong></li>
                <li>Description: <strong>Опишите Ваше приложение</strong></li>
                <li>Website: <strong>' . $CFG->wwwroot . '</strong></li>
                <li>Callback URL: <strong style="color:red">' . $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=twitter</strong></li>
                <li>Developer Rules of the Road: отметьте галочку <strong>Yes, I agree</strong></li>
            </ul>
        </li>
        <li>Из настроек приложения скопируйте сюда: <strong>Consumer Key</strong>, <strong>Consumer Secret</strong>. Закладка <strong>Keys and Access Tokens</strong></li>
        <li><em>Необязательно</em>: скопируйте сюда <strong>ID приложения</strong> из URL страницы приложения, например <strong>1234567</strong> если URL <strong>https://apps.twitter.com/app/1234567</strong></li>
    </ol>';
$string['twitter_binding'] = 'ID Твиттера';

/**
 * VK Russian locale
 */
$string['vk_settings'] = 'Настройки ВКонтакте';
$string['vk_dashboard'] = 'Настройки приложения';
$string['vk_app_id_key'] = 'ID приложения';
$string['vk_app_secret_key'] = 'Защищенный ключ';
$string['vk_button_text_default'] = 'ВКонтакте';
$string['vk_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в соцсети <a href="http://vk.com/" target="_blank">ВКонтакте</a></li>
        <li>
            <ul><a href="http://vk.com/editapp?act=create" target="_blank">Создайте приложение</a>
                <li>Тип: <strong>Веб-сайт</strong></li>
                <li>Адрес сайта: <strong>' . $CFG->wwwroot . '</strong></li>
                <li>Базовый домен: <strong>' . str_replace( array( 'http://', 'https://' ), '', $CFG->wwwroot ) . '</strong></li>
            </ul>
        </li>
        <li>В консоли приложения во вкладке <strong>Настройки</strong> скопируйте сюда <strong>ID приложения</strong> и <strong>Защищенный ключ</strong></li>
        <li><em>Необязательно</em>: во вкладке <strong>Информация</strong> заполните информацию о приложении</li>
    </ol>';

/**
 * Yandex Russian locale
 */
$string['yandex_settings'] = 'Настройки Яндекса';
$string['yandex_dashboard'] = 'Панель управления приложением';
$string['yandex_app_id'] = 'ID';
$string['yandex_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://passport.yandex.ru/registration/" target="_blank">Яндексе</a></li>
        <li><a href="https://oauth.yandex.ru/client/new" target="_blank">Зарегистрируйте</a> Ваше OAuth приложение</li>
        <li>
            <ul><strong>Настройте приложение</strong>:
                <li>Поля <strong>название</strong>, <strong>описание</strong>, </strong>ссылка на иконку</strong> и <strong>ссылка на приложение</strong> приложения на Ваше усмотрение</li>
                <li>В поле <strong>Права</strong> выбираем <strong>Яндекс.Логин</strong> и выставляем все 2 опции (email, ФИО)</li>
                <li>В поле <strong>Callback URI</strong> ставим ссылку <strong style="color:red">' . $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=yandex' . '</strong></li>
            </ul>
        </li>
        <li>Скопируйте сюда 2 параметра: <strong>ID</strong>, <strong>Пароль</strong></li>
    </ol>';
$string['yandex_app_password_key'] = 'Пароль';
$string['yandex_button_text_default'] = 'Яндекс';
$string['yandex_binding'] = 'ID Яндекса';

/**
 * Mail.ru Russian locale
 */
$string['mailru_settings'] = 'Настройки Mail.ru';
$string['mailru_dashboard'] = 'Редактирование настроек сайта';
$string['mailru_site_id'] = 'ID сайта';
$string['mailru_client_private_key'] = 'Приватный ключ';
$string['mailru_client_secret_key'] = 'Секретный ключ';
$string['mailru_button_text_default'] = 'Mail.ru';
$string['mailru_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://e.mail.ru/signup?from=main_noc" target="_blank">Mail.ru</a></li>
        <li><a href="http://api.mail.ru/sites/my/add" target="_blank">Зарегистрируйте</a> Ваш сайт. <em>Скачивать и устанавливать receiver.html не обязательно, но желательно.</em></li>
        <li>Скопируйте сюда 3 параметра: <strong>ID</strong>, <strong>Приватный ключ</strong>, <strong>Секретный ключ</strong></li>
        <li><em>Необязательно</em>: Настройте Ваше приложение: <strong>Иконка для списков</strong>, <strong>Картинка для диалогов</strong></li>
    </ol>';
$string['mailru_binding'] = 'ID Mail.Ru';

/**
 * OdnoKlassniki Russian locale
 */
/*$string['auth_ok_settings'] = 'Настройки Одноклассников';
$string['auth_ok_app_id_key'] = 'ID приложения';
$string['auth_ok_public_key_key'] = 'Публичный ключ';
$string['auth_ok_secret_key_key'] = 'Секретный ключ';
$string['auth_ok_button_text_default'] = 'Войти с помощью Одноклассников';*/