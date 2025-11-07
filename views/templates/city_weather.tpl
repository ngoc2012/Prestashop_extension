<div class="container" style="padding-top:50px;">

    <!-- Weather Card -->
    <div class="panel panel-default" style="padding:20px; margin-bottom:30px;">
        <h1 class="text-center" style="margin-bottom:25px;">🌤️ Weather for {$city->getName()|escape}</h1>
        <p><strong>API:</strong> {$lastHistory->getApi()|escape}</p>
        <p><strong>Temperature:</strong> {$lastHistory->getTemperature()} °C</p>
        <p><strong>Humidity:</strong> {$lastHistory->getHumidity()}%</p>
    </div>

    <!-- Table of Records -->
    <div class="panel panel-default" style="padding:20px;">
        <h2 style="margin-bottom:20px;">Recent Weather Records</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>API</th>
                        <th>Temperature</th>
                        <th>Humidity</th>
                    </tr>
                </thead>
                <tbody>
                {foreach from=$city->getHistory() item=record}
                    <tr>
                        <td class="text-primary">{$record->getCreatedAt()}</td>
                        <td>{$record->getApi()|escape}</td>
                        <td>🌡️ {$record->getTemperature()} °C</td>
                        <td>💧 {$record->getHumidity()}%</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>

    <!-- Return Button -->
    <div class="text-center" style="margin-top:30px;">
        <a href="{$base_url}" class="btn btn-default">← Return to Home</a>
    </div>
</div>