<?php defined('PHPFOX') or exit('NO DICE!');

/**
 * @copyright      [PHPFOX_COPYRIGHT]
 * @author         CodeMake.Org
 * @package        Module_CMmaterial
 */
class Cmmaterial_Component_Block_Popular_Users extends Phpfox_Component
{

    public function process()
    {
        $aPopularUsers = PhpFox::getService('cmmaterial.user.user')->getPopularUsers();
        foreach ($aPopularUsers as &$aItem) {
            $pUsersInfo = array(
                'title' => $aItem['full_name'],
                'path' => 'core.url_user',
                'file' => $aItem['user_image'],
                'suffix' => '_200_square',
                'width' => 200,
                'height' => 200,
                'no_default' => (Phpfox::getUserId() == $aItem['user_id'] ? false : true),
                'thickbox' => true,
                'class' => 'profile_user_image _size__200',
                'no_link' => true
            );
            $aItem['profile_image'] = Phpfox::getLib('image.helper')->display(array_merge(array('user' => Phpfox::getService('user')->getUserFields(true, $aItem)), $pUsersInfo));
        }
        $this->template()->assign(array(
                'aPopularUsers' => $aPopularUsers
            )
        );
    }
}
