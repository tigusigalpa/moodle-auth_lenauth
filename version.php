<?php
// This file is not a part of Moodle - http://moodle.org/
// This is a none core contributed module.
//
// This is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// The GNU General Public License
// can be see at <http://www.gnu.org/licenses/>.

/**
 * LenAuth authentication plugin version specification.
 *
 * NOTE: Some parts of the plugin are taken from auth_googleoauth2 Moodle plugin. {@author} Jérôme Mouneyrac (jerome@mouneyrac.com) twitter: mouneyrac
 *
 * @package    auth
 * @subpackage lenauth
 * @copyright  2014 Igor Sazonov ( @tigusigalpa )
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2015123100;
$plugin->requires  = 2013111805;   // Requires Moodle 2.6.5 or later
$plugin->release   = '1.2.4 (Build: 2015123100)';
$plugin->maturity  = MATURITY_BETA;             // this version's maturity level
$plugin->component = 'auth_lenauth';