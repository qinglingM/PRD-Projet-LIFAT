<?php $this->Html->docType(); ?>

<html>
<body>

<p>Au responsable d'équipe,</p>

<p>L'ordre de mission suivant a été sousmis par <?=$first_name?> <?=$name?>.
La mission aura lieu à <?=$lieu?> du <?=$date_d?> au <?=$date_r?> pour le motif :  <?=$motif?></p>

<p>Veuillez valider l'ordre de mission en vous rendant sur le site <?php echo $this->Html->link('site Budget', 'http://odm.li.univ-tours.fr'); ?>.</p>

</body>
</html>