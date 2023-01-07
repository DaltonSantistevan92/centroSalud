<?php

class DashboardController
{

    public function estadistico()
    {
        include_once 'views/contents/dashboardEstadistico.php';
    }


    public function kpi()
    {
        include_once 'views/contents/dashboardKpi.php';
    }

}