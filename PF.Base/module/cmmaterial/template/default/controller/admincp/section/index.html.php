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
{if count($aItems)}
<div class="table_header">
	{phrase var='ynclean.welcome_blocks'}
</div>
<form method="post" action="{url link='admincp.ynclean.welcome'}">
	<table id="js_drag_drop" cellpadding="0" cellspacing="0">
		<tr>
			<th></th>
			<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
			<th style="width:20px;"></th>
			<th class="t_center" style="width:60px;">{phrase var='ynclean.photo'}</th>	
			<th>{phrase var='ynclean.title'}</th>
		</tr>
		{foreach from=$aItems key=iKey item=aItem}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td class="drag_handle"><input type="hidden" name="val[ordering][{$aItem.welcome_id}]" value="{$aItem.ordering}" /></td>
			<td><input type="checkbox" name="id[]" class="checkbox" value="{$aItem.welcome_id}" id="js_id_row{$aItem.welcome_id}" /></td>
			<td class="t_center">
				<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						<li><a href="{url link='admincp.ynclean.welcome.add' id=$aItem.welcome_id}">{phrase var='ynclean.edit'}</a></li>	
						<li><a href="{url link='admincp.ynclean.welcome' delete=$aItem.welcome_id}" onclick="return confirm('{phrase var='core.are_you_sure'}');">{phrase var='ynclean.delete'}</a></li>		
					</ul>
				</div>		
			</td>	
			<td class="t_center">
				{img path='core.url_pic' file='ynclean/'.$aItem.image_path server_id=$aItem.server_id suffix='_120' max_width=50}
			</td>		
			<td>{$aItem.title|convert|clean}</td>
		</tr>
		{/foreach}
	</table>
	<div class="extra_info">
		{phrase var='ynclean.you_can_have_maximum_3_welcome_blocks'}
	</div>
	<div class="table_bottom">
		<input type="submit" name="delete" value="{phrase var='ynclean.delete_selected'}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" />
	</div>
</form>
{else}
<div class="p_4">
	{phrase var='ynclean.no_welcome_blocks_have_been_created'} <a href="{url link='admincp.ynclean.welcome.add'}">{phrase var='ynclean.create_one_now'}</a>.
</div>
{/if}