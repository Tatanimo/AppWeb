<?php

namespace App\Services\Mercure;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class MessageService 
{
    public function __construct(private HubInterface $hub)
    {
        
    }

    public function generate(string $uuid, string $content, int $author, String $publication_date, String $type) : bool
    {
        try {
            $update = new Update(
                "messages/$uuid",
                json_encode(['content' => $content, 'authorId' => $author, 'publication_date' => $publication_date, 'type' => $type]),
                true
            );
            
            $this->hub->publish($update);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}