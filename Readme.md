Aplikacja to prosty system do tworzenia produktów i składania zamówień.
Nie implementowałem nelmio/api-doc-bundle, dlatego dokumentacja jest w pliku Insomnia_2024-07-02.json

##Zbuduj obrazy dockera:
 `cd .docker`
 
`docker compose build`

##Zainstaluj zależności:
`docker compose run --rm php composer install`

##Zainicjalizuj bazę danych:
`docker compose run --rm php php bin/console doctrine:schema:create`

## wróć do głównego katalogu
`cd ..`

## Uruchom kontenery:
`make run`

## Aplikacja jest dostępna pod adresem:
`http://localhost:8082`

###wszystkie endpointy są w kolekcji Insomnia_2024-07-02.json
