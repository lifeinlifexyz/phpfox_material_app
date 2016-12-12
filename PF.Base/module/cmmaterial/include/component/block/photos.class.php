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
class Cmmaterial_Component_Block_Photos extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        if (!Phpfox::isModule('photo')) {
            return false;
        }

        if (!Phpfox::getUserParam('photo.can_view_photos')) {
            return false;
        }

        $aType = $this->_getType();

        $sRequestView = $this->request()->get('view');
        $sView = 'photos';
        $this->request()->set('view', $sView);

        $aSort = $aType['sort'];

        $sViewMoreUrl = $this->url()->makeUrl('photo', array(
            'view' => $sView,
            'sort' => key($aType['sort']),
        ));

        $aPhotoDisplays = array(
            Phpfox::getParam('cmmaterial.number_of_photos'),
        );
        $aSearchParam = array(
            'type' => 'photo',
            'field' => 'photo.photo_id',
            'search_tool' => array(
                'table_alias' => 'photo',
                'sort' => $aSort,
                'show' => (array) $aPhotoDisplays,
            ),
        );

        $this->search()->browse()->reset();
        $this->search()->reset();

        $this->search()->set($aSearchParam);
        $aBrowseParams = array(
            'module_id' => 'photo',
            'alias' => 'photo',
            'field' => 'photo_id',
            'table' => Phpfox::getT('photo'),
            'hide_view' => array('pending', 'my'),
        );

        $this->search()->setCondition('AND photo.view_id = 0 AND photo.group_id = 0 AND photo.type_id = 0 AND photo.privacy IN(%PRIVACY%)');

        if (!Phpfox::getParam('photo.display_profile_photo_within_gallery')) {
            $this->search()->setCondition('AND photo.is_profile_photo IN (0)');
        }

        $this->search()->browse()->params($aBrowseParams)->execute();

        $aPhotos = $this->search()->browse()->getRows();

        if (!count($aPhotos)) {
            return false;
        }

        foreach ($aPhotos as $key => $photo) {
            $aPhotos[$key]['can_view'] = true;
            if ($photo['user_id'] != Phpfox::getUserId()) {
                if ($photo['mature'] == 1 && Phpfox::getUserParam(array(
                    'photo.photo_mature_age_limit' => array(
                        '>',
                        (int) Phpfox::getUserBy('age'),
                    ),
                ))) {
                    // warning check cookie
                    $aPhotos[$key]['can_view'] = false;
                } elseif ($photo['mature'] == 2 && Phpfox::getUserParam(array(
                    'photo.photo_mature_age_limit' => array(
                        '>',
                        (int) Phpfox::getUserBy('age'),
                    ),
                ))) {
                    $aPhotos[$key]['can_view'] = false;
                }
            }

            $this->_processItem($aPhotos[$key]);
        }
        $this->template()->assign(array(
            'sTitle' => $aType['title'],
            'aPhotos' => $aPhotos,
            'sViewMoreUrl' => $sViewMoreUrl,
        ));

        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_block_photos_process')) ? eval($sPlugin) : false);

        // Revert request view
        $this->request()->set('view', $sRequestView);

        return 'block';
    }

    /**
     * @param $aPhoto
     */
    private function _processItem(&$aPhoto)
    {
        $aPhoto['original_destination'] = $aPhoto['destination'];
        $aPhoto['destination'] = Phpfox::getService('photo')->getPhotoUrl($aPhoto);

        if ($aPhoto['album_id'] > 0) {
            if ($aPhoto['album_profile_id'] > 0) {
                $aPhoto['album_title'] = _p('photo.profile_pictures');
                $aPhoto['album_url'] = Phpfox::permalink('photo.album.profile', $aPhoto['user_id'], $aPhoto['user_name']);
            } else {
                $aPhoto['album_title'] = $aPhoto['album_name'];
                $aPhoto['album_url'] = Phpfox::permalink('photo.album', $aPhoto['album_id'], $aPhoto['album_title']);
            }
        }
    }

    private function _getType()
    {
        $aTypes = array(
            'latest' => array(
                'title' => _p('cmmaterial.latest_photos'),
                'sort' => array(
                    'latest' => array('photo.photo_id', _p('photo.latest')),
                ),
            ),
            'most_viewed' => array(
                'title' => _p('cmmaterial.most_viewed_photos'),
                'sort' => array(
                    'most-viewed' => array('photo.total_view', _p('photo.most_viewed')),
                ),
            ),
            'most_discussed' => array(
                'title' => _p('cmmaterial.most_discussed_photos'),
                'sort' => array(
                    'most-talked' => array('photo.total_comment', _p('photo.most_discussed')),
                ),
            ),
        );

        $sParam = Phpfox::getParam('cmmaterial.photo_sort');

        return isset($aTypes[$sParam]) ? $aTypes[$sParam] : $aTypes['latest'];
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_block_photos_clean')) ? eval($sPlugin) : false);
    }
}
