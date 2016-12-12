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
<div class="table_header">
	{phrase var='cmmaterial.cmmaterial_section_block_details'}
</div>
{$sCreateJs}
<form id="cmmaterial_js_section_form" method="post" action="{url link='current'}" enctype="multipart/form-data" onsubmit="{$sGetJsForm}">

	<div class="table form-group">
		<div class="table_left">
			{required}{phrase var='cmmaterial.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" value="{value id='title' type='input'}" size="30" maxlength="64" />
			<div class="extra_info">
				{phrase var='cmmaterial.material_maximum_64_characters'}
			</div>
		</div>
		<div class="clear"></div>		
	</div>
	{if $sType == 'row'}
	<div class="table form-group">
		<div class="table_left">
			{phrase var='cmmaterial.subtitle'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[subtitle]" value="{value id='subtitle' type='input'}" size="30" maxlength="64" />
			<div class="extra_info">
				{phrase var='cmmaterial.material_maximum_64_characters'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	{/if}
	<div class="table form-group">
		<div class="table_left">
			{required}{phrase var='cmmaterial.description'}:
		</div>
		<div class="table_right">
			<textarea class="form-control" name="val[description]" rows="3" cols="50" maxlength="500" id="description">{value type='textarea' id='description'}</textarea>
		</div>
		<div class="clear"></div>		
	</div>


	<div class="table form-group">
		<div class="table_left">
			{phrase var='cmmaterial.link'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[link]" placeholder="{phrase var='cmmaterial.url'}" value="{value id='link' type='input'}" size="30" />
		</div>
		<div class="clear"></div>		
	</div>


	<div class="table form-group-follow">
		<div class="table_left">
			{required}{phrase var='cmmaterial.photo'}:
		</div>
		<div class="table_right" id="js_submit_upload_image">
			{if isset($aForms.image_path)}
				{img path='core.url_pic' file='cmmaterial/'.$aForms.image_path server_id=$aForms.server_id suffix='_120'}
				<div class="p_4"></div>
			{/if}
			<input type="file" id='image' name="image" accept="image/*"/>
			<div class="extra_info">
				{phrase var='cmmaterial.you_can_upload_a_jpg_gif_or_png_file'}
			</div>
		</div>
	</div>

	{if $sType == 'row'}

	<div class="table form-group">
		<div class="table_left">
			{required}{phrase var='cmmaterial.image_position'}:
		</div>
		<div class="table_right">
			<select name="val[image_position]" id="image_position">
				<option value="left"{value type='select' id='image_position' default='right'}>Left</option>
				<option value="right"{value type='select' id='image_position' default='right'}>Right</option>
			</select>
		</div>
		<div class="clear"></div>
	</div>

	<div class="table form-group">
		<div class="table_left">
			{required}{phrase var='cmmaterial.background'}:
		</div>
		<div class="table_right">
			<select name="val[background]" id="background">
				<option value="white"{value type='select' id='background' default='white'}>White</option>
				<option value="dark"{value type='select' id='background' default='white'}>Dark</option>
			</select>
		</div>
		<div class="clear"></div>
	</div>

	{/if}
	<div class="table_clear">
		<input type="submit" value="{phrase var='cmmaterial.submit'}" class="button btn-primary" />
	</div>
</form>
