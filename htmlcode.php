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

require __DIR__ . '/../../config.php';
if (has_capability('moodle/user:update', \context_system::instance())) {
    if ($style = format_string(required_param('style', PARAM_ALPHANUMEXT))) {
        include_once __DIR__ . '/out.php';
        echo 'Static inline HTML code:<br /><pre>'
            . htmlspecialchars(\auth_lenauth_out::getInstance()
                ->lenauth_output($style, false, true), ENT_QUOTES) . '</pre>';
    } else {
        throw new \moodle_exception('style GET-parameter is not set', 'auth_lenauth');
    }
} else {
    throw new \moodle_exception('You do not have permissions', 'auth_lenauth');
}
