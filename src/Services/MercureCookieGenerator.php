<?php

namespace App\Services;

use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;

class MercureCookieGenerator {
    public function __construct(private string $secret, private UuidSession $uuidSession)
    {
        
    }

    // public function generate(){
    //     $token = (new Builder())
    //     ->set('mercure', ['subscribe' => ["alerts/{$this->uuidSession->sessionUuid()}"]])
    //     ->sign(new Sha256(), $this->secret)
    //     ->getToken(); 
    //     $this->uuidSession->sessionUuid();
    // }
}