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
class CMmaterial_Service_Section_Process extends Phpfox_Service
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('cmmaterial_section');
    }

    private function getInputData($aInput)
    {
        $oFilter = Phpfox::getLib('parse.input');
        $aData = array(
            'title' => $oFilter->clean($aInput['title']),
            'subtitle' => $oFilter->clean((isset($aInput['subtitle']) ? $aInput['subtitle'] : '')),
            'description' => nl2br($oFilter->prepare($aInput['description'])),
            'link' => isset($aInput['link']) ? $aInput['link'] : '',
            'user_id' => Phpfox::getUserId(),
            'type' => $oFilter->clean($aInput['type']),
            'time_stamp' => PHPFOX_TIME,
        );
        if ($aInput['type'] == 'row') {
            $aData['background'] = $oFilter->clean($aInput['background']);
            $aData['image_position'] = $oFilter->clean($aInput['image_position']);
        }

        return $aData;
    }

    public function create($aInput)
    {
        $aData = array_merge(array(
            'server_id' => 0,
            'is_active' => 1,
            'ordering' => Phpfox::getService('cmmaterial.section')->getMaxOrdering() + 1,
        ), $this->getInputData($aInput));

        $iId = $this->database()->insert($this->_sTable, $aData);
        if (!$iId) {
            return false;
        }

        $this->loadImageIfNeeeded($iId);
        return $iId;
    }

    public function update($aInput)
    {
        $aData = $this->getInputData($aInput);
        $iId = (int) $aInput['section_id'];
        $this->database()->update($this->_sTable, $aData, 'section_id = ' . $iId);
        $this->loadImageIfNeeeded($iId);
        return $iId;
    }

    private function loadImageIfNeeeded($iId)
    {
        $oFile = Phpfox_File::instance();
        $bHasImage = $this->hasImage($oFile);

        if ($bHasImage) {
            $sDirImage = Phpfox::getParam('core.dir_pic') . 'cmmaterial'.PHPFOX_DS;
            if (!is_dir($sDirImage)){
                $oFile->mkdir($sDirImage);
            }
            $sFileName = $oFile->upload('image', $sDirImage, $iId);
            $this->database()->update($this->_sTable, array('image_path' => $sFileName), 'section_id = ' . $iId);
            // thumbnails will be created automatically

            $this->database()->update($this->_sTable, array('server_id' => Phpfox_Request::instance()->getServer('PHPFOX_SERVER_ID')), 'section_id = ' . (int) $iId);
        }
    }

    /**
     * @param $oFile
     * @return bool
     */
    private function hasImage($oFile)
    {
        $bHasImage = false;
        if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != '')) {
            $aImage = $oFile->load('image', array('jpg', 'gif', 'png'));
            if ($aImage === false) {
                return false;
            }
            $bHasImage = true;
        }
        return $bHasImage;
    }
    /**
     * @param $iIds
     */
    public function deleteMultiple($iIds)
    {
        foreach ($iIds as $iId) {
            $this->database()->delete($this->_sTable, 'section_id = ' . (int) $iId);
        }

        return true;
    }

    /**
     * @param $iId
     */
    public function delete($iId)
    {
        $this->database()->delete($this->_sTable, 'section_id = ' . (int) $iId);
        return true;
    }

    /**
     * If a call is made to an unknown method attempt to connect
     * it to a specific plug-in with the same name thus allowing
     * plug-in developers the ability to extend classes.
     *
     * @param string $sMethod    is the name of the method
     * @param array  $aArguments is the array of arguments of being passed
     */
    public function __call($sMethod, $aArguments)
    {
        /**
         * Check if such a plug-in exists and if it does call it.
         */
        if ($sPlugin = Phpfox_Plugin::get('cmaterial.service_section_process__call')) {
            eval($sPlugin);
            return;
        }

        /**
         * No method or plug-in found we must throw a error.
         */
        Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
    }
}
