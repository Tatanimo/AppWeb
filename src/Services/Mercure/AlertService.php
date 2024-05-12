<?php

namespace App\Services\Mercure;

use App\Services\UuidSession;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class AlertService 
{
    public function __construct(private HubInterface $hub, private UuidSession $uuidSession)
    {
        
    }

    public function generate(string $type, string $title, string $message)
    {
        try {
            $uuid = $this->uuidSession->sessionUuid();
    
            $update = new Update(
                "alerts/$uuid",
                json_encode(['type' => $type, 'flash' => array(['title' => $title, 'message' => $message])]),
                true
            );
            
            $this->hub->publish($update);
        } catch (\Throwable $th) {
           
        }
    }
}