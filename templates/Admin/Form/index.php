<div class="wrap">
    <h1><?php echo __('Formularios', 'easymailing') ?></h1>
    <div class="em-mb-3">
        <p class="em-body-size-2"><?php echo __('Selecciona el tipo de formulario que quieres configurar', 'easymailing') ?></p>
    </div>
    <div class="em-card-group">
        <div class="em-card em-position-relative">
            <a class="em-streched-link" href="<?php $this->adminUrl('easymailing_forms_popup') ?>"></a>

            <div class="em-card-title"><?php echo __('Popup', 'easymailing') ?></div>
            <div class="em-card-body">
                <?php echo __('Selecciona un formulario popup para tu sitio web', 'easymailing') ?>
            </div>
            <div class="em-card-image">
                <img class="em-img-responsive" alt="<?php echo __('Popup', 'easymailing') ?>" src="<?php $this->asset('plugin/img/popup.png') ?>">
            </div>
        </div>
        <div class="em-card em-position-relative">
            <a class="em-streched-link" href="<?php $this->adminUrl('easymailing_forms_embedded') ?>"></a>
            <div class="em-card-title"><?php echo __('Incrustado', 'easymailing') ?></div>
            <div class="em-card-body">
                <?php echo __('Añade un formulario en cualquier página de tu sitio web', 'easymailing') ?>
            </div>
            <div class="em-card-image">
                <img class="em-img-responsive" alt="<?php echo __('Incrustado', 'easymailing') ?>" src="<?php $this->asset('plugin/img/embedded.png') ?>">
            </div>
        </div>
    </div>
</div>



