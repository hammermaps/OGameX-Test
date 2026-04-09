<?php

return [
    // -------------------------------------------------------------------------
    // Übersichtsseite
    // -------------------------------------------------------------------------

    'overview' => [
        // Planeteninfo-Panel (Schreibmaschinenanimation)
        'diameter'             => 'Durchmesser',
        'temperature'          => 'Temperatur',
        'position'             => 'Position',
        'points'               => 'Punkte',
        'honour_points'        => 'Ehrenpunkte',
        'score_place'          => 'Platz',
        'score_of'             => 'von',

        // Seiten- / Abschnittsüberschriften
        'page_title'           => 'Übersicht',
        'buildings'            => 'Gebäude',
        'research'             => 'Forschung',

        // Planeten-Header-Schaltflächen
        'switch_to_moon'       => 'Zum Mond wechseln',
        'switch_to_planet'     => 'Zum Planeten wechseln',
        'abandon_rename'       => 'Aufgeben/Umbenennen',
        'abandon_rename_title' => 'Planet aufgeben/umbenennen',
    ],

    // -------------------------------------------------------------------------
    // Planetenumsiedlung / Planetenumzug
    // -------------------------------------------------------------------------

    'planet_move' => [
        'resettle_title' => 'Planet umsiedeln',
        'cancel_confirm' => 'Bist du sicher, dass du diese Planetenumsiedlung abbrechen möchtest? Die reservierte Position wird freigegeben.',
        'cancel_success' => 'Die Planetenumsiedlung wurde erfolgreich abgebrochen.',
        'blockers_title' => 'Folgende Dinge stehen deiner Planetenumsiedlung derzeit im Weg:',
        'no_blockers'    => 'Nichts kann die geplante Umsiedlung des Planeten jetzt noch aufhalten.',
        'cooldown_title' => 'Zeit bis zur nächsten möglichen Umsiedlung',
        'to_galaxy'      => 'In Galaxie',
        'relocate'       => 'Umsiedeln',
        'cancel'         => 'abbrechen',
        'explanation'    => 'Die Umsiedlung erlaubt es dir, deine Planeten an eine andere Position in einem entfernten System deiner Wahl zu verlegen.<br /><br />Die eigentliche Umsiedlung findet erst 24 Stunden nach der Aktivierung statt. In dieser Zeit kannst du deine Planeten wie gewohnt nutzen. Ein Countdown zeigt dir, wie viel Zeit bis zur Umsiedlung verbleibt.<br /><br />Sobald der Countdown abgelaufen ist und der Planet versetzt werden soll, darf keine deiner dort stationierten Flotten aktiv sein. Zu diesem Zeitpunkt sollte auch nichts im Bau, nichts in Reparatur und nichts in Forschung sein. Wenn beim Ablauf des Countdowns noch ein Bauauftrag, ein Reparaturauftrag oder eine Flotte aktiv ist, wird die Umsiedlung abgebrochen.<br /><br />Wenn die Umsiedlung erfolgreich ist, werden dir 240.000 Dunkle Materie berechnet. Die Planeten, die Gebäude und die gespeicherten Ressourcen einschließlich des Mondes werden sofort versetzt. Deine Flotten reisen automatisch mit der Geschwindigkeit des langsamsten Schiffes zu den neuen Koordinaten. Das Sprungtor eines umgesiedelten Mondes ist für 24 Stunden deaktiviert.',
    ],

    // -------------------------------------------------------------------------
    // Gemeinsame UI-Zeichenketten (Schaltflächen, Dialog-Beschriftungen)
    // -------------------------------------------------------------------------

    'shared' => [
        'caution' => 'Achtung',
        'yes'     => 'Ja',
        'no'      => 'Nein',
        'error'   => 'Fehler',
    ],

    // -------------------------------------------------------------------------
    // Gemeinsame Gebäudeseiten-Zeichenketten (Ressourcen, Anlagen, Forschung, Werft, Verteidigung)
    // -------------------------------------------------------------------------

    'buildings' => [
        // Status-Tooltips für Gebäudesymbole
        'under_construction'     => 'Im Bau',
        'vacation_mode_error'    => 'Fehler, Spieler befindet sich im Urlaubsmodus',
        'requirements_not_met'   => 'Voraussetzungen nicht erfüllt!',
        'wrong_class'            => 'Falsche Charakterklasse!',
        'no_moon_building'       => 'Du kannst dieses Gebäude nicht auf einem Mond bauen!',
        'not_enough_resources'   => 'Nicht genug Ressourcen!',
        'queue_full'             => 'Warteschlange ist voll',
        'not_enough_fields'      => 'Nicht genug Felder!',
        'shipyard_busy'          => 'Die Werft ist noch beschäftigt',
        'research_in_progress'   => 'Forschung wird gerade durchgeführt!',
        'research_lab_expanding' => 'Forschungslabor wird ausgebaut.',
        'shipyard_upgrading'     => 'Werft wird ausgebaut.',
        'nanite_upgrading'       => 'Nanitenfabrik wird ausgebaut.',
        'max_amount_reached'     => 'Maximale Anzahl erreicht!',
        // Ausbau-Schaltfläche (benannte Parameter: :title, :level)
        'expand_button'          => ':title auf Stufe :level ausbauen',
        // JS-Lokalisierungs-Zeichenketten
        'loca_notice'            => 'Hinweis',
        'loca_demolish'          => 'TECHNOLOGY_NAME wirklich um eine Stufe zurückbauen?',
        'loca_lifeform_cap'      => 'Ein oder mehrere zugehörige Boni sind bereits maximal ausgebaut. Möchtest du trotzdem weiterbauen?',
        'last_inquiry_error'     => 'Deine letzte Aktion konnte nicht verarbeitet werden. Bitte versuche es erneut.',
        'planet_move_warning'    => 'Achtung! Diese Mission könnte noch laufen, wenn der Umsiedlungszeitraum beginnt, und in diesem Fall wird der Vorgang abgebrochen. Möchtest du diesen Auftrag wirklich fortsetzen?',
    ],

    // -------------------------------------------------------------------------
    // Ressourcenseite (Minen / Lagergebäude)
    // -------------------------------------------------------------------------

    'resources_page' => [
        'page_title'    => 'Ressourcen',
        'settings_link' => 'Ressourceneinstellungen',
        'section_title' => 'Ressourcengebäude',
    ],

    // -------------------------------------------------------------------------
    // Anlagenseite
    // -------------------------------------------------------------------------

    'facilities_page' => [
        'page_title'     => 'Anlagen',
        'section_title'  => 'Anlagengebäude',
        'use_jump_gate'  => 'Sprungtor benutzen',
        'jump_gate'      => 'Sprungtor',
        'alliance_depot' => 'Allianzdepot',
        'burn_confirm'   => 'Bist du sicher, dass du dieses Trümmerfeld verbrennen möchtest? Diese Aktion kann nicht rückgängig gemacht werden.',
    ],

    // -------------------------------------------------------------------------
    // Forschungsseite
    // -------------------------------------------------------------------------

    'research_page' => [
        'basic'    => 'Grundlagenforschung',
        'drive'    => 'Antriebsforschung',
        'advanced' => 'Erweiterte Forschungen',
        'combat'   => 'Kampfforschung',
    ],

    // -------------------------------------------------------------------------
    // Werftseite
    // -------------------------------------------------------------------------

    'shipyard_page' => [
        'battleships' => 'Kampfschiffe',
        'civil_ships' => 'Zivilschiffe',
    ],

    // -------------------------------------------------------------------------
    // Verteidigungsseite
    // -------------------------------------------------------------------------

    'defense_page' => [
        'page_title'    => 'Verteidigung',
        'section_title' => 'Verteidigungsanlagen',
    ],

    // -------------------------------------------------------------------------
    // Ressourceneinstellungsseite
    // -------------------------------------------------------------------------

    'resource_settings' => [
        'production_factor'  => 'Produktionsfaktor',
        'recalculate'        => 'Neu berechnen',
        'metal'              => 'Metall',
        'crystal'            => 'Kristall',
        'deuterium'          => 'Deuterium',
        'energy'             => 'Energie',
        'basic_income'       => 'Grundeinkommen',
        'level'              => 'Stufe',
        'number'             => 'Anzahl:',
        'items'              => 'Items',
        'geologist'          => 'Geologe',
        'mine_production'    => 'Minenproduktion',
        'engineer'           => 'Ingenieur',
        'energy_production'  => 'Energieproduktion',
        'character_class'    => 'Charakterklasse',
        'commanding_staff'   => 'Kommandostab',
        'storage_capacity'   => 'Lagerkapazität',
        'total_per_hour'     => 'Gesamt pro Stunde:',
        'total_per_day'      => 'Gesamt pro Tag',
        'total_per_week'     => 'Gesamt pro Woche:',
    ],

    // -------------------------------------------------------------------------
    // Dialog zum Vernichten von Raketen (Anlagenseite)
    // -------------------------------------------------------------------------

    'facilities_destroy' => [
        'silo_description'  => 'Raketensilos werden verwendet, um Interplanetare Raketen und Abfangraketen zu bauen, zu lagern und abzufeuern. Mit jeder Silostufe können fünf Interplanetare Raketen oder zehn Abfangraketen gelagert werden. Eine Interplanetare Rakete beansprucht denselben Platz wie zwei Abfangraketen. Die gleichzeitige Lagerung von Interplanetaren Raketen und Abfangraketen im selben Silo ist erlaubt.',
        'silo_capacity'     => 'Ein Raketensilo auf Stufe :level kann :ipm Interplanetare Raketen oder :abm Abfangraketen aufnehmen.',
        'type'              => 'Typ',
        'number'            => 'Anzahl',
        'tear_down'         => 'abreißen',
        'proceed'           => 'Weiter',
        'enter_minimum'     => 'Bitte gib mindestens eine Rakete zum Vernichten an',
        'not_enough_abm'    => 'Du hast nicht so viele Abfangraketen',
        'not_enough_ipm'    => 'Du hast nicht so viele Interplanetare Raketen',
        'destroyed_success' => 'Raketen erfolgreich vernichtet',
        'destroy_failed'    => 'Raketen konnten nicht vernichtet werden',
        'error'             => 'Ein Fehler ist aufgetreten. Bitte versuche es erneut.',
    ],

    // -------------------------------------------------------------------------
    // Flotteseiten (Flottensenden + Flottenbewegung)
    // -------------------------------------------------------------------------

    'fleet' => [
        // Seiten- / Schrittüberschriften
        'dispatch_1_title'         => 'Flotte schicken I',
        'dispatch_2_title'         => 'Flotte schicken II',
        'dispatch_3_title'         => 'Flotte schicken III',
        'movement_title'           => 'Flottenbewegung',
        'to_movement'              => 'Zur Flottenbewegung',

        // Statusleiste
        'fleets'                   => 'Flotten',
        'expeditions'              => 'Expeditionen',
        'reload'                   => 'Neu laden',
        'clock'                    => 'Uhr',
        'load_dots'                => 'laden...',
        'never'                    => 'Nie',

        // Flottenslot-Info
        'tooltip_slots'            => 'Genutzte/Gesamte Flottenslots',
        'no_free_slots'            => 'Keine Flottenslots verfügbar',
        'tooltip_exp_slots'        => 'Genutzte/Gesamte Expeditionsslots',
        'market_slots'             => 'Angebote',
        'tooltip_market_slots'     => 'Genutzte/Gesamte Handelsflotten',

        // Warnungen / unmögliche Zustände
        'fleet_dispatch'           => 'Flotte schicken',
        'dispatch_impossible'      => 'Flotte schicken nicht möglich',
        'no_ships'                 => 'Auf diesem Planeten befinden sich keine Schiffe.',
        'in_combat'                => 'Die Flotte befindet sich gerade im Kampf.',
        'vacation_error'           => 'Im Urlaubsmodus können keine Flotten abgeschickt werden!',
        'not_enough_deuterium'     => 'Nicht genug Deuterium!',
        'no_target'                => 'Du musst ein gültiges Ziel auswählen.',
        'cannot_send_to_target'    => 'Flotten können nicht zu diesem Ziel geschickt werden.',
        'cannot_start_mission'     => 'Du kannst diese Mission nicht starten.',

        // Statusleistenbeschriftungen (ohne abschließenden Doppelpunkt — im Template ggf. ergänzen)
        'mission_label'            => 'Mission',
        'target_label'             => 'Ziel',
        'player_name_label'        => 'Spielername',
        'no_selection'             => 'Nichts ausgewählt',
        'no_mission_selected'      => 'Keine Mission ausgewählt!',

        // Schritt 1 – Schiffsauswahl
        'combat_ships'             => 'Kampfschiffe',
        'civil_ships'              => 'Zivilschiffe',
        'standard_fleets'          => 'Standardflotten',
        'edit_standard_fleets'     => 'Standardflotten bearbeiten',
        'select_all_ships'         => 'Alle Schiffe auswählen',
        'reset_choice'             => 'Auswahl zurücksetzen',
        'api_data'                 => 'Diese Daten können in einen kompatiblen Kampfsimulator eingegeben werden:',
        'tactical_retreat'         => 'Taktischer Rückzug',
        'tactical_retreat_tooltip' => 'Deuteriumverbrauch pro taktischem Rückzug anzeigen',
        'continue'                 => 'Weiter',
        'back'                     => 'Zurück',

        // Schritt 2 – Zielauswahl
        'origin'                   => 'Herkunft',
        'destination'              => 'Ziel',
        'planet'                   => 'Planet',
        'moon'                     => 'Mond',
        'coordinates'              => 'Koordinaten',
        'distance'                 => 'Entfernung',
        'debris_field'             => 'Trümmerfeld',
        'debris_field_lower'       => 'trümmerfeld',
        'shortcuts'                => 'Abkürzungen',
        'combat_forces'            => 'Kampfkräfte',
        'player_label'             => 'Spieler',
        'player_name'              => 'Spielername',

        // Schritt 3 – Missionsauswahl
        'select_mission'           => 'Mission für Ziel auswählen',
        'bashing_disabled'         => 'Angriffsmissionen wurden aufgrund zu vieler Angriffe auf das Ziel deaktiviert.',

        // Missionsnamen
        'mission_expedition'       => 'Expedition',
        'mission_colonise'         => 'Besiedlung',
        'mission_recycle'          => 'Trümmerfeld abbauen',
        'mission_transport'        => 'Transport',
        'mission_deploy'           => 'Stationierung',
        'mission_espionage'        => 'Spionage',
        'mission_acs_defend'       => 'AKS Verteidigen',
        'mission_attack'           => 'Angriff',
        'mission_acs_attack'       => 'AKS Angriff',
        'mission_destroy_moon'     => 'Mondzerstörung',

        // Missionsbeschreibungen
        'desc_attack'              => 'Greift die Flotte und Verteidigung deines Gegners an.',
        'desc_acs_attack'          => 'Ehrenhaftige Kämpfe können unehrenhaft werden, wenn starke Spieler durch AKS einsteigen. Die Summe der Militärpunkte des Angreifers im Vergleich zur Summe der Militärpunkte des Verteidigers ist hierbei der ausschlaggebende Faktor.',
        'desc_transport'           => 'Transportiert deine Ressourcen zu anderen Planeten.',
        'desc_deploy'              => 'Schickt deine Flotte dauerhaft zu einem anderen Planeten deines Imperiums.',
        'desc_acs_defend'          => 'Verteidige den Planeten deines Verbündeten.',
        'desc_espionage'           => 'Bespitzle die Welten fremder Kaiser.',
        'desc_colonise'            => 'Besiedelt einen neuen Planeten.',
        'desc_recycle'             => 'Schicke deine Recycler zu einem Trümmerfeld, um die dort herumschwimmenden Ressourcen einzusammeln.',
        'desc_destroy_moon'        => 'Zerstört den Mond deines Feindes.',
        'desc_expedition'          => 'Schicke deine Schiffe in die entferntesten Weiten des Alls, um spannende Quests zu absolvieren.',

        // AKS-Angriff – Verbandoverlay
        'fleet_union'              => 'Flottenverbund',
        'union_created'            => 'Flottenverbund erfolgreich erstellt.',
        'union_edited'             => 'Flottenverbund erfolgreich bearbeitet.',
        'err_union_max_fleets'     => 'Es können maximal 16 Flotten angreifen.',
        'err_union_max_players'    => 'Es können maximal 5 Spieler angreifen.',
        'err_union_too_slow'        => 'Du bist zu langsam, um diesem Flottenverbund beizutreten.',
        'err_union_target_mismatch' => 'Deine Flotte muss dasselbe Ziel wie der Flottenverbund ansteuern.',
        'union_name'               => 'Verbundname',
        'buddy_list'               => 'Freundesliste',
        'buddy_list_loading'       => 'Lädt...',
        'buddy_list_empty'         => 'Keine Freunde verfügbar',
        'buddy_list_error'         => 'Freunde konnten nicht geladen werden',
        'search_user'              => 'Spieler suchen',
        'search'                   => 'Suchen',
        'union_user'               => 'Verbundmitglied',
        'invite'                   => 'Einladen',
        'kick'                     => 'Kicken',
        'ok'                       => 'Ok',
        'own_fleet'                => 'Eigene Flotte',

        // Briefingabschnitt (ohne abschließende Doppelpunkte — im Template ggf. ergänzen)
        'briefing'                 => 'Briefing',
        'load_resources'           => 'Ressourcen laden',
        'load_all_resources'       => 'Alle Ressourcen laden',
        'all_resources'            => 'alle Ressourcen',
        'flight_duration'          => 'Flugdauer (einfache Strecke)',
        'federation_duration'      => 'Flugdauer (Flottenverbund)',
        'arrival'                  => 'Ankunft',
        'return_trip'              => 'Rückkehr',
        'speed'                    => 'Geschwindigkeit:',
        'max_abbr'                 => 'max.',
        'hour_abbr'                => 'h',
        'deuterium_consumption'    => 'Deuteriumverbrauch',
        'empty_cargobays'          => 'Leere Laderäume',
        'hold_time'                => 'Haltezeit',
        'expedition_duration'      => 'Expeditionsdauer',
        'cargo_bay'                => 'Laderaum',
        'cargo_space'              => 'Verfügbarer Platz / Max. Laderaumkapazität',
        'send_fleet'               => 'Flotte schicken',
        'retreat_on_defender'      => 'Rückkehr bei Rückzug des Verteidigers',
        'retreat_tooltip'          => 'Wenn diese Option aktiviert ist, zieht sich deine Flotte ebenfalls kampflos zurück, falls dein Gegner flieht.',
        'plunder_food'             => 'Nahrung plündern',

        // Ressourcenbezeichnungen (für das Lokalisierungsobjekt)
        'metal'                    => 'Metall',
        'crystal'                  => 'Kristall',
        'deuterium'                => 'Deuterium',

        // Flottenbewegungsseite
        'fleet_details'            => 'Flottendetails',
        'ships'                    => 'Schiffe',
        'shipment'                 => 'Fracht',
        'recall'                   => 'Zurückrufen',
        'start_time'               => 'Startzeit',
        'time_of_arrival'          => 'Ankunftszeit',
        'deep_space'               => 'Tiefer Weltraum',

        // Ziel- / Spielerstatusanzeigen
        'uninhabited_planet'       => 'Unbewohnter Planet',
        'no_debris_field'          => 'Kein Trümmerfeld',
        'player_vacation'          => 'Spieler im Urlaubsmodus',
        'admin_gm'                 => 'Admin oder GM',
        'noob_protection'          => 'Anfängerschutz',
        'player_too_strong'        => 'Dieser Planet kann nicht angegriffen werden, da der Spieler zu stark ist!',
        'no_moon'                  => 'Kein Mond verfügbar.',
        'no_recycler'              => 'Kein Recycler verfügbar.',
        'no_events'                => 'Es laufen derzeit keine Ereignisse.',
        'planet_already_reserved'  => 'Dieser Planet wurde bereits für eine Umsiedlung reserviert.',
        'max_planet_warning'       => 'Achtung! Im Moment können keine weiteren Planeten besiedelt werden. Für jede neue Kolonie sind zwei Stufen Astrophysik-Forschung erforderlich. Möchtest du deine Flotte trotzdem schicken?',

        // Galaxie / Netzwerk
        'empty_systems'            => 'Leere Systeme',
        'inactive_systems'         => 'Inaktive Systeme',
        'network_on'               => 'Ein',
        'network_off'              => 'Aus',

        // Fehlercodes (in der errorCodeMap verwendet)
        'err_generic'              => 'Ein Fehler ist aufgetreten',
        'err_no_moon'              => 'Fehler, es gibt keinen Mond',
        'err_newbie_protection'    => 'Fehler, Spieler kann wegen Anfängerschutz nicht angesteuert werden',
        'err_too_strong'           => 'Spieler ist zu stark, um angegriffen zu werden',
        'err_vacation_mode'        => 'Fehler, Spieler befindet sich im Urlaubsmodus',
        'err_own_vacation'         => 'Im Urlaubsmodus können keine Flotten abgeschickt werden!',
        'err_not_enough_ships'     => 'Fehler, nicht genug Schiffe verfügbar, sende maximale Anzahl:',
        'err_no_ships'             => 'Fehler, keine Schiffe verfügbar',
        'err_no_slots'             => 'Fehler, keine freien Flottenslots verfügbar',
        'err_no_deuterium'         => 'Fehler, du hast nicht genug Deuterium',
        'err_no_planet'            => 'Fehler, dort ist kein Planet',
        'err_no_cargo'             => 'Fehler, nicht genug Laderaumkapazität',
        'err_multi_alarm'          => 'Multi-Alarm',
        'err_attack_ban'           => 'Angriffsverbot',
    ],

    // -------------------------------------------------------------------------
    // Galaxieseite
    // -------------------------------------------------------------------------

    'galaxy' => [
        // Urlaubsmodus
        'vacation_error'               => 'Du kannst die Galaxieansicht im Urlaubsmodus nicht verwenden!',

        // Navigation / Header
        'system'                       => 'System',
        'go'                           => 'Los!',

        // System-Aktionsschaltflächen
        'system_phalanx'               => 'System-Phalanx',
        'system_espionage'             => 'System-Spionage',
        'discoveries'                  => 'Entdeckungen',
        'discoveries_tooltip'          => 'Entdeckungsmission zu allen möglichen Positionen starten',

        // Header-Statistikzeilen-Beschriftungen
        'probes_short'                 => 'Spio.Sonde',
        'recycler_short'               => 'Recy.',
        'ipm_short'                    => 'IPR.',
        'used_slots'                   => 'Genutzte Slots',

        // Tabellenspaltenüberschriften
        'planet_col'                   => 'Planet',
        'name_col'                     => 'Name',
        'moon_col'                     => 'Mond',
        'debris_short'                 => 'TF',
        'player_status'                => 'Spieler (Status)',
        'alliance'                     => 'Allianz',
        'action'                       => 'Aktion',

        // Expedition / Tiefer-Weltraum-Zeile
        'planets_colonized'            => 'Besiedelte Planeten',
        'expedition_fleet'             => 'Expeditionsflotte',
        'admiral_needed'               => 'Du benötigst einen Admiral, um diese Funktion zu nutzen.',
        'send'                         => 'senden',

        // Legende-Tooltip
        'legend'                       => 'Legende',
        'status_admin_abbr'            => 'A',
        'legend_admin'                 => 'Administrator',
        'status_strong_abbr'           => 's',
        'legend_strong'                => 'stärkerer Spieler',
        'status_noob_abbr'             => 'n',
        'legend_noob'                  => 'schwächerer Spieler (Neuling)',
        'status_outlaw_abbr'           => 'o',
        'legend_outlaw'                => 'Outlaw (vorübergehend)',
        'status_vacation_abbr'         => 'v',
        'vacation_mode'                => 'Urlaubsmodus',
        'status_banned_abbr'           => 'b',
        'legend_banned'                => 'gebannt',
        'status_inactive_abbr'         => 'i',
        'legend_inactive_7'            => '7 Tage inaktiv',
        'status_longinactive_abbr'     => 'I',
        'legend_inactive_28'           => '28 Tage inaktiv',
        'status_honorable_abbr'        => 'hp',
        'legend_honorable'             => 'Ehrenhaftes Ziel',

        // Lokalisierungs-JS-Objekt (eindeutige Galaxie-Zeichenketten)
        'phalanx_restricted'           => 'Die System-Phalanx kann nur von der Allianzklasse Forscher genutzt werden!',
        'astro_required'               => 'Du musst zuerst Astrophysik erforschen.',
        'galaxy_nav'                   => 'Galaxie',
        'activity'                     => 'Aktivität',
        'no_action'                    => 'Keine Aktionen verfügbar.',
        'time_minute_abbr'             => 'm',
        'moon_diameter_km'             => 'Monddurchmesser in km',
        'km'                           => 'km',
        'pathfinders_needed'           => 'Pfadfinder benötigt',
        'recyclers_needed'             => 'Recycler benötigt',
        'mine_debris'                  => 'Abbauen',
        'phalanx_no_deut'              => 'Nicht genug Deuterium für den Phalanxeinsatz.',
        'use_phalanx'                  => 'Phalanx einsetzen',
        'colonize_error'               => 'Es ist nicht möglich, einen Planeten ohne ein Kolonieschiff zu besiedeln.',
        'ranking'                      => 'Rangliste',
        'espionage_report'             => 'Spionagebericht',
        'missile_attack'               => 'Raketenangriff',
        'rank'                         => 'Rang',
        'alliance_member'              => 'Mitglied',
        'alliance_class'               => 'Allianzklasse',
        'espionage_not_possible'       => 'Spionage nicht möglich',
        'espionage'                    => 'Spionage',
        'hire_admiral'                 => 'Admiral anheuern',
        'dark_matter'                  => 'Dunkle Materie',
        'outlaw_explanation'           => 'Wenn du ein Outlaw bist, hast du keinen Angriffsschutz mehr und kannst von allen Spielern angegriffen werden.',
        'honorable_target_explanation' => 'Im Kampf gegen dieses Ziel kannst du Ehrenpunkte erhalten und 50% mehr Beute plündern.',

        // galaxyLoca-JS-Objekt
        'relocate_success'             => 'Die Position wurde für dich reserviert. Die Umsiedlung der Kolonie hat begonnen.',
        'relocate_title'               => 'Planet umsiedeln',
        'relocate_question'            => 'Bist du sicher, dass du deinen Planeten zu diesen Koordinaten umsiedeln möchtest? Zur Finanzierung der Umsiedlung benötigst du :cost Dunkle Materie.',
        'deut_needed_relocate'         => 'Du hast nicht genug Deuterium! Du benötigst 10 Einheiten Deuterium.',
        'fleet_attacking'              => 'Flotte greift an!',
        'fleet_underway'               => 'Flotte ist unterwegs',
        'discovery_send'               => 'Erkundungsschiff entsenden',
        'discovery_success'            => 'Erkundungsschiff entsandt',
        'discovery_unavailable'        => 'Du kannst kein Erkundungsschiff zu diesem Ort entsenden.',
        'discovery_underway'           => 'Ein Erkundungsschiff ist bereits auf dem Weg zu diesem Planeten.',
        'discovery_locked'             => 'Du hast die Forschung zum Entdecken neuer Lebensformen noch nicht freigeschaltet.',
        'discovery_title'              => 'Erkundungsschiff',
        'discovery_question'           => 'Möchtest du ein Erkundungsschiff zu diesem Planeten entsenden?<br/>Metall: 5000 Kristall: 1000 Deuterium: 500',

        // Phalanx-Ergebnis-Dialog (JS-Zeichenketten im Blade-Script-Block)
        'sensor_report'                => 'Sensorbericht',
        'refresh'                      => 'Aktualisieren',
        'arrived'                      => 'Angekommen',

        // Raketenangriff-Dialog
        'target'                       => 'Ziel',
        'flight_duration'              => 'Flugdauer',
        'ipm_full'                     => 'Interplanetare Raketen',
        'primary_target'               => 'Primärziel',
        'no_primary_target'            => 'Kein Primärziel ausgewählt: zufälliges Ziel',
        'target_has'                   => 'Ziel hat',
        'abm_full'                     => 'Abfangraketen',
        'fire'                         => 'Feuern',
        'valid_missile_count'          => 'Bitte gib eine gültige Raketenzahl ein',
        'not_enough_missiles'          => 'Du hast nicht genug Raketen',
        'launched_success'             => 'Raketen erfolgreich abgefeuert!',
        'launch_failed'                => 'Raketen konnten nicht abgefeuert werden',
    ],

    // -------------------------------------------------------------------------
    // Freundesystem (Freundschaftsanfragen + Spieler ignorieren — auf der Galaxieseite verwendet)
    // -------------------------------------------------------------------------

    'buddy' => [
        'request_sent'   => 'Freundschaftsanfrage erfolgreich gesendet!',
        'request_failed' => 'Freundschaftsanfrage konnte nicht gesendet werden.',
        'request_to'     => 'Freundschaftsanfrage an',
        'ignore_confirm' => 'Bist du sicher, dass du ignorieren möchtest',
        'ignore_success' => 'Spieler erfolgreich ignoriert!',
        'ignore_failed'  => 'Spieler konnte nicht ignoriert werden.',
    ],

    // -------------------------------------------------------------------------
    // Nachrichtenseite
    // -------------------------------------------------------------------------

    'messages' => [
        // Hauptregisterkarten
        'tab_fleets'        => 'Flotten',
        'tab_communication' => 'Kommunikation',
        'tab_economy'       => 'Wirtschaft',
        'tab_universe'      => 'Universum',
        'tab_system'        => 'OGame',
        'tab_favourites'    => 'Favoriten',

        // Flotten-Unterregisterkarten
        'subtab_espionage'   => 'Spionage',
        'subtab_combat'      => 'Kampfberichte',
        'subtab_expeditions' => 'Expeditionen',
        'subtab_transport'   => 'Verbände/Transport',
        'subtab_other'       => 'Sonstiges',

        // Kommunikations-Unterregisterkarten
        'subtab_messages'         => 'Nachrichten',
        'subtab_information'      => 'Information',
        'subtab_shared_combat'    => 'Geteilte Kampfberichte',
        'subtab_shared_espionage' => 'Geteilte Spionageberichte',

        // Allgemeine Benutzeroberfläche
        'news_feed'          => 'Newsfeed',
        'loading'            => 'laden...',
        'error_occurred'     => 'Ein Fehler ist aufgetreten',
        'mark_favourite'     => 'als Favorit markieren',
        'remove_favourite'   => 'aus Favoriten entfernen',
        'from'               => 'Von',
        'no_messages'        => 'In diesem Reiter sind derzeit keine Nachrichten verfügbar',
        'new_alliance_msg'   => 'Neue Allianznachricht',
        'to'                 => 'An',
        'all_players'        => 'alle Spieler',
        'send'               => 'senden',
        'delete_buddy_title' => 'Freund löschen',
        'report_to_operator' => 'Diese Nachricht einem Spielleiter melden?',
        'too_few_chars'      => 'Zu wenig Zeichen! Bitte gib mindestens 2 Zeichen ein.',

        // BBCode-Editor (localizedBBCode)
        'bbcode_bold'           => 'Fett',
        'bbcode_italic'         => 'Kursiv',
        'bbcode_underline'      => 'Unterstrichen',
        'bbcode_stroke'         => 'Durchgestrichen',
        'bbcode_sub'            => 'Tiefgestellt',
        'bbcode_sup'            => 'Hochgestellt',
        'bbcode_font_color'     => 'Schriftfarbe',
        'bbcode_font_size'      => 'Schriftgröße',
        'bbcode_bg_color'       => 'Hintergrundfarbe',
        'bbcode_bg_image'       => 'Hintergrundbild',
        'bbcode_tooltip'        => 'Tooltip',
        'bbcode_align_left'     => 'Linksbündig',
        'bbcode_align_center'   => 'Zentriert',
        'bbcode_align_right'    => 'Rechtsbündig',
        'bbcode_align_justify'  => 'Blocksatz',
        'bbcode_block'          => 'Umbruch',
        'bbcode_code'           => 'Code',
        'bbcode_spoiler'        => 'Spoiler',
        'bbcode_moreopts'       => 'Weitere Optionen',
        'bbcode_list'           => 'Liste',
        'bbcode_hr'             => 'Horizontale Linie',
        'bbcode_picture'        => 'Bild',
        'bbcode_link'           => 'Link',
        'bbcode_email'          => 'E-Mail',
        'bbcode_player'         => 'Spieler',
        'bbcode_item'           => 'Item',
        'bbcode_coordinates'    => 'Koordinaten',
        'bbcode_preview'        => 'Vorschau',
        'bbcode_text_ph'        => 'Text...',
        'bbcode_player_ph'      => 'Spieler-ID oder Name',
        'bbcode_item_ph'        => 'Item-ID',
        'bbcode_coord_ph'       => 'Galaxie:System:Position',
        'bbcode_chars_left'     => 'Verbleibende Zeichen',
        'bbcode_ok'             => 'Ok',
        'bbcode_cancel'         => 'Abbrechen',
        'bbcode_repeat_x'       => 'Horizontal wiederholen',
        'bbcode_repeat_y'       => 'Vertikal wiederholen',

        // Spionagebericht
        'spy_player'          => 'Spieler',
        'spy_activity'        => 'Aktivität',
        'spy_minutes_ago'     => 'Minuten zuvor',
        'spy_class'           => 'Klasse',
        'spy_unknown'         => 'Unbekannt',
        'spy_alliance_class'  => 'Allianzklasse',
        'spy_no_alliance_class' => 'Keine Allianzklasse ausgewählt',
        'spy_resources'       => 'Ressourcen',
        'spy_loot'            => 'Beute',
        'spy_counter_esp'     => 'Chance auf Gegenspionage',
        'spy_no_info'         => 'Wir konnten keine zuverlässigen Informationen dieser Art aus dem Scan gewinnen.',
        'spy_debris_field'    => 'Trümmerfeld',
        'spy_no_activity'     => 'Deine Spionage zeigt keine Auffälligkeiten in der Atmosphäre des Planeten. In der letzten Stunde scheint keine Aktivität auf dem Planeten stattgefunden zu haben.',
        'spy_fleets'          => 'Flotten',
        'spy_defense'         => 'Verteidigung',
        'spy_research'        => 'Forschung',
        'spy_building'        => 'Gebäude',

        // Kampfbericht (kurz)
        'battle_attacker'    => 'Angreifer',
        'battle_defender'    => 'Verteidiger',
        'battle_resources'   => 'Ressourcen',
        'battle_loot'        => 'Beute',
        'battle_debris_new'       => 'Trümmerfeld (neu entstanden)',
        'battle_wreckage_created'  => 'Wrack entstanden',
        'battle_attacker_wreckage' => 'Angreiferwrack',
        'battle_repaired'    => 'Tatsächlich repariert',
        'battle_moon_chance' => 'Mondchance',

        // Kampfbericht (vollständig)
        'battle_report'          => 'Kampfbericht',
        'battle_planet'          => 'Planet',
        'battle_fleet_command'   => 'Flottenkommando',
        'battle_from'            => 'Von',
        'battle_tactical_retreat' => 'Taktischer Rückzug',
        'battle_total_loot'      => 'Gesamtbeute',
        'battle_debris'          => 'Trümmer (neu)',
        'battle_recycler'        => 'Recycler',
        'battle_mined_after'     => 'Nach dem Kampf abgebaut',
        'battle_reaper'          => 'Reaper',
        'battle_debris_left'     => 'Trümmerfelder (übrig)',
        'battle_honour_points'   => 'Ehrenpunkte',
        'battle_dishonourable'   => 'Unehrenhafter Kampf',
        'battle_vs'              => 'vs',
        'battle_honourable'      => 'Ehrenhafter Kampf',
        'battle_class'           => 'Klasse',
        'battle_weapons'         => 'Waffen',
        'battle_shields'         => 'Schilde',
        'battle_armour'          => 'Panzerung',
        'battle_combat_ships'    => 'Kampfschiffe',
        'battle_civil_ships'     => 'Zivilschiffe',
        'battle_defences'        => 'Verteidigungsanlagen',
        'battle_repaired_def'    => 'Reparierte Verteidigungsanlagen',
        'battle_share'           => 'Nachricht teilen',
        'battle_attack'          => 'Angriff',
        'battle_espionage'       => 'Spionage',
        'battle_delete'          => 'löschen',
        'battle_favourite'       => 'als Favorit markieren',
        'battle_hamill'          => 'Ein Leichter Jäger zerstörte einen Todesstern, bevor die Schlacht begann!',
        'battle_retreat_tooltip'  => 'Bitte beachte, dass Todessterne, Spionagesonden, Solarsatelliten und Flotten auf einer AKS-Verteidigungsmission nicht fliehen können. Taktische Rückzüge sind in ehrenhaften Kämpfen ebenfalls deaktiviert. Ein Rückzug kann auch manuell deaktiviert oder durch Deuteriummangel verhindert worden sein. Banditen und Spieler mit mehr als 500.000 Punkten ziehen sich niemals zurück.',
        'battle_no_flee'         => 'Die verteidigende Flotte ist nicht geflohen.',
        'battle_rounds'          => 'Runden',
        'battle_start'           => 'Start',
        'battle_player_from'     => 'von',
        'battle_attacker_fires'  => 'Der :attacker feuert insgesamt :hits Schüsse auf den :defender mit einer Gesamtstärke von :strength. Die Schilde des :defender2 absorbieren :absorbed Schadenspunkte.',
        'battle_defender_fires'  => 'Der :defender feuert insgesamt :hits Schüsse auf den :attacker mit einer Gesamtstärke von :strength. Die Schilde des :attacker2 absorbieren :absorbed Schadenspunkte.',
    ],

    // -------------------------------------------------------------------------
    // Allianzseite
    // -------------------------------------------------------------------------

    'alliance' => [
        // Seite / Navigation
        'page_title'                    => 'Allianz',
        'tab_overview'                  => 'Übersicht',
        'tab_management'                => 'Verwaltung',
        'tab_communication'             => 'Kommunikation',
        'tab_applications'              => 'Bewerbungen',
        'tab_classes'                   => 'Allianzklassen',
        'tab_create'                    => 'Allianz gründen',
        'tab_search'                    => 'Allianz suchen',
        'tab_apply'                     => 'bewerben',

        // Übersicht – Allianzinformationstabelle
        'your_alliance'                 => 'Deine Allianz',
        'name'                          => 'Name',
        'tag'                           => 'Tag',
        'created'                       => 'Gegründet',
        'member'                        => 'Mitglied',
        'your_rank'                     => 'Dein Rang',
        'homepage'                      => 'Homepage',
        'logo'                          => 'Allianzlogo',
        'open_page'                     => 'Allianzseite öffnen',
        'highscore'                     => 'Allianzhighscore',
        'leave_wait_warning'            => 'Wenn du die Allianz verlässt, musst du 3 Tage warten, bevor du einer anderen Allianz beitreten oder eine neue gründen kannst.',
        'leave_btn'                     => 'Allianz verlassen',

        // Übersicht – Mitgliederliste
        'member_list'                   => 'Mitgliederliste',
        'no_members'                    => 'Keine Mitglieder gefunden',
        'assign_rank_btn'               => 'Rang zuweisen',
        'kick_tooltip'                  => 'Allianzmitglied kicken',
        'write_msg_tooltip'             => 'Nachricht schreiben',
        'col_name'                      => 'Name',
        'col_rank'                      => 'Rang',
        'col_coords'                    => 'Koordinaten',
        'col_joined'                    => 'Beigetreten',
        'col_online'                    => 'Online',
        'col_function'                  => 'Funktion',

        // Übersicht – Textabschnitte
        'internal_area'                 => 'Interner Bereich',
        'external_area'                 => 'Externer Bereich',

        // Verwaltung – Berechtigungen
        'configure_privileges'          => 'Berechtigungen konfigurieren',
        'col_rank_name'                 => 'Rangname',
        'col_applications_group'        => 'Bewerbungen',
        'col_member_group'              => 'Mitglied',
        'col_alliance_group'            => 'Allianz',
        'delete_rank'                   => 'Rang löschen',
        'save_btn'                      => 'Speichern',
        'rights_warning_html'           => '<strong>Warnung!</strong> Du kannst nur Berechtigungen vergeben, die du selbst besitzt.',
        'rights_warning_loca'           => '[b]Warnung![/b] Du kannst nur Berechtigungen vergeben, die du selbst besitzt.',
        'rights_legend'                 => 'Rechte-Legende',
        'create_rank_btn'               => 'Neuen Rang erstellen',
        'rank_name_placeholder'         => 'Rangname',
        'no_ranks'                      => 'Keine Ränge gefunden',

        // Verwaltung – Berechtigungen (Icon-Titel und Legende)
        'perm_see_applications'         => 'Bewerbungen anzeigen',
        'perm_edit_applications'        => 'Bewerbungen bearbeiten',
        'perm_see_members'              => 'Mitgliederliste anzeigen',
        'perm_kick_user'                => 'Benutzer kicken',
        'perm_see_online'               => 'Online-Status sehen',
        'perm_send_circular'            => 'Rundschreiben schreiben',
        'perm_disband'                  => 'Allianz auflösen',
        'perm_manage'                   => 'Allianz verwalten',
        'perm_right_hand'               => 'Rechte Hand',
        'perm_right_hand_long'          => '`Rechte Hand` (notwendig zur Übertragung des Gründerrangs)',
        'perm_manage_classes'           => 'Allianzklasse verwalten',

        // Verwaltung – Textabschnitt
        'manage_texts'                  => 'Texte verwalten',
        'internal_text'                 => 'Interner Text',
        'external_text'                 => 'Externer Text',
        'application_text'              => 'Bewerbungstext',

        // Verwaltung – Optionen/Einstellungen
        'options'                       => 'Optionen',
        'alliance_logo_label'           => 'Allianzlogo',
        'applications_field'            => 'Bewerbungen',
        'status_open'                   => 'Möglich (Allianz offen)',
        'status_closed'                 => 'Nicht möglich (Allianz geschlossen)',
        'rename_founder'                => 'Gründertitel umbenennen in',
        'rename_newcomer'               => 'Neuling-Rang umbenennen',
        'no_settings_perm'              => 'Du hast keine Berechtigung, die Allianzeinstellungen zu verwalten.',

        // Verwaltung – Tag/Name ändern
        'change_tag_name'               => 'Allianz-Tag/Name ändern',
        'change_tag'                    => 'Allianz-Tag ändern',
        'change_name'                   => 'Allianzname ändern',
        'former_tag'                    => 'Bisheriger Allianz-Tag:',
        'new_tag'                       => 'Neuer Allianz-Tag:',
        'former_name'                   => 'Bisheriger Allianzname:',
        'new_name'                      => 'Neuer Allianzname:',
        'former_tag_short'              => 'Bisheriger Allianz-Tag',
        'new_tag_short'                 => 'Neuer Allianz-Tag',
        'former_name_short'             => 'Bisheriger Allianzname',
        'new_name_short'                => 'Neuer Allianzname',
        'no_tagname_perm'               => 'Du hast keine Berechtigung, Allianz-Tag/Name zu ändern.',

        // Verwaltung – Auflösen / Weitergeben
        'delete_pass_on'                => 'Allianz löschen/weitergeben',
        'delete_btn'                    => 'Diese Allianz löschen',
        'no_delete_perm'                => 'Du hast keine Berechtigung, die Allianz zu löschen.',
        'handover'                      => 'Allianz übergeben',
        'takeover_btn'                  => 'Allianz übernehmen',
        'loca_continue'                 => 'Weiter',
        'loca_change_founder'           => 'Den Gründertitel übertragen an:',
        'loca_no_transfer_error'        => 'Keines der Mitglieder besitzt das erforderliche Recht `Rechte Hand`. Du kannst die Allianz nicht übergeben.',
        'loca_founder_inactive_error'   => 'Der Gründer ist noch nicht lange genug inaktiv, um die Allianz zu übernehmen.',

        // Verwaltung – Allianz-Verlassen-Abschnitt (für Nicht-Gründer)
        'leave_section_title'           => 'Allianz verlassen',
        'leave_consequences'            => 'Wenn du die Allianz verlässt, verlierst du alle deine Rangberechtigungen und Allianzvorteile.',

        // Bewerbungen-Reiter
        'no_applications'               => 'Keine Bewerbungen gefunden',
        'accept_btn'                    => 'annehmen',
        'deny_btn'                      => 'Bewerber ablehnen',
        'report_btn'                    => 'Bewerbung melden',
        'app_date'                      => 'Bewerbungsdatum',
        'action_col'                    => 'Aktion',
        'answer_btn'                    => 'antworten',
        'reason_label'                  => 'Grund',

        // Bewerben-Seite
        'apply_title'                   => 'Allianz beitreten',
        'apply_heading'                 => 'Bewerbung an',
        'send_application_btn'          => 'Bewerbung senden',
        'chars_remaining'               => 'Verbleibende Zeichen',
        'msg_too_long'                  => 'Nachricht ist zu lang (max. 2000 Zeichen)',

        // Rundschreiben
        'addressee'                     => 'An',
        'all_players'                   => 'alle Spieler',
        'only_rank'                     => 'nur Rang:',
        'send_btn'                      => 'Senden',

        // Info-Popup
        'info_title'                    => 'Allianzinformationen',
        'apply_confirm'                 => 'Möchtest du dich bei dieser Allianz bewerben?',
        'redirect_confirm'              => 'Wenn du diesem Link folgst, verlässt du OGame. Möchtest du fortfahren?',

        // Klassen-Reiter
        'class_selection_header'        => 'Klassenauswahl',
        'select_class_title'            => 'Allianzklasse auswählen',
        'select_class_note'             => 'Wähle eine Allianzklasse, um besondere Boni zu erhalten. Du kannst die Allianzklasse im Allianzmenü ändern, sofern du die erforderlichen Berechtigungen hast.',
        'class_warriors'                => 'Krieger (Allianz)',
        'class_traders'                 => 'Händler (Allianz)',
        'class_researchers'             => 'Forscher (Allianz)',
        'class_label'                   => 'Allianzklasse',
        'buy_for'                       => 'Kaufen für',
        'no_dark_matter'                => 'Es ist nicht genug Dunkle Materie verfügbar',
        'loca_deactivate'               => 'Deaktivieren',
        'loca_activate_dm'              => 'Möchtest du die Allianzklasse #allianceClassName# für #darkmatter# Dunkle Materie aktivieren? Dabei verlierst du deine aktuelle Allianzklasse.',
        'loca_activate_item'            => 'Möchtest du die Allianzklasse #allianceClassName# aktivieren? Dabei verlierst du deine aktuelle Allianzklasse.',
        'loca_deactivate_note'          => 'Möchtest du die Allianzklasse #allianceClassName# wirklich deaktivieren? Für die Reaktivierung wird ein Allianzklassen-Wechsel-Item für 500.000 Dunkle Materie benötigt.',
        'loca_class_change_append'      => '<br><br>Aktuelle Allianzklasse: #currentAllianceClassName#<br><br>Zuletzt geändert am: #lastAllianceClassChange#',
        'loca_no_dm'                    => 'Nicht genug Dunkle Materie verfügbar! Möchtest du jetzt welche kaufen?',
        'loca_reference'                => 'Referenz',
        'loca_language'                 => 'Sprache:',
        'loca_loading'                  => 'laden...',
        'warrior_bonus_1'               => '+10% Geschwindigkeit für Schiffe zwischen Allianzmitgliedern',
        'warrior_bonus_2'               => '+1 Kampfforschungsstufen',
        'warrior_bonus_3'               => '+1 Spionageforschungsstufen',
        'warrior_bonus_4'               => 'Das Spionagesystem kann zum Scannen ganzer Systeme eingesetzt werden.',
        'trader_bonus_1'                => '+10% Geschwindigkeit für Transporter',
        'trader_bonus_2'                => '+5% Minenproduktion',
        'trader_bonus_3'                => '+5% Energieproduktion',
        'trader_bonus_4'                => '+10% planetare Lagerkapazität',
        'trader_bonus_5'                => '+10% Mondlagerkapazität',
        'researcher_bonus_1'            => '+5% größere Planeten bei der Besiedlung',
        'researcher_bonus_2'            => '+10% Geschwindigkeit zum Expeditionsziel',
        'researcher_bonus_3'            => 'Die System-Phalanx kann zum Scannen von Flottenbewegungen in ganzen Systemen eingesetzt werden.',
        'class_not_implemented'         => 'Allianzklassensystem noch nicht implementiert',

        // Allianz-Gründungsformular
        'create_tag_label'              => 'Allianz-Tag (3-8 Zeichen)',
        'create_name_label'             => 'Allianzname (3-30 Zeichen)',
        'create_btn'                    => 'Allianz gründen',
        'loca_ally_tag_chars'           => 'Allianz-Tag (3-30 Zeichen)',
        'loca_ally_name_chars'          => 'Allianzname (3-8 Zeichen)',
        'loca_ally_name_label'          => 'Allianzname (3-30 Zeichen)',
        'loca_ally_tag_label'           => 'Allianz-Tag (3-8 Zeichen)',
        'validation_min_chars'          => 'Nicht genug Zeichen',
        'validation_special'            => 'Enthält ungültige Zeichen.',
        'validation_underscore'         => 'Dein Name darf nicht mit einem Unterstrich beginnen oder enden.',
        'validation_hyphen'             => 'Dein Name darf nicht mit einem Bindestrich beginnen oder enden.',
        'validation_space'              => 'Dein Name darf nicht mit einem Leerzeichen beginnen oder enden.',
        'validation_max_underscores'    => 'Dein Name darf insgesamt nicht mehr als 3 Unterstriche enthalten.',
        'validation_max_hyphens'        => 'Dein Name darf nicht mehr als 3 Bindestriche enthalten.',
        'validation_max_spaces'         => 'Dein Name darf insgesamt nicht mehr als 3 Leerzeichen enthalten.',
        'validation_consec_underscores' => 'Du darfst nicht zwei oder mehr Unterstriche hintereinander verwenden.',
        'validation_consec_hyphens'     => 'Du darfst nicht zwei oder mehr Bindestriche hintereinander verwenden.',
        'validation_consec_spaces'      => 'Du darfst nicht zwei oder mehr Leerzeichen hintereinander verwenden.',

        // JS-Bestätigungsdialoge
        'confirm_leave'                 => 'Bist du sicher, dass du die Allianz verlassen möchtest?',
        'confirm_kick'                  => 'Bist du sicher, dass du :username aus der Allianz kicken möchtest?',
        'confirm_deny'                  => 'Bist du sicher, dass du diese Bewerbung ablehnen möchtest?',
        'confirm_deny_title'            => 'Bewerbung ablehnen',
        'confirm_disband'               => 'Allianz wirklich löschen?',
        'confirm_pass_on'               => 'Bist du sicher, dass du deine Allianz weitergeben möchtest?',
        'confirm_takeover'              => 'Bist du sicher, dass du diese Allianz übernehmen möchtest?',
        'confirm_abandon'               => 'Diese Allianz aufgeben?',
        'confirm_takeover_long'         => 'Diese Allianz übernehmen?',

        // Controller- / AJAX-Erfolgs- und Fehlermeldungen
        'msg_already_in'                => 'Du bist bereits in einer Allianz',
        'msg_not_in_alliance'           => 'Du bist in keiner Allianz',
        'msg_not_found'                 => 'Allianz nicht gefunden',
        'msg_id_required'               => 'Allianz-ID ist erforderlich',
        'msg_closed'                    => 'Diese Allianz ist für Bewerbungen geschlossen',
        'msg_created'                   => 'Allianz erfolgreich gegründet',
        'msg_applied'                   => 'Bewerbung erfolgreich eingereicht',
        'msg_accepted'                  => 'Bewerbung angenommen',
        'msg_rejected'                  => 'Bewerbung abgelehnt',
        'msg_kicked'                    => 'Mitglied aus der Allianz geworfen',
        'msg_kicked_success'            => 'Mitglied erfolgreich geworfen',
        'msg_left'                      => 'Du hast die Allianz verlassen',
        'msg_rank_assigned'             => 'Rang zugewiesen',
        'msg_rank_assigned_to'          => 'Rang erfolgreich an :name vergeben',
        'msg_ranks_assigned'            => 'Ränge erfolgreich vergeben',
        'msg_rank_perms_updated'        => 'Rangberechtigungen aktualisiert',
        'msg_texts_updated'             => 'Allianztexte aktualisiert',
        'msg_text_updated'              => 'Allianztext aktualisiert',
        'msg_settings_updated'          => 'Allianzeinstellungen aktualisiert',
        'msg_tag_updated'               => 'Allianz-Tag aktualisiert',
        'msg_name_updated'              => 'Allianzname aktualisiert',
        'msg_tag_name_updated'          => 'Allianz-Tag und Name aktualisiert',
        'msg_disbanded'                 => 'Allianz aufgelöst',
        'msg_broadcast_sent'            => 'Rundschreiben erfolgreich gesendet',
        'msg_rank_created'              => 'Rang erfolgreich erstellt',
        'msg_apply_success'             => 'Bewerbung erfolgreich eingereicht',
        'msg_apply_error'               => 'Bewerbung konnte nicht eingereicht werden',
        'msg_leave_error'               => 'Allianz konnte nicht verlassen werden',
        'msg_assign_error'              => 'Ränge konnten nicht vergeben werden',
        'msg_kick_error'                => 'Mitglied konnte nicht geworfen werden',
        'msg_invalid_action'            => 'Ungültige Aktion',
        'msg_error'                     => 'Ein Fehler ist aufgetreten',
    ],

    // -------------------------------------------------------------------
    // Technologiebaum-Modul
    // -------------------------------------------------------------------
    'techtree' => [
        // Navigations-Reiter
        'tab_techtree'                          => 'Technologiebaum',
        'tab_applications'                      => 'Anwendungen',
        'tab_techinfo'                          => 'Techinfo',
        'tab_technology'                        => 'Technologie',

        // Allgemein
        'page_title'                            => 'Technologie',
        'no_requirements'                       => 'Keine Voraussetzungen vorhanden',
        'is_requirement_for'                    => 'ist Voraussetzung für',
        'level'                                 => 'Stufe',

        // Gemeinsame Tabellenspalten
        'col_level'                             => 'Stufe',
        'col_difference'                        => 'Unterschied',
        'col_diff_per_level'                    => 'Unterschied/Stufe',
        'col_protected'                         => 'Geschützt',
        'col_protected_percent'                 => 'Geschützt (Prozent)',

        // Produktionstabelle
        'production_energy_balance'             => 'Energiebilanz',
        'production_per_hour'                   => 'Produktion/h',
        'production_deuterium_consumption'      => 'Deuteriumverbrauch',

        // Eigenschaftentabelle (Schiffe/Verteidigung)
        'properties_technical_data'             => 'Technische Daten',
        'properties_structural_integrity'       => 'Strukturelle Integrität',
        'properties_shield_strength'            => 'Schildstärke',
        'properties_attack_strength'            => 'Angriffsstärke',
        'properties_speed'                      => 'Geschwindigkeit',
        'properties_cargo_capacity'             => 'Laderaumkapazität',
        'properties_fuel_usage'                 => 'Treibstoffverbrauch (Deuterium)',

        // Eigenschafts-Tooltip
        'tooltip_basic_value'                   => 'Grundwert',

        // Schnellfeuer
        'rapidfire_from'                        => 'Schnellfeuer von',
        'rapidfire_against'                     => 'Schnellfeuer gegen',

        // Lagertabelle
        'storage_capacity'                      => 'Lagerkapaz.',

        // Plasmatabelle
        'plasma_metal_bonus'                    => 'Metallbonus %',
        'plasma_crystal_bonus'                  => 'Kristallbonus %',
        'plasma_deuterium_bonus'                => 'Deuteriumbonus %',

        // Astrophysik-Tabelle
        'astrophysics_max_colonies'             => 'Maximale Kolonien',
        'astrophysics_max_expeditions'          => 'Maximale Expeditionen',
        'astrophysics_note_1'                   => 'Positionen 3 und 13 können ab Stufe 4 besiedelt werden.',
        'astrophysics_note_2'                   => 'Positionen 2 und 14 können ab Stufe 6 besiedelt werden.',
        'astrophysics_note_3'                   => 'Positionen 1 und 15 können ab Stufe 8 besiedelt werden.',
    ],

    // -------------------------------------------------------------------
    // Optionen (Benutzereinstellungen) Modul
    // -------------------------------------------------------------------
    'options' => [
        // Seitentitel
        'page_title'                                => 'Optionen',

        // Reiter
        'tab_userdata'                              => 'Benutzerdaten',
        'tab_general'                               => 'Allgemein',
        'tab_display'                               => 'Anzeige',
        'tab_extended'                              => 'Erweitert',

        // Reiter 1 – Spielername
        'section_playername'                        => 'Spielername',
        'your_player_name'                          => 'Dein Spielername:',
        'new_player_name'                           => 'Neuer Spielername:',
        'username_change_once_week'                 => 'Du kannst deinen Benutzernamen einmal pro Woche ändern.',
        'username_change_hint'                      => 'Klicke dazu auf deinen Namen oder die Einstellungen oben auf dem Bildschirm.',

        // Reiter 1 – Passwort
        'section_password'                          => 'Passwort ändern',
        'old_password'                              => 'Altes Passwort eingeben:',
        'new_password'                              => 'Neues Passwort (mindestens 4 Zeichen):',
        'repeat_password'                           => 'Neues Passwort wiederholen:',
        'password_check'                            => 'Passwortprüfung:',
        'password_strength_low'                     => 'Niedrig',
        'password_strength_medium'                  => 'Mittel',
        'password_strength_high'                    => 'Hoch',
        'password_properties_title'                 => 'Das Passwort sollte folgende Eigenschaften aufweisen',
        'password_min_max'                          => 'mind. 4 Zeichen, max. 128 Zeichen',
        'password_mixed_case'                       => 'Groß- und Kleinschreibung',
        'password_special_chars'                    => 'Sonderzeichen (z. B. !?:_., )',
        'password_numbers'                          => 'Zahlen',
        'password_length_hint'                      => 'Dein Passwort muss mindestens <strong>4 Zeichen</strong> lang sein und darf nicht länger als <strong>128 Zeichen</strong> sein.',

        // Reiter 1 – E-Mail
        'section_email'                             => 'E-Mail-Adresse',
        'current_email'                             => 'Aktuelle E-Mail-Adresse:',
        'send_validation_link'                      => 'Bestätigungslink senden',
        'email_sent_success'                        => 'E-Mail wurde erfolgreich gesendet!',
        'email_sent_error'                          => 'Fehler! Konto ist bereits verifiziert oder die E-Mail konnte nicht gesendet werden!',
        'email_too_many_requests'                   => 'Du hast bereits zu viele E-Mails angefordert!',
        'new_email'                                 => 'Neue E-Mail-Adresse:',
        'new_email_confirm'                         => 'Neue E-Mail-Adresse (zur Bestätigung):',
        'enter_password_confirm'                    => 'Passwort eingeben (zur Bestätigung):',
        'email_warning'                             => 'Warnung! Nach einer erfolgreichen Kontovalidierung ist eine erneute Änderung der E-Mail-Adresse erst nach einem Zeitraum von <b>7 Tagen</b> möglich.',

        // Reiter 2 – Allgemein
        'section_spy_probes'                        => 'Spionagesonden',
        'spy_probes_amount'                         => 'Anzahl der Spionagesonden:',
        'section_chat'                              => 'Chat',
        'disable_chat_bar'                          => 'Chatleiste deaktivieren:',
        'section_warnings'                          => 'Warnungen',
        'disable_outlaw_warning'                    => 'Outlaw-Warnung bei Angriffen auf 5-mal stärkere Gegner deaktivieren:',

        // Reiter 3 – Anzeige > Allgemein
        'section_general_display'                   => 'Allgemein',
        'show_mobile_version'                       => 'Mobile Version anzeigen:',
        'show_alt_dropdowns'                        => 'Alternative Dropdowns anzeigen:',
        'activate_autofocus'                        => 'Autofokus in den Highscores aktivieren:',
        'always_show_events'                        => 'Ereignisse immer anzeigen:',
        'events_hide'                               => 'Ausblenden',
        'events_above'                              => 'Über dem Inhalt',
        'events_below'                              => 'Unter dem Inhalt',

        // Reiter 3 – Anzeige > Planeten
        'section_planets'                           => 'Deine Planeten',
        'sort_planets_by'                           => 'Planeten sortieren nach:',
        'sort_emergence'                            => 'Entstehungsreihenfolge',
        'sort_coordinates'                          => 'Koordinaten',
        'sort_alphabet'                             => 'Alphabet',
        'sort_size'                                 => 'Größe',
        'sort_used_fields'                          => 'Genutzte Felder',
        'sort_sequence'                             => 'Sortierreihenfolge:',
        'sort_order_up'                             => 'aufsteigend',
        'sort_order_down'                           => 'absteigend',

        // Reiter 3 – Anzeige > Übersicht
        'section_overview_display'                  => 'Übersicht',
        'highlight_planet_info'                     => 'Planeteninfos hervorheben:',
        'animated_detail_display'                   => 'Animierte Detailanzeige:',
        'animated_overview'                         => 'Animierte Übersicht:',

        // Reiter 3 – Anzeige > Overlays
        'section_overlays'                          => 'Overlays',
        'overlays_hint'                             => 'Mit den folgenden Einstellungen können die entsprechenden Overlays als separates Browserfenster statt innerhalb des Spiels geöffnet werden.',
        'popup_notes'                               => 'Notizen in einem extra Fenster:',
        'popup_combat_reports'                      => 'Kampfberichte in einem extra Fenster:',

        // Reiter 3 – Anzeige > Nachrichten
        'section_messages_display'                  => 'Nachrichten',
        'hide_report_pictures'                      => 'Bilder in Berichten ausblenden:',
        'msgs_per_page'                             => 'Anzahl der angezeigten Nachrichten pro Seite:',
        'auctioneer_notifications'                  => 'Auktionator-Benachrichtigung:',
        'economy_notifications'                     => 'Wirtschaftsnachrichten erstellen:',

        // Reiter 3 – Anzeige > Galaxie
        'section_galaxy_display'                    => 'Galaxie',
        'detailed_activity'                         => 'Detaillierte Aktivitätsanzeige:',
        'preserve_galaxy_system'                    => 'Galaxie/System beim Planetenwechsel beibehalten:',

        // Reiter 4 – Erweitert > Urlaubsmodus
        'section_vacation'                          => 'Urlaubsmodus',
        'vacation_active'                           => 'Du befindest dich derzeit im Urlaubsmodus.',
        'vacation_can_deactivate_after'             => 'Du kannst ihn deaktivieren nach:',
        'vacation_cannot_activate'                  => 'Urlaubsmodus kann nicht aktiviert werden (Aktive Flotten)',
        'vacation_description_1'                    => 'Der Urlaubsmodus ist dazu gedacht, dich während langer Abwesenheiten vom Spiel zu schützen. Du kannst ihn nur aktivieren, wenn keine deiner Flotten unterwegs ist. Bau- und Forschungsaufträge werden pausiert.',
        'vacation_description_2'                    => 'Sobald der Urlaubsmodus aktiviert ist, schützt er dich vor neuen Angriffen. Bereits gestartete Angriffe laufen jedoch weiter und deine Produktion wird auf null gesetzt. Der Urlaubsmodus verhindert nicht die Löschung deines Kontos, wenn es seit 35+ Tagen inaktiv ist und kein gekauftes DM vorhanden ist.',
        'vacation_description_3'                    => 'Der Urlaubsmodus dauert mindestens 48 Stunden. Erst nach Ablauf dieser Zeit kannst du ihn deaktivieren.',
        'vacation_tooltip_min_days'                 => 'Der Urlaub dauert mindestens 2 Tage.',
        'vacation_deactivate_btn'                   => 'Deaktivieren',
        'vacation_activate_btn'                     => 'Aktivieren',

        // Reiter 4 – Erweitert > Konto
        'section_account'                           => 'Dein Konto',
        'delete_account'                            => 'Konto löschen',
        'delete_account_hint'                       => 'Hier ankreuzen, um dein Konto zur automatischen Löschung nach 7 Tagen zu markieren.',

        // Absenden
        'use_settings'                              => 'Einstellungen übernehmen',

        // JS-validationEngine-Regeln
        'validation_not_enough_chars'               => 'Nicht genug Zeichen',
        'validation_pw_too_short'                   => 'Das eingegebene Passwort ist zu kurz (mind. 4 Zeichen)',
        'validation_pw_too_long'                    => 'Das eingegebene Passwort ist zu lang (max. 20 Zeichen)',
        'validation_invalid_email'                  => 'Du musst eine gültige E-Mail-Adresse eingeben!',
        'validation_special_chars'                  => 'Enthält ungültige Zeichen.',
        'validation_no_begin_end_underscore'        => 'Dein Name darf nicht mit einem Unterstrich beginnen oder enden.',
        'validation_no_begin_end_hyphen'            => 'Dein Name darf nicht mit einem Bindestrich beginnen oder enden.',
        'validation_no_begin_end_whitespace'        => 'Dein Name darf nicht mit einem Leerzeichen beginnen oder enden.',
        'validation_max_three_underscores'          => 'Dein Name darf insgesamt nicht mehr als 3 Unterstriche enthalten.',
        'validation_max_three_hyphens'              => 'Dein Name darf nicht mehr als 3 Bindestriche enthalten.',
        'validation_max_three_spaces'               => 'Dein Name darf insgesamt nicht mehr als 3 Leerzeichen enthalten.',
        'validation_no_consecutive_underscores'     => 'Du darfst nicht zwei oder mehr Unterstriche hintereinander verwenden.',
        'validation_no_consecutive_hyphens'         => 'Du darfst nicht zwei oder mehr Bindestriche hintereinander verwenden.',
        'validation_no_consecutive_spaces'          => 'Du darfst nicht zwei oder mehr Leerzeichen hintereinander verwenden.',

        // JS-preferenceLoca-Objekt
        'js_change_name_title'                      => 'Neuer Spielername',
        'js_change_name_question'                   => 'Bist du sicher, dass du deinen Spielernamen in %newName% ändern möchtest?',
        'js_planet_move_question'                   => 'Achtung! Diese Mission könnte noch laufen, wenn der Umsiedlungszeitraum beginnt, und in diesem Fall wird der Vorgang abgebrochen. Möchtest du diesen Auftrag wirklich fortsetzen?',
        'js_tab_disabled'                           => 'Um diese Option zu nutzen, musst du validiert sein und darfst dich nicht im Urlaubsmodus befinden!',
        'js_vacation_question'                      => 'Möchtest du den Urlaubsmodus aktivieren? Du kannst deinen Urlaub erst nach 2 Tagen beenden.',

        // Controller-Nachrichten
        'msg_settings_saved'                        => 'Einstellungen gespeichert',
        'msg_password_incorrect'                    => 'Das eingegebene aktuelle Passwort ist falsch.',
        'msg_password_mismatch'                     => 'Die neuen Passwörter stimmen nicht überein.',
        'msg_password_length_invalid'               => 'Das neue Passwort muss zwischen 4 und 128 Zeichen lang sein.',
        'msg_vacation_activated'                    => 'Urlaubsmodus wurde aktiviert. Er schützt dich für mindestens 48 Stunden vor neuen Angriffen.',
        'msg_vacation_deactivated'                  => 'Urlaubsmodus wurde deaktiviert.',
        'msg_vacation_min_duration'                 => 'Du kannst den Urlaubsmodus erst deaktivieren, wenn die Mindestdauer von 48 Stunden abgelaufen ist.',
        'msg_vacation_fleets_in_transit'            => 'Du kannst den Urlaubsmodus nicht aktivieren, während Flotten unterwegs sind.',
        'msg_probes_min_one'                        => 'Die Anzahl der Spionagesonden muss mindestens 1 betragen',
    ],

    // -------------------------------------------------------------------------
    // Layout (main.blade.php) — Header, Menü, Ressourcenleiste, Footer, JS-Loca
    // -------------------------------------------------------------------------
    'layout' => [
        // Header-Leiste
        'player'                    => 'Spieler',
        'change_player_name'        => 'Spielername ändern',
        'highscore'                 => 'Highscore',
        'notes'                     => 'Notizen',
        'notes_overlay_title'       => 'Meine Notizen',
        'buddies'                   => 'Freunde',
        'search'                    => 'Suchen',
        'search_overlay_title'      => 'Universum durchsuchen',
        'options'                   => 'Optionen',
        'support'                   => 'Support',
        'log_out'                   => 'Abmelden',
        'unread_messages'           => 'ungelesene Nachricht(en)',
        'loading'                   => 'laden...',
        'no_fleet_movement'         => 'Keine Flottenbewegung',
        'under_attack'              => 'Du wirst angegriffen!',

        // Charakterklasse
        'class_none'                => 'Keine Klasse ausgewählt',
        'class_selected'            => 'Deine Klasse: :name',
        'class_click_select'        => 'Klicken, um eine Charakterklasse auszuwählen',

        // Ressourcenleiste
        'res_available'             => 'Verfügbar',
        'res_storage_capacity'      => 'Lagerkapazität',
        'res_current_production'    => 'Aktuelle Produktion',
        'res_den_capacity'          => 'Höhlenkapazität',
        'res_consumption'           => 'Verbrauch',
        'res_purchase_dm'           => 'Dunkle Materie kaufen',
        'res_metal'                 => 'Metall',
        'res_crystal'               => 'Kristall',
        'res_deuterium'             => 'Deuterium',
        'res_energy'                => 'Energie',
        'res_dark_matter'           => 'Dunkle Materie',

        // Menü-Seitenleiste — Eintrags-Bezeichnungen
        'menu_overview'             => 'Übersicht',
        'menu_resources'            => 'Ressourcen',
        'menu_facilities'           => 'Anlagen',
        'menu_merchant'             => 'Händler',
        'menu_research'             => 'Forschung',
        'menu_shipyard'             => 'Werft',
        'menu_defense'              => 'Verteidigung',
        'menu_fleet'                => 'Flotte',
        'menu_galaxy'               => 'Galaxie',
        'menu_alliance'             => 'Allianz',
        'menu_officers'             => 'Offiziere rekrutieren',
        'menu_shop'                 => 'Shop',
        'menu_directives'           => 'Direktiven',

        // Menü-Seitenleiste — Icon-Tooltip-Titel
        'menu_rewards_title'        => 'Belohnungen',
        'menu_resource_settings_title' => 'Ressourceneinstellungen',
        'menu_jump_gate'            => 'Sprungtor',
        'menu_resource_market_title' => 'Ressourcenmarkt',
        'menu_technology_title'     => 'Technologie',
        'menu_fleet_movement_title' => 'Flottenbewegung',
        'menu_inventory_title'      => 'Inventar',

        // Planeten-Seitenleiste
        'planets'                   => 'Planeten',

        // Chatleiste
        'contacts_online'           => ':count Kontakt(e) online',

        // Scroll-Schaltfläche
        'back_to_top'               => 'Nach oben',

        // Footer
        'all_rights_reserved'       => 'Alle Rechte vorbehalten.',
        'patch_notes'               => 'Patch-Notizen',
        'server_settings'           => 'Servereinstellungen',
        'help'                      => 'Hilfe',
        'rules'                     => 'Regeln',
        'legal'                     => 'Impressum',
        'board'                     => 'Forum',

        // JS — jsloca
        'js_internal_error'         => 'Ein bisher unbekannter Fehler ist aufgetreten. Leider konnte deine letzte Aktion nicht ausgeführt werden!',
        'js_notify_info'            => 'Info',
        'js_notify_success'         => 'Erfolg',
        'js_notify_warning'         => 'Warnung',
        'js_combatsim_planning'     => 'Planung',
        'js_combatsim_pending'      => 'Simulation läuft...',
        'js_combatsim_done'         => 'Fertig',
        'js_msg_restore'            => 'wiederherstellen',
        'js_msg_delete'             => 'löschen',
        'js_copied'                 => 'In die Zwischenablage kopiert',
        'js_report_operator'        => 'Diese Nachricht einem Spielleiter melden?',

        // JS — LocalizationStrings
        'js_time_done'              => 'fertig',
        'js_question'               => 'Frage',
        'js_ok'                     => 'Ok',
        'js_outlaw_warning'         => 'Du bist dabei, einen stärkeren Spieler anzugreifen. Wenn du das tust, werden deine Angriffsschutzmaßnahmen für 7 Tage abgeschaltet und alle Spieler können dich ungestraft angreifen. Bist du sicher, dass du fortfahren möchtest?',
        'js_last_slot_moon'         => 'Dieses Gebäude wird den letzten verfügbaren Bauplatz belegen. Erweitere deine Mondbasis, um mehr Platz zu erhalten. Bist du sicher, dass du dieses Gebäude bauen möchtest?',
        'js_last_slot_planet'       => 'Dieses Gebäude wird den letzten verfügbaren Bauplatz belegen. Erweitere deinen Terraformer oder kaufe ein Planetenfeld-Item, um mehr Plätze zu erhalten. Bist du sicher, dass du dieses Gebäude bauen möchtest?',
        'js_forced_vacation'        => 'Einige Spielfunktionen sind erst verfügbar, wenn dein Konto validiert wurde.',
        'js_more_details'           => 'Mehr Details',
        'js_less_details'           => 'Weniger Details',
        'js_planet_lock'            => 'Anordnung sperren',
        'js_planet_unlock'          => 'Anordnung entsperren',
        'js_activate_item_question' => 'Möchtest du das vorhandene Item ersetzen? Der alte Bonus geht dabei verloren.',
        'js_activate_item_header'   => 'Item ersetzen?',

        // JS — chatLoca
        'chat_text_empty'           => 'Wo ist die Nachricht?',
        'chat_text_too_long'        => 'Die Nachricht ist zu lang.',
        'chat_same_user'            => 'Du kannst nicht an dich selbst schreiben.',
        'chat_ignored_user'         => 'Du hast diesen Spieler ignoriert.',
        'chat_not_activated'        => 'Diese Funktion ist erst nach der Aktivierung deines Kontos verfügbar.',
        'chat_new_chats'            => '#+# ungelesene Nachricht(en)',
        'chat_more_users'           => 'mehr anzeigen',

        // JS — eventboxLoca
        'eventbox_mission'          => 'Mission',
        'eventbox_missions'         => 'Missionen',
        'eventbox_next'             => 'Nächste',
        'eventbox_type'             => 'Typ',
        'eventbox_own'              => 'eigen',
        'eventbox_friendly'         => 'freundlich',
        'eventbox_hostile'          => 'feindlich',

        // JS — planetMoveLoca
        'planet_move_ask_title'     => 'Planet umsiedeln',
        'planet_move_ask_cancel'    => 'Bist du sicher, dass du diese Planetenumsiedlung abbrechen möchtest? Die normale Wartezeit wird dabei beibehalten.',
        'planet_move_success'       => 'Die Planetenumsiedlung wurde erfolgreich abgebrochen.',

        // JS — locaPremium
        'premium_building_half'     => 'Möchtest du die Bauzeit um 50% der Gesamtbauzeit () für <b>750 Dunkle Materie<\/b> reduzieren?',
        'premium_building_full'     => 'Möchtest du den Bauauftrag sofort für <b>750 Dunkle Materie<\/b> abschließen?',
        'premium_ships_half'        => 'Möchtest du die Bauzeit um 50% der Gesamtbauzeit () für <b>750 Dunkle Materie<\/b> reduzieren?',
        'premium_ships_full'        => 'Möchtest du den Bauauftrag sofort für <b>750 Dunkle Materie<\/b> abschließen?',
        'premium_research_half'     => 'Möchtest du die Forschungszeit um 50% der Gesamtforschungszeit () für <b>750 Dunkle Materie<\/b> reduzieren?',
        'premium_research_full'     => 'Möchtest du den Forschungsauftrag sofort für <b>750 Dunkle Materie<\/b> abschließen?',

        // JS — loca-Objekt
        'loca_error_not_enough_dm'  => 'Nicht genug Dunkle Materie verfügbar! Möchtest du jetzt welche kaufen?',
        'loca_notice'               => 'Hinweis',
        'loca_planet_giveup'        => 'Bist du sicher, dass du den Planeten %planetName% %planetCoordinates% aufgeben möchtest?',
        'loca_moon_giveup'          => 'Bist du sicher, dass du den Mond %planetName% %planetCoordinates% aufgeben möchtest?',
    ],

    // ── Highscore ───────────────────────────────────────────────────────────
    'highscore' => [
        'player_highscore'      => 'Spielerhighscore',
        'alliance_highscore'    => 'Allianzhighscore',
        'own_position'          => 'Eigene Position',
        'own_position_hidden'   => 'Eigene Position (-)',
        'points'                => 'Punkte',
        'economy'               => 'Wirtschaft',
        'research'              => 'Forschung',
        'military'              => 'Militär',
        'military_built'        => 'Gebaute Militärpunkte',
        'military_destroyed'    => 'Zerstörte Militärpunkte',
        'military_lost'         => 'Verlorene Militärpunkte',
        'honour_points'         => 'Ehrenpunkte',
        'position'              => 'Position',
        'player_name_honour'    => 'Spielername (Ehrenpunkte)',
        'action'                => 'Aktion',
        'alliance'              => 'Allianz',
        'member'                => 'Mitglied',
        'average_points'        => 'Durchschnittspunkte',
        'no_alliances_found'    => 'Keine Allianzen gefunden',
        'write_message'         => 'Nachricht schreiben',
        'buddy_request'         => 'Freundschaftsanfrage',
        'buddy_request_to'      => 'Freundschaftsanfrage an',
        'total_ships'           => 'Schiffe gesamt',
        'buddy_request_sent'    => 'Freundschaftsanfrage erfolgreich gesendet!',
        'buddy_request_failed'  => 'Freundschaftsanfrage konnte nicht gesendet werden.',
        'are_you_sure_ignore'   => 'Bist du sicher, dass du ignorieren möchtest',
        'player_ignored'        => 'Spieler erfolgreich ignoriert!',
        'player_ignored_failed' => 'Spieler konnte nicht ignoriert werden.',
    ],

    // ── Premium / Offiziere ──────────────────────────────────────────────────
    'premium' => [
        'recruit_officers'           => 'Offiziere rekrutieren',
        'your_officers'              => 'Deine Offiziere',
        'intro_text'                 => 'Mit deinen Offizieren kannst du dein Imperium zu einer Größe führen, die deine kühnsten Träume übertrifft – du brauchst nur etwas Dunkle Materie, und deine Arbeiter und Berater werden noch härter arbeiten!',
        'info_dark_matter'           => 'Weitere Informationen zu: Dunkle Materie',
        'info_commander'             => 'Weitere Informationen zu: Kommandant',
        'info_admiral'               => 'Weitere Informationen zu: Admiral',
        'info_engineer'              => 'Weitere Informationen zu: Ingenieur',
        'info_geologist'             => 'Weitere Informationen zu: Geologe',
        'info_technocrat'            => 'Weitere Informationen zu: Technokrat',
        'info_commanding_staff'      => 'Weitere Informationen zu: Kommandostab',
        'hire_commander_tooltip'     => 'Kommandant anheuern|+40 Favoriten, Bauwarteschlange, Abkürzungen, Transportscanner, werbefrei* <span style=\'font-size: 10px; line-height: 10px\'>(*ausgenommen: spielbezogene Hinweise)</span>',
        'hire_admiral_tooltip'       => "Admiral anheuern|Max. Flottenslots +2,\nMax. Expeditionen +1,\nVerbesserte Flottenfluchtrate,\nKampfsimulator-Speicherplätze +20",
        'hire_engineer_tooltip'      => 'Ingenieur anheuern|Halbiert Verluste bei Verteidigungsanlagen, +10% Energieproduktion',
        'hire_geologist_tooltip'     => 'Geologen anheuern|+10% Minenproduktion',
        'hire_technocrat_tooltip'    => 'Technokraten anheuern|+2 Spionagestufen, 25% weniger Forschungszeit',
        'remaining_officers'         => ':current von :max',
        'benefit_fleet_slots_title'  => 'Du kannst gleichzeitig mehr Flotten entsenden.',
        'benefit_fleet_slots'        => 'Max. Flottenslots +1',
        'benefit_energy_title'       => 'Deine Kraftwerke und Solarsatelliten produzieren 2% mehr Energie.',
        'benefit_energy'             => '+2% Energieproduktion',
        'benefit_mines_title'        => 'Deine Minen produzieren 2% mehr.',
        'benefit_mines'              => '+2% Minenproduktion',
        'benefit_espionage_title'    => 'Deiner Spionageforschung wird 1 Stufe hinzugefügt.',
        'benefit_espionage'          => '+1 Spionagestufen',
    ],

    // ── Shop ────────────────────────────────────────────────────────────────
    'shop' => [
        'page_title'               => 'Shop',
        'tooltip_shop'             => 'Hier kannst du Items kaufen.',
        'tooltip_inventory'        => 'Hier erhältst du eine Übersicht deiner gekauften Items.',
        'btn_shop'                 => 'Shop',
        'btn_inventory'            => 'Inventar',
        'category_special_offers'  => 'Sonderangebote',
        'category_all'             => 'alle',
        'category_resources'       => 'Ressourcen',
        'category_buddy_items'     => 'Freundes-Items',
        'category_construction'    => 'Konstruktion',
        'btn_get_more_resources'   => 'Mehr Ressourcen erhalten',
        'btn_purchase_dark_matter' => 'Dunkle Materie kaufen',
        'feature_coming_soon'      => 'Funktion demnächst verfügbar.',
        // Item-Stufen
        'tier_gold'                => 'Gold',
        'tier_silver'              => 'Silber',
        'tier_bronze'              => 'Bronze',
        // Tooltip-Beschriftungen in Item-Karten
        'tooltip_duration'         => 'Dauer',
        'duration_now'             => 'sofort',
        'tooltip_price'            => 'Preis',
        'tooltip_in_inventory'     => 'Im Inventar',
        'dark_matter'              => 'Dunkle Materie',
        'dm_abbreviation'          => 'DM',
        'item_duration'            => 'Dauer',
        'now'                      => 'sofort',
        'item_price'               => 'Preis',
        'item_in_inventory'        => 'Im Inventar',
        // JS-Loca-Schlüssel (von inventory.js verwendet)
        'loca_extend'              => 'Verlängern',
        'loca_activate'            => 'Aktivieren',
        'loca_buy_activate'        => 'Kaufen und aktivieren',
        'loca_buy_extend'          => 'Kaufen und verlängern',
        'loca_buy_dm'              => 'Du hast nicht genug Dunkle Materie. Möchtest du jetzt welche kaufen?',
    ],

    // -------------------------------------------------------------------------
    // Suchoverlay
    // -------------------------------------------------------------------------

    'search' => [
        'input_hint'              => 'Spieler-, Allianz- oder Planetenname eingeben',
        'search_btn'              => 'Suchen',
        'tab_players'             => 'Spielernamen',
        'tab_alliances'           => 'Allianzen/Tags',
        'tab_planets'             => 'Planetennamen',
        'no_search_term'          => 'Kein Suchbegriff eingegeben',
        'searching'               => 'Suche läuft...',
        'search_failed'           => 'Suche fehlgeschlagen. Bitte versuche es erneut.',
        'no_results'              => 'Keine Ergebnisse gefunden',
        'player_name'             => 'Spielername',
        'planet_name'             => 'Planetenname',
        'coordinates'             => 'Koordinaten',
        'tag'                     => 'Tag',
        'alliance_name'           => 'Allianzname',
        'member'                  => 'Mitglied',
        'points'                  => 'Punkte',
        'action'                  => 'Aktion',
        'apply_for_alliance'      => 'Bei dieser Allianz bewerben',
    ],

    // -------------------------------------------------------------------------
    // Notizen-Overlay
    // -------------------------------------------------------------------------

    'notes' => [
        'no_notes_found'          => 'Keine Notizen gefunden',
    ],

    // -------------------------------------------------------------------------
    // Planet aufgeben / umbenennen Overlay
    // -------------------------------------------------------------------------

    'planet_abandon' => [
        // Seitenbeschreibung
        'description'                   => 'Über dieses Menü kannst du Planetennamen und Monde ändern oder sie vollständig aufgeben.',

        // Umbenennen-Abschnitt
        'rename_heading'                => 'Umbenennen',
        'new_planet_name'               => 'Neuer Planetenname',
        'new_moon_name'                 => 'Neuer Name des Mondes',
        'rename_btn'                    => 'Umbenennen',

        // Tooltips (HTML-Inhalt – durch {{ }} in Title-Attributen automatisch escaped)
        'tooltip_rules_title'           => 'Regeln',
        'tooltip_rename_planet'         => 'Hier kannst du deinen Planeten umbenennen.<br /><br />Der Planetenname muss zwischen <span style="font-weight: bold;">2 und 20 Zeichen</span> lang sein.<br />Planetennamen dürfen Groß- und Kleinbuchstaben sowie Zahlen enthalten.<br />Sie dürfen Bindestriche, Unterstriche und Leerzeichen enthalten – jedoch nicht an folgenden Stellen:<br />- am Anfang oder am Ende des Namens<br />- direkt nebeneinander<br />- mehr als dreimal im Namen',
        'tooltip_rename_moon'           => 'Hier kannst du deinen Mond umbenennen.<br /><br />Der Mondname muss zwischen <span style="font-weight: bold;">2 und 20 Zeichen</span> lang sein.<br />Mondnamen dürfen Groß- und Kleinbuchstaben sowie Zahlen enthalten.<br />Sie dürfen Bindestriche, Unterstriche und Leerzeichen enthalten – jedoch nicht an folgenden Stellen:<br />- am Anfang oder am Ende des Namens<br />- direkt nebeneinander<br />- mehr als dreimal im Namen',

        // Aufgeben-Abschnittsüberschriften
        'abandon_home_planet'           => 'Heimatplaneten aufgeben',
        'abandon_moon'                  => 'Mond aufgeben',
        'abandon_colony'                => 'Kolonie aufgeben',
        'abandon_home_planet_btn'       => 'Heimatplaneten aufgeben',
        'abandon_moon_btn'              => 'Mond aufgeben',
        'abandon_colony_btn'            => 'Kolonie aufgeben',

        // Aufgeben-Warnungen
        'home_planet_warning'           => 'Wenn du deinen Heimatplaneten aufgibst, wirst du beim nächsten Login sofort zum Planeten weitergeleitet, den du danach besiedelt hast.',
        'items_lost_moon'               => 'Wenn du auf einem Mond Items aktiviert hast, gehen diese verloren, wenn du den Mond aufgibst.',
        'items_lost_planet'             => 'Wenn du auf einem Planeten Items aktiviert hast, gehen diese verloren, wenn du den Planeten aufgibst.',

        // Aufgeben-Bestätigungsformular
        'confirm_password'              => 'Bitte bestätige die Löschung von :type [:coordinates] durch Eingabe deines Passworts',
        'confirm_btn'                   => 'Bestätigen',
        'type_moon'                     => 'Mond',
        'type_planet'                   => 'Planet',

        // Validierungsmeldungen (JS)
        'validation_min_chars'          => 'Nicht genug Zeichen',
        'validation_pw_min'             => 'Das eingegebene Passwort ist zu kurz (mind. 4 Zeichen)',
        'validation_pw_max'             => 'Das eingegebene Passwort ist zu lang (max. 20 Zeichen)',
        'validation_email'              => 'Du musst eine gültige E-Mail-Adresse eingeben!',
        'validation_special'            => 'Enthält ungültige Zeichen.',
        'validation_underscore'         => 'Dein Name darf nicht mit einem Unterstrich beginnen oder enden.',
        'validation_hyphen'             => 'Dein Name darf nicht mit einem Bindestrich beginnen oder enden.',
        'validation_space'              => 'Dein Name darf nicht mit einem Leerzeichen beginnen oder enden.',
        'validation_max_underscores'    => 'Dein Name darf insgesamt nicht mehr als 3 Unterstriche enthalten.',
        'validation_max_hyphens'        => 'Dein Name darf nicht mehr als 3 Bindestriche enthalten.',
        'validation_max_spaces'         => 'Dein Name darf insgesamt nicht mehr als 3 Leerzeichen enthalten.',
        'validation_consec_underscores' => 'Du darfst nicht zwei oder mehr Unterstriche hintereinander verwenden.',
        'validation_consec_hyphens'     => 'Du darfst nicht zwei oder mehr Bindestriche hintereinander verwenden.',
        'validation_consec_spaces'      => 'Du darfst nicht zwei oder mehr Leerzeichen hintereinander verwenden.',

        // Controller-Nachrichten
        'msg_invalid_planet_name'       => 'Der neue Planetenname ist ungültig. Bitte versuche es erneut.',
        'msg_invalid_moon_name'         => 'Der neue Mondname ist ungültig. Bitte versuche es erneut.',
        'msg_planet_renamed'            => 'Planet erfolgreich umbenannt.',
        'msg_moon_renamed'              => 'Mond erfolgreich umbenannt.',
        'msg_wrong_password'            => 'Falsches Passwort!',
        'msg_confirm_title'             => 'Bestätigen',
        'msg_confirm_deletion'          => 'Wenn du die Löschung von :type [:coordinates] (:name) bestätigst, werden alle Gebäude, Schiffe und Verteidigungsanlagen auf diesem :type von deinem Konto entfernt. Wenn du auf deinem :type Items aktiv hast, gehen diese ebenfalls verloren, wenn du den :type aufgibst. Dieser Vorgang kann nicht rückgängig gemacht werden!',
        'msg_reference'                 => 'Referenz',
        'msg_abandoned'                 => ':type wurde erfolgreich aufgegeben!',
        'msg_type_moon'                 => 'Mond',
        'msg_type_planet'               => 'Planet',
        'msg_yes'                       => 'Ja',
        'msg_no'                        => 'Nein',
        'msg_ok'                        => 'Ok',
    ],
];
