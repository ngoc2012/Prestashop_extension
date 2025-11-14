
<div class="container" style="padding-top: 50px; padding-bottom: 50px;">

    {include file="modules/weather/views/templates/weatherPanel.tpl"}

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
                            <td>{$record->createdAt}</td>
                            <td>{$record->api|escape}</td>
                            <td>🌡️ {$record->temperature} °C</td>
                            <td>💧 {$record->humidity}%</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center" style="margin-top: 20px;">
        <a href="{$homeLink}" class="btn btn-default">← Return to Home</a>
    </div>

</div>