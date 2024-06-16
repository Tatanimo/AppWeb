<?php

namespace App\Services\Mercure;

use App\Services\UuidSession;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MercureJWTGenerator extends AbstractExtension {
    public function __construct(private UuidSession $uuidSession, private ParameterBagInterface $params, private Security $security)
    {
        
    }

    public function getFunctions() : array
    {
        return [
            new TwigFunction('generateJWT', [$this, 'generateJWT']),
        ];
    }

    public function generateJWT(): String {
        $signingKey = $this->params->get("app.signing_key");
        $time = time() + 3600;
        $header = [ 
            "alg" => "HS256", 
            "typ" => "JWT" 
        ];
        $header = $this->base64_url_encode(json_encode($header));

        $topic = array("alerts/{$this->uuidSession->sessionUuid()}");

        $user = $this->security->getUser();
        if (isset($user)) {
            array_push($topic, "messages/{id}");
            array_push($topic, "notifications/{id}");
        }

        $payload =  [
            "exp" => $time,
            "mercure" => [
                "publish" => $topic,
                "subscribe" => $topic
            ]
        ];
        $payload = $this->base64_url_encode(json_encode($payload));
        $signature = $this->base64_url_encode(hash_hmac('sha256', "$header.$payload", $signingKey, true));
        $jwt = "$header.$payload.$signature";
        return $jwt;    
    }
    
    private function base64_url_encode($text):String{
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
}