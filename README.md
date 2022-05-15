### Projet camping

## Installation 

Nécéssite composer d'installer et php

``` 
cd camper_appy
composer  req symfony/web-server-bundle --dev
php bin/console server:run
```

## Navigation 

localhost:8000

ou indiqué

localhost:8000

-> Home page

localhost:8000/inscription

pour la création d'un compte
Stockage du token en cookie

localhost:8000/connexion

Pour se connecter
Stockage du token en cookie

localhost:8000/mescampings

Acces aux campings des propriétaires

localhost:8000/camping/ajout

Création d'un camping 

configuration

-> lien api définit dans .env (si à modifier)


Dans src/Controller
les controlleurs


src/Service
CallApiService.php
-> les appels à l'api 


templates 
-> front du site



Lien Git API

https://github.com/Wiltoag/appli-rep-api

