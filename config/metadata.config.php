<?php
/**
 *
 * @copyright  2014 Fumito MIZUNO
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 */

return array(
    'name'    => '管理用コメント',
    'version' => 'chiba',
    'provider' => array(
        'name' => 'ounziw',
    ),
    'namespace' => 'OunziwPagecomment',
    'requires' => array('novius_metadata', 'noviusos_comments'),
    'permission' => array(
    ),
    'icons' => array(
        16 => 'static/apps/novius_metadata/img/icons/metadata-16.png',
        32 => 'static/apps/novius_metadata/img/icons/metadata-32.png',
        64 => 'static/apps/novius_metadata/img/icons/metadata-64.png',
    ),
);
