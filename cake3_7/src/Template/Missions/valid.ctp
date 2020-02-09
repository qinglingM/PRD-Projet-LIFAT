<?php echo $this->Session->flash('email'); ?>
<?php echo $this->Session->flash(); ?>

<h2>Validation</h2>

<?php

echo $this->Form->create($mission);
echo $this->Form->control('id', array('type' => 'hidden'));
echo $this->Form->button(__('Valider '));
echo $this->Form->end();

?>