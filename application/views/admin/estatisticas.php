<?php

    // Call the Analytics Reporting API V4.
    $response = $this->google->getReport();

    // Print the response.
    $this->google->printResults($response);

?>