<?php
    require_once "ScheduleMatches.php";

    const TEAMS = [
        'A' => 'A',
        'B' => 'B',
        'C' => 'C',
        'D' => 'D',
        'E' => 'E',
        'F' => 'F',
        'G' => 'G',
        'H' => 'H'
    ];

    const CITY_MAP = [
        'A' => 'Chennai',
        'B' => 'Bengaluru',
        'C' => 'Mumbai',
        'D' => 'Kolkata',
        'E' => 'Hyderabad',
        'F' => 'Punjab',
        'G' => 'Delhi',
        'H' => 'Rajasthan'
    ];

    $matches = [];
    $date = $_POST['date'] ?? '';
    if($date) {
        $scheduler = new ScheduleMatches($_POST['date'], TEAMS);
        $matches = $scheduler->schedule();
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="author" content="Tharini">
    <meta name="description" content="IPL Scheduler">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">IPL Scheduler</h1>
        </div>
    </div>
    <div id="row">
        <div class="col-md-4" style="float: none; margin: 0 auto;">
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <div class="input-group input-append date">
                        <input type="text" class="form-control mr-3" id="datepicker" name="date" value="<?php echo $date; ?>" readonly style="background-color: #fff;"><span class="add-on"><i class="icon-th"></i></span>
                        <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">Schedule</button>
                            </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Match #</th>
                <th>Date</th>
                <th>Teams</th>
                <th>Venue</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($matches as $date => $match) {
                foreach($match as $m) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d F, Y - l', strtotime($date)); ?></td>
                        <td><?php echo CITY_MAP[$m['home']].' vs '.CITY_MAP[$m['away']]; ?></td>
                        <td><?php echo CITY_MAP[$m['home']]; ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $('#datepicker').datepicker({ format: 'yyyy-mm-dd' });
    </script>
</footer>
</body>

</html>
