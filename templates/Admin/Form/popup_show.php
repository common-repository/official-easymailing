<?php $this->include("Admin/Flashes/flashes.php") ?>
<div class="wrap">
    <h1><?php echo __('Formulario Popup', 'easymailing') ?></h1>
    <div class="em-mb-3">
        <p class="em-body-size-2"><?php echo __('Para deshabilitar el formulario o configurar uno nuevo haz clic en eliminar', 'easymailing') ?>.</p>

    </div>
    <div>

        <div class="<?php if(!$config->getPopupForm()){ ?> em-d-none <?php }?> em-position-relative" id="form-container">

            <iframe id="form-iframe" class="em-form-iframe" src="<?php if($config->getPopupForm()){ echo $config->getPopupForm()->url; }?>"></iframe>

        </div>

        <form method="post">
            <input type="hidden" name="_method" value="DELETE">
            <p id="submit-btn" class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Eliminar', 'easymailing') ?>"></p>
        </form>


    </div>
</div>



