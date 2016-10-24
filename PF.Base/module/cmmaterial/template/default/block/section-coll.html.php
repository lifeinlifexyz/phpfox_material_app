{if !empty($aItems)}
<div class="section-coll">
    <div class="container-fluid">
        <div class="row">
            {foreach from=$aItems item=aItem}
                <div class="col-md-4">
                    <div class="info">
                        <div class="icon">
                            {if !empty($aItem.link)}
                                <a href="{$aItem.link}" target="_blank">
                                    {img path='core.url_pic' file='cmmaterial/'.$aItem.image_path server_id=$aItem.server_id suffix='_120' max_width=62}
                                </a>
                            {else}
                                {img path='core.url_pic' file='cmmaterial/'.$aItem.image_path server_id=$aItem.server_id suffix='_120' max_width=62}
                            {/if}
                        </div>
                        <h4 class="info-title">
                            {if !empty($aItem.link)}
                            <a href="{$aItem.link}" target="_blank">
                                {$aItem.title}
                            </a>
                            {else}
                                {$aItem.title}
                            {/if}
                        </h4>
                        <p>{$aItem.description}</p>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>
{/if}