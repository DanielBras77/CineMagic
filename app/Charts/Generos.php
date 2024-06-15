<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;


class Generos extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */


    public function __construct()
    {
        parent::__construct();

        $this->options(['scales'=> ['yAxes' =>
                    ['ticks' => ['beginAtZero' => true,],],],
                     'legend' =>
            [
                'display' => false,
            ]
        ]);
    }
}
