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
 * Authentication Plugin: LenAuth Authentication
 * If the email doesn't exist, then the auth plugin creates the user.
 * If the email exist (and the user has for auth plugin this current one),
 * then the plugin login the user related to this email.
 *
 * @link    http://lms-service.org/lenauth-plugin-oauth-moodle/
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @version 2.0
 * @author  Igor Sazonov <sovletig@gmail.com>
 */

defined('MOODLE_INTERNAL') || die();

require_once __DIR__ . '/../../auth/lenauth/autoload.php';
require_once __DIR__ . '/../../lib/authlib.php';
require_once __DIR__ . '/../../lib/formslib.php';

/**
 * LenAuth authentication plugin.
 */
class auth_plugin_lenauth extends \Tigusigalpa\Auth_LenAuth\Moodle\Auth\LenAuth\LenAuth
{
    //
}
