<?php

return [
    // Raumdock-Gebäude
    'space_dock' => [
        'name'             => 'Raumdock',
        'description'      => 'Im Raumdock können Wracks repariert werden.',
        'description_long' => 'Das Raumdock bietet die Möglichkeit, im Kampf zerstörte Schiffe zu reparieren, die Wracks hinterlassen haben. Die Reparaturzeit beträgt maximal 12 Stunden, es dauert jedoch mindestens 30 Minuten, bis die Schiffe wieder einsatzbereit sind.

Da das Raumdock im Orbit schwebt, belegt es kein Planetenfeld.',
        'requirements'     => 'Benötigt Raumschiffwerft Stufe 2',
        'field_consumption' => 'Belegt kein Planetenfeld (schwebt im Orbit)',

        // Raumdock-Oberfläche
        'wreck_field_section' => 'Trümmerfeld',
        'no_wreck_field'      => 'An diesem Ort ist kein Trümmerfeld verfügbar.',
        'wreck_field_info'    => 'Es ist ein Trümmerfeld mit reparierbaren Schiffen verfügbar.',
        'ships_available'     => 'Schiffe zur Reparatur verfügbar: {count}',
        'repair_capacity'     => 'Reparaturkapazität basierend auf Raumdock Stufe {level}',

        // Reparaturaktionen
        'start_repair'        => 'Trümmerfeld reparieren starten',
        'repair_in_progress'  => 'Reparaturen laufen',
        'repair_completed'    => 'Reparaturen abgeschlossen',
        'deploy_ships'        => 'Reparierte Schiffe einsetzen',
        'burn_wreck_field'    => 'Trümmerfeld verbrennen',

        // Reparaturinformationen
        'repair_time'         => 'Geschätzte Reparaturzeit: {time}',
        'repair_progress'     => 'Reparaturfortschritt: {progress} %',
        'completion_time'     => 'Fertigstellung: {time}',
        'auto_deploy_warning' => 'Schiffe werden {hours} Stunden nach Reparaturabschluss automatisch eingesetzt, falls nicht manuell eingesetzt.',

        // Stufeneffekte
        'level_effects' => [
            'repair_speed'      => 'Reparaturgeschwindigkeit um {bonus} % erhöht',
            'capacity_increase' => 'Maximale Anzahl reparierbarer Schiffe erhöht',
        ],

        // Statusmeldungen
        'status' => [
            'no_dock'          => 'Raumdock zum Reparieren von Trümmerfeldern erforderlich',
            'level_too_low'    => 'Raumdock Stufe 1 zum Reparieren von Trümmerfeldern erforderlich',
            'no_wreck_field'   => 'Kein Trümmerfeld verfügbar',
            'repairing'        => 'Trümmerfeld wird derzeit repariert',
            'ready_to_deploy'  => 'Reparaturen abgeschlossen, Schiffe einsatzbereit',
        ],
    ],

    // Allgemeine Einrichtungsmeldungen
    'actions' => [
        'build'     => 'Bauen',
        'upgrade'   => 'Auf Stufe {level} ausbauen',
        'downgrade' => 'Auf Stufe {level} zurückbauen',
        'demolish'  => 'Abreißen',
        'cancel'    => 'Abbrechen',
    ],

    // Voraussetzungen
    'requirements' => [
        'met'       => 'Voraussetzungen erfüllt',
        'not_met'   => 'Voraussetzungen nicht erfüllt',
        'research'  => 'Forschung: {requirement}',
        'building'  => 'Gebäude: {requirement} Stufe {level}',
    ],

    // Rohstoffe
    'cost' => [
        'metal'       => 'Metall: {amount}',
        'crystal'     => 'Kristall: {amount}',
        'deuterium'   => 'Deuterium: {amount}',
        'energy'      => 'Energie: {amount}',
        'dark_matter' => 'Dunkle Materie: {amount}',
        'total'       => 'Gesamtkosten: {amount}',
    ],

    // Zeit
    'construction_time' => 'Bauzeit: {time}',
    'upgrade_time'      => 'Ausbauzeit: {time}',
];
