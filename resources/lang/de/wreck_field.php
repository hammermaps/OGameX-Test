<?php

return [
    // Trümmerfeld – Informationen und Status
    'wreck_field'          => 'Trümmerfeld',
    'wreck_field_formed'   => 'Trümmerfeld hat sich bei den Koordinaten {coordinates} gebildet',
    'wreck_field_expired'  => 'Trümmerfeld ist abgelaufen',
    'wreck_field_burned'   => 'Trümmerfeld wurde verbrannt',

    // Trümmerfeld – Bedingungen
    'formation_conditions' => 'Ein Trümmerfeld entsteht, wenn mindestens {min_resources} Rohstoffe verloren gehen und mindestens {min_percentage} % der verteidigenden Flotte zerstört wird.',
    'resources_lost'       => 'Verlorene Rohstoffe: {amount}',
    'fleet_percentage'     => 'Flotte zerstört: {percentage} %',

    // Reparaturinformationen
    'repair_time'          => 'Reparaturzeit',
    'repair_progress'      => 'Reparaturfortschritt',
    'repair_completed'     => 'Reparatur abgeschlossen',
    'repairs_underway'     => 'Reparaturen laufen',
    'repair_duration_min'  => 'Mindest-Reparaturzeit: {minutes} Minuten',
    'repair_duration_max'  => 'Maximale Reparaturzeit: {hours} Stunden',
    'repair_speed_bonus'   => 'Raumdock Stufe {level} gewährt {bonus} % Reparaturgeschwindigkeitsbonus',

    // Schiffe im Trümmerfeld
    'ships_in_wreck_field' => 'Schiffe im Trümmerfeld',
    'ship_type'            => 'Schiffstyp',
    'quantity'             => 'Menge',
    'repairable'           => 'Reparierbar',
    'total_ships'          => 'Schiffe gesamt: {count}',

    // Aktionen
    'start_repairs'        => 'Reparaturen starten',
    'complete_repairs'     => 'Reparaturen abschließen',
    'burn_wreck_field'     => 'Trümmerfeld verbrennen',
    'cancel_repairs'       => 'Reparaturen abbrechen',

    // Aktionsmeldungen
    'repair_started'            => 'Reparaturen haben begonnen. Fertigstellungszeit: {time}',
    'repairs_completed'         => 'Alle Reparaturen wurden abgeschlossen. Schiffe sind einsatzbereit.',
    'wreck_field_burned_success' => 'Trümmerfeld wurde erfolgreich verbrannt.',
    'cannot_repair'             => 'Dieses Trümmerfeld kann nicht repariert werden.',
    'cannot_burn'               => 'Dieses Trümmerfeld kann nicht verbrannt werden, solange Reparaturen laufen.',

    // Galaxieansicht
    'wreck_field_icon'     => 'TF',
    'wreck_field_tooltip'  => 'Trümmerfeld (noch {time_remaining})',
    'click_to_repair'      => 'Klicke, um zum Raumdock für Reparaturen zu gelangen',
    'no_wreck_field'       => 'Kein Trümmerfeld',

    // Raumdock-Integration
    'space_dock_required'     => 'Raumdock Stufe 1 ist erforderlich, um Trümmerfelder zu reparieren.',
    'space_dock_level'        => 'Raumdock Stufe: {level}',
    'upgrade_space_dock'      => 'Raumdock ausbauen, um mehr Schiffe zu reparieren',
    'repair_capacity_reached' => 'Maximale Reparaturkapazität erreicht. Raumdock ausbauen, um die Kapazität zu erhöhen.',

    // Kampfberichte
    'wreck_field_section'           => 'Trümmerfeldinformationen',
    'ships_available_for_repair'    => 'Schiffe zur Reparatur verfügbar: {count}',
    'wreck_field_resources'         => 'Das Trümmerfeld enthält Schiffe im Wert von etwa {value} Rohstoffen.',

    // Administrator-Einstellungen
    'settings_title'                 => 'Trümmerfeld-Einstellungen',
    'enabled_description'            => 'Trümmerfelder ermöglichen die Reparatur zerstörter Schiffe über das Raumdock-Gebäude. Schiffe können repariert werden, wenn die Zerstörung bestimmte Kriterien erfüllt.',
    'percentage_setting'             => 'Zerstörte Schiffe im Trümmerfeld:',
    'min_resources_setting'          => 'Mindest-Zerstörung für Trümmerfelder:',
    'min_fleet_percentage_setting'   => 'Mindestanteil der zerstörten Flotte:',
    'lifetime_setting'               => 'Lebensdauer des Trümmerfeldes (Stunden):',
    'repair_max_time_setting'        => 'Maximale Reparaturzeit (Stunden):',
    'repair_min_time_setting'        => 'Minimale Reparaturzeit (Minuten):',

    // Fehler und Warnungen
    'error_no_wreck_field'           => 'Kein Trümmerfeld an diesem Ort gefunden.',
    'error_not_owner'                => 'Du besitzt dieses Trümmerfeld nicht.',
    'error_already_repairing'        => 'Reparaturen laufen bereits.',
    'error_no_ships'                 => 'Keine Schiffe zur Reparatur verfügbar.',
    'error_space_dock_required'      => 'Raumdock Stufe 1 ist erforderlich, um Trümmerfelder zu reparieren.',
    'error_cannot_collect_late_added' => 'Während laufender Reparaturen hinzugefügte Schiffe können nicht manuell eingesammelt werden. Du musst warten, bis alle Reparaturen automatisch abgeschlossen sind.',
    'warning_auto_return'            => 'Reparierte Schiffe werden {hours} Stunden nach Reparaturabschluss automatisch in Dienst gestellt.',

    // Verbleibende Zeit
    'time_remaining'       => 'noch {hours}h {minutes}m',
    'expires_soon'         => 'Läuft bald ab',
    'repair_time_remaining' => 'Reparaturabschluss: {time}',

    // Statusmeldungen
    'status_active'     => 'Aktiv',
    'status_repairing'  => 'Wird repariert',
    'status_completed'  => 'Abgeschlossen',
    'status_burned'     => 'Verbrannt',
    'status_expired'    => 'Abgelaufen',

    // Aktionsergebnisse
    'repairs_started'       => 'Reparaturen erfolgreich gestartet',
    'all_ships_deployed'    => 'Alle Schiffe wurden wieder in Dienst gestellt',
    'no_ships_ready'        => 'Keine Schiffe bereit zur Einsammlung',
    'repairs_not_started'   => 'Reparaturen wurden noch nicht begonnen',
];
