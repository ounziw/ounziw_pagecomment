<?php
/**
 *
 * @copyright  2014 Fumito MIZUNO
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 */

return array(
    'comment_for_page' => array(
        'group' => '管理コメント',
        'label' => 'Comment for Management',

        'nature' => 'Nos\Comments\Model_Comment',

        'field' => array(
            'label' => __('コメントする'),
            'renderer' => '\OunziwPagecomment\Renderer_Metadata',
        ),
    ),
);