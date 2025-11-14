<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    {include file="modules/weather/views/templates/weatherPanel.tpl"}

    <form method="get" action="{$homeLink}" class="text-center" style="margin-bottom: 30px;">
        <div class="form-group" style="display: inline-block; margin-right: 10px;">
            <input type="text" name="name" class="form-control" placeholder="Enter city name..." 
                style="width: 250px; display: inline-block;" required>
        </div>
        <button type="submit" name="api" value="OpenWeatherApi" class="btn btn-info btn-sm">
            Get from OpenWeather 🌤️
        </button>
        <button type="submit" name="api" value="FreeWeatherApi" class="btn btn-success btn-sm">
            Get from FreeWeather 🌦️
        </button>
    </form>

    <!-- ========================================== -->
    <!--         BOOTSTRAP CAROUSEL START           -->
    <!-- ========================================== -->

    <div id="cityWeatherCarousel" class="carousel slide" data-ride="carousel" style="margin-bottom: 40px;">

        <!-- Indicators -->
        <ol class="carousel-indicators">
            {foreach from=$cities item=city name=cityLoop}
                <li data-target="#cityWeatherCarousel"
                    data-slide-to="{$smarty.foreach.cityLoop.index}"
                    class="{if $smarty.foreach.cityLoop.first}active{/if}">
                </li>
            {/foreach}
        </ol>

        <!-- Slides -->
        <div class="carousel-inner" role="listbox">

            {foreach from=$cities item=city name=cityLoop}
            <div class="item {if $smarty.foreach.cityLoop.first}active{/if}">
                <a href="{$homeLink}?name={$city->encodeCityName()}&id_city={$city->id}">
                    <div class="cw-slide text-center" style="padding:40px;">

                        <h3 style="margin-bottom: 15px;">
                            {$city->name}
                        </h3>

                        <!-- temperature if available -->
                        {if isset($city->temperature)}
                            <p style="font-size:22px; font-weight:bold;">
                                {$city->temperature}°C
                            </p>
                        {else}
                            <p style="font-size:16px; color:#888;">
                                No temperature yet
                            </p>
                        {/if}

                        <!-- Buttons -->
                        <div style="margin-top: 15px;">
                            <a href="{$homeLink}?name={$city->encodeCityName()}&id_city={$city->id}&api=OpenWeatherApi"
                                class="btn btn-info btn-xs" style="margin-right: 5px;">
                                Open Weather
                            </a>

                            <a href="{$homeLink}?name={$city->encodeCityName()}&id_city={$city->id}&api=FreeWeatherApi"
                                class="btn btn-success btn-xs">
                                Free Weather
                            </a>
                        </div>

                    </div>
                </a>
            </div>
            {/foreach}

        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#cityWeatherCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>

        <a class="right carousel-control" href="#cityWeatherCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>

    <!-- ========================================== -->
    <!--           BOOTSTRAP CAROUSEL END           -->
    <!-- ========================================== -->


    <div class="text-center" style="margin-top: 30px;">
        <p style="color: #6c757d;">Select a city to view the latest weather 🌦️</p>
    </div>
</div>
