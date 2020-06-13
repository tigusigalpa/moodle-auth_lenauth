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
 * Auth LenAuth autoload.
 *
 * @package   auth_lenauth
 * @copyright 2020 Igor Sazonov <sovletig@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once __DIR__ . '/../../config.php';
defined('MOODLE_INTERNAL') || die();
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}
spl_autoload_register(function ($class) {
    if (!class_exists($class)) {
        $arr = $tmp = explode('\\', $class);
        $cnt = count($arr);
        if ($cnt > 2 && $arr[0] == 'Tigusigalpa' && $arr[1] == 'Auth_LenAuth') {
            unset($tmp[0], $tmp[1]);
            $file = __DIR__ . '/src/' . join('/', $tmp) . '.php';
            if ($file && file_exists($file)) {
                require $file;
            }
        }
    }
});
