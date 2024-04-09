commande pour run le serveur sous windows : $env:MERCURE_PUBLISHER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!'; $env:MERCURE_SUBSCRIBER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!'; $env:MERCURE_EXTRA_DIRECTIVES="cors_origins http://tatanimo"; $env:SERVER_NAME=":3000"; $env:ADDR=":3000"; .\mercure.exe run --config Caddyfile.dev

