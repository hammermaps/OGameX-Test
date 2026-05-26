# OGameX TODO Routemap

Diese Datei ordnet alle im Repository gefundenen TODOs nach Priorität, Themenbereich und Abhängigkeiten.
Sie dient als zentrale Planungsgrundlage für die schrittweise Umsetzung offener Aufgaben.

---

## Legende

| Symbol | Bedeutung |
|--------|-----------|
| 🔴 | Kritisch / Sicherheitsrelevant |
| 🟠 | Hoch – Funktionalität fehlt oder ist fehlerhaft |
| 🟡 | Mittel – Verbesserung / Refactoring |
| 🟢 | Niedrig – Tests, Doku, Kleinigkeiten |
| ⬜ | Offen |
| ✅ | Umgesetzt |

---

## Phase 1 – Stabilitäts- & Datenkonsistenz-Grundlage

> Voraussetzung für alle weiteren Phasen. Betrifft DB-Transaktionen, Input-Validierung und grundlegende Service-Absicherung.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🔴 | `app/Services/PlanetService.php` | 1566 | DB-Transaktion-Wrapper hinzufügen |
| 🔴 | `app/Services/PlayerService.php` | 661 | DB-Transaktion-Wrapper hinzufügen |
| 🟠 | `app/Services/BuildingQueueService.php` | 95 | Prüfen, ob eingeloggter User Planetbesitzer ist |
| 🟠 | `app/Services/ResearchQueueService.php` | 128 | Prüfen, ob eingeloggter User Planetbesitzer ist |
| 🟠 | `app/Services/UnitQueueService.php` | 161 | Prüfen, ob eingeloggter User Planetbesitzer ist |
| 🟠 | `app/Http/Controllers/PlanetAbandonController.php` | 96 | Planet-ID explizit übergeben statt implizit auflösen |
| 🟡 | `app/Http/Middleware/GlobalGame.php` | 47 | Race-Condition beim "load player"-Aufruf unter Planet-Update-Locking untersuchen |
| 🟡 | `app/Services/PlanetService.php` | 1593 | Refactor: als `UnitQueueService` abstrahieren |

---

## Phase 2 – Universe- & Settings-Integration

> Globale Einstellungen (Universumsgeschwindigkeit, Aktivitätsanzeige) müssen aus der Datenbank/Config geladen werden statt hartcodiert zu sein.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟠 | `app/Http/Controllers/GalaxyController.php` | 905 | `$universeSpeed = 1` aus Settings laden |
| 🟠 | `app/Http/Controllers/GalaxyController.php` | 996 | `$universeSpeed = 1` aus Settings laden (Duplikat) |
| 🟡 | `app/Http/Controllers/GalaxyController.php` | 762 | Spieleroption „Detaillierte Aktivitätsanzeige" statt hardcoded `showMinutes: true` verwenden |
| 🟡 | `app/Http/Controllers/Abstracts/AbstractBuildingsController.php` | 183 | `$max_build_queue_count = 4` als globale Konstante / Config |
| 🟡 | `app/ViewModels/Queue/Abstracts/QueueListViewModel.php` | 15 | Max-Queue-Größe als admin-konfigurierbares Setting |

---

## Phase 3 – Allianz-System

> Alle TODOs, die das noch nicht implementierte Allianz-System betreffen, werden hier gebündelt.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟠 | `database/migrations/2024_04_08_075348_create_messages_table.php` | 29, 32 | Allianz-Spalten für Nachrichten hinzufügen |
| 🟠 | `database/migrations/2024_05_15_164736_update_messages_table.php` | 32, 36, 70, 73 | Allianz-Spalten (up/down) |
| 🟠 | `resources/views/ingame/alliance/classes.blade.php` | 76 | Allianzklassen-Auswahl und -Aktivierung implementieren |
| 🟡 | `resources/views/ingame/buddies/partials/buddy-list.blade.php` | 48 | Allianz-Tag anzeigen, sobald Allianz-System verfügbar |
| 🟡 | `resources/views/ingame/buddies/partials/ignored-list.blade.php` | 25 | Allianz-Tag anzeigen, sobald Allianz-System verfügbar |
| 🟡 | `resources/js/ingame/e7c74974620fa35b197315ebdbb8c2.js` | 16936, 16946 | Allianz-Chat und Mitgliederliste im Chat-Widget implementieren |

---

## Phase 4 – Kampf & Missionen (ACS / Multi-Angreifer)

> Kampfberichte, ACS-Angriffe und Trümmerfelder sind unvollständig. Diese Phase vervollständigt die Kampflogik.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟠 | `app/GameMissions/AttackMission.php` | 424 | Kampfbericht an alle ACS-Teilnehmer senden, nicht nur Hauptangreifer |
| 🟠 | `app/GameMissions/AttackMission.php` | 663 | Kampfbericht: individuelle Flotten/Verteidiger anzeigen |
| 🟠 | `app/GameMissions/AttackMission.php` | 230 | Reaper-Trümmeranteil bei Multi-Angreifer-Kämpfen einberechnen |
| 🟠 | `app/GameMissions/EspionageMission.php` | 101 | ACS-Defend-Flotten in Gegenspionage-Chance einbeziehen |
| 🟠 | `app/GameMissions/EspionageMission.php` | 466 | ACS-Defend-Flotten im Spionagebericht anzeigen |
| 🟠 | `app/Services/PhalanxService.php` | 319 | ACS-Angriff (Typ 2) in Phalanx-Ergebnissen anzeigen |
| 🟡 | `app/GameMessages/BattleReport.php` | 143 | ACS-Angriff: mehrere Angriffsflotten (eine pro Union-Mitglied) korrekt rendern |
| 🟡 | `app/GameMessages/BattleReport.php` | 244 | Expedition-Trümmerfeld-Sammlung implementieren |
| 🟡 | `app/GameMissions/AttackMission.php` | 278 | Trümmerfeld-Append-Logik in eine einzige DB-Query zusammenführen |
| 🟡 | `app/GameMissions/EspionageMission.php` | 132 | Trümmerfeld-Append-Logik (wie AttackMission) zusammenführen |
| 🟡 | `app/GameMissions/EspionageMission.php` | 457 | Sicherstellen, dass Sondieren von Slot 16 keine Probleme verursacht |
| 🟡 | `app/GameMissions/Abstracts/GameMission.php` | 292 | `calculate` in GameMission-Basisklasse refactoren |

---

## Phase 5 – Mond-System

> Alles, was Mond-Features (Phalanx, Sprungtor) betrifft.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟠 | `app/Services/PlanetService.php` | 2506, 2554 | Phalanx und Sprungtor (50%) nach Mond-Implementierung hinzufügen |
| 🟡 | `app/Http/Controllers/GalaxyController.php` | 261 | `moon_c` erscheint rot (kürzlich zerstört?) – untersuchen |

---

## Phase 6 – Items & Expedition

> Spielitems und Expedition sind noch nicht vollständig implementiert.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟠 | `app/GameMissions/ExpeditionMission.php` | 644 | Tatsächliche Item-Vergabelogik implementieren, wenn Items eingeführt sind |
| 🟠 | `app/GameObjects/Models/Fields/GameObjectProduction.php` | 544 | Item-Boni in Produktion einbeziehen, wenn Items verfügbar sind |
| 🟡 | `app/GameMissions/ExpeditionMission.php` | 577 | Pathfinder-Schiff auskommentieren, wenn verfügbar |
| 🟡 | `resources/views/ingame/galaxy/index.blade.php` | 775 | BBCode-Editor: Item-Dropdown für Spielitems implementieren |
| 🟡 | `resources/views/ingame/highscore/players_points.blade.php` | 195 | BBCode-Editor: Item-Dropdown implementieren |

---

## Phase 7 – Premium / Shop / Charakterklassen

> Dark Matter, Premium-Schiffe, Commander-Features.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟠 | `app/Services/CharacterClassService.php` | 100 | DM-Kosten korrekt über add/subtract-Feature abziehen statt Kostenpfad zu umgehen |
| 🟡 | `app/Http/Controllers/MerchantController.php` | 290 | Zukunftssicherheit für Premium-Schiffe (Reaper: 218, Pathfinder: 219) |
| 🟡 | `resources/views/ingame/admin/developershortcuts.blade.php` | 83 | DM-Shortcuts auf korrektes add/subtract-System umstellen |
| 🟡 | `resources/views/ingame/layouts/main.blade.php` | 1392–1451 | Shop-URLs, Payment-Links, Commander-Links von `#TODO_` auf echte Routen umstellen |
| 🟢 | `resources/lang/de/t_merchant.php` | 89 | „Mehr Rohstoffe erhalten" – implementieren oder Text anpassen |
| 🟢 | `resources/lang/en/t_merchant.php` | 89 | „Get more resources" – implement or update text |
| 🟢 | `resources/lang/nl/t_merchant.php` | 89 | „Get more resources" – nog niet geïmplementeerd |

---

## Phase 8 – Nachrichten-System

> Ungelesene Nachrichten, Mondzerströrungsberichte, Allianz-Nachrichten.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟡 | `app/Http/Controllers/MessagesController.php` | 24, 62 | Anzahl ungelesener Nachrichten aller Tabs in einer einzigen Query abrufen |
| 🟡 | `app/GameMessages/Abstracts/GameMessage.php` | 180 | Footer-Aktionen für Nachrichten implementieren (Planet angreifen, Favorit, etc.) |
| 🟡 | `app/GameMessages/Abstracts/GameMessage.php` | 191 | Footer-Aktionen auf weitere Nachrichtentypen ausweiten |
| 🟡 | `app/Services/BuddyService.php` | 394 | Ignorieren-Funktion mit Nachrichten, Galaxieansicht und Chat integrieren |
| 🟡 | `resources/lang/de/t_messages.php` | 424 | Mondzerströrungsnachrichten korrigieren |
| 🟡 | `resources/lang/en/t_messages.php` | 424 | Moon destruction messages fix |
| 🟢 | `app/Http/Controllers/GalaxyController.php` | 545 | Support-Link in Galaxieansicht mit echtem Messaging-Link ersetzen |
| 🟢 | `resources/views/ingame/layouts/main.blade.php` | 1893 | Changelog-Link von `#TODO_` auf echte Route umstellen |

---

## Phase 9 – Produktions- & Ressourcenberechnungen

> Solar-Satelliten, Speicher, Treibstoff, Ressourcen-Bruch.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟠 | `app/GameObjects/CivilShipObjects.php` | 169 | Solar-Satelliten-Produktion abhängig von Planetposition (Sonnenabstand) berechnen |
| 🟡 | `app/GameObjects/Services/Properties/FuelPropertyService.php` | 22 | Treibstoff-Bonus-/Extra-Berechnung pro Objekt-ID implementieren |
| 🟡 | `app/GameObjects/Services/Properties/Abstracts/ObjectPropertyService.php` | 50, 51 | Aufschlüsselungsmodell für Eigenschaften erweitern (Klassenboni, Premium-Mitglied) |
| 🟡 | `app/Http/Controllers/ResourcesController.php` | 249 | Ressourcen-Neuberechnung nach Wertänderung hinzufügen |
| 🟡 | `app/Http/Traits/ObjectAjaxTrait.php` | 135 | Speicher in neuer Datenstruktur implementieren |
| 🟢 | `app/Services/PlanetService.php` | 786 | Spionage-Logik prüfen: kann sie in `EspionageReport` verschoben werden? |

---

## Phase 10 – Spieler-Aktionslogik (5× unimplementierte Stubs)

> `PlayerService.php` enthält 5 leere Methoden, die noch implementiert werden müssen.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟠 | `app/Services/PlayerService.php` | 937 | Logik hinzufügen |
| 🟠 | `app/Services/PlayerService.php` | 943 | Logik hinzufügen |
| 🟠 | `app/Services/PlayerService.php` | 949 | Logik hinzufügen |
| 🟠 | `app/Services/PlayerService.php` | 955 | Logik hinzufügen |
| 🟠 | `app/Services/PlayerService.php` | 961 | Logik hinzufügen |
| 🟡 | `app/Services/PlayerService.php` | 888 | Potentieller Performance-Engpass: Bulk-Delete für viele Missionen erwägen |

---

## Phase 11 – Fehlerbehandlung & User-Experience

> Exceptions sollen benutzerfreundlich werden, Fehlermeldungen lesbar.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟡 | `app/Services/BuildingQueueService.php` | 75, 115 | Exceptions in benutzerfreundliche Meldungen umwandeln |
| 🟡 | `app/Services/ResearchQueueService.php` | 115, 138 | Exceptions in benutzerfreundliche Meldungen umwandeln |
| 🟡 | `app/Services/WreckFieldService.php` | 1027 | Korrekte Unit-Objekt-Erstellung implementieren |
| 🟡 | `app/Http/Controllers/PlanetAbandonController.php` | 117, 178 | Prüfen, ob `productionBox`-Key in Response benötigt wird |
| 🟢 | `app/Http/Controllers/PlanetMoveController.php` | 28 | Korrektes Template für Planet-Move-Seite hinzufügen |
| 🟢 | `app/Http/Controllers/OverviewController.php` | 121 | `user_honor_points` korrekt implementieren (aktuell hardcoded `0`) |
| 🟢 | `resources/views/ingame/layouts/main.blade.php` | 1044 | Reparaturzeit dynamisch berechnen (Schiffanzahl × Dock-Level) |
| 🟢 | `resources/views/ingame/layouts/main.blade.php` | 42 | Aktuelle Planeteninformationen im Layout aktualisieren |

---

## Phase 12 – Flotten-UI & Placeholder-URLs

> Viele `#TODO_`-Platzhalter-URLs in Blade-Templates müssen durch echte Laravel-Routen ersetzt werden.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟡 | `resources/views/ingame/fleet/index.blade.php` | 30 | Schiffsdaten dynamisch aus `GameObject`-Daten laden |
| 🟡 | `resources/views/ingame/fleet/index.blade.php` | 860, 863 | Tactical-Retreat-Links auf echte Routen umstellen |
| 🟡 | `resources/views/ingame/fleet/index.blade.php` | 908, 1270 | Fleet-Form-Actions auf echte Routen umstellen |
| 🟡 | `resources/views/ingame/fleet/index.blade.php` | 1146 | Synchronisierte Ankunftszeit für ACS-Union dem Spieler anzeigen |
| 🟡 | `resources/views/ingame/defense/index.blade.php` | 48, 70, 71 | Premium/Charakterklassen-URLs auf echte Routen umstellen |
| 🟡 | `resources/views/ingame/facilities/index.blade.php` | 134, 1069, 1070 | Gleiches wie Defense-View |
| 🟢 | `resources/views/ingame/ajax/object.blade.php` | 275 | Premium-Bauqueue-Link auf echte Route umstellen |
| 🟢 | `resources/views/ingame/layouts/main.blade.php` | 283, 310–326, 399, 502 | Weitere Placeholder-Links (LF-Settings, Commander, Admiral, etc.) |
| 🟢 | `resources/views/ingame/buddies/index.blade.php` | 413 | Alte Twig-Logik zusammenführen |

---

## Phase 13 – Tests & Code-Qualität

> Unit-Tests, Feature-Tests und Refactoring für Wartbarkeit.

| Prio | Datei | Zeile | TODO |
|------|-------|-------|------|
| 🟡 | `app/Facades/AppUtil.php` | 136 | Unit-Test für `timeFormatText` schreiben |
| 🟡 | `app/GameMessages/BattleReport.php` | 117, 321 | Feature-Test und Unit-Test für Kampfbericht |
| 🟡 | `app/GameMessages/EspionageReport.php` | 129 | Feature-Test für Spionagebericht |
| 🟡 | `app/GameMissions/ColonisationMission.php` | 84 | Unit-Test für Kolonisationsverhalten |
| 🟡 | `app/Http/Controllers/TechtreeController.php` | 185 | Unit-Test für Speicherberechnung verschiedener Gebäude |
| 🟡 | `app/Services/BuildingQueueService.php` | 327 | Unit-Test für `$time_start`-Edge-Case |
| 🟡 | `app/Services/PlanetService.php` | 275, 1177, 1182 | Feature-Test Planetaufgabe + Unit-Tests für Ressourcen-Bruchteile |
| 🟡 | `app/Services/HighscoreService.php` | 335 | Prüfen: Planetdetails in Highscore-Tabelle speichern? |
| 🟡 | `tests/Feature/FleetDispatch/FleetDispatchAcsDefendTest.php` | 118 | Testarchitektur für `DatabaseTransactions`/`RefreshDatabase` refactoren |
| 🟡 | `tests/Feature/MessagesTest.php` | 232 | Weitere Assertions für Kampfbericht-Inhalt hinzufügen |
| 🟡 | `tests/Unit/BattleEngine/BattleEngineTestAbstract.php` | 453 | Angreifer und Verteidiger im Test trennen (aktuell identischer Spieler) |
| 🟡 | `tests/Unit/ObjectPropertiesTest.php` | 192, 210 | Kapazitäts- und Treibstoff-Property-Tests pro Objekt-ID |
| 🟢 | `app/Services/UnitQueueService.php` | 205 | Abstraktion und Unit-Test für Multiplikationslogik |

---

## Zusammenfassung

| Phase | Thema | TODOs | Prio |
|-------|-------|-------|------|
| 1 | Stabilität & DB-Transaktionen | 8 | 🔴/🟠 |
| 2 | Universe-Settings | 5 | 🟠/🟡 |
| 3 | Allianz-System | 6 | 🟠/🟡 |
| 4 | Kampf & ACS | 12 | 🟠/🟡 |
| 5 | Mond-System | 2 | 🟠/🟡 |
| 6 | Items & Expedition | 5 | 🟠/🟡 |
| 7 | Premium / Shop | 7 | 🟡/🟢 |
| 8 | Nachrichten-System | 8 | 🟡/🟢 |
| 9 | Ressourcenberechnungen | 6 | 🟡/🟢 |
| 10 | Spieler-Aktionsstubs | 6 | 🟠/🟡 |
| 11 | Fehlerbehandlung & UX | 8 | 🟡/🟢 |
| 12 | Flotten-UI & Placeholder-URLs | 9 | 🟡/🟢 |
| 13 | Tests & Code-Qualität | 13 | 🟡/🟢 |
| **Gesamt** | | **~95** | |

---

> Letzte Aktualisierung: 2026-05-26 | Basis: vollständiger TODO-Scan aller Quell-Dateien (ohne `vendor/`, `node_modules/`, kompilierte `public/` Assets)
