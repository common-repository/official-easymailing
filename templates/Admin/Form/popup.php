<?php $this->include("Admin/Flashes/flashes.php") ?>
<div class="wrap">
    <h1><?php echo __('Formulario Popup', 'easymailing') ?></h1>
    <div class="em-mb-3">
        <p class="em-body-size-2"><?php echo __('Para configurar un formulario tipo popup, tienes que seleccionar primero una audiencia y después el formulario que quieres integrar', 'easymailing') ?>.</p>
        <p class="em-body-size-2"><?php echo __('Si no encuentras el formulario asegúrate de esté publicado desde el panel de control Easymailing', 'easymailing') ?>.</p>
    </div>
    <div>
        <form id="em-popup-form" autocomplete="off" method="post">
            <div class="em-form-group">
                <label for="em-audience-field"><?php echo __('Audiencia', 'easymailing') ?></label>
                <select name="audience_id" id="em-audience-field">
                    <option value=""><?php echo __('Selecciona una audiencia', 'easymailing') ?></option>
                    <?php foreach($audiences as $audience):?>
                    <option <?php if($audience->id === $config->getAudience() ? $config->getAudience()->id : null): echo "selected"; endif; ?> value="<?php echo $audience->id ?>" ><?php echo $audience->title ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="em-form-group <?php if(!$config->getAudience()): echo "em-d-none"; endif;?>" id="suscription-form-div">

                <label for="em-suscription-form-field"><?php echo __('Formulario', 'easymailing') ?></label>
                <select name="suscription_form_id" id="em-suscription-form-field" data-text-empty="<?php echo __('Selecciona un formulario', 'easymailing') ?>">
                    <option value=""><?php echo __('Selecciona un formulario', 'easymailing') ?></option>
	                <?php foreach($popupForms as $popupForm):?>
                        <option <?php if($popupForm->id === $config->getPopupForm()->id): echo "selected"; endif; ?> value="<?php echo $popupForm->id ?>" ><?php echo $popupForm->title ?></option>
	                <?php endforeach; ?>

                </select>
                <div id="no-forms-alert" class="em-d-none em-alert em-alert-warning"><?php echo __('No hay formularios tipo popup en la audiencia seleccionada', 'easymailing') ?></div>
            </div>

            <div class="<?php if(!$config->getPopupForm()){ ?> em-d-none <?php }?> em-position-relative" id="form-container">
                <iframe id="form-iframe" class="em-form-iframe" src="<?php if($config->getPopupForm()){ echo $config->getPopupForm()->url; }?>"></iframe>
            </div>

            <p id="submit-btn" class="submit em-d-none"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Guardar', 'easymailing') ?>"></p>
        </form>
    </div>
</div>



