<?php
/**
 *
 * @copyright  2014 Fumito Mizuno
 *
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 */

namespace OunziwPagecomment;


// forked from https://github.com/novius/novius_metadata, released under AGPL ver.3 or later
class Renderer_Metadata extends \Nos\Renderer
{
    protected static $DEFAULT_RENDERER_OPTIONS = array(
        'single' => true,
        'select_limit' => 50,
        'metadata_class' => array(),
        'i18n' => array(),
    );

    public static function _init()
    {
        \Nos\I18n::current_dictionary('ounziw_pagecomment::common');
    }

    public function set_value($value, $repopulate = false)
    {
        if (empty($value)) {
            $this->value = null;
            return $this;
        }
        if ($this->isSingle()) {
            if (is_array($value)) {
                $value = array_shift($value);
                $value = $value->id;
            }
            $this->value = $value;
        } else {
            $first = current($value);
            if (is_object($first)) {
                $value = array_keys($value);
            }
            $this->value = $value;
        }
        return $this;
    }

    public function before_save($item, $data)
    {

        if(isset($data['metadata_comment_for_page']))
        {
            $arr = array(
                'ismm' => 327,
                'id' => $data['page_id'],
                'comm_email' => \Session::user()->user_email,
                'comm_content' => $data['metadata_comment_for_page'],
                'comm_author' => \Session::user()->user_name,
                'comm_context' => $item->get_context(),
                'recaptcha_challenge_field' => 1,
                'recaptcha_response_field' => 1,
            );
            $item::commentApi($item->get_context())->addComment($arr);
            $arr['page_title'] = $item->page_title;
            \Event::trigger('ounziw_pagecomment::after_comment', $arr);
        }

        return false;
    }

    /**
     * Build the field
     *
     * @return  string
     */
    public function build()
    {

        $metadata_class = $this->getMetadataClass();
        $nature = \Arr::get($metadata_class, 'nature');
        $nature_model = is_array($nature) ? \Arr::get($nature, 'model', null) : $nature;
        if ($this->label === $this->name) {
            $this->label = strtr(__('{{metadata_class}}:'), array(
                '{{metadata_class}}' => \Arr::get($metadata_class, 'label'),
            ));
        }

        $this->type  = 'textarea';
        $this->value = '';

        $params = array();
        if (is_array($nature) && $query = \Arr::get($nature, 'query', false)) {
            $params = $query;
        }
            $params['where'] = array(
                'comm_foreign_id'    => (int) $this->fieldset()->field('page_id')->value, // get page_id. might be a bad coding.
                'comm_foreign_model'    => 'Nos\Page\Model_Page',
            );
            $params['order_by'] = array('comm_created_at' => 'desc');
            //@TODO $params['limit'] = ;
            
        $natures = $nature_model::find('all', $params);

        return $this->template((string) \View::forge('ounziw_pagecomment::renderer/commentlist', array(
            'natures' => $natures,
    ), false)). parent::build();

    }

    protected function getMetadataClassName()
    {
        return str_replace('metadata_', '', $this->name);
    }

    protected function getMetadataClass()
    {
        return \Arr::get($this->renderer_options, 'metadata_class', array());
    }

    protected function isSingle()
    {
        return \Arr::get($this->renderer_options, 'single', false);
    }
}
