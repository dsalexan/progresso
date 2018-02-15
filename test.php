<?php
    $this->load->database();
    $output = $this->db->query('SELECT GLOBAL sql_mode');
    echo "<pre>$output</pre>";
?>