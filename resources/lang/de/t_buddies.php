<?php

return [
    // Fehlermeldungen
    'error' => [
        'cannot_send_to_self'      => 'Du kannst keine Freundschaftsanfrage an dich selbst senden.',
        'user_not_found'           => 'Benutzer nicht gefunden.',
        'cannot_send_to_admin'     => 'Du kannst keine Freundschaftsanfragen an Administratoren senden.',
        'cannot_send_to_user'      => 'Du kannst keine Freundschaftsanfrage an diesen Benutzer senden.',
        'already_buddies'          => 'Du bist bereits mit diesem Benutzer befreundet.',
        'request_exists'           => 'Zwischen diesen Benutzern existiert bereits eine Freundschaftsanfrage.',
        'request_not_found'        => 'Freundschaftsanfrage nicht gefunden.',
        'not_authorized_accept'    => 'Du bist nicht berechtigt, diese Anfrage anzunehmen.',
        'not_authorized_reject'    => 'Du bist nicht berechtigt, diese Anfrage abzulehnen.',
        'not_authorized_cancel'    => 'Du bist nicht berechtigt, diese Anfrage abzubrechen.',
        'already_processed'        => 'Diese Anfrage wurde bereits bearbeitet.',
        'relationship_not_found'   => 'Freundschaftsbeziehung nicht gefunden.',
        'cannot_ignore_self'       => 'Du kannst dich selbst nicht ignorieren.',
        'already_ignored'          => 'Spieler wird bereits ignoriert.',
        'not_in_ignore_list'       => 'Spieler befindet sich nicht auf deiner Ignorierliste.',
        'send_request_failed'      => 'Freundschaftsanfrage konnte nicht gesendet werden.',
        'ignore_player_failed'     => 'Spieler konnte nicht ignoriert werden.',
        'delete_buddy_failed'      => 'Freund konnte nicht gelöscht werden.',
        'search_too_short'         => 'Zu wenige Zeichen! Bitte gib mindestens 2 Zeichen ein.',
        'invalid_action'           => 'Ungültige Aktion',
    ],

    // Erfolgsmeldungen
    'success' => [
        'request_sent'             => 'Freundschaftsanfrage erfolgreich gesendet!',
        'request_cancelled'        => 'Freundschaftsanfrage erfolgreich abgebrochen.',
        'request_accepted'         => 'Freundschaftsanfrage angenommen!',
        'request_rejected'         => 'Freundschaftsanfrage abgelehnt',
        'request_accepted_symbol'  => '✓ Freundschaftsanfrage angenommen',
        'request_rejected_symbol'  => '✗ Freundschaftsanfrage abgelehnt',
        'buddy_deleted'            => 'Freund erfolgreich gelöscht!',
        'player_ignored'           => 'Spieler erfolgreich ignoriert!',
        'player_unignored'         => 'Spieler erfolgreich nicht mehr ignoriert.',
    ],

    // UI-Beschriftungen und Titel
    'ui' => [
        'page_title'               => 'Freunde',
        'my_buddies'               => 'Meine Freunde',
        'ignored_players'          => 'Ignorierte Spieler',
        'buddy_request'            => 'Freundschaftsanfrage',
        'buddy_request_title'      => 'Freundschaftsanfrage',
        'buddy_request_to'         => 'Freundschaftsanfrage an',
        'buddy_requests'           => 'Freundschaftsanfragen',
        'new_buddy_request'        => 'Neue Freundschaftsanfrage',
        'write_message'            => 'Nachricht schreiben',
        'send_message'             => 'Nachricht senden',
        'send'                     => 'senden',
        'search_placeholder'       => 'Suchen...',
        'no_buddies_found'         => 'Keine Freunde gefunden',
        'no_buddy_requests'        => 'Du hast derzeit keine Freundschaftsanfragen.',
        'no_requests_sent'         => 'Du hast keine Freundschaftsanfragen gesendet.',
        'no_ignored_players'       => 'Keine ignorierten Spieler',
        'requests_received'        => 'erhaltene Anfragen',
        'requests_sent'            => 'gesendete Anfragen',
        'new'                      => 'neu',
        'new_label'                => 'Neu',
        'from'                     => 'Von:',
        'to'                       => 'An:',
        'online'                   => 'online',
        'status_on'                => 'An',
        'status_off'               => 'Aus',
        'received_request_from'    => 'Du hast eine neue Freundschaftsanfrage von',
        'buddy_request_to_player'  => 'Freundschaftsanfrage an Spieler',
        'ignore_player_title'      => 'Spieler ignorieren',
    ],

    // Aktionen
    'action' => [
        'accept_request'           => 'Freundschaftsanfrage annehmen',
        'reject_request'           => 'Freundschaftsanfrage ablehnen',
        'withdraw_request'         => 'Freundschaftsanfrage zurückziehen',
        'delete_buddy'             => 'Freund löschen',
        'confirm_delete_buddy'     => 'Möchtest du deinen Freund wirklich löschen',
        'add_as_buddy'             => 'Als Freund hinzufügen',
        'ignore_player'            => 'Bist du sicher, dass du ignorieren möchtest',
        'remove_from_ignore'       => 'Von der Ignorierliste entfernen',
        'report_message'           => 'Diese Nachricht einem Spielleiter melden?',
    ],

    // Tabellenköpfe
    'table' => [
        'id'       => 'ID',
        'name'     => 'Name',
        'points'   => 'Punkte',
        'rank'     => 'Rang',
        'alliance' => 'Allianz',
        'coords'   => 'Koordinaten',
        'actions'  => 'Aktionen',
    ],

    // Allgemein
    'common' => [
        'yes'     => 'ja',
        'no'      => 'Nein',
        'caution' => 'Achtung',
    ],
];
