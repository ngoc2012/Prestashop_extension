{$weatherPanel}

<form method="get" action="index.php" class="text-center" style="margin-bottom: 30px;">
    <div class="form-group" style="display: inline-block; margin-right: 10px;">
        <input type="text" name="name" class="form-control" placeholder="Enter city name..." 
               style="width: 250px; display: inline-block;" required>
    </div>

    <input type="hidden" name="controller" value="city" />

    <button type="submit" name="api" value="OpenWeatherApi" class="btn btn-info btn-sm">
        Get from OpenWeather 🌤️
    </button>
    <button type="submit" name="api" value="FreeWeatherApi" class="btn btn-success btn-sm">
        Get from FreeWeather 🌦️
    </button>
</form>

<div class="panel panel-default" style="background-color: transparent;border: none;">
    <div class="panel-body" style="padding: 0;">
        <ul class="list-group">
            {foreach from=$cities item=city}
                <li class="list-group-item" style="background-color: #343a40; color: #f8f9fa; border: 1px solid #6c757d;">
                    <div style="display: table; width: 100%;">
                        <!-- Name on the left -->
                        <span style="display: table-cell; font-weight: bold;">{$city->getName()}</span>

                        <!-- Buttons on the right -->
                        <div style="display: table-cell; text-align: right; white-space: nowrap;">
                            <a href="index.php?name={$city->encodeCityName()}&id={$city->getId()}&api=OpenWeatherApi" 
                               class="btn btn-info btn-xs" style="margin-left: 5px;">
                                Open Weather
                            </a>

                            <a href="index.php?name={$city->encodeCityName()}&id={$city->getId()}&api=FreeWeatherApi" 
                               class="btn btn-success btn-xs" style="margin-left: 5px;">
                                Free Weather
                            </a>
                        </div>
                    </div>
                </li>
            {/foreach}
        </ul>
    </div>
</div>

<div class="text-center" style="margin-top: 30px;">
    <p style="color: #6c757d;">Select a city to view the latest weather 🌦️</p>
</div>
