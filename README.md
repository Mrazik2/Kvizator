# O aplikácii

Kvizátor je webová aplikácia na tvorbu a hranie kvízov vytvorená vo frameworku vaiicko.

Používatelia môžu v základe iba hrať kvízy vytvorené inými používateľmi.
Po registrácii však tiež môžu vytvárať vlastné kvízy, zdieľať ich s ostatnými používateľmi, pozerať štatistiky ich kvízov a vidieť históriu svojich hraní.

# Návod na inštaláciu

1. Naklonovanie repozitára z GitHubu do PHPStorm
2. Spustenie aplikácie docker
3. Spustenie services /docker/docker-compose.yml, čo vytvorí webový server, databázu a adminer pre databázu
4. Pripojenie databázy typu MariaDB do PHPStorm, port 3306, údaje na prihlásenie sú v /docker/.env
5. Importovanie databázovej štruktúry z /docker/sql/tabulky.sql do databázy
6. V prípade potreby import ukážkových dát z /docker/sql/data.sql po importovaní tabuliek
7. Webová aplikácia je dostupná na http://localhost
8. Adminer je dostupný na http://localhost:8080
