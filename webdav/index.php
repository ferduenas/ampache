<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2015 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

define('NO_SESSION','1');
require_once '../lib/init.php';

if (!AmpConfig::get('webdav_backend')) {
    echo "Disabled.";
    exit;
}

use Sabre\DAV;

$rootDir = new WebDAV_Catalog();
$server = new DAV\Server($rootDir);

$server->setBaseUri(AmpConfig::get('raw_web_path') . '/webdav/index.php');
if (AmpConfig::get('use_auth')) {
    $authBackend = new WebDAV_Auth();
    $authPlugin = new DAV\Auth\Plugin($authBackend, 'SabreDAV');
    $server->addPlugin($authPlugin);
}

$server->exec();