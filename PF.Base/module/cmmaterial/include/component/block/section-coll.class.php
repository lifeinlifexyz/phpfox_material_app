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
class Cmmaterial_Component_Block_Section_Coll extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $this->template()->assign(array(
            'aItems' => Phpfox::getService('cmmaterial.section')->getForDisplay('coll', 3),
        ));
        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_block_section_coll_process')) ? eval($sPlugin) : false);
        return 'block';
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_block_section_col_clean')) ? eval($sPlugin) : false);
    }
}
