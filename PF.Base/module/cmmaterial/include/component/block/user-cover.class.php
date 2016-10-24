<?php defined('PHPFOX') or exit('NO DICE!');

/**
 * @copyright      [PHPFOX_COPYRIGHT]
 * @author         CodeMake.Org
 * @package        Module_CMmaterial
 */
class Cmmaterial_Component_Block_User_Cover extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aUser = Phpfox::getService('user')->get(Phpfox::getUserId());
        $aCoverPhoto = Phpfox::getService('photo')->getCoverPhoto($aUser['cover_photo_exists']);
        $this->template()->assign(array(
                'aCoverPhoto' => $aCoverPhoto,
                'sCoverDefaultUrl' => flavor()->active->default_photo('user_cover_default', true),
            )
        );

        return 'block';
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_block_user_cover_clean')) ? eval($sPlugin) : false);
    }
}
