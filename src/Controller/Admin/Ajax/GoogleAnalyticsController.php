<?php

namespace App\Controller\Admin\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunRealtimeReportRequest;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;

class GoogleAnalyticsController extends AbstractController
{
    private BetaAnalyticsDataClient $client;
    private string $property_id;

    public function __construct()
    {
        putenv("GOOGLE_APPLICATION_CREDENTIALS=" . $this->getParameter('kernel.project_dir').'/google_credentials.json');
        $this->property_id = $_ENV['GOOGLE_PROPERTY_ID'];

        $this->client = new BetaAnalyticsDataClient();
    }

    #[Route('/admin/ajax/google/analytics/activeusers', name: 'google_analytics_active_users')]
    public function fetchActiveUsers(): JsonResponse
    {
        $request = (new RunRealtimeReportRequest())
            ->setProperty('properties/' . $this->property_id)
            ->setMetrics([new Metric([
                    'name' => 'activeUsers',
                ])
            ]);
        $response = $this->client->runRealtimeReport($request);

        $users = 0;
        foreach ($response->getRows() as $row) {
            $users = $row->getMetricValues()[0]->getValue();
        }
        return $this->json($users);
    }

    #[Route('/admin/ajax/google/analytics/users', name: 'google_analytics_users')]
    public function fetchUsers(): JsonResponse
    {
        $request = (new RunReportRequest())
            ->setProperty('properties/' . $this->property_id)
            ->setMetrics([new Metric([
                    'name' => 'users',
                ])
            ]);
        $response = $this->client->runReport($request);

        $users = 0;
        foreach ($response->getRows() as $row) {
            $users = $row->getMetricValues()[0]->getValue();
        }
        return $this->json($users);
    }
}
