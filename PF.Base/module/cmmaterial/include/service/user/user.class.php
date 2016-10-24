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
class Cmmaterial_Service_User_User extends Phpfox_Service
{

    private $_sTableFields;
    private $_sTablePhoto;

    public function __construct()
    {
        $this->_sTable = Phpfox::getT('user');
        $this->_sTableFields = Phpfox::getT('user_field');
        $this->_sTablePhoto = Phpfox::getT('photo');
    }

    public function getPopularUsers($iLimit = 9)
    {
        $oCache = $this->cache()->set('popular_users_' . $iLimit);
        $aUsers = $this->cache()->get($oCache, 360);
        if ($aUsers === false) {
            $aUsers = $this->database()->select('u.*,uf.*,(0.3*uf.total_view)+(1*uf.total_friend) AS popular_field')
                ->from($this->_sTableFields, 'uf')
                ->join($this->_sTable, 'u', 'u.user_id = uf.user_id')
                ->order('popular_field DESC')
                ->where("profile_page_id = 0")
                ->limit($iLimit)
                ->execute('getSlaveRows');
            $this->cache()->save($oCache, $aUsers);
        }
        return  $aUsers;
    }
}
