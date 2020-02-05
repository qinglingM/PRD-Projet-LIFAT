<?php echo $this->Session->flash('email'); ?>
<?php echo $this->Session->flash(); ?>

<h2>Validation</h2>

<?php

echo $this->Form->create('Mission',array('controller' => '', 'action'=> ''));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('valider');

?>