<?php /* Smarty version Smarty-3.1.19, created on 2025-11-07 16:07:30
         compiled from "/var/www/html/prestashop/prestashop/modules/weather/views/templates/city_weather.tpl" */ ?>
<?php /*%%SmartyHeaderCode:746246068690df845a05221-24609934%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fdb1d2025e83bbf41f80313e4d958da8fb44d5b' => 
    array (
      0 => '/var/www/html/prestashop/prestashop/modules/weather/views/templates/city_weather.tpl',
      1 => 1762528009,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '746246068690df845a05221-24609934',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_690df845aad137_65995999',
  'variables' => 
  array (
    'city' => 0,
    'lastHistory' => 0,
    'record' => 0,
    'base_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_690df845aad137_65995999')) {function content_690df845aad137_65995999($_smarty_tpl) {?><div class="container" style="padding-top:50px;">

    <!-- Weather Card -->
    <div class="panel panel-default" style="padding:20px; margin-bottom:30px;">
        <h1 class="text-center" style="margin-bottom:25px;">🌤️ Weather for <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['city']->value->getName(), ENT_QUOTES, 'UTF-8', true);?>
</h1>
        <p><strong>API:</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lastHistory']->value->getApi(), ENT_QUOTES, 'UTF-8', true);?>
</p>
        <p><strong>Temperature:</strong> <?php echo $_smarty_tpl->tpl_vars['lastHistory']->value->getTemperature();?>
 °C</p>
        <p><strong>Humidity:</strong> <?php echo $_smarty_tpl->tpl_vars['lastHistory']->value->getHumidity();?>
%</p>
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
                <?php  $_smarty_tpl->tpl_vars['record'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['record']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city']->value->getHistory(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['record']->key => $_smarty_tpl->tpl_vars['record']->value) {
$_smarty_tpl->tpl_vars['record']->_loop = true;
?>
                    <tr>
                        <td class="text-primary"><?php echo $_smarty_tpl->tpl_vars['record']->value->getCreatedAt();?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['record']->value->getApi(), ENT_QUOTES, 'UTF-8', true);?>
</td>
                        <td>🌡️ <?php echo $_smarty_tpl->tpl_vars['record']->value->getTemperature();?>
 °C</td>
                        <td>💧 <?php echo $_smarty_tpl->tpl_vars['record']->value->getHumidity();?>
%</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Return Button -->
    <div class="text-center" style="margin-top:30px;">
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
" class="btn btn-default">← Return to Home</a>
    </div>
</div><?php }} ?>
