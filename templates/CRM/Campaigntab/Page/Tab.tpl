
{if $rows|@count gt 0}
  {strip}
  <table id="options" class="display">
    <thead>
      <tr>
      <th>{ts}Page Title{/ts}</th>
      <th>{ts}Contribution Page / Event{/ts}</th>
      <th>{ts}Status{/ts}</th>
      <th>{ts}Reached{/ts}</th>
      <th>{ts}Targer amount{/ts}</th>
      <th>{ts}Contributions{/ts}</th>
      <th>{ts}Edit{/ts}</th>
      </tr>
    </thead>
    <tbody>
    {foreach from=$rows item=row}
    <tr id="row_{$row.id}" class="{$row.class}">
      <td><a href="{crmURL p='civicrm/pcp/info' q="reset=1&id=`$row.pcpId`" fe='true'}" title="{ts}View Personal Campaign Page{/ts}" target="_blank">{$row.pcpTitle}</a></td>
      <td><a href="{crmURL p='civicrm/contribute/transact' q="reset=1&id=`$row.page_id`" fe='true'}" title="{ts}View page{/ts}" target="_blank">{$row.pageTitle}</td>
      <td>{$row.pcpStatus}</td>
      <td>{$row.pcpReached}</td>
      <td>{$row.pcpAmount}</td>
      <td>{$row.pcpContribations}</td>
      <td><a href="{crmURL p='civicrm/pcp/info' q="action=update&reset=1&id=`$row.pcpId`&component=contribute" fe='true'}" title="{ts}Edit personal campaign page{/ts}" target="_blank">{ts}Edit{/ts}</a></td>
    </tr>
    {/foreach}
    </tbody>
  </table>
  {/strip}
{else}
  <br /><br />
  <center>There is no any Personal campaign page for this contact.</center>
{/if}