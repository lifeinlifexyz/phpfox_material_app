{if !empty($aBlogs)}
<div class="section section-blogs">
	<div class="container-fluid">
		<div class="col-md-8 col-md-offset-2">
			<div class="section-description">
				<h2 class="title">{$sTitle}</h2>
				<a href="{$sViewMoreUrl}" class="btn btn-primary btn-round">{phrase var='cmmaterial.view_more'}</a>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			{foreach from=$aBlogs item=aBlog}
			<div class="col-md-4 col-sm-6">
				<div class="card card-plain card-blog">
					<div class="card-image">
						<a href="{$aBlog.link}">
							<span class="img" style="background-image: url({if isset($aBlog.image) && !empty($aBlog.image)}{$aBlog.image}{else}{$aBlog.url_photo}{/if});"></span>
						</a>
					</div>
					<div class="content">
						<h4 class="card-title">
							<a class="card-title" href="{$aBlog.link}">{$aBlog.title}</a>
						</h4>
						<p class="card-description">
							{$aBlog.parsed_text|stripbb|highlight:'search'|split:500|shorten:150:'...'}
							<a href="{$aBlog.link}">More</a>
						</p>
					</div>
				</div>
			</div>
			{/foreach}
		</div>
	</div>

</div>
{/if}