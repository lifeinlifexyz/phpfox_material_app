<div class="cover overlay">
	{if isset($aCoverPhoto.server_id)}
		{img server_id=$aCoverPhoto.server_id path='photo.url_photo' file=$aCoverPhoto.destination class="cover_photo cover-image"}
	{else}
	<img src="{$sCoverDefaultUrl}" alt="" class="cover_photo cover-image">
	{/if}
	<div class="overlay-panel vertical-align overlay-background">
		<div class="vertical-align-middle">
			{img user=$aGlobalUser suffix='_50_square'}
			<div class="site-menubar-info">
				<h5 class="site-menubar-user">{$aGlobalUser.full_name}</h5>
				<p class="site-menubar-email">{$aGlobalUser.email}</p>
			</div>
		</div>
	</div>
</div>