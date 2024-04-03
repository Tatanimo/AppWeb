<?php

namespace App\Controller\Admin\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunRealtimeReportRequest;
use Google\Analytics\Data\V1beta\Metric;

class GoogleAnalyticsController extends AbstractController
{
    #[Route('/admin/ajax/google/analytics', name: 'app_admin_ajax_google_analytics')]
    public function fetchActiveUsers(): JsonResponse
    {
        putenv("GOOGLE_APPLICATION_CREDENTIALS=" . $this->getParameter('kernel.project_dir').'/google_credentials.json');
        $property_id = $_ENV['GOOGLE_PROPERTY_ID'];

        $client = new BetaAnalyticsDataClient();

        $request = (new RunRealtimeReportRequest())
            ->setProperty('properties/' . $property_id)
            ->setMetrics([new Metric([
                    'name' => 'activeUsers',
                ])
            ]);
        $response = $client->runRealtimeReport($request);

        $var = null;
        foreach ($response->getRows() as $row) {
            $var = $row->getMetricValues()[0]->getValue();
        }
        return $this->json($var);
    }
}
