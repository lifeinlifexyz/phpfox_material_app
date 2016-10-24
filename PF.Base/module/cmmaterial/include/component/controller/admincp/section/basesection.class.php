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
class Cmmaterial_Component_Controller_Admincp_Section_Basesection extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $oFilter = Phpfox::getLib('parse.input');
        $sType = $oFilter->clean($this->request()->get('req4'));
        $aAllowedTypes = ['row', 'coll'];

        if (!in_array($sType, $aAllowedTypes)) {
            return Phpfox_Error::display(Phpfox::getPhrase('cmmaterial.section_type_not_found', array(), false, 'Not Found'), 404);
        }

        if ($aDeleteIds = $this->request()->getArray('id')) {
            if (Phpfox::getService('cmmaterial.section.process')->deleteMultiple($aDeleteIds)) {
                $this->url()->send('admincp.app', ['id' => 'CM_Material'], Phpfox::getPhrase('cmmaterial.section_s_successfully_deleted'));
            }
        }

        if (($iDelete = $this->request()->getInt('delete'))) {
            if (Phpfox::getService('cmmaterial.section.process')->delete($iDelete)) {
                $this->url()->send('admincp.app', ['id' => 'CM_Material'], Phpfox::getPhrase('cmmaterial.section_successfully_deleted'));
            }
        }

        $aSections = Phpfox::getService('cmmaterial.section')->all($sType);
        $this->template()->setTitle(Phpfox::getPhrase('cmmaterial.manage_sections'))
            ->setBreadCrumb(Phpfox::getPhrase('cmmaterial.manage_sections'), $this->url()->makeUrl('admincp.app', ['id'=>'CM_Material']))
            ->setHeader(array(
                'drag.js' => 'static_script',
                'section.js' => 'module_cmmaterial',
            ))
            ->assign(array(
                'aSections' => $aSections,
            ));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_controller_admincp_sections_clean')) ? eval($sPlugin) : false);
    }
}
