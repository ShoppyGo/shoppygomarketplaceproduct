<strong> Il prodotto è venduto da:</strong>
<ul>

    {foreach from=$sellers item=row}
      <a href="{$row.seller_page}">{$row.seller->name}</a>
    {/foreach}
</ul>
