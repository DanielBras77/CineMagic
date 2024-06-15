<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;


class Purchase_graph extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */


    public function __construct()
    {
        parent::__construct();


        $this->options([
            'scales' => [
                'xAxes' => [[
                    'display' => false,
                    'gridLines' => [
                        'display' => false,
                    ],
                ]],
                'yAxes' => [[]],
            ],
            'legend' => [
                'display' => false,
            ]

        ]);

    }
}
