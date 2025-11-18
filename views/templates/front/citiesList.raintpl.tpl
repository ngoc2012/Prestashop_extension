{include="weatherPanel.raintpl"}

<form method="{$method}" action="index.php" class="text-center" style="margin-bottom: 30px;">
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
			{loop="cities"}
			<li class="list-group-item" style="background-color: #f8f9fa; color : #343a40;border: 1px solid #6c757d;">
				<div style="display: table; width: 100%;">
					<!-- Name on the left -->
					<span style="display: table-cell; font-weight: bold;">{$value->getName()}</span>
					<!-- Buttons on the right -->
					<div style="display: table-cell; text-align: right; white-space: nowrap;">
						{if="$method=='post'"}

						<form method="post" action="index.php" class="form-inline" style="display:inline-block; margin-right:5px;">
							<input type="hidden" name="name" value="{$value->getName()}">
							<input type="hidden" name="api" value="OpenWeatherApi">
							<input type="hidden" name="id" value="{$value->getId()}">
							<button type="submit" class="btn btn-info btn-xs">Open Weather</button>
						</form>

						<form method="post" action="index.php" class="form-inline" style="display:inline-block;">
							<input type="hidden" name="name" value="{$value->getName()}">
							<input type="hidden" name="api" value="FreeWeatherApi">
							<input type="hidden" name="id" value="{$value->getId()}">
							<button type="submit" class="btn btn-success btn-xs">Free Weather</button>
						</form>
						
						{else} 
						
						<a href="index.php?name={$value->encodeCityName()}&id={$value->getId()}&api=OpenWeatherApi" 
							class="btn btn-info btn-xs" style="margin-left: 5px;">
							Open Weather
						</a>
						<a href="index.php?name={$value->encodeCityName()}&id={$value->getId()}&api=FreeWeatherApi" 
							class="btn btn-success btn-xs" style="margin-left: 5px;">
							Free Weather
						</a>
						
						{/if}
					</div>
				</div>
			</li>
			{/loop}
		</ul>
	</div>
</div>

<div class="text-center" style="margin-top: 30px;">
	<p style="color: #6c757d;">Select a city to view the latest weather 🌦️</p>
</div>
