<?php
    class Analytics_model extends CI_Model{

        public function __construct(){
            parent::__construct();
            // Replace with your view ID. E.g., XXXX.
            $this->VIEW_ID = "168276981";
        }

        public function get_acessos_semanal(){
          
            // especifica o tempo
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate("7daysAgo");
            $dateRange->setEndDate("today");
          
            // pede o numero de sessoes e pageviews
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");

            $pageviews = new Google_Service_AnalyticsReporting_Metric();
            $pageviews->setExpression("ga:pageviews");
            $pageviews->setAlias("pageviews");

            // especifica que é pra separar por data
            $date = new Google_Service_AnalyticsReporting_Dimension();
            $date->setName("ga:date");
          
            // monta a query
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId($this->VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($date));
            $request->setMetrics(array($sessions, $pageviews));
          
            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests( array( $request) );

            $reports = $this->google->bachtGet( $body );

            return $this->google->build_array($reports);
        }
    }
