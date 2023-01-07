<?php

class ReporteController
{

    public function masEntregado()
    {
        include_once 'views/contents/reporteProductoMasEntregado.php';
    }

    public function pacienteVacunadoCampania()
    {
        include_once 'views/contents/reportePacientesVacunadosCampania.php';
    }

    public function progreso()
    {
        include_once 'views/contents/reporteProgresoVacunasCampania.php';
    }

}