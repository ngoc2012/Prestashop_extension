<?php /* Smarty version Smarty-3.1.19, created on 2025-11-07 18:04:49
         compiled from "/var/www/html/prestashop/prestashop/modules/weather/views/templates/error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:819292932690df394d12798-22539652%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b1ab6b3d326084f09671698998fff55b7555a18' => 
    array (
      0 => '/var/www/html/prestashop/prestashop/modules/weather/views/templates/error.tpl',
      1 => 1762535085,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '819292932690df394d12798-22539652',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_690df394d1e6d1_01105229',
  'variables' => 
  array (
    'errorMessage' => 0,
    'base_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_690df394d1e6d1_01105229')) {function content_690df394d1e6d1_01105229($_smarty_tpl) {?><div class="container text-center" style="padding-top:60px;">
    <div class="panel panel-danger" style="padding:40px; max-width:500px; margin:0 auto;">
        <h1 class="text-danger" style="margin-bottom:20px;">⚠️ Error <?php echo @constant('_PS_VERSION_');?>
</h1>
        <p class="lead"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</p>
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
" class="btn btn-default" style="margin-top:20px;">Return to Home</a>
    </div>
</div>
<?php }} ?>
