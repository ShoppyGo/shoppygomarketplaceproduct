<strong>{l s="Product sold and shipped from: " d="Modules.Shoppygomarketplaceproduct.Shop"}</strong>
<ul>

    {foreach from=$sellers item=row}
      <a href="{$row.seller_page}">{$row.seller->name}</a>
    {/foreach}
</ul>
