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
class Cmmaterial_Component_Ajax_Ajax extends Phpfox_Ajax
{
    public function sectionOrdering()
    {
        Phpfox::isAdmin(true);
        $aVals = $this->get('val');
        Phpfox::getService('core.process')->updateOrdering(array(
            'table' => 'cmmaterial_section',
            'key' => 'section_id',
            'values' => $aVals['ordering'],
        ));
    }
}


