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

$string['auth_lenauth_enabled_key'] = 'Включено';
$string['button_text'] = 'Текст кнопки';
$string['auth_lenauth_button_div_width'] = 'Ширина (<em>0 = авто</em>)';
$string['auth_lenauth_binding_key'] = 'Привязка';
$string['auth_lenauth_output_settings'] = 'Настройки визуализации';

$string['privacy:metadata:auth_lenauth:userid'] = 'Идентификатор пользователя, данные которого хранятся в поле профиля пользователя LenAuth';
$string['privacy:metadata:auth_lenauth:fieldid'] = 'Идентификатор поля профиля';
$string['privacy:metadata:auth_lenauth:data'] = 'Поле социального ID в данных профиля пользователя плагина LenAuth';
$string['privacy:metadata:auth_lenauth:dataformat'] = 'Формат поля социального ID в данных профиля пользователя LenAuth';
$string['privacy:metadata:auth_lenauth:tableexplanation'] = 'Дополнительные данные профиля';

$string['pluginname'] = 'LenAuth';
$string['auth_lenauthdescription'] = 'Данный модуль авторизации позволяет пользователям авторизовываться в Вашем Moodle через OAuth-протокол популярных социальных сетей и поисковиков: Фейсбук, Google, Yahoo, Twitter, Вконтакте, Яндекс, Мейл.ру. При первой авторизации пользователя, он автоматически регистрируется в системе, а при дальнейших попытках входа, система автоматически определяет зарегистрированного пользователя.';
$string['auth_lenauth_main_settings'] = 'Общие настройки';

$string['user_prefix_key'] = 'Префикс';
$string['user_prefix_desc'] = 'Префикс у никнейма пользователя';
$string['default_country_key'] = 'Страна по-умолчанию';
$string['locale_en_key'] = 'Международные логотипы';
$string['locale_ru_key'] = 'Российские логотипы';
$string['auth_lenauth_static_html'] = 'Статичный HTML-код';
$string['style_not_defined'] = 'Данный стиль не является стилем плагина';
$string['locale_desc'] = 'Некоторые сервисы имеют локальные и международные логотипы, например, ВКонтакте и Яндекс.';
$string['default_country_desc'] = 'У каждый впервые регистрируемого пользователя, который первый раз авторизовывается через LenAuth будет выбрана данная страна по-умолчанию';
$string['can_reset_password_key'] = 'Пользователь может сбрасывать/менять внутренний пароль (<em>рекомендуется</em>)';
$string['can_reset_password_desc'] = 'Если включить опцию, то пользователь сможет поменять заданный внутренний пароль (<strong>по-умолчанию он не задан</strong>) и авторизовываться через обычную форму логина';
$string['can_confirm_key'] = 'Модерация новых пользователей';
$string['can_confirm_desc'] = 'Все новые пользователи, зарегистрированные через LenAuth должны будут быть одобрены администратором Moodle';
$string['retrieve_avatar_key'] = 'Подгружать аватар';
$string['retrieve_avatar_desc'] = 'Если опция выбрана, то новому пользователю или пользователю без аватара Moodle будет автоматически подгружаться аватар из его социального профиля';
$string['dev_mode_key'] = 'Режим отладки/разработки';
$string['dev_mode_desc'] = 'Если Вы разработчик и Вам необходимо проверить ответы запросов к OAuth-вебсервисам, просто включите эту опцию.<br /><strong style="color:red">Должен быть включен режим РАЗРАБОТЧИК в настройках отладки Moodle</strong>';

$string['empty_code_param'] = 'Что-то пошло не так, GET-параметр code пустой. Проверьте настройки приложений в LenAuth';

$string['buttons_settings'] = 'Настройки кнопок';

$string['buttons_location'] = 'Расположение кнопок';
$string['display_inline'] = 'В строку';
$string['display_block'] = 'Блочно (друг под другом)';

$string['margin_top_key'] = 'Отступ сверху (px)';
$string['margin_right_key'] = 'Отступ справа (px)';
$string['margin_bottom_key'] = 'Отступ снизу (px)';
$string['margin_left_key'] = 'Отступ слева (px)';
$string['order'] = 'Порядок';

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
$string['facebook_app_id'] = 'App ID';
$string['facebook_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://www.facebook.com/" target="_blank">Facebook</a></li>
        <li><a href="https://developers.facebook.com/apps/" target="_blank">Зарегистрируйтесь</a> как разработчик Facebook. <em>Процедура ни к чему не обязывает.</em></li>
        <li>В <a href="https://developers.facebook.com/apps/" target="_blank">консоли разработчика</a> необходимо создать новый ID приложения (кнопка <strong>Добавить новое приложение</strong>).
            <ol>
                <li><strong>Отображаемое название</strong>: Ваше название</li>
                <li><strong>Эл. адрес для связи</strong>: Ваш адрес электронной почты</li>
                <li>Нажмите кнопку <strong>Создайте ID приложения</strong> и, по необходимости, выполните проверку безопасности</li>
            </ol>
        </li>
        <li>Добавьте продукт <strong>Вход через Facebook</strong>
            <ol>
                <li>нажмите кнопку &laquo;<strong>Настроить</strong>&raquo;</li>
                <li>выберите платформу приложения &laquo;<strong>WWW (Веб)</strong>&raquo;
                    <ol>
                        <li>Ваш сайт
                            <ul>
                                <li>URL сайта: <strong style="color:red">{$a->wwwroot}</strong>, &laquo;<strong>Save</strong>&raquo;, &laquo;<strong>Продолжить</strong>&raquo;</li>
                            </ul>
                        </li>
                        <li><strong>Настройка Facebook SDK для Javascript</strong> &mdash; &laquo;<strong>Далее</strong>&raquo;</li>
                        <li><strong>Проверка статуса входа</strong> &mdash; &laquo;<strong>Далее</strong>&raquo;</li>
                        <li><strong>Добавление кнопки &laquo;Вход через Facebook&raquo;</strong> &mdash; &laquo;<strong>Далее</strong>&raquo;</li>
                    </ol>
                </li>
            </ol>
        </li>
        <li>В <a href="https://developers.facebook.com/apps/" target="_blank">консоли разработчика Facebook</a> в данном проекте в подкатегории &laquo;<strong>Настройки</strong>&raquo; &rarr; &laquo;<strong>Основное</strong>&raquo;:
            <ol>Заполните следующие значения:
                <li>Домены приложений: <strong style="color:red">{$a->wwwroot}</strong></li>
            </ol>
            <ol>Скопируйте и сохраните сюда следующие значения:
                <li><strong>Идентификатор приложения</strong></li>
                <li><strong>Секрет приложения</strong></li>
            </ol>
        </li>
        <li>В подкатегории &laquo;<strong>Товары</strong>&raquo;  &rarr; &laquo;<strong>Вход через Facebook</strong>&raquo; &rarr; &laquo;<strong>Настройки</strong>&raquo; в разделе &laquo;<strong>Клиентские настройки OAuth</strong>&raquo; в поле &laquo;<strong>Действительные URI перенаправления для OAuth</strong>&raquo; вставьте значение <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?provider=facebook</strong></li>
    </ol>';
$string['facebook_app_secret'] = 'Секрет приложения';
$string['facebook_button_text_default'] = 'Фейсбук';
$string['auth_lenauth_facebook_binding'] = 'ID Фейсбука';

/**
 * Google Russian locale
 */
$string['google_client_id'] = 'Client ID';
$string['google_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт в <a href="https://accounts.google.com/SignUp" target="_blank">Google</a></li>
        <li><a href="https://console.developers.google.com/" target="_blank">Создайте приложение</a> (<strong>Create Project</strong>) в консоли разработчиков Google</li>
        <li>В консоли разработчика в разделе <strong>APIs &amp; auth &raquo; Credentials</strong> создайте <strong>OAuth Client ID</strong></li>
        <li><strong>ВНИМАНИЕ!</strong> Приложение Google позволяет вводить несколько <strong>Redirect URI</strong>, Вам же необходимо ввести только один, а именно &mdash; <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?provider=google</strong></li>
        <li>В приложении в разделе <strong>APIs &amp; auth &raquo; Credentials</strong> скопируйте сюда <strong>CLIENT ID</strong> и <strong>CLIENT SECRET</strong></li>
        <li>Параметр <strong>Project ID</strong> не обязателен, его Вы можете скопировать из пункта меню <strong>Overview</strong> в консоли сверху страницы</li>
    </ol>';
$string['google_client_secret'] = 'CLIENT SECRET';
$string['google_project_id'] = 'Project ID';
$string['google_button_text_default'] = 'Google';
$string['google_binding'] = 'ID Гугл';

/**
 * Yahoo Russian locale
 */
$string['auth_lenauth_yahoo_settings'] = 'Настройки Yahoo';
$string['auth_lenauth_yahoo_oauth_1_note'] = 'если у Вас уже есть приложение Yahoo';
$string['auth_lenauth_yahoo_oauth_2_note'] = 'рекомендуется для создания новых приложений';
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
$string['yahoo_binding'] = 'ID Yahoo';

/**
 * Twitter Russian locale
 */
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
                <li>Website: <strong>{$a->wwwroot}</strong></li>
                <li>Callback URL: <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?provider=twitter</strong></li>
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
$string['vk_app_id'] = 'ID приложения';
$string['vk_app_secret'] = 'Защищенный ключ';
$string['vk_button_text_default'] = 'ВКонтакте';
$string['vk_desc'] = '
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
$string['yandex_app_id'] = 'ID';
$string['yandex_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://passport.yandex.ru/registration/" target="_blank">Яндексе</a></li>
        <li><a href="https://oauth.yandex.ru/client/new" target="_blank">Зарегистрируйте</a> Ваше OAuth приложение</li>
        <li>
            <ul><strong>Настройте приложение</strong>:
                <li>Поля <strong>название</strong>, <strong>описание</strong>, </strong>ссылка на иконку</strong> и <strong>ссылка на приложение</strong> приложения на Ваше усмотрение</li>
                <li>В поле <strong>Права</strong> выбираем <strong>Яндекс.Логин</strong> и выставляем все 2 опции (email, ФИО)</li>
                <li>В поле <strong>Callback URI</strong> ставим ссылку <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?provider=yandex' . '</strong></li>
            </ul>
        </li>
        <li>Скопируйте сюда 2 параметра: <strong>ID</strong>, <strong>Пароль</strong></li>
    </ol>';
$string['yandex_app_password'] = 'Пароль';
$string['yandex_button_text_default'] = 'Яндекс';
$string['auth_lenauth_yandex_binding'] = 'ID Яндекса';

/**
 * Mail.ru Russian locale
 */
$string['auth_lenauth_mailru_settings'] = 'Настройки Mail.ru';
$string['auth_lenauth_mailru_dashboard'] = 'Редактирование настроек сайта';
$string['mailru_site_id'] = 'ID сайта';
$string['mailru_client_private'] = 'Приватный ключ';
$string['mailru_client_secret'] = 'Секретный ключ';
$string['mailru_button_text_default'] = 'Mail.ru';
$string['mailru_desc'] = '
    <ol>
        <li>У Вас должен быть зарегистрирован любой аккаунт на <a href="https://e.mail.ru/signup?from=main_noc" target="_blank">Mail.ru</a></li>
        <li><a href="http://api.mail.ru/sites/my/add" target="_blank">Зарегистрируйте</a> Ваш сайт. <em>Скачивать и устанавливать receiver.html не обязательно, но желательно.</em></li>
        <li>Скопируйте сюда 3 параметра: <strong>ID</strong>, <strong>Приватный ключ</strong>, <strong>Секретный ключ</strong></li>
        <li><em>Необязательно</em>: Настройте Ваше приложение: <strong>Иконка для списков</strong>, <strong>Картинка для диалогов</strong></li>
    </ol>';
$string['auth_lenauth_mailru_binding'] = 'ID Mail.Ru';