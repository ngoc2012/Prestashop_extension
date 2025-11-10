
{$weatherPanel}

<div class="panel panel-default" style="background-color: transparent; border: 2px solid #ccc;">
    <div class="panel-heading" style="background-color: transparent; color: #343a40;">
        <h2>Recent Weather Records</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>API</th>
                        <th>Temperature</th>
                        <th>Humidity</th>
                    </tr>
                </thead>
                <tbody>
                {foreach from=$histories item=record}
                    <tr>
                        <td class="text-info">{$record->getCreatedAt()}</td>
                        <td>{$record->getApi()|escape}</td>
                        <td>🌡️ {$record->getTemperature()} °C</td>
                        <td>💧 {$record->getHumidity()}%</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="text-center" style="margin-top: 20px;">
    <a href="index.php" class="btn btn-default">← Return to Home</a>
</div>
