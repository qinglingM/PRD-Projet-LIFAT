<?php $this->Html->docType(); ?>

<html>
<body>

<?php echo "<p>".$nom." ".$prenom."</p>" ?>

<p>L'ordre de mission suivant a été modifié.
La mission aura lieu à <?php echo $lieu; ?> du <?php echo $date_depart; ?> au <?php echo $date_retour; ?> pour le motif suivant :  <?php echo $motif; ?></p>

</body>
</html>
