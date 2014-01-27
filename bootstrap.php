<?php
// Copy the code below into your local/bootstrap.php

/**
 *
 * @copyright  2014 Fumito Mizuno
 *
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 */

\Event::register_function('config|novius_metadata::metadata_classes', function(&$config) {

    $config['comment_for_page'] = array(
        // Use as field label
        'group' => '管理コメント',
        'label' => __('Metadata class label'),

        // The model of the metadata class's nature
        'nature' => 'Nos\Comments\Model_Comment',

        // The field configuration used in the CRUD
        'field' => array(
            'label' => __('コメントする'),
            'renderer' => '\OunziwPagecomment\Renderer_Metadata',
        )
    );
});

\Event::register_function('config|noviusos_page::model/page', function(&$config) {

    $config['behaviours']['Nos\Comments\Orm_Behaviour_Commentable'] = array();

    $config['behaviours']['Nos\Orm_Behaviour_Urlenhancer']['enhancers'][] = 'noviusos_page';

});

