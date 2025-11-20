# Weather

### API

FreeWeather return $this->baseUrl . "?key={$this->apiKey}&q={$cityNameEscaped}&aqi=no";

OpenWeatherApi URL: https://api.openweathermap.org/data/2.5/weather?q=Quang+Ninh&units=metric&lang=en&appid=6bd83c8ba20d3606bd49cef93d45f943
FreeWeatherApi URL: http://api.weatherapi.com/v1/current.json?key=d0087dd7e57c4ed5b23142120250411&q=Quang+Ninh&aqi=no

FreeWeather code error:

// {"error":{"code":1006,"message":"No matching location found."}}
// {"error":{"code":2006,"message":"API key is invalid."}}

/home/minh/weather_php_vanilla/app/services/api/FreeWeatherApi.php:48:string '{"location":{"name":"Ninh Quang","region":"","country":"Vietnam","lat":12.4833,"lon":109.1167,"tz_id":"Asia/Ho_Chi_Minh","localtime_epoch":1763658686,"localtime":"2025-11-21 00:11"},"current":{"last_updated_epoch":1763658000,"last_updated":"2025-11-21 00:00","temp_c":23.3,"temp_f":74.0,"is_day":0,"condition":{"text":"Light rain shower","icon":"//cdn.weatherapi.com/weather/64x64/night/353.png","code":1240},"wind_mph":13.4,"wind_kph":21.6,"wind_degree":20,"wind_dir":"NNE","pressure_mb":1013.0,"pressure_in":29'...

/home/minh/weather_php_vanilla/app/services/api/OpenWeatherApi.php:48:string '{"coord":{"lon":105.8412,"lat":21.0245},"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"base":"stations","main":{"temp":18,"feels_like":17.55,"temp_min":18,"temp_max":18,"pressure":1025,"humidity":65,"sea_level":1025,"grnd_level":1024},"visibility":10000,"wind":{"speed":3.04,"deg":358,"gust":6.69},"clouds":{"all":5},"dt":1763658856,"sys":{"type":1,"id":9308,"country":"VN","sunrise":1763680246,"sunset":1763720068},"timezone":25200,"id":1581130,"name":"Hanoi","cod":200}' (length=502)