<?php if(!class_exists('raintpl')){exit;}?><div class="container" style="padding-top:50px;">
    <h1 class="text-center" style="margin-bottom:30px;">🌍 All Cities</h1>

    <div class="panel panel-default" style="padding:20px;">
        <ul class="list-group">
        <?php $counter1=-1; if( !is_null($cities) && is_array($cities) && sizeof($cities) ) foreach( $cities as $key1 => $value1 ){ $counter1++; ?>

            <li class="list-group-item clearfix">
                <span class="pull-left"><strong><?php echo $value1->getName();?></strong></span>

                <div class="pull-right">
                    <form method="post" action="<?php echo $base_url;?>" style="display:inline;">
                        <input type="hidden" name="name" value="<?php echo $value1->getName();?>">
                        <input type="hidden" name="api" value="OpenWeatherApi">
                        <input type="hidden" name="id" value="<?php echo $value1->getId();?>">
                        <button type="submit" class="btn btn-info btn-xs">Open Weather</button>
                    </form>

                    <form method="post" action="<?php echo $base_url;?>" style="display:inline;">
                        <input type="hidden" name="name" value="<?php echo $value1->getName();?>">
                        <input type="hidden" name="api" value="FreeWeatherApi">
                        <input type="hidden" name="id" value="<?php echo $value1->getId();?>">
                        <button type="submit" class="btn btn-info btn-xs">Free Weather</button>
                    </form>
                </div>
            </li>
        <?php } ?>

        </ul>
    </div>

    <div class="text-center" style="margin-top:20px;">
        <p class="text-muted">Select a city to view the latest weather 🌦️</p>
    </div>
</div>