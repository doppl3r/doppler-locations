<?php
    $periods = array('AM', 'PM');
    $divisions = 2; // 2 = 30 minutes

    // $interval is called before hours.php include, 0 = open, 1 = close
    $time = explode("-", $hours->$day)[$interval]; 

    // Loop through each time options
    foreach($periods as $period) {
        for ($hour = 0; $hour < 12; $hour++) {
            for ($d = 0; $d < $divisions; $d++) {
                $selected = '';
                $h = (($hour + 12) % 12); // Sanitize hour to start at '0'
                $h = ($h == 0) ? 12 : $h; // Fix '12' appearing as '0'
                $m = ($d % $divisions == 0) ? '00' : ($d * (60 / $divisions)) . '';
                $t = $h . ':' . $m . ' ' . $period; // Final time string
                if ($time == $t) $selected = ' selected';
?>
<option value="<?php echo $t; ?>"<?php echo $selected; ?>><?php echo $t; ?></option>
<?php
            }
        }
    }
?>