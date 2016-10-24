{if !empty($aItems)}
{foreach from=$aItems item=aItem}
<div class="section-row {$aItem.background} image-{$aItem.image_position}">
    <div class="container-fluid">
        <div class="row">
            {if $aItem.image_position == 'right'}
            <div class="col-md-5">
                <h3 class="title">
                    {if !empty($aItem.link)}
                        <a href="{$aItem.link}" target="_blank">{$aItem.title}</a>
                    {else}
                        {$aItem.title}
                    {/if}
                </h3>
                <h6 class="description">{$aItem.subtitle}</h6>
                <h5 class="description">{$aItem.description}</h5>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <div class="image-container">
                    {if !empty($aItem.link)}
                        <a href="{$aItem.link}" target="_blank">
                            {img server_id=$aItem.server_id title=$aItem.title path='core.url_pic' file='cmmaterial/'.$aItem.image_path}
                        </a>
                    {else}
                        {img server_id=$aItem.server_id title=$aItem.title path='core.url_pic' file='cmmaterial/'.$aItem.image_path}
                    {/if}
                </div>
            </div>
            {else}
            <div class="col-md-7">
                <div class="image-container">
                    {if !empty($aItem.link)}
                        <a href="{$aItem.link}" target="_blank">
                            {img server_id=$aItem.server_id title=$aItem.title path='core.url_pic' file='cmmaterial/'.$aItem.image_path}
                        </a>
                    {else}
                        {img server_id=$aItem.server_id title=$aItem.title path='core.url_pic' file='cmmaterial/'.$aItem.image_path}
                    {/if}
                </div>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <div class="section-description">
                    <h3 class="title">
                        {if !empty($aItem.link)}
                            <a href="{$aItem.link}" target="_blank">
                                {$aItem.title}
                            </a>
                        {else}
                            {$aItem.title}
                        {/if}
                    </h3>
                    <h6 class="description">{$aItem.subtitle}</h6>
                    <h5 class="description">{$aItem.description}</h5>
                </div>
            </div>
            {/if}
        </div>
    </div>
</div>
{/foreach}
{/if}