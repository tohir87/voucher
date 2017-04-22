 
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            .card-amount {
                float: right;
                font-size: 12pt;
                font-weight: bold;
            }

            .pin {
                font-size: 18px;
                font-weight: bold;
                text-align: center;
            }
            
            .logo {
                float: right;
                margin-right: 5px;
            }
        </style>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <link rel="icon" href="">

        <title>...</title>

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Bootstrap core CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">


    </head>

    <!-- Body Starte -->

    <body>

        <?php if (!empty($pins)) : ?>

            <?php foreach ($pins as $pin) : ?>

                <div class="col-md-4 col-md-offset-1" style="margin-bottom: 10px; margin-top: 10px; border: 1px solid #000;">
                    <span><?= BUSINESS_NAME; ?> </span>
                    <div class="card-amount">N<?= $pin->amount; ?></div>
                    <div class="card-worth"><?= $pin->provider_name; ?><?= $pin->amount; ?>-<?= $batch_id; ?><?= $count; ?></div>
                    <hr style="margin-top: 2px;margin-bottom: 2px;">
                    <div>
                        <span>PIN No.</span>
                        <span class="pin" style="width: 300px"><?= $pin->pin_code; ?></span>
                        <span class="logo">
                            <img src="/img/<?= strtolower($pin->provider_acronym)?>.jpg" style="max-height: 75px" />
                        </span><br>
                        <span>Serial &nbsp;&nbsp;&nbsp;&nbsp;<?= $pin->pin_serial; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>



        <!-- Bootstrap core JavaScript
        ================================================== -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    </body>
</html>