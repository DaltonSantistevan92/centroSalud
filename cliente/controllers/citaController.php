<?php

class CitaController
{

    public function nueva()
    {
        include_once 'views/contents/nuevaCita.php';
    }

    public function paciente()
    {
        include_once 'views/contents/nuevoPaciente.php';
    }

    public function control()
    {
        include_once 'views/contents/controlCitas.php';
    }

}