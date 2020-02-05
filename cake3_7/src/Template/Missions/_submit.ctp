<h2>submission</h2>

<?php

echo $this->Form->create('Estimation', array('controller' => 'Mission', 'action' => 'submit'));
echo $this->Form->control('nbNuite', array('label'=>'nombre de nuités'));
echo $this->Form->control('prixNuite', array('label'=>'forfait nuités'));
echo $this->Form->control('nbRepas', array('label'=>'nombre de repas'));
echo $this->Form->control('prixRepas', array('label'=>'forfait repas'));
echo $this->Form->control('coutTrajet', array('label'=>'coût trajet (aller-retour)'));
echo $this->Form->end('Soumettre');

?>
