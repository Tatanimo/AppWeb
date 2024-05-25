<?php

namespace App\Services\Mercure;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class NotificationService 
{
    public function __construct(private HubInterface $hub)
    {
        
    }

    public function generate(int $id, string $uuid) : bool
    {
        try {
            $update = new Update(
                "notifications/$id",
                json_encode(['uuid' => $uuid]),
                true
            );
            
            $this->hub->publish($update);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}