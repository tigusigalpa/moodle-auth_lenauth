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
 * Admin setting notification
 *
 * @package   tool_imageoptimize
 * @copyright Igor Sazonov <sovletig@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Tigusigalpa\Auth_LenAuth\Moodle\Admin\Setting;

defined('MOODLE_INTERNAL') || die();

require_once __DIR__ . '/../../../../../../lib/adminlib.php';

/**
 * Notification panel
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Notification extends \admin_setting
{
    /**
     * Notification type
     *
     * @var string
     */
    protected $type = 'info';
    /**
     * not a setting, just text
     *
     * @param string $name unique ascii name, either 'mysetting' for settings that in config,
     *                     or 'myplugin/mysetting' for ones in config_plugins.
     * @param string $visibleName heading
     * @param string $text text in box
     * @param string $type box type error|info|success|warning
     */
    public function __construct($name, $visibleName, $text, $type = 'info')
    {
        $this->nosave = true;
        if (in_array($type, ['error', 'info', 'success', 'warning'])) {
            $this->type = $type;
        }
        parent::__construct($name, $visibleName, $text, '');
    }

    /**
     * Always returns true
     * @return bool Always returns true
     */
    public function get_setting()
    {
        return true;
    }

    /**
     * Never write settings
     * @return string Always returns an empty string
     */
    public function write_setting($data)
    {
        // do not write any setting
        return '';
    }

    /**
     * Returns an HTML string
     *
     * @param string $data
     * @param string $query
     * @return string Returns an HTML string
     */
    public function output_html($data, $query='')
    {
        global $OUTPUT;
        $context = [
            'message' => $this->description
        ];
        switch ($this->type) {
            case 'error':
                $context['extraclasses'] = 'alert-danger';
                break;
            case 'info':
                $context['extraclasses'] = 'alert-info';
                break;
            case 'success':
                $context['extraclasses'] = 'alert-success';
                break;
            case 'warning':
                $context['extraclasses'] = 'alert-warning';
                break;
        }
        return $OUTPUT->render_from_template('auth_lenauth/notification', $context);
    }
}
