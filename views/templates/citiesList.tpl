<div class="container" style="padding-top: 50px; padding-bottom: 50px;">

	{include file="./front/weatherPanel.tpl"}

	<form method="{$weather_method}" action="index.php" class="text-center" style="margin-bottom: 30px;">

		<input type="hidden" name="fc" value="module">
		<input type="hidden" name="module" value="weather">
		<input type="hidden" name="controller" value="cityweather">
		<input type="hidden" name="id_lang" value="1">
		<input type="hidden" name="method" value="{$weather_method}">

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

	<div class="panel panel-default" style="background-color: transparent;border: none;">
		<div class="panel-body" style="padding: 0;">
			<ul class="list-group">
				{foreach from=$weather_cities item=city}
				<li class="list-group-item" style="background-color: #f8f9fa; color : #343a40;border: 1px solid #6c757d;">
					<div style="display: table; width: 100%;">
						<!-- Name on the left -->
						<span style="display: table-cell; font-weight: bold;">{$city->name}</span>
						<!-- Buttons on the right -->
						<div style="display: table-cell; text-align: right; white-space: nowrap;">
							{if $weather_method == 'post'}
							
							<form method="post" action="{$weather_link}&method=post" class="form-inline" style="display:inline-block; margin-right:5px;">
								<input type="hidden" name="name" value="{$city->name}">
								<input type="hidden" name="api" value="OpenWeatherApi">
								<input type="hidden" name="id" value="{$city->id}">
								<button type="submit" class="btn btn-info btn-xs">Open Weather</button>
							</form>
							
							<form method="post" action="{$weather_link}&method=post" class="form-inline" style="display:inline-block;">
								<input type="hidden" name="name" value="{$city->name}">
								<input type="hidden" name="api" value="FreeWeatherApi">
								<input type="hidden" name="id" value="{$city->id}">
								<button type="submit" class="btn btn-success btn-xs">Free Weather</button>
							</form>
							
							{else} 
							
							<a href="{$weather_link}&method=get&name={$city->encodeCityName()}&id={$city->id}&api=OpenWeatherApi" 
								class="btn btn-info btn-xs" style="margin-left: 5px;">
								Open Weather
							</a>
							<a href="{$weather_link}&method=get&name={$city->encodeCityName()}&id={$city->id}&api=FreeWeatherApi" 
								class="btn btn-success btn-xs" style="margin-left: 5px;">
								Free Weather
							</a>
							
							{/if}
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
</div>