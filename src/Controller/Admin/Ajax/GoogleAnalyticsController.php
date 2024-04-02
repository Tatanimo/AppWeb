<?php

namespace App\Controller\Admin\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;

class GoogleAnalyticsController extends AbstractController
{
    #[Route('/admin/ajax/google/analytics', name: 'app_admin_ajax_google_analytics')]
    public function fetch(): JsonResponse
    {
        putenv("GOOGLE_APPLICATION_CREDENTIALS=" . $this->getParameter('kernel.project_dir').'/vendor/google/credentials.json');
        $property_id = $_ENV['GOOGLE_PROPERTY_ID'];

        $client = new BetaAnalyticsDataClient();

        $request = (new RunReportRequest())
            ->setProperty('properties/' . $property_id)
            ->setDateRanges([
                new DateRange([
                    'start_date' => '2020-03-31',
                    'end_date' => 'today',
                ]),
            ])
            ->setDimensions([new Dimension([
                    'name' => 'city',
                ]),
            ])
            ->setMetrics([new Metric([
                    'name' => 'activeUsers',
                ])
            ]);
        $response = $client->runReport($request);

        // Print results of an API call.
        print 'Report result: ' . PHP_EOL;

        foreach ($response->getRows() as $row) {
            $var = $row->getDimensionValues()[0]->getValue()
                . ' ' . $row->getMetricValues()[0]->getValue() . PHP_EOL;
        }
        return $this->json($var);
    }
}
