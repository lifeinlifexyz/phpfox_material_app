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
class CMmaterial_Service_Section_Section extends Phpfox_Service
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('cmmaterial_section');
    }

    /**
     * @return mixed
     */
    public function getForDisplay($sType, $iLimit = 100)
    {
        $aItems = $this->database()->select('*')
            ->from($this->_sTable)
            ->where("type = '{$sType}' AND is_active = 1")
            ->order('ordering ASC')
            ->limit($iLimit)
            ->execute('getRows');

        return $aItems;
    }

    /**
     * @return mixed
     */
    public function getCount($sType)
    {
        return $this->database()->select('COUNT(*)')
            ->from($this->_sTable)
            ->where("type = '{$sType}'")
            ->execute('getField');
    }

    /**
     * @param  $iId
     * @return mixed
     */
    public function hasImage($iId)
    {
        $sImagePath = $this->database()->select('image_path')
            ->from($this->_sTable)
            ->where('section_id = ' . (int)$iId)
            ->execute('getField');

        return $sImagePath ? true : false;
    }

    /**
     * @return mixed
     */
    public function getMaxOrdering()
    {
        return $this->database()->select('MAX(ordering)')
            ->from($this->_sTable)
            ->execute('getField');
    }

    /**
     * @param  $iId
     * @return mixed
     */
    public function get($iId)
    {
        return $this->database()->select('*')
            ->from($this->_sTable)
            ->where('section_id = ' . (int)$iId)
            ->execute('getRow');
    }

    /**
     * @return mixed
     */
    public function all($sType)
    {
        return $this->database()->select('*')
            ->from($this->_sTable)
            ->where("`type` = '{$sType}'")
            ->order('ordering ASC')
            ->execute('getRows');
    }

    /**
     * If a call is made to an unknown method attempt to connect
     * it to a specific plug-in with the same name thus allowing
     * plug-in developers the ability to extend classes.
     *
     * @param string $sMethod is the name of the method
     * @param array $aArguments is the array of arguments of being passed
     */
    public function __call($sMethod, $aArguments)
    {
        /**
         * Check if such a plug-in exists and if it does call it.
         */
        if ($sPlugin = Phpfox_Plugin::get('ynclean.service_section_section__call')) {
            eval($sPlugin);
            return;
        }

        /**
         * No method or plug-in found we must throw a error.
         */
        Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
    }
}
