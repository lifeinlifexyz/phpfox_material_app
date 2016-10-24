<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright      [PHPFOX_COPYRIGHT]
 * @author         CodeMake.Org
 * @package        Module_CMmaterial
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<h1 class="pull-left"><?php echo _p('Colls');?></h1> <a class="btn btn-primary pull-right" href="{url link='admincp.cmmaterial.section.add.coll'}">{phrase var='cmmaterial.create_one_now'}</a>.
<br>
<hr>
{if count($aSections)}
<div class="table_header">
	{phrase var='cmmaterial.section_row'}
</div>
<form method="post" action="{url link='admincp.cmmaterial.section.row'}">
	<table id="js_drag_drop" cellpadding="0" cellspacing="0">
		<tr>
			<th></th>
			<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
			<th style="width:20px;"></th>
			<th class="t_center" style="width:60px;">{phrase var='cmmaterial.photo'}</th>	
			<th>{phrase var='cmmaterial.title'}</th>
		</tr>
		{foreach from=$aSections key=iKey item=aItem}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td class="drag_handle"><input type="hidden" name="val[ordering][{$aItem.section_id}]" value="{$aItem.ordering}" /></td>
			<td><input type="checkbox" name="id[]" class="checkbox" value="{$aItem.section_id}" id="js_id_row{$aItem.section_id}" /></td>
			<td class="t_center">
				<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						<li><a href="{url link='admincp.cmmaterial.section.add.coll' id=$aItem.section_id}">{phrase var='cmmaterial.edit'}</a></li>
						<li><a href="{url link='admincp.cmmaterial.section.coll' delete=$aItem.section_id}" onclick="return confirm('{phrase var='core.are_you_sure'}');">{phrase var='cmmaterial.delete'}</a></li>
					</ul>
				</div>		
			</td>	
			<td class="t_center">
				{img path='core.url_pic' file='cmmaterial/'.$aItem.image_path server_id=$aItem.server_id suffix='_120' max_width=50}
			</td>		
			<td>{$aItem.title|convert|clean}</td>
		</tr>
		{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" name="delete" value="{phrase var='cmmaterial.delete_selected'}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" />
	</div>
</form>
{else}
<div class="p_4">
	{phrase var='cmmaterial.no_section_have_been_created'}
</div>
{/if}