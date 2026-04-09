<?php

/*
|--------------------------------------------------------------------------
| Außerhalb des Spiels / Startseite - Deutsch
|--------------------------------------------------------------------------
*/

return [
    // Browser-Veraltungswarnung
    'browser_warning' => [
        'title'  => 'Dein Browser ist nicht aktuell.',
        'desc1'  => 'Deine Internet-Explorer-Version entspricht nicht den aktuellen Standards und wird von dieser Website nicht mehr unterstützt.',
        'desc2'  => 'Um diese Website zu nutzen, aktualisiere bitte deinen Webbrowser auf eine aktuelle Version oder verwende einen anderen Browser. Falls du bereits die neueste Version verwendest, lade die Seite bitte neu, um sie korrekt anzuzeigen.',
        'desc3'  => 'Hier ist eine Liste der beliebtesten Browser. Klicke auf eines der Symbole, um zur Download-Seite zu gelangen:',
    ],

    // Anmeldeformular (Kopfzeile)
    'login' => [
        'page_title'        => 'OGame - Erobere das Universum',
        'btn'               => 'Anmelden',
        'email_label'       => 'E-Mail-Adresse:',
        'password_label'    => 'Passwort:',
        'universe_label'    => 'Universum:',
        'universe_option_1' => '1. Universum',
        'submit'            => 'Einloggen',
        'forgot_password'   => 'Passwort vergessen?',
        'forgot_email'      => 'E-Mail-Adresse vergessen?',
        'terms_accept_html' => 'Mit dem Login akzeptiere ich die <a class="" href="#" target="_blank" title="AGB">AGB</a>',
    ],

    // Registrierungsformular (Seitenleiste)
    'register' => [
        'play_free'      => 'KOSTENLOS SPIELEN!',
        'email_label'    => 'E-Mail-Adresse:',
        'password_label' => 'Passwort:',
        'universe_label' => 'Universum:',
        'distinctions'   => 'Auszeichnungen',
        'terms_html'     => 'Im Spiel gelten unsere <a class="" target="_blank" href="#" title="AGB"> AGB </a> und <a class="" target="_blank" href="#" title="Datenschutzerklärung"> Datenschutzerklärung </a>',
        'submit'         => 'Registrieren',
    ],

    // Obere Navigations-Tabs
    'nav' => [
        'home'  => 'Startseite',
        'about' => 'Über OGame',
        'media' => 'Medien',
        'wiki'  => 'Wiki',
    ],

    // Inhalt des Startseiten-Tabs
    'home' => [
        'title'            => 'OGame - Erobere das Universum',
        'description_html' => '<em>OGame</em> ist ein Strategiespiel im Weltraum, bei dem Tausende Spieler aus aller Welt gleichzeitig gegeneinander antreten. Du benötigst lediglich einen normalen Webbrowser zum Spielen.',
        'board_btn'        => 'Forum',
        'trailer_title'    => 'Trailer',
    ],

    // Fußzeile
    'footer' => [
        'legal'          => 'Impressum',
        'privacy_policy' => 'Datenschutzerklärung',
        'terms'          => 'AGB',
        'contact'        => 'Kontakt',
        'rules'          => 'Regeln',
        'copyright'      => '© OGameX. Alle Rechte vorbehalten.',
    ],

    // Inline-JS-Strings
    'js' => [
        'login'            => 'Anmelden',
        'close'            => 'Schließen',
        'age_check_failed' => 'Es tut uns leid, aber du bist nicht berechtigt, dich zu registrieren. Weitere Informationen findest du in unseren AGB.',
    ],

    // jQuery ValidationEngine-Strings
    'validation' => [
        'required'                   => 'Dieses Feld ist erforderlich',
        'make_decision'              => 'Bitte triff eine Entscheidung',
        'accept_terms'               => 'Du musst die AGB akzeptieren.',
        'length'                     => 'Zwischen 3 und 20 Zeichen erlaubt.',
        'pw_length'                  => 'Zwischen 4 und 20 Zeichen erlaubt.',
        'email'                      => 'Bitte gib eine gültige E-Mail-Adresse ein!',
        'invalid_chars'              => 'Enthält ungültige Zeichen.',
        'no_begin_end_underscore'    => 'Dein Name darf nicht mit einem Unterstrich beginnen oder enden.',
        'no_begin_end_whitespace'    => 'Dein Name darf nicht mit einem Leerzeichen beginnen oder enden.',
        'max_three_underscores'      => 'Dein Name darf insgesamt nicht mehr als 3 Unterstriche enthalten.',
        'max_three_whitespaces'      => 'Dein Name darf insgesamt nicht mehr als 3 Leerzeichen enthalten.',
        'no_consecutive_underscores' => 'Du darfst nicht zwei oder mehr Unterstriche hintereinander verwenden.',
        'no_consecutive_whitespaces' => 'Du darfst nicht zwei oder mehr Leerzeichen hintereinander verwenden.',
        'username_available'         => 'Dieser Benutzername ist verfügbar.',
        'username_loading'           => 'Bitte warten, wird geladen...',
        'username_taken'             => 'Dieser Benutzername ist nicht mehr verfügbar.',
        'only_letters'               => 'Nur Buchstaben verwenden.',
    ],

    // Universumscharakteristiken – Tooltip-Texte
    'universe_characteristics' => [
        'fleet_speed'      => 'Flottengeschwindigkeit: Je höher der Wert, desto weniger Zeit bleibt dir, auf einen Angriff zu reagieren.',
        'economy_speed'    => 'Wirtschaftsgeschwindigkeit: Je höher der Wert, desto schneller werden Gebäude und Forschung abgeschlossen und Rohstoffe gesammelt.',
        'debris_ships'     => 'Ein Teil der im Kampf zerstörten Schiffe gelangt in das Trümmerfeld.',
        'debris_defence'   => 'Ein Teil der im Kampf zerstörten Verteidigungsanlagen gelangt in das Trümmerfeld.',
        'dark_matter_gift' => 'Du erhältst Dunkle Materie als Belohnung für die Bestätigung deiner E-Mail-Adresse.',
        'aks_on'           => 'Allianz-Kampfsystem aktiviert',
        'planet_fields'    => 'Die maximale Anzahl der Baufelder wurde erhöht.',
        'wreckfield'       => 'Raumdock aktiviert: Einige zerstörte Schiffe können mit dem Raumdock wiederhergestellt werden.',
        'universe_big'     => 'Anzahl der Galaxien im Universum',
    ],
];
