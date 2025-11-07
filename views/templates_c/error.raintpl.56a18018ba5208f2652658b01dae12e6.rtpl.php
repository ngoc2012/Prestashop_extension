<?php if(!class_exists('raintpl')){exit;}?><div class="container text-center" style="padding-top:60px;">
    <div class="panel panel-danger" style="padding:40px; max-width:500px; margin:0 auto;">
        <h1 class="text-danger" style="margin-bottom:20px;">⚠️ Error</h1>
        <p class="lead"><?php echo $errorMessage;?></p>
        <a href="/<?php echo $base_url;?>" class="btn btn-default" style="margin-top:20px;">Return to Home</a>
    </div>
</div>
