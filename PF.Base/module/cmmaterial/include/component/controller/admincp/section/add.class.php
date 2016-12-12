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
class Cmmaterial_Component_Controller_Admincp_section_Add extends Phpfox_Component
{

    /**
     * Controller
     */
    public function process()
    {

        $bIsEdit = false;
        $oFilter = Phpfox::getLib('parse.input');
        $sType = $oFilter->clean($this->request()->get('req5'));
        if ($iEditId = $this->request()->getInt('id')) {
            $bIsEdit = true;
            $aItem = Phpfox::getService('cmmaterial.section')->get($iEditId);
            $this->template()->assign('aForms', $aItem);
        }

        $aValidation = array(
            'title' => array(
                'def' => 'required',
                'title' => _p('cmmaterial.title_is_required'),
            ),
            'description' => array(
                'def' => 'required',
                'title' => _p('cmmaterial.description_is_required'),
            )
        );

        $bHasImage = false;
        if ($bIsEdit && Phpfox::getService('cmmaterial.section')->hasImage($iEditId)) {
            $bHasImage = true;
        }

        if (!$bHasImage) {
            $aValidation['image'] = array(
                'def' => 'required',
                'title' => _p('cmmaterial.photo_is_required'),
            );
        }

        if ($sType == 'row') {
            $aValidation['background'] = array(
                'def' => 'required',
                'background' => _p('cmmaterial.background_is_required'),
            );
        }

        $oValid = Phpfox_Validator::instance()->set(array(
            'sFormName' => 'cmmaterial_js_section_form',
            'aParams' => $aValidation,
        ));

        if ($aInput = $this->request()->getArray('val')) {
            $aInput['type'] = $sType;
            if ($aImage = $this->request()->get('image')) {
                if (!empty($aImage['name'])) {
                    $aInput['image'] = $aImage['name'];
                }
            }

            if ($oValid->isValid($aInput) && $this->_validateInputLength($aInput)) {
                if ($bIsEdit) {
                    $aInput['section_id'] = $iEditId;
                    if (Phpfox::getService('cmmaterial.section.process')->update($aInput)) {
                        $this->url()->send('admincp.app', ['id' => 'CM_Material', 'sectiontype' => $sType], _p('cmmaterial.section_block_successfully_updated'));
                    }
                } else {
                    if (Phpfox::getService('cmmaterial.section.process')->create($aInput)) {
                        $this->url()->send('admincp.app', ['id' => 'CM_Material', 'sectiontype' => $sType], _p('cmmaterial.section_block_successfully_added'));
                    }
                }
            }
        }
        $this->template()
            ->setTitle($bIsEdit ? _p('cmmaterial.edit_section_block') : _p('cmmaterial.add_section_block'))
            ->setHeader('<style>.apps_menu{display:none;}.apps_content{margin-left: 0px !important;}</style>')
            ->setBreadCrumb($bIsEdit ? _p('cmmaterial.edit_section_block') : _p('cmmaterial.add_section_block'), $this->url()->makeUrl('admincp.app', ['id'=>'CM_Material']))
            ->assign(array(
                'sCreateJs' => $oValid->createJS(),
                'sGetJsForm' => $oValid->getJsForm(),
                'sType' => $sType,
            ));
    }

    /**
     * @param $aVals
     */
    private function _validateInputLength($aVals)
    {
        $iMaxLengTitle = 64;
        if (strlen($aVals['title']) > $iMaxLengTitle) {
            Phpfox_Error::set(_p('cmmaterial.title_can_not_be_larger_than_max_characters', array('max' => $iMaxLengTitle)));
        }

        if (!Phpfox_Error::isPassed()) {
            return false;
        }

        return true;
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_controller_admincp_section_add_clean')) ? eval($sPlugin) : false);
    }
}
