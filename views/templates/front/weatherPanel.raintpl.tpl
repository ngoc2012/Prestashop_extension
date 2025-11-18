<div class="panel panel-default" style="background-color: transparent; border: 2px solid #ccc;">
	<div style="background-color: transparent;color: #343a40;" class="panel-heading text-center">
		<h1>🌤️ Weather for {$city->getName()}</h1>
	</div>
	<div class="panel-body">
		<p><strong>API:</strong> {$history->getApi()}</p>
		<p><strong>Temperature:</strong> {$history->getTemperature()} °C</p>
		<p><strong>Humidity:</strong> {$history->getHumidity()}%</p>
	</div>
</div>
