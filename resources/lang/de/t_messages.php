<?php

return [
    // ------------------------
    'welcome_message' => [
        'from' => 'OGameX',
        'subject' => 'Willkommen bei OGameX!',
        'body' => 'Grüße, Kaiser :player!

Herzlichen Glückwunsch zum Beginn deiner ruhmreichen Karriere. Ich werde dir bei deinen ersten Schritten behilflich sein.

Auf der linken Seite siehst du das Menü, mit dem du dein galaktisches Imperium überwachen und regieren kannst.

Du hast bereits die Übersicht gesehen. Unter Ressourcen und Einrichtungen kannst du Gebäude errichten, um dein Imperium auszubauen. Beginne damit, ein Solarkraftwerk zu bauen, um Energie für deine Minen zu gewinnen.

Baue dann deine Metallmine und Kristallmine aus, um wichtige Ressourcen zu produzieren. Schau dich ansonsten einfach selbst um. Du wirst dich sicher schnell heimisch fühlen.

Weitere Hilfe, Tipps und Taktiken findest du hier:

Discord Chat: Discord Server
Forum: OGameX Forum
Support: Spielsupport

Aktuelle Ankündigungen und Änderungen am Spiel findest du nur in den Foren.


Jetzt bist du bereit für die Zukunft. Viel Erfolg!

Diese Nachricht wird in 7 Tagen gelöscht.',
    ],

    // ------------------------
    'return_of_fleet_with_resources' => [
        'from' => 'Flottenkommando',
        'subject' => 'Rückkehr einer Flotte',
        'body' => 'Deine Flotte kehrt von :from nach :to zurück und hat folgende Waren geliefert:

Metall: :metal
Kristall: :crystal
Deuterium: :deuterium',
    ],

    // ------------------------
    'return_of_fleet' => [
        'from' => 'Flottenkommando',
        'subject' => 'Rückkehr einer Flotte',
        'body' => 'Deine Flotte kehrt von :from nach :to zurück.

Die Flotte liefert keine Waren.',
        ],

    // ------------------------
    'fleet_deployment_with_resources' => [
        'from' => 'Flottenkommando',
        'subject' => 'Rückkehr einer Flotte',
        'body' => 'Eine deiner Flotten von :from hat :to erreicht und folgende Waren geliefert:

Metall: :metal
Kristall: :crystal
Deuterium: :deuterium',
    ],

    // ------------------------
    'fleet_deployment' => [
        'from' => 'Flottenkommando',
        'subject' => 'Rückkehr einer Flotte',
        'body' => 'Eine deiner Flotten von :from hat :to erreicht. Die Flotte liefert keine Waren.',
        ],

    // ------------------------
    'transport_arrived' => [
        'from' => 'Flottenkommando',
        'subject' => 'Erreichen eines Planeten',
        'body' => 'Deine Flotte von :from erreicht :to und liefert folgende Waren:
Metall: :metal Kristall: :crystal Deuterium: :deuterium',
        ],

    // ------------------------
    'transport_received' => [
        'from' => 'Flottenkommando',
        'subject' => 'Eingehende Flotte',
        'body' => 'Eine eingehende Flotte von :from hat deinen Planeten :to erreicht und folgende Waren geliefert:
Metall: :metal Kristall: :crystal Deuterium: :deuterium',
    ],

    // ------------------------
    'acs_defend_arrival_host' => [
        'from' => 'Raumüberwachung',
        'subject' => 'Flotte steht still',
        'body' => 'Eine Flotte ist bei :to eingetroffen.',
    ],

    // ------------------------
    'acs_defend_arrival_sender' => [
        'from' => 'Flottenkommando',
        'subject' => 'Flotte steht still',
        'body' => 'Eine Flotte ist bei :to eingetroffen.',
    ],

    // ------------------------
    'colony_established' => [
        'from' => 'Flottenkommando',
        'subject' => 'Siedlungsbericht',
        'body' => 'Die Flotte ist bei den zugewiesenen Koordinaten :coordinates eingetroffen, hat dort einen neuen Planeten gefunden und beginnt sofort mit dessen Erschließung.',
    ],

    // ------------------------
    'colony_establish_fail_astrophysics' => [
        'from' => 'Siedler',
        'subject' => 'Siedlungsbericht',
        'body' => 'Die Flotte ist bei den zugewiesenen Koordinaten :coordinates eingetroffen und stellt fest, dass der Planet für eine Kolonisierung geeignet ist. Kurz nach Beginn der Erschließung erkennen die Kolonisten jedoch, dass ihre Kenntnisse der Astrophysik nicht ausreichen, um die Kolonisierung eines neuen Planeten abzuschließen.',
    ],

    // ------------------------
    'espionage_report' => [
        'from' => 'Flottenkommando',
        'subject' => 'Spionagebericht von :planet',
    ],

    // ------------------------
    'espionage_detected' => [
        'from' => 'Flottenkommando',
        'subject' => 'Spionagebericht von Planet :planet',
        'body' => "Eine fremde Flotte von Planet :planet (:attacker_name) wurde in der Nähe deines Planeten gesichtet\n:defender\nChance auf Gegenpionage: :chance%",
    ],

    // ------------------------
    'battle_report' => [
        'from' => 'Flottenkommando',
        'subject' => 'Kampfbericht :planet',
    ],

      // ------------------------
    'fleet_lost_contact' => [
        'from' => 'Flottenkommando',
        'subject' => 'Kontakt zur angreifenden Flotte verloren. :coordinates',
        'body' => '(Das bedeutet, sie wurde in der ersten Runde zerstört.)',
    ],

    // ------------------------
    'debris_field_harvest' => [
        'from' => 'Flotte',
        'subject' => 'Erntebericht von TF bei :coordinates',
        'body' => 'Dein :ship_name (:ship_amount Schiffe) hat eine Gesamtladekapazität von :storage_capacity. Am Zielort :to treiben :metal Metall, :crystal Kristall und :deuterium Deuterium im All. Du hast :harvested_metal Metall, :harvested_crystal Kristall und :harvested_deuterium Deuterium geerntet.',
    ],

    // ------------------------
    // Expeditions – allgemeine Nachrichtenteile
    'expedition_resources_captured' => ':resource_type :resource_amount wurden erbeutet.',
    'expedition_dark_matter_captured' => '(:dark_matter_amount Dunkle Materie)',
    'expedition_units_captured' => 'Folgende Schiffe sind jetzt Teil der Flotte:',

    'expedition_unexplored_statement' => 'Eintrag aus dem Logbuch des Kommunikationsoffiziers: Es scheint, dass dieser Teil des Universums noch nicht erforscht wurde.',

    // Expedition Fehlgeschlagen
    'expedition_failed' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionFailed verarbeitet werden.
        'body' => [
            '1' => 'Aufgrund eines Ausfalls der Zentralcomputer des Flaggschiffs musste die Expeditionsmission abgebrochen werden. Infolge der Computerstörung kehrt die Flotte leider mit leeren Händen zurück.',
            '2' => 'Deine Expedition geriet beinahe in das Gravitationsfeld eines Neutronensterns und benötigte einige Zeit, um sich zu befreien. Dadurch wurde sehr viel Deuterium verbraucht und die Expeditionsflotte musste ohne Ergebnisse zurückkehren.',
            '3' => 'Aus unbekannten Gründen ging der Sprung der Expedition vollkommen schief. Die Flotte landete beinahe im Herzen einer Sonne. Glücklicherweise landete sie in einem bekannten System, aber der Rücksprung wird länger dauern als gedacht.',
            '4' => 'Ein Fehler im Reaktorkern des Flaggschiffs hätte die gesamte Expeditionsflotte beinahe zerstört. Glücklicherweise waren die Techniker mehr als kompetent und konnten das Schlimmste verhindern. Die Reparaturen nahmen einige Zeit in Anspruch und zwangen die Expedition, ohne ihr Ziel erreicht zu haben, zurückzukehren.',
            '5' => 'Ein aus reiner Energie bestehendes Lebewesen kam an Bord und versetzte alle Expeditionsmitglieder in eine seltsame Trance. Sie starrten nur auf die hypnotisierenden Muster auf den Computerbildschirmen. Als die meisten von ihnen schließlich aus dem hypnotischen Zustand erwachten, musste die Mission abgebrochen werden, da zu wenig Deuterium vorhanden war.',
            '6' => 'Das neue Navigationsmodul hat noch Fehler. Der Sprung der Expedition führte sie nicht nur in die falsche Richtung, sondern verbrauchte auch den gesamten Deuterium-Treibstoff. Glücklicherweise landete die Flotte in der Nähe des Mondes des Ausgangsplaneten. Etwas enttäuscht kehrt die Expedition nun ohne Impulsantrieb zurück. Der Rückweg wird länger dauern als erwartet.',
            '7' => 'Deine Expedition hat die ausgedehnte Leere des Weltraums kennen gelernt. Es gab nicht einmal einen kleinen Asteroiden, Strahlung oder ein Teilchen, das diese Expedition interessant gemacht hätte.',
            '8' => 'Nun wissen wir, dass diese roten, Klasse-5-Anomalien nicht nur chaotische Auswirkungen auf die Navigationssysteme der Schiffe haben, sondern auch massive Halluzinationen bei der Besatzung erzeugen. Die Expedition brachte nichts zurück.',
            '9' => 'Deine Expedition hat wunderschöne Bilder einer Supernova gemacht. Aus der Expedition konnte nichts Neues gewonnen werden, aber immerhin besteht eine gute Chance, den Wettbewerb „Bestes Bild des Universums" in der nächsten Ausgabe des OGame-Magazins zu gewinnen.',
            '10' => 'Deine Expeditionsflotte folgte einige Zeit seltsamen Signalen. Am Ende stellten sie fest, dass diese Signale von einer alten Sonde stammten, die vor Generationen ausgesandt worden war, um fremde Spezies zu begrüßen. Die Sonde wurde gerettet und einige Museen auf deinem Heimatplaneten haben bereits ihr Interesse bekundet.',
            '11' => 'Trotz der ersten, sehr vielversprechenden Scans dieses Sektors sind wir leider mit leeren Händen zurückgekehrt.',
            '12' => 'Außer einigen kuriosen kleinen Haustieren von einem unbekannten Sumpfplaneten bringt diese Expedition nichts Aufregendes von der Reise zurück.',
            '13' => 'Das Flaggschiff der Expedition kollidierte mit einem fremden Schiff, das ohne jede Vorwarnung in die Flotte gesprungen ist. Das fremde Schiff explodierte und das Flaggschiff wurde erheblich beschädigt. Die Expedition kann unter diesen Umständen nicht fortgesetzt werden, sodass die Flotte nach Abschluss der notwendigen Reparaturen den Rückweg antreten wird.',
            '14' => 'Unser Expeditionsteam stieß auf eine seltsame Kolonie, die vor Äonen verlassen worden war. Nach der Landung begann unsere Besatzung unter hohem Fieber zu leiden, das durch einen fremden Virus verursacht wurde. Es wurde festgestellt, dass dieser Virus die gesamte Zivilisation auf dem Planeten ausgelöscht hatte. Unser Expeditionsteam bricht auf, um die erkrankten Besatzungsmitglieder zu behandeln. Leider mussten wir die Mission abbrechen und kehren mit leeren Händen zurück.',
            '15' => 'Ein seltsamer Computervirus befiel das Navigationssystem kurz nach dem Verlassen unseres Heimatsystems. Dadurch flog die Expeditionsflotte im Kreis. Unnötig zu sagen, dass die Expedition nicht wirklich erfolgreich war.',
        ],
    ],

    // Ressourcen erbeuten
    'expedition_gain_resources' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionGainResources verarbeitet werden.
        'body' => [
            '1' => 'Auf einem abgelegenen Planetoiden haben wir einige leicht zugängliche Ressourcenfelder gefunden und erfolgreich geerntet.',
            '2' => 'Deine Expedition entdeckte einen kleinen Asteroiden, von dem einige Ressourcen geerntet werden konnten.',
            '3' => 'Deine Expedition fand einen alten, vollständig beladenen, aber verlassenen Frachtkonvoi. Einige der Ressourcen konnten geborgen werden.',
            '4' => 'Die Expeditionsflotte meldet die Entdeckung eines riesigen fremden Schiffswracks. Sie konnten zwar nicht von der Technologie lernen, aber das Schiff in seine Hauptbestandteile zerlegen und daraus nützliche Ressourcen gewinnen.',
            '5' => 'Auf einem kleinen Mond mit eigener Atmosphäre fand deine Expedition riesige Rohstofflager. Die Besatzung auf dem Boden versucht, diesen Naturschatz zu bergen und zu verladen.',
            '6' => 'Mineralgürtel um einen unbekannten Planeten enthielten unzählige Ressourcen. Die Expeditionsschiffe kommen zurück und ihre Laderäume sind voll!',
        ],
    ],

    // Dunkle Materie erbeuten
    'expedition_gain_dark_matter' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionGainDarkMatter verarbeitet werden.
        'body' => [
            '1' => 'Die Expedition folgte seltsamen Signalen zu einem Asteroiden. Im Kern des Asteroiden wurde eine kleine Menge Dunkler Materie gefunden. Der Asteroid wurde genommen und die Forscher versuchen, die Dunkle Materie zu extrahieren.',
            '2' => 'Die Expedition konnte eine kleine Menge Dunkler Materie einfangen und sichern.',
            '3' => 'Wir begegneten einem seltsamen Außerirdischen auf dem Regal eines kleinen Schiffes, der uns im Tausch gegen einfache mathematische Berechnungen einen Behälter mit Dunkler Materie gab.',
            '4' => 'Wir fanden die Überreste eines fremden Schiffes. In einem Regal im Frachtraum fanden wir einen kleinen Behälter mit Dunkler Materie!',
            '5' => 'Unsere Expedition machte den Erstkontakt mit einer besonderen Rasse. Es sieht so aus, als ob ein aus reiner Energie bestehendes Wesen, das sich Legorianer nannte, durch die Expeditionsschiffe flog und sich dann entschloss, unserer unterentwickelten Spezies zu helfen. Ein Behälter mit Dunkler Materie materialisierte auf der Brücke des Schiffes!',
            '6' => 'Unsere Expedition übernahm ein Geisterschiff, das eine kleine Menge Dunkler Materie transportierte. Wir fanden keine Hinweise darauf, was mit der ursprünglichen Besatzung des Schiffes passiert ist, aber unsere Techniker konnten die Dunkle Materie bergen.',
            '7' => 'Unsere Expedition führte ein einzigartiges Experiment durch. Es gelang ihnen, Dunkle Materie aus einem sterbenden Stern zu gewinnen.',
            '8' => 'Unsere Expedition entdeckte eine verrostete Raumstation, die scheinbar seit langer Zeit unkontrolliert durch den Weltraum treibt. Die Station selbst war völlig nutzlos, jedoch wurde entdeckt, dass im Reaktor etwas Dunkle Materie gespeichert ist. Unsere Techniker versuchen, so viel wie möglich zu retten.',
        ],
    ],

    // Schiffe erbeuten
    'expedition_gain_ships' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionGainShips verarbeitet werden.
        'body' => [
            '1' => 'Unsere Expedition fand einen Planeten, der während einer Reihe von Kriegen fast vollständig zerstört wurde. Im Orbit treiben verschiedene Schiffe. Die Techniker versuchen, einige davon zu reparieren. Vielleicht erhalten wir auch Informationen darüber, was hier geschehen ist.',
            '2' => 'Wir fanden eine verlassene Piratenstation. Im Hangar liegen einige alte Schiffe. Unsere Techniker prüfen, ob einige davon noch brauchbar sind.',
            '3' => 'Deine Expedition stieß auf die Werften einer vor Äonen verlassenen Kolonie. Im Werfthangar entdeckten sie einige Schiffe, die geborgen werden konnten. Die Techniker versuchen, einige davon wieder flugfähig zu machen.',
            '4' => 'Wir stießen auf die Überreste einer früheren Expedition! Unsere Techniker werden versuchen, einige der Schiffe wieder in Betrieb zu nehmen.',
            '5' => 'Unsere Expedition stieß auf eine alte automatische Werft. Einige der Schiffe befinden sich noch in der Produktionsphase und unsere Techniker versuchen derzeit, die Energiegeneratoren der Werft wieder zu aktivieren.',
            '6' => 'Wir fanden die Überreste einer Armada. Die Techniker gingen sofort zu den nahezu intakten Schiffen, um zu versuchen, sie wieder in Betrieb zu nehmen.',
            '7' => 'Wir fanden den Planeten einer ausgestorbenen Zivilisation. Wir können eine riesige, intakte Raumstation im Orbit sehen. Einige deiner Techniker und Piloten begaben sich auf die Oberfläche, um nach noch verwendbaren Schiffen zu suchen.',
        ],
    ],

    // Gegenstand erbeuten
    'expedition_gain_item' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionGainItem verarbeitet werden.
        'body' => [
            '1' => 'Eine fliehende Flotte ließ einen Gegenstand zurück, um uns bei ihrer Flucht abzulenken.',
        ],
    ],

    // Fehlgeschlagen und Beschleunigung
    'expedition_failed_and_speedup' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionSpeedup verarbeitet werden.
        'body' => [
            '1' => 'Deine Expedition meldet keine Anomalien im erkundeten Sektor. Die Flotte geriet jedoch auf dem Rückweg in Sonnenwind. Dies führte dazu, dass der Rückweg beschleunigt wurde. Deine Expedition kehrt etwas früher zurück.',
            '2' => 'Der neue und mutige Kommandant reiste erfolgreich durch ein instabiles Wurmloch, um den Rückweg abzukürzen! Die Expedition selbst brachte jedoch nichts Neues.',
            '3' => 'Eine unerwartete Rückkopplung in den Energiespulen der Triebwerke beschleunigte die Rückkehr der Expedition; sie kehrt früher als erwartet zurück. Ersten Berichten zufolge haben sie nichts Aufregendes zu berichten.',
        ],
    ],

    // Fehlgeschlagen und Verzögerung
    'expedition_failed_and_delay' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionDelay verarbeitet werden.
        'body' => [
            '1' => 'Deine Expedition geriet in einen Sektor voller Teilchenstürme. Dies brachte die Energiespeicher zum Überlaufen und die meisten Hauptsysteme der Schiffe fielen aus. Deine Mechaniker konnten das Schlimmste verhindern, aber die Expedition wird mit großer Verspätung zurückkehren.',
            '2' => 'Dein Navigator machte einen schwerwiegenden Fehler in seinen Berechnungen, der dazu führte, dass der Sprung der Expedition falsch berechnet wurde. Die Flotte verfehlte das Ziel völlig und der Rückweg wird sehr viel mehr Zeit in Anspruch nehmen als ursprünglich geplant.',
            '3' => 'Der Sonnenwind eines roten Riesen ruinierte den Sprung der Expedition und es wird einige Zeit dauern, den Rücksprung zu berechnen. Außer der Leere des Weltraums zwischen den Sternen gab es in diesem Sektor nichts. Die Flotte wird später als erwartet zurückkehren.',
        ],
    ],

    // Kampf
    'expedition_battle' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionBattle verarbeitet werden.
        'body' => [
            '1' => 'Einige primitive Barbaren greifen uns mit Raumschiffen an, die man kaum als solche bezeichnen kann. Wenn das Feuer ernst wird, werden wir gezwungen sein, zurückzuschießen.',
            '2' => 'Wir mussten gegen einige Piraten kämpfen, die zum Glück nur wenige waren.',
            '3' => 'Wir fingen einige Funkübertragungen von betrunkenen Piraten auf. Anscheinend werden wir bald angegriffen.',
            '4' => 'Unsere Expedition wurde von einer kleinen Gruppe unbekannter Schiffe angegriffen!',
            '5' => 'Einige völlig verzweifelte Weltraumpiraten versuchten, unsere Expeditionsflotte zu kapern.',
            '6' => 'Einige exotisch aussehende Schiffe griffen die Expeditionsflotte ohne Vorwarnung an!',
            '7' => 'Deine Expeditionsflotte hatte einen unfreundlichen Erstkontakt mit einer unbekannten Spezies.',
        ],
    ],

    // Kampf – Piraten
    'expedition_battle_pirates' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        'body' => [
            '1' => 'Einige primitive Barbaren greifen uns mit Raumschiffen an, die man kaum als solche bezeichnen kann. Wenn das Feuer ernst wird, werden wir gezwungen sein, zurückzuschießen.',
            '2' => 'Wir mussten gegen einige Piraten kämpfen, die zum Glück nur wenige waren.',
            '3' => 'Wir fingen einige Funkübertragungen von betrunkenen Piraten auf. Anscheinend werden wir bald angegriffen.',
            '4' => 'Unsere Expedition wurde von einer kleinen Gruppe Weltraumpiraten angegriffen!',
            '5' => 'Einige völlig verzweifelte Weltraumpiraten versuchten, unsere Expeditionsflotte zu kapern.',
            '6' => 'Piraten überfielen die Expeditionsflotte ohne Vorwarnung!',
            '7' => 'Eine zusammengewürfelte Flotte von Weltraumpiraten stellte sich uns in den Weg und forderte Tribut.',
        ],
    ],

    // Kampf – Aliens
    'expedition_battle_aliens' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        'body' => [
            '1' => 'Wir empfingen seltsame Signale von unbekannten Schiffen. Sie erwiesen sich als feindlich!',
            '2' => 'Eine fremde Patrouille entdeckte unsere Expeditionsflotte und griff sofort an!',
            '3' => 'Deine Expeditionsflotte hatte einen unfreundlichen Erstkontakt mit einer unbekannten Spezies.',
            '4' => 'Einige exotisch aussehende Schiffe griffen die Expeditionsflotte ohne Vorwarnung an!',
            '5' => 'Eine Flotte fremder Kriegsschiffe tauchte aus dem Hyperraum auf und griff uns an!',
            '6' => 'Wir begegneten einer technologisch fortgeschrittenen fremden Spezies, die nicht friedlich war.',
            '7' => 'Unsere Sensoren entdeckten unbekannte Energiesignaturen, bevor fremde Schiffe angriffen!',
        ],
    ],

    // Verlust der Flotte
    'expedition_loss_of_fleet' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionLossOfFleet verarbeitet werden.
        'body' => [
            '1' => 'Eine Kernschmelze des Leitschiffes löst eine Kettenreaktion aus, die die gesamte Expeditionsflotte in einer spektakulären Explosion vernichtet.',
        ],
    ],

    // Händler gefunden
    'expedition_merchant_found' => [
        'from' => 'Flottenkommando',
        'subject' => 'Expeditionsergebnis',
        // Eine Expeditionsnachricht kann verschiedene Varianten haben, die von der Klasse ExpeditionMerchantFound verarbeitet werden.
        'body' => [
            '1' => 'Deine Expeditionsflotte hat Kontakt mit einer freundlichen fremden Rasse aufgenommen. Sie kündigten an, einen Vertreter mit Waren zum Handeln auf deine Welten zu schicken.',
            '2' => 'Ein mysteriöses Händlerschiff näherte sich deiner Expedition. Der Händler bot an, deine Planeten zu besuchen und besondere Handelsdienste anzubieten.',
            '3' => 'Die Expedition traf auf einen intergalaktischen Händlerkonvoi. Einer der Händler hat sich bereit erklärt, deine Heimatwelt zu besuchen und Handelsmöglichkeiten anzubieten.',
        ],
    ],

    // ------------------------
    // Freundschaftsanfrage erhalten
    'buddy_request_received' => [
        'from' => 'Freunde',
        'subject' => 'Freundschaftsanfrage',
        'body' => 'Du hast eine neue Freundschaftsanfrage von :sender_name erhalten.<span style="display:none;">:buddy_request_id</span>',
    ],

    // ------------------------
    // Freundschaftsanfrage angenommen
    'buddy_request_accepted' => [
        'from' => 'Freunde',
        'subject' => 'Freundschaftsanfrage angenommen',
        'body' => 'Spieler :accepter_name hat dich zu seiner Freundesliste hinzugefügt.',
    ],

    // ------------------------
    // Freund entfernt
    'buddy_removed' => [
        'from' => 'Freunde',
        'subject' => 'Du wurdest von einer Freundesliste gelöscht',
        'body' => 'Spieler :remover_name hat dich von seiner Freundesliste entfernt.',
    ],

    // ------------------------
    // Raketenangriffsbericht (Angreifer)
    'missile_attack_report' => [
        'from' => 'Flottenkommando',
        'subject' => 'Raketenangriff auf :target_coords',
        'body' => 'Deine interplanetaren Raketen von :origin_planet_name :origin_planet_coords (ID: :origin_planet_id) haben ihr Ziel bei :target_planet_name :target_coords (ID: :target_planet_id, Typ: :target_type) erreicht.

Abgefeuerte Raketen: :missiles_sent
Abgefangene Raketen: :missiles_intercepted
Eingeschlagene Raketen: :missiles_hit

Zerstörte Verteidigungsanlagen: :defenses_destroyed',
    ],

    // ------------------------
    // Raketenabwehrbericht (Verteidiger)
    'missile_defense_report' => [
        'from' => 'Verteidigungskommando',
        'subject' => 'Raketenangriff auf :planet_coords',
        'body' => 'Dein Planet :planet_name bei :planet_coords (ID: :planet_id) wurde von interplanetaren Raketen von :attacker_name angegriffen!

Eingehende Raketen: :missiles_incoming
Abgefangene Raketen: :missiles_intercepted
Eingeschlagene Raketen: :missiles_hit

Zerstörte Verteidigungsanlagen: :defenses_destroyed',
    ],

    // ------------------------
    // Allianz-Rundschreiben
    'alliance_broadcast' => [
        'from' => ':sender_name',
        'subject' => '[:alliance_tag] Allianz-Rundschreiben von :sender_name',
        'body' => ':message',
    ],

    // ------------------------
    // Allianz-Bewerbung erhalten
    'alliance_application_received' => [
        'from' => 'Allianzmanagement',
        'subject' => 'Neue Allianz-Bewerbung',
        'body' => 'Spieler :applicant_name hat sich beworben, deiner Allianz beizutreten.

Bewerbungsnachricht:
:application_message',
    ],

    // Planetenumsiedlungsnachrichten
    'planet_relocation_success' => [
        'from' => 'Kolonieverwaltung',
        'subject' => 'Umsiedlung von :planet_name war erfolgreich',
        'body' => 'Der Planet :planet_name wurde erfolgreich von den Koordinaten [coordinates]:old_coordinates[/coordinates] zu [coordinates]:new_coordinates[/coordinates] umgesiedelt.',
    ],

    // Flottenverbands-Einladung
    'fleet_union_invite' => [
        'from' => 'Flottenkommando',
        'subject' => 'Einladung zum Verbandskampf',
        'body' => ':sender_name hat dich zur Mission :union_name gegen :target_player bei [:target_coords] eingeladen. Die Flotte wurde auf :arrival_time zeitgesteuert.

ACHTUNG: Die Ankunftszeit kann sich durch beitretende Flotten ändern. Jede neue Flotte darf diese Zeit um maximal 30 % verlängern, andernfalls wird der Beitritt nicht erlaubt.

HINWEIS: Die Gesamtstärke aller Teilnehmer im Vergleich zur Gesamtstärke der Verteidiger bestimmt, ob es ein ehrenhafter Kampf wird oder nicht.',
    ],

    // Gebäude-Upgrade-Nachrichten
    'Shipyard is being upgraded.' => 'Werft wird ausgebaut.',
    'Nanite Factory is being upgraded.' => 'Nanitenfabrik wird ausgebaut.',

    // ------------------------
    // Mondzerströrungsnachrichten (Angreifer)
    // TODO: Diese Mondzerströrungsnachrichten sind nicht korrekt und sollten mit
    // echten offiziellen Nachrichten aus dem Originalspiel aktualisiert werden. Diese sind vorerst nur Platzhalter.
    'moon_destruction_success' => [
        'from' => 'Flottenkommando',
        'subject' => 'Mond :moon_name [:moon_coords] wurde zerstört!',
        'body' => 'Mit einer Zerstörungswahrscheinlichkeit von :destruction_chance und einer Todesstern-Verlustswahrscheinlichkeit von :loss_chance hat deine Flotte den Mond :moon_name bei :moon_coords erfolgreich zerstört.',
    ],

    // ------------------------
    'moon_destruction_failure' => [
        'from' => 'Flottenkommando',
        'subject' => 'Mondzerstörung bei :moon_coords fehlgeschlagen',
        'body' => 'Mit einer Zerstörungswahrscheinlichkeit von :destruction_chance und einer Todesstern-Verlustswahrscheinlichkeit von :loss_chance konnte deine Flotte den Mond :moon_name bei :moon_coords nicht zerstören. Die Flotte kehrt zurück.',
    ],

    // ------------------------
    'moon_destruction_catastrophic' => [
        'from' => 'Flottenkommando',
        'subject' => 'Katastrophaler Verlust bei Mondzerstörung bei :moon_coords',
        'body' => 'Mit einer Zerstörungswahrscheinlichkeit von :destruction_chance und einer Todesstern-Verlustswahrscheinlichkeit von :loss_chance konnte deine Flotte den Mond :moon_name bei :moon_coords nicht zerstören. Zusätzlich gingen alle Todessterne beim Versuch verloren. Es gibt keine Trümmer.',
    ],

    // ------------------------
    'moon_destruction_mission_failed' => [
        'from' => 'Flottenkommando',
        'subject' => 'Mondzerstörungsmission bei :coordinates fehlgeschlagen',
        'body' => 'Deine Flotte ist bei :coordinates eingetroffen, aber am Zielort wurde kein Mond gefunden. Die Flotte kehrt zurück.',
    ],

    // ------------------------
    // Mondzerströrungsnachrichten (Verteidiger)
    'moon_destruction_repelled' => [
        'from' => 'Raumüberwachung',
        'subject' => 'Zerstörungsversuch auf Mond :moon_name [:moon_coords] abgewehrt',
        'body' => ':attacker_name griff deinen Mond :moon_name bei :moon_coords mit einer Zerstörungswahrscheinlichkeit von :destruction_chance und einer Todesstern-Verlustswahrscheinlichkeit von :loss_chance an. Dein Mond hat den Angriff überlebt!',
    ],

    // ------------------------
    'moon_destroyed' => [
        'from' => 'Raumüberwachung',
        'subject' => 'Mond :moon_name [:moon_coords] wurde zerstört!',
        'body' => 'Dein Mond :moon_name bei :moon_coords wurde von einer Todesstern-Flotte von :attacker_name zerstört!',
    ],

    // ------------------------
    // Trümmerfeldreperatur abgeschlossen
    'wreck_field_repair_completed' => [
        'from' => 'Systemnachricht',
        'subject' => 'Reparatur abgeschlossen',
        'body' => 'Dein Reparaturauftrag auf Planet :planet wurde abgeschlossen.
:ship_count Schiffe wurden wieder in Dienst gestellt.',
    ],
];
