{if !empty($aPhotos)}
<div class="section section-photo">
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
            {foreach from=$aPhotos item=aPhoto}
            <div class="col-md-3  col-sm-6 item">
                <a href="{$aPhoto.link}">
                    {if $aPhoto.can_view}
                    <span class="img" style="background-image: url({img server_id=$aPhoto.server_id path='photo.url_photo' file=$aPhoto.destination suffix='_500' title=$aPhoto.title return_url=true});"></span>
                    {else}
                    <div class="photo_mature photo_mature_{$aPhoto.mature}">
                        <i class="fa fa-warning"></i>
                    </div>
                    {/if}
                </a>
                {if !empty($aPhoto.album_id)}
                <div class="album-title">
                    <a href="{$aPhoto.album_url}">{$aPhoto.album_title|convert|clean|split:45|shorten:75:'...'}</a>
                </div>
                {/if}
            </div>
            {/foreach}
        </div>
    </div>
</div>
{/if}