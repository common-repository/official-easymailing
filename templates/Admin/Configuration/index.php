
<div class="wrap columns-2 dd-wrap">
    <h1><?php echo __('Configuración del plugin', 'easymailing') ?></h1>

    <div class="metabox-holder has-right-sidebar">
        <div id="side-info-column" class="inner-sidebar">
            <div class="postbox">
                <?php if ($apiKeyWorking === false) { ?>
                <?php $this->include('Admin/Partials/not_have_account.php') ?>
                <?php } ?>

                <?php $this->include('Admin/Partials/need_help.php') ?>
            </div>
        </div>
        <?php //dump(get_defined_vars ( )) ?>
        <div id="post-body">
            <div id="post-body-content">
                <p class="description"><?php echo __('Para poder empezar a configurar tus formularios necesitas introducir la clave API de Easymailing. Puedes encontrarla en configuración > Claves API', 'easymailing') ?></p>
	            <?php if ($error) { ?>
                    <div class="em-alert em-alert-danger"><?php echo $error ?></div>
	            <?php } ?>
	            <?php if ($apiKeyWorking) { ?>
                    <div class="em-alert em-alert-success"><?php echo __('Tu clave API está configurada correctamente', 'easymailing') ?></div>
	            <?php } ?>

                <form action="" method="post" id="easymailing_config_form">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th><label class="m" for="easymailing_form_api_key"><?php echo __('Clave API', 'easymailing') ?></label></th>
                        <td>
                            <input value="<?php echo $apiKey ?>" type="text" name="easymailing_api_key" id="easymailing_form_api_key" class="regular-text" placeholder="<?php echo __('Tu clave API', 'easymailing') ?>"/>
	                        <?php if ($apiKeyWorking === false) { ?>
                            <p class="description">
	                            <?php echo __('Si necesitas ayuda para encontrar tu clave API', 'easymailing') ?>
                                <a href="https://ayuda.easymailing.com/hc/es/articles/360018017797-C%C3%B3mo-generar-una-clave-API" target="_blank">
	                                <?php echo __('haz clic aquí', 'easymailing') ?>
                                </a>
                            </p>
	                        <?php } ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Guardar', 'easymailing') ?>"></p>
                </form>
            </div>
        </div>
    </div>
</div>



