<div class="container" style="padding-top:50px;">
    <h1 class="text-center" style="margin-bottom:30px;">🌍 All Cities</h1>

    <div class="panel panel-default" style="padding:20px;">
        <ul class="list-group">
        {foreach from=$cities item=city}
            <li class="list-group-item clearfix">
                <span class="pull-left"><strong>{$city->getName()}</strong></span>

                <div class="pull-right">
                    <form method="post" action="{$base_url}" style="display:inline;">
                        <input type="hidden" name="name" value="{$city->getName()}">
                        <input type="hidden" name="api" value="OpenWeatherApi">
                        <input type="hidden" name="id" value="{$city->getId()}">
                        <button type="submit" class="btn btn-info btn-xs">Open Weather</button>
                    </form>

                    <form method="post" action="{$base_url}" style="display:inline;">
                        <input type="hidden" name="name" value="{$city->getName()}">
                        <input type="hidden" name="api" value="FreeWeatherApi">
                        <input type="hidden" name="id" value="{$city->getId()}">
                        <button type="submit" class="btn btn-info btn-xs">Free Weather</button>
                    </form>
                </div>
            </li>
        {/foreach}
        </ul>
    </div>

    <div class="text-center" style="margin-top:20px;">
        <p class="text-muted">Select a city to view the latest weather 🌦️</p>
    </div>
</div>