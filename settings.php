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
 * Admin settings and defaults.
 *
 * @package   auth_lenauth
 * @copyright Igor Sazonov <sovletig@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once __DIR__ . '/../../auth/lenauth/autoload.php';

if ($ADMIN->fulltree) {
    $stringManager = get_string_manager();
    $settings->add(new \admin_setting_heading(
        'auth_lenauth/general',
        get_string('general'),
        get_string('auth_emaildescription', 'auth_email')
    ));

    $settings->add(new \admin_setting_configtext(
        'auth_lenauth/user_prefix',
        get_string('user_prefix_key', 'auth_lenauth'),
        '',
        'lenauth_user_',
        PARAM_ALPHANUMEXT
    ));

    $settings->add(new \admin_setting_configcheckbox(
        'auth_lenauth/user_can_reset_password',
        get_string('can_reset_password_key', 'auth_lenauth'),
        get_string('can_reset_password_desc', 'auth_lenauth'),
        0
    ));

    $settings->add(new \admin_setting_configcheckbox(
        'auth_lenauth/can_confirm',
        get_string('can_confirm_key', 'auth_lenauth'),
        get_string('can_confirm_desc', 'auth_lenauth'),
        0
    ));

    foreach (\Tigusigalpa\Auth_LenAuth\Moodle\Auth\LenAuth\LenAuth::SETTINGS as $socialName => $socialData) {
        $settings->add(new \admin_setting_heading(
            'auth_lenauth/' . $socialName,
            ucfirst($socialName),
            ''
        ));
        $settings->add(new \Tigusigalpa\Auth_LenAuth\Moodle\Admin\Setting\Notification(
            'auth_lenauth/' . $socialName . '_desc',
            $socialName . '_desc',
            get_string($socialName . '_desc', 'auth_lenauth', [
                'wwwroot' => $CFG->wwwroot,
                'versionstr' => get_string('version')
            ])
        ));
        $settings->add(new \admin_setting_configcheckbox(
            'auth_lenauth/' . $socialName . '_enabled',
            get_string('enable'),
            '',
            0
        ));
        $settings->add(new \admin_setting_configtext(
            'auth_lenauth/' . $socialName . '_button_text',
            get_string('button_text', 'auth_lenauth'),
            '',
            get_string($socialName . '_button_text_default', 'auth_lenauth')
        ));
        foreach ($socialData['fields'] as $fieldName => $fieldData) {
            $key = $socialName . '_' . $fieldName;
            $title = isset($fieldData['title']) ? $fieldData['title'] :
                ($stringManager->string_exists($key, 'auth_lenauth') ? get_string($key, 'auth_lenauth')
                    : ($stringManager->string_exists($fieldName, 'core') ? get_string($fieldName) : ''));
            switch ($fieldData['type']) {
                case 'text':
                    $settings->add(new \admin_setting_configtext(
                        'auth_lenauth/' . $key,
                        $title,
                        '',
                        '',
                        (isset($fieldData['paramtype']) && !empty($fieldData['paramtype']))
                            ? $fieldData['paramtype'] : PARAM_ALPHANUMEXT
                    ));
                    break;
                case 'password':
                    $settings->add(new \admin_setting_configpasswordunmask(
                        'auth_lenauth/' . $key,
                        $title,
                        '',
                        ''
                    ));
                    break;
                case 'select':
                    if (isset($fieldData['options']) && !empty($fieldData['options'])
                        && is_array($fieldData['options'])) {
                        $settings->add(new \admin_setting_configselect(
                            'auth_lenauth/' . $key,
                            $title,
                            '',
                            '',
                            $fieldData['options']
                        ));
                    }
                    break;
            }
        }
    }
}
