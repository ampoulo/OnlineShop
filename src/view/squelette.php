<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content="initial-scale=1" />
    <link rel='stylesheet' href='skin/screen.css' />


    <title> <?php print_r($this->title); ?> </title>

</head>
<body>
    
    <?php print_r($this->navig()); ?>
    <?php if ($this->feedback !== '') { ?>
	    <div class="feedback"><?php echo $this->feedback; ?></div>
    <?php } ?>  
    <?php print_r($this->content); ?>
    <?php print_r($this->footer()); ?>

</body>
</html>
