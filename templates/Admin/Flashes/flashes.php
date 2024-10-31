
<div class="wrap">


	<?php foreach($this->getFlashes('success') as $message): ?>
		<div class="em-alert em-alert-success">
			<?php echo esc_html($message); ?>
		</div>
	<?php endforeach; ?>


	<?php foreach($this->getFlashes('danger') as $message): ?>
		<div class="em-alert em-alert-danger">
			<?php echo esc_html($message); ?>
		</div>
	<?php endforeach; ?>


	<?php foreach($this->getFlashes('warning') as $message): ?>
		<div class="em-alert em-alert-warning">
			<?php echo esc_html($message); ?>
		</div>
	<?php endforeach; ?>


	<?php foreach($this->getFlashes('info') as $message): ?>
		<div class="em-alert em-alert-info">
			<?php echo esc_html($message); ?>
		</div>
	<?php endforeach; ?>


</div>
