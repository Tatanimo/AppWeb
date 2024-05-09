<?php

namespace App\Services;

use App\Repository\CitiesRepository;
use App\Repository\ProfessionalsRepository;
use App\Repository\ServicesTypeRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CalculatingDistance
{
  public function __construct(private Security $security, private CitiesRepository $citiesRepository, private ProfessionalsRepository $professionalsRepository, private ServicesTypeRepository $servicesTypeRepository){}

  /**
   * Calculates the great-circle distance between two points, with
   * the Haversine formula.
   * @param float $latitudeFrom Latitude of start point in [deg decimal]
   * @param float $longitudeFrom Longitude of start point in [deg decimal]
   * @param float $latitudeTo Latitude of target point in [deg decimal]
   * @param float $longitudeTo Longitude of target point in [deg decimal]
   * @param float $earthRadius Mean earth radius in [m]
   * @return float Distance between points in [m] (same as earthRadius)
   */
  public function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
  {
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);
  
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;
  
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
  }

  private function findByKM(int $id, int $dist) : array {
    $city = $this->citiesRepository->findOneBy(["id" => $id]);
    $allCities = $this->citiesRepository->findAll();

    $cities = [];
    foreach ($allCities as $e) {
        $distanceFromCity = $this->haversineGreatCircleDistance($city->getLatitude(), $city->getLongitude(), $e->getLatitude(), $e->getLongitude());
        if ($distanceFromCity <= $dist) {
            array_push($cities, ["dist" => $distanceFromCity, "id" => $e->getId()]);
        }
    }

    usort($cities, function ($a, $b) {
        return $a["dist"] > $b["dist"];
    });

    return $cities;
  }

  public function getProfessionalsInAreaAndService(string $type, int $idCity, int $km) : array
  {
    $user = $this->security->getUser();
    $service = $this->servicesTypeRepository->findOneBy(["type" => $type]);
    $professionals = $this->professionalsRepository->findBy(["service" => $service]);
    
    
    $searchResult = array_filter($professionals, function($professional) use ($user) {
      return $professional->getId() == $user->getProfessionals()->getId();
    });

    if ($searchResult) {
      unset($professionals[key($searchResult)]);
    }
    
    $cities = $this->findByKM($idCity, $km);
    $idCities = array_column($cities, 'id');
    $professionalsInArea = [];
    foreach ($professionals as $professional) {
        $city = $professional->getCity();
        if (in_array($city->getId(), $idCities)) {
            $key = array_search($city->getId(), $idCities);
            array_push($professionalsInArea, [$professional, $cities[$key]["dist"]]);
        }
    }

    return $professionalsInArea;
  }
}