<?php
    class Analytics_model extends CI_Model{

        public function __construct(){
            parent::__construct();
            // Replace with your view ID. E.g., XXXX.
            $this->VIEW_ID = "168276981";
        }

        public function get_acesso_semanal($startDate, $endDate){
          
            // especifica o tempo
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($startDate);
            $dateRange->setEndDate($endDate);
          
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

            $reports = $this->google->bachtGet($body);

            $result=array();
            $result['attempts'] = $reports['attempts'];

            //echo $reports['attempts'];
            if(!isset($reports['result'])) return $result;

            $result += $this->google->get_metrics($reports['result'][0]);
            $result += array("dimensions" => $this->google->get_dimensions($reports['result'][0]));

            return $result;
        }

        public function get_fontes_trafego(){
            // especifica o tempo
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate("31daysAgo");
            $dateRange->setEndDate("today");
          
            // pede o numero de sessoes e pageviews
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");

            // especifica que é pra separar por data
            $source = new Google_Service_AnalyticsReporting_Dimension();
            $source->setName("ga:source");
          
            // monta a query
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId($this->VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($source));
            $request->setMetrics(array($sessions));
          
            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests( array( $request) );

            $reports = $this->google->bachtGet($body);

            $result=array();
            $result['attempts'] = $reports['attempts'];

            //echo $reports['attempts'];
            if(!isset($reports['result'])) return $result;

            $result += $this->google->get_metrics($reports['result'][0]);
            $result += array("dimensions" => $this->google->get_dimensions($reports['result'][0]));

            return $result;
        }
    }
