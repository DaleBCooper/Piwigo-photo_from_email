<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based picture gallery                                  |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2015 Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

if( !defined("PHPWG_ROOT_PATH") )
{
  die ("Hacking attempt!");
}

include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');

define('PFEMAIL_BASE_URL', get_root_url().'admin.php?page=plugin-photo_from_email');

// +-----------------------------------------------------------------------+
// | Check Access and exit when user status is not ok                      |
// +-----------------------------------------------------------------------+

check_status(ACCESS_ADMINISTRATOR);

// +-----------------------------------------------------------------------+
// | Tabs                                                                  |
// +-----------------------------------------------------------------------+

$pendings_label = l10n('Pending Photos');
if ($page['pfemail_nb_pendings'] > 0)
{
  $pendings_label.= ' ('.$page['pfemail_nb_pendings'].')';
}

$tabs = array(
  array(
    'code' => 'pendings',
    'label' => $pendings_label,
    ),
  array(
    'code' => 'config',
    'label' => l10n('Configuration'),
    ),
  );

$tab_codes = array_map(
  function($a) { return $a["code"];},
  $tabs
  );

if (isset($_GET['tab']) and in_array($_GET['tab'], $tab_codes))
{
  $page['tab'] = $_GET['tab'];
}
else
{
  $page['tab'] = $tabs[0]['code'];
}

$tabsheet = new tabsheet();
foreach ($tabs as $tab)
{
  $tabsheet->add(
    $tab['code'],
    $tab['label'],
    PFEMAIL_BASE_URL.'-'.$tab['code']
    );
}
$tabsheet->select($page['tab']);
$tabsheet->assign();

// +-----------------------------------------------------------------------+
// |                             Load the tab                              |
// +-----------------------------------------------------------------------+

include(PFEMAIL_PATH.'admin_'.$page['tab'].'.php');
?>
