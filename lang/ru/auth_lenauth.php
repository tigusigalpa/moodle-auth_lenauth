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
$string['auth_lenauth_main_settings'] = 'Общие настройки';
$string['auth_lenauth_enabled_key'] = 'Включено';
$string['auth_lenauth_buttontext_key'] = 'Текст кнопки';
$string['auth_lenauth_button_div_width'] = 'Ширина (<em>0 = авто</em>)';
$string['auth_lenauth_binding_key'] = 'Привязка';
$string['auth_lenauth_output_settings'] = 'Настройки визуализации';
$string['auth_lenauth_user_prefix_key'] = 'Префикс';
$string['auth_lenauth_user_prefix_desc'] = 'Префикс у никнейма пользователя';
$string['auth_lenauth_default_country_key'] = 'Страна по-умолчанию';
$string['auth_lenauth_locale_en_key'] = 'Международные логотипы';
$string['auth_lenauth_locale_ru_key'] = 'Российские логотипы';
$string['auth_lenauth_static_html'] = 'Статичный HTML-код';
$string['auth_lenauth_style_not_defined'] = 'Данный стиль не является стилем плагина';
$string['auth_lenauth_locale_desc'] = 'Некоторые сервисы имеют локальные и международные логотипы, например, ВКонтакте и Яндекс.';
$string['auth_lenauth_default_country_desc'] = 'У каждый впервые регистрируемого пользователя, который первый раз авторизовывается через LenAuth будет выбрана данная страна по-умолчанию';
//$string['can_change_password'] = 'Пользователь может менять пароль';
$string['auth_lenauth_can_reset_password_key'] = 'Пользователь может сбрасывать/менять внутренний пароль (<em>рекомендуется</em>)';
$string['auth_lenauth_can_reset_password_desc'] = 'Если включить опцию, то пользователь сможет поменять заданный внутренний пароль (<strong>по-умолчанию он не задан</strong>) и авторизовываться через обычную форму логина';
//$string['password_expire_key'] = 'Время жизни пароля (дни)';
//$string['password_expire_desc'] = 'Период жизни пароля, необходимо будет создать новый через определенное Вами количество дней. 0 &mdash; значит пароль можно оставить навсегда.';
$string['auth_lenauth_can_confirm_key'] = 'Модерация новых пользователей';
$string['auth_lenauth_can_confirm_desc'] = 'Все новые пользователи, зарегистрированные через LenAuth должны будут быть одобрены администратором Moodle';
$string['auth_lenauth_retrieve_avatar_key'] = 'Подгружать аватар';
$string['auth_lenauth_retrieve_avatar_desc'] = 'Если опция выбрана, то новому пользователю или пользователю без аватара Moodle будет автоматически подгружаться аватар из его социального профиля';
$string['auth_lenauth_dev_mode_key'] = 'Режим отладки/разработки';
$string['auth_lenauth_dev_mode_desc'] = 'Если Вы разработчик и Вам необходимо проверить ответы запросов к OAuth-вебсервисам, просто включите эту опцию.<br /><strong style="color:red">Должен быть включен режим РАЗРАБОТЧИК в настройках отладки Moodle</strong>';

$string['auth_lenauth_empty_code_param'] = 'Что-то пошло не так, GET-параметр code пустой. Проверьте настройки приложений в LenAuth';

$string['auth_lenauth_buttons_settings'] = 'Настройки кнопок';

$string['auth_lenauth_buttons_location'] = 'Расположение кнопок';
$string['auth_lenauth_display_inline'] = 'В строку';
$string['auth_lenauth_display_block'] = 'Блочно (друг под другом)';

$string['auth_lenauth_margin_top_key'] = 'Отступ сверху (px)';
$string['auth_lenauth_margin_right_key'] = 'Отступ справа (px)';
$string['auth_lenauth_margin_bottom_key'] = 'Отступ снизу (px)';
$string['auth_lenauth_margin_left_key'] = 'Отступ слева (px)';
$string['auth_lenauth_order'] = 'Порядок';

$string['auth_lenauth_div_settings'] = 'Настройки области кнопок';
$string['auth_lenauth_div_location'] = 'Расположение области';
$string['auth_lenauth_output_style_key'] = 'Стиль как на сайте';
$string['auth_lenauth_bootstrap_fontawesome_needle'] = 'Для корректного вывода кнопок в шаблоне необходимо подключение CSS-фреймворка Bootstrap и шрифтов семейства Font-Awesome!';

/**
 * ERRORS
 */
$string['auth_lenauth_user_suspended'] = 'Пользователь заблокирован';
$string['auth_lenauth_access_token_empty'] = 'Невозможно получить токен. Проверьте настройки Вашего приложения';

/**
 * Facebook Russian locale
 */
$string['auth_lenauth_facebook_settings'] = 'Настройки Facebook';
$string['auth_lenauth_facebook_dashboard'] = 'Панель управления приложением';
$string['facebook_app_id'] = 'ID приложения';
$string['auth_lenauth_facebook_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://www.facebook.com/" target="_blank">Facebook</a></li>
        <li><a href="https://developers.facebook.com/apps/" target="_blank">Зарегистрируйтесь</a> как разработчик Facebook. <em>Процедура ни к чему не обязывает.</em></li>
        <li>В консоли разработчика необходимо создать приложение (кнопка <strong>+ Add a New App</strong>) с категорией <strong>WWW Веб-сайт</strong> и произвольным названием</li>
        <li>Заполните в процессе настройки приложения <strong>Site URL</strong> как <strong>{$a->wwwroot}</strong>. Далее нажмите ссылку <strong><a href="https://developers.facebook.com/apps/" target="_blank">Skip to Developer Dashboard</a></strong></li>
        <li>В результате Вам будут выданы <strong>App ID</strong> и <strong>App Secret</strong> (чтобы он стал виден нажмите <strong>Show</strong>). Скопируйте их сюда.</li>
        <li><strong>ВАЖНО!</strong> в консоли приложения зайдите во вкладку <strong>Advanced</strong> и заполните поле <strong>Valid OAuth redirect URIs</strong>: впишите там <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?auth_service=facebook</strong></li>
    </ol>';
$string['auth_lenauth_facebook_app_secret'] = 'Секретный ключ приложения (App Secret)';
$string['auth_lenauth_facebook_button_text_default'] = 'Фейсбук';
$string['auth_lenauth_facebook_binding'] = 'ID Фейсбука';

/**
 * Google Russian locale
 */
$string['auth_lenauth_google_settings'] = 'Настройки Google';
$string['auth_lenauth_google_dashboard'] = 'Настройки приложения';
$string['auth_lenauth_google_client_id_key'] = 'CLIENT ID';
$string['auth_lenauth_google_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в <a href="https://accounts.google.com/SignUp" target="_blank">Google</a></li>
        <li><a href="https://console.developers.google.com/" target="_blank">Создайте приложение</a> (<strong>Create Project</strong>) в консоли разработчиков Google</li>
        <li>В консоли разработчика в разделе <strong>APIs &amp; auth &raquo; Credentials</strong> создайте <strong>OAuth Client ID</strong></li>
        <li><strong>ВНИМАНИЕ!</strong> Приложение Google позволяет вводить несколько <strong>Redirect URI</strong>, Вам же необходимо ввести только один, а именно &mdash; <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?auth_service=google</strong></li>
        <li>В приложении в разделе <strong>APIs &amp; auth &raquo; Credentials</strong> скопируйте сюда <strong>CLIENT ID</strong> и <strong>CLIENT SECRET</strong></li>
        <li>Параметр <strong>Project ID</strong> не обязателен, его Вы можете скопировать из пункта меню <strong>Overview</strong> в консоли сверху страницы</li>
    </ol>';
$string['auth_lenauth_google_client_secret_key'] = 'CLIENT SECRET';
$string['auth_lenauth_google_project_id_key'] = 'Project ID';
$string['auth_lenauth_google_button_text_default'] = 'Google';
$string['auth_lenauth_google_binding'] = 'ID Гугл';

/**
 * Yahoo Russian locale
 */
$string['auth_lenauth_yahoo_settings'] = 'Настройки Yahoo';
$string['auth_lenauth_yahoo_oauth_1_note'] = 'если у Вас уже есть приложение Yahoo';
$string['auth_lenauth_yahoo_oauth_2_note'] = 'рекомендуется для создания новых приложений';
$string['auth_lenauth_yahoo_application_id'] = 'Application ID';
$string['auth_lenauth_yahoo_consumer_key'] = 'Consumer Key';
$string['auth_lenauth_yahoo_consumer_secret'] = 'Consumer Secret';
$string['auth_lenauth_yahoo_button_text_default'] = 'Yahoo';
$string['auth_lenauth_yahoo_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в <a href="https://edit.yahoo.com/registration" target="_blank">Yahoo</a></li>
        <li>
            <ul><a href="https://developer.apps.yahoo.com/dashboard/createKey.html" target="_blank">Создайте приложение</a> (<strong>Create An App</strong>) в <a href="https://developer.apps.yahoo.com/projects" target="_blank">консоли разработчиков Yahoo (YDN)</a>
                <li>Application Type: <strong>Web-based</strong></li>
                <li>Home Page URL: <strong>{$a->wwwroot}</strong></li>
                <li>Access Scopes: <strong>This app requires access to private user data.</strong></li>
                <li>Callback Domain: <strong style="color:red">{$a->wwwroot}</strong></li>
                <li>Select APIs for private user data access: отметьте галочку <strong>Social Directory (Profiles)</strong>, а под ней отметьте последний пункт <strong>Read/Write Public and Private</strong></li>
                <li>Terms of Use: <em>отметьте галочку</em></li>
            </ul>
        </li>
        <li>Из настроек приложения скопируйте сюда: <strong>Consumer Key</strong>, <strong>Consumer Secret</strong></li>
        <li><em>Необязательно</em>: скопируйте сюда <strong>Application ID</strong>, сверху страницы приложения</li>
    </ol>';
$string['auth_lenauth_yahoo_binding'] = 'ID Yahoo';

/**
 * Twitter Russian locale
 */
$string['auth_lenauth_twitter_settings'] = 'Настройки Twitter';
$string['auth_lenauth_twitter_dashboard'] = 'Настройки приложения';
$string['auth_lenauth_twitter_application_id'] = 'ID приложения';
$string['auth_lenauth_twitter_consumer_key'] = 'Consumer Key';
$string['auth_lenauth_twitter_consumer_secret'] = 'Consumer Secret';
$string['auth_lenauth_twitter_button_text_default'] = 'Твиттер';
$string['auth_lenauth_twitter_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в <a href="https://twitter.com" target="_blank">Twitter</a></li>
        <li>
            <ul><a href="https://apps.twitter.com/app/new" target="_blank">Создайте приложение</a>
                <li>Name: <strong>Назовите Ваше приложение</strong></li>
                <li>Description: <strong>Опишите Ваше приложение</strong></li>
                <li>Website: <strong>{$a->wwwroot}</strong></li>
                <li>Callback URL: <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?auth_service=twitter</strong></li>
                <li>Developer Rules of the Road: отметьте галочку <strong>Yes, I agree</strong></li>
            </ul>
        </li>
        <li>Из настроек приложения скопируйте сюда: <strong>Consumer Key</strong>, <strong>Consumer Secret</strong>. Закладка <strong>Keys and Access Tokens</strong></li>
        <li><em>Необязательно</em>: скопируйте сюда <strong>ID приложения</strong> из URL страницы приложения, например <strong>1234567</strong> если URL <strong>https://apps.twitter.com/app/1234567</strong></li>
    </ol>';
$string['auth_lenauth_twitter_binding'] = 'ID Твиттера';

/**
 * VK Russian locale
 */
$string['auth_lenauth_vk_settings'] = 'Настройки ВКонтакте';
$string['auth_lenauth_vk_dashboard'] = 'Настройки приложения';
$string['auth_lenauth_vk_app_id_key'] = 'ID приложения';
$string['auth_lenauth_vk_app_secret_key'] = 'Защищенный ключ';
$string['auth_lenauth_vk_button_text_default'] = 'ВКонтакте';
$string['auth_lenauth_vk_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в соцсети <a href="http://vk.com/" target="_blank">ВКонтакте</a></li>
        <li>
            <ul><a href="http://vk.com/editapp?act=create" target="_blank">Создайте приложение</a>
                <li>Тип: <strong>Веб-сайт</strong></li>
                <li>Адрес сайта: <strong>{$a->wwwroot}</strong></li>
                <li>Базовый домен: <strong>{$a->wwwroot}</strong> (<em style="color:red;font-weight:bold;">без префиксов <u>http://</u> или <u>https://</u></em>)</li>
            </ul>
        </li>
        <li>В консоли приложения во вкладке <strong>Настройки</strong> скопируйте сюда <strong>ID приложения</strong> и <strong>Защищенный ключ</strong></li>
        <li><em>Необязательно</em>: во вкладке <strong>Информация</strong> заполните информацию о приложении</li>
    </ol>';

/**
 * Yandex Russian locale
 */
$string['auth_lenauth_yandex_settings'] = 'Настройки Яндекса';
$string['auth_lenauth_yandex_dashboard'] = 'Панель управления приложением';
$string['auth_lenauth_yandex_app_id'] = 'ID';
$string['auth_lenauth_yandex_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://passport.yandex.ru/registration/" target="_blank">Яндексе</a></li>
        <li><a href="https://oauth.yandex.ru/client/new" target="_blank">Зарегистрируйте</a> Ваше OAuth приложение</li>
        <li>
            <ul><strong>Настройте приложение</strong>:
                <li>Поля <strong>название</strong>, <strong>описание</strong>, </strong>ссылка на иконку</strong> и <strong>ссылка на приложение</strong> приложения на Ваше усмотрение</li>
                <li>В поле <strong>Права</strong> выбираем <strong>Яндекс.Логин</strong> и выставляем все 2 опции (email, ФИО)</li>
                <li>В поле <strong>Callback URI</strong> ставим ссылку <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?auth_service=yandex' . '</strong></li>
            </ul>
        </li>
        <li>Скопируйте сюда 2 параметра: <strong>ID</strong>, <strong>Пароль</strong></li>
    </ol>';
$string['auth_lenauth_yandex_app_password_key'] = 'Пароль';
$string['auth_lenauth_yandex_button_text_default'] = 'Яндекс';
$string['auth_lenauth_yandex_binding'] = 'ID Яндекса';

/**
 * Mail.ru Russian locale
 */
$string['auth_lenauth_mailru_settings'] = 'Настройки Mail.ru';
$string['auth_lenauth_mailru_dashboard'] = 'Редактирование настроек сайта';
$string['auth_lenauth_mailru_site_id'] = 'ID сайта';
$string['auth_lenauth_mailru_client_private_key'] = 'Приватный ключ';
$string['auth_lenauth_mailru_client_secret_key'] = 'Секретный ключ';
$string['auth_lenauth_mailru_button_text_default'] = 'Mail.ru';
$string['auth_lenauth_mailru_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://e.mail.ru/signup?from=main_noc" target="_blank">Mail.ru</a></li>
        <li><a href="http://api.mail.ru/sites/my/add" target="_blank">Зарегистрируйте</a> Ваш сайт. <em>Скачивать и устанавливать receiver.html не обязательно, но желательно.</em></li>
        <li>Скопируйте сюда 3 параметра: <strong>ID</strong>, <strong>Приватный ключ</strong>, <strong>Секретный ключ</strong></li>
        <li><em>Необязательно</em>: Настройте Ваше приложение: <strong>Иконка для списков</strong>, <strong>Картинка для диалогов</strong></li>
    </ol>';
$string['auth_lenauth_mailru_binding'] = 'ID Mail.Ru';

/**
 * OdnoKlassniki Russian locale
 */
/*$string['auth_ok_settings'] = 'Настройки Одноклассников';
$string['auth_ok_app_id_key'] = 'ID приложения';
$string['auth_ok_public_key_key'] = 'Публичный ключ';
$string['auth_ok_secret_key_key'] = 'Секретный ключ';
$string['auth_ok_button_text_default'] = 'Войти с помощью Одноклассников';*/