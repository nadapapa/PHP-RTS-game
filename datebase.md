# Adatbázis
MySQL

## táblák

### users
**feladat:** a felhaszálói fiók adatainak tárolása

- id
- name
- password
- email
- avatar
- rememeber_token
- created_at
- updated_at
- validation_code - *Email-ellenõrzéskor elküldött kód. Törlõdik, ha az érvényesítés sikeres*
- validated - *Alapból 0. Ha az email érvényes 1-re változik*

### user_settings
**feladat:** a felhasználó beállításainak tárolása

- timezone - *a felhasználó idõzónája*
- vacation - *ha a felhasználó ideiglenesen inaktiválja magát, itt tárolódik az idõtartam*


### cities
**feladat:** a városok adatainak tárolása

- id
- name
- grid_id *annak a hexnek az id-je, amin a város van*
- level
- population
- owner - *a tulajdonos felhasználó id-je*



### grid
**feladat:** a térkép adatainak tárolása

- id
- x - *x koordináta*
- y - *y koordináta*
- type - *Az adott terület típusa egy pozitív egész számmal jelölve. A feloldást a táblához tartozó model osztály tárolja*
- owner - *A tulajdonos felhasználó id-je*


## TODO
az alábbi táblák megtervezése:
- egységek
- épületek
- nyersanyagok
- csapatmozgások
- kereskedelmi tranzakciók
- in-game üzenetek

