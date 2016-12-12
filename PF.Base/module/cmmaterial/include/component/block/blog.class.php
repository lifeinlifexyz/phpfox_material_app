<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * @copyright      [PHPFOX_COPYRIGHT]
 * @author         CodeMake.Org
 * @package        Module_CMmaterial
 */
class Cmmaterial_Component_Block_Blog extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        if (!Phpfox::isModule('blog')) {
            return false;
        }

        if (!Phpfox::getUserParam('blog.view_blogs')) {
            return false;
        }

        $aType = $this->_getType();

        $sRequestView = $this->request()->get('view');
        $sView = 'blogs';
        $this->request()->set('view', $sView);

        $aSort = $aType['sort'];

        $sViewMoreUrl = $this->url()->makeUrl('blog', array(
            'view' => $sView,
            'sort' => key($aType['sort']),
        ));

        $ablogDisplays = array(
            Phpfox::getParam('cmmaterial.number_of_blogs'),
        );
        $aSearchParam = array(
            'type' => 'blog',
            'field' => 'blog.blog_id',
            'search_tool' => array(
                'table_alias' => 'blog',
                'sort' => $aSort,
                'show' => (array)$ablogDisplays,
            ),
        );

        $this->search()->browse()->reset();
        $this->search()->reset();

        $this->search()->set($aSearchParam);
        $aBrowseParams = array(
            'module_id' => 'blog',
            'alias' => 'blog',
            'field' => 'blog_id',
            'table' => Phpfox::getT('blog'),
            'hide_view' => array('pending', 'my')
        );

        $aPage = $this->getParam('aPage');
        $sCondition = "AND blog.is_approved = 1 AND blog.post_status = 1" . (Phpfox::getUserParam('privacy.can_comment_on_all_items') ? "" : " AND blog.privacy IN(%PRIVACY%)");
        if (isset($aPage['privacy']) && $aPage['privacy'] == 1) {
            $sCondition = "AND blog.is_approved = 1 AND blog.privacy IN(%PRIVACY%, 1) AND blog.post_status = 1";
        }
        $this->search()->setCondition($sCondition);

        http_cache()->set();

        $this->search()->browse()->params($aBrowseParams)->execute();

        $ablogs = $this->search()->browse()->getRows();
        if (!count($ablogs)) {
            return false;
        }

        foreach ($ablogs as $iKey => $ablog) {
            $ablog['can_view'] = true;
            $ablog['url_photo'] = $this->_getStringBetween($ablog['text'], '[img]', '[/img]');
            $ablog['link'] = Phpfox::permalink('blog', $ablog['blog_id'], $ablog['title']);
            $ablog['parsed_text'] = preg_replace("/\[img\].*\[\/img\]/",'',$ablog['text']);
            $ablogs[$iKey] = $ablog;
        }

        $this->template()->assign(array(
            'sTitle' => $aType['title'],
            'aBlogs' => $ablogs,
            'sViewMoreUrl' => $sViewMoreUrl,
        ));

        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_block_blogs_process')) ? eval($sPlugin) : false);

        // Revert request view
        $this->request()->set('view', $sRequestView);

        return 'block';
    }

    private function _getStringBetween($sStr, $sFrom, $sTo)
    {
        $sSub = substr($sStr, strpos($sStr,$sFrom)+strlen($sFrom),strlen($sStr));
        return  substr($sSub,0,strpos($sSub,$sTo));
    }

    private function _getType()
    {
        $aTypes = array(
            'latest' => array(
                'title' => _p('cmmaterial.latest_blogs'),
                'sort' => array(
                    'latest' => array('blog.blog_id', _p('blog.latest')),
                ),
            ),
            'most_viewed' => array(
                'title' => _p('cmmaterial.most_viewed_blogs'),
                'sort' => array(
                    'most-viewed' => array('blog.total_view', _p('blog.most_viewed')),
                ),
            ),
            'most_discussed' => array(
                'title' => _p('cmmaterial.most_discussed_blogs'),
                'sort' => array(
                    'most-talked' => array('blog.total_comment', _p('blog.most_discussed')),
                ),
            ),
        );

        $sParam = Phpfox::getParam('cmmaterial.blog_sort');

        return isset($aTypes[$sParam]) ? $aTypes[$sParam] : $aTypes['latest'];
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_block_blogs_clean')) ? eval($sPlugin) : false);
    }
}
