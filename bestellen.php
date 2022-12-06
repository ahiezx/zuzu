<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellen bij ZuZu</title>
</head>
<body>

    <?php include('components/header.php') ?>
    <?php session_start(); ?>
    <?php
        include('components/database/db.php');
    ?>
	<div class="container-fluid section-1">
	</div>
    <div class='container p-5'>
        <h3>Sushi's Bestellen</h3>
        <!-- Bootstrap form -->
        <form action="bestellen.php" method="post">
            <div class="form-group">
            <?php if(!isset($_POST['fname']) && !isset($_POST['sushi'])) {?>
                <label for="name">Voornaam</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="Voornaam">

                <label for="name">Achternaam</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Achternaam">
            
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">

                <label for="address">Adres</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Adres">

                <label for="postcode">Postcode</label>
                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode">

                <label for="city">Woonplats</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Woonplats">

                <button type="submit" class="btn btn-dark mt-3">Ga naar Sushi's</button>
            <?php } ?>
            <?php if(isset($_POST['fname']) && !isset($_POST['sushi'])) { 
                add_user($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['address'], $_POST['postcode'], $_POST['city']);
            ?>
                <?php $_SESSION['contacts'] = $_POST; ?>
                <?php
                $sushis = get_sushi();
                foreach($sushis as $sushi):
                ?>


                <div class="col-12 col-md-6">
                    <label for="<?= $sushi['id']?>" class="form-label"><?= $sushi['name'], ' - &euro;', $sushi['price'] ?></label>
                    <br><label for="<?= $sushi['id']?>" class="form-label stock">Voorraad: <?= $sushi['amount']?></label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" sushi="0"  name="<?= $sushi['id']?>" id="<?= $sushi['id']?>" min=0 max=<?= $sushi['amount']?>>
                    </div>
                </div>

                <?php endforeach; ?>
                

                <input type="hidden" name="sushi" value="sushi">

                <button type="submit" class="btn btn-dark mt-3">Bestellen</button>
            <?php } ?>
            <?php if(isset($_POST['sushi']) && isset($_SESSION['contacts'])) { ?>
                <h3>Bedankt voor het bestellen bij ZuZu</h3>
                <p>Uw bestelling is succesvol verstuurd.</p>
                <p>Uw bestelling wordt zo snel mogelijk bezorgd.</p>
                <h4>Uw Gegevens</h4>
                <div style="border:1px solid black;padding:15px;">
                <?php
                foreach($_SESSION['contacts'] as $key => $value):
                ?>
                <p style="border-bottom:1px dotted black;"><b><?= ucfirst($key) ?>:</b> <?= $value ?></p>
                <?php endforeach; ?>
                </div>
                <!-- Echo list of sushi using get_sushi_by_id() -->

                <h4 class='mt-4'>Uw bestelling</h4>
                <div style="border:1px solid black;padding:15px;">
                <?php
                $total = 0;
                foreach($_POST as $key => $value):
                    if($key != 'sushi' && $value != 0){
                        $sushi = get_sushi_by_id($key);
                        $total += $sushi['price'] * $value;
                ?>
                <p style="border-bottom:1px dotted black;"><b><?= $sushi['name'], '</b> - &euro;', $sushi['price'], ' - ', $value, 'x' ?></p>
                <?php } endforeach; ?>
                </div>
                <br>
                <p><b>Totaal: &euro;<?= $total ?></b></p>
                
            <?php } ?>
            </div>
    </div>
    <?php include('components/footer.php') ?>
    
</body>
</html>