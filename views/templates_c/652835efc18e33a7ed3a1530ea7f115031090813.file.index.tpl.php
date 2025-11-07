<?php /* Smarty version Smarty-3.1.19, created on 2025-11-07 14:50:57
         compiled from "/var/www/html/prestashop/prestashop/modules/weather/views/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1431413635690df57db02550-01517409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '652835efc18e33a7ed3a1530ea7f115031090813' => 
    array (
      0 => '/var/www/html/prestashop/prestashop/modules/weather/views/templates/index.tpl',
      1 => 1762523455,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1431413635690df57db02550-01517409',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_690df57db2a334_24124034',
  'variables' => 
  array (
    'cities' => 0,
    'city' => 0,
    'base_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_690df57db2a334_24124034')) {function content_690df57db2a334_24124034($_smarty_tpl) {?><div class="container py-5">
    <h1 class="text-center mb-4">🌍 All Cities</h1>

    <div class="card bg-dark text-light shadow-sm p-4 border-2">
        <ul class="list-group list-group-flush">
        <?php  $_smarty_tpl->tpl_vars['city'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['city']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cities']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['city']->key => $_smarty_tpl->tpl_vars['city']->value) {
$_smarty_tpl->tpl_vars['city']->_loop = true;
?>
            <li class="list-group-item bg-dark text-light border-0 border-bottom border-secondary d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><?php echo $_smarty_tpl->tpl_vars['city']->value->getName();?>
</span>

                <div class="d-flex gap-2 ms-auto">
                    <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
" class="m-0">
                        <input type="hidden" name="name" value="<?php echo $_smarty_tpl->tpl_vars['city']->value->getName();?>
">
                        <input type="hidden" name="api" value="OpenWeatherApi">
                        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['city']->value->getId();?>
">
                        <button type="submit" class="btn btn-outline-info btn-sm">Open Weather</button>
                    </form>

                    <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
" class="m-0">
                        <input type="hidden" name="name" value="<?php echo $_smarty_tpl->tpl_vars['city']->value->getName();?>
">
                        <input type="hidden" name="api" value="FreeWeatherApi">
                        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['city']->value->getId();?>
">
                        <button type="submit" class="btn btn-outline-info btn-sm">Free Weather</button>
                    </form>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>

    <div class="text-center mt-4">
        <p class="text-muted">Select a city to view the latest weather 🌦️</p>
    </div>
</div><?php }} ?>
