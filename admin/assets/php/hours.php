<?php
    // TODO: add attribute "selected" from database
    $periods = array('AM', 'PM');
    $divisions = 2; // 2 = 30 minutes

    // Loop through each time options
    foreach($periods as $period) {
        for ($hour = 0; $hour < 12; $hour++) {
            for ($d = 0; $d < $divisions; $d++) {
                $h = (($hour + 12) % 12);
                $h = ($h == 0) ? 12 : $h;
                $m = ($d % $divisions == 0) ? '00' : ($d * (60 / $divisions)) . '';
                $t = $h . ':' . $m . ' ' . $period;
?>
<option value="<?php echo $t; ?>"><?php echo $t; ?></option>
<?php
            }
        }
    }
?>