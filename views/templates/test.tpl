
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