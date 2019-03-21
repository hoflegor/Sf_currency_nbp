# Sf_currency_nbp

## Zadanie rekrutacyjne - programista PHP

> ## Samodzielna nauka Fremeworka symfony. Zadanie wykonane bez zastosowania API REST.

> ### Wstęp

> Firma X zajmuje się sprzedażą produktów przez Internet. Dział IT firmy rozwija równolegle kilka systemów m.in. sklep internetowy, system magazynowy i CRM.

> W najbliższym czasie firma planuje otworzyć się na rynki światowe i udostępnić swoją ofertę dla osób spoza Polski.

> Dział IT firmy X stoi przed dużym wyzwaniem, gdyż dla każdego kraju musi zostać udostępniona dedykowana wersja językowa, a ceny każdego produktu muszą być przedstawione w lokalnej (dla danego kraju) walucie.

> Project manager rozpisał projekt na etapy i każdemu programiście przydzielił zadania do wykonania.

### Zadanie

* Celem Twojego zadania jest przygotowanie mikroserwisu, który udostępni (poprzez API REST) notowania kursów walut dla wszystkich systemów firmy X.

* Jako źródło danych przyjmujemy kursy średnie walut obcych udostępniane przez Narodowy Bank Polski na stronie
nbp.pl

* Mikroserwis musi być gotowy na sprawne obsłużenie dużej ilości żądań dziennie - często będzie to wielokrotne pobranie kursu tej samej waluty.

### Endpointy

Mikroserwis powinien udostępniać następujące endpointy:

* lista dostępnych walut wraz z kodem waluty,

* najnowszy, średni kurs NBP dla wybranej waluty (w parametrach przekazany kod waluty),

* średni kursu dla wybranej waluty, obliczony na podstawie wszystkich pobranych wcześniej (od początku życia usługi) średnich kursów NBP danej waluty (w parametrach przekazany kod waluty).

> ### Dodatkowe wytyczne

> zastosuj dowolnie wybrany, znany Ci framework PHP,

> mikroserwis powinien wykorzystywać warstwę persystencji danych,

> staraj się wykonać zadanie wedle swojej najlepszej wiedzy, oceniane będzie nie tylko to "czy działa", ale także to w jaki sposób zadanie zostało wykonane.



