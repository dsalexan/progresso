<?php 


class Google{

    public $client;
    public $analytics;

    public function __construct(){

        $this->client = new Google_Client();
        $this->client->setAuthConfig(FCPATH . '/client_secrets.json');
        $this->client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

        // If the user has already authorized this app then get an access token
        // else redirect to ask the user to authorize access to Google Analytics.
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            // Set the access token on the client.
            $this->client->setAccessToken($_SESSION['access_token']);
        
            // Create an authorized analytics service object.
            $this->analytics = new Google_Service_AnalyticsReporting($this->client);
        
            // // Call the Analytics Reporting API V4.
            // $response = getReport($analytics);
        
            // // Print the response.
            // printResults($response);
        
        } else {
            $redirect_uri = base_url('oauth2callback');
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
    }

    function getReport() {

        // Replace with your view ID. E.g., XXXX.
        $VIEW_ID = "168276981";
      
        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate("7daysAgo");
        $dateRange->setEndDate("today");
      
        // Create the Metrics object.
        $sessions = new Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression("ga:sessions");
        $sessions->setAlias("sessions");
      
        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($sessions));
      
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $this->analytics->reports->batchGet( $body );
    }
      
    function printResults($reports) {
        for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();
        
            if(!isset($dimensionHeaders)) $dimensionHeaders = [];
        
            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
            $row = $rows[ $rowIndex ];
            $dimensions = $row->getDimensions();
            $metrics = $row->getMetrics();
            for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
            }
        
            for ($j = 0; $j < count( $metricHeaders ) && $j < count( $metrics ); $j++) {
                $entry = $metricHeaders[$j];
                $values = $metrics[$j];
                print("Metric type: " . $entry->getType() . "\n" );
                for ( $valueIndex = 0; $valueIndex < count( $values->getValues() ); $valueIndex++ ) {
                $value = $values->getValues()[ $valueIndex ];
                print($entry->getName() . ": " . $value . "\n");
                }
            }
            }
        }
    }

}