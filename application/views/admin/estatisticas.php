<?php

    // Call the Analytics Reporting API V4.
    // $response = $this->google->getReport();
    $response = $this->analytics_model->get_acessos_semanal();

    // Print the response.
    // echo '<pre>'; $this->google->printResults($response); echo '</pre>';
    echo '<pre>'; print_r($response); echo '</pre>';

?>