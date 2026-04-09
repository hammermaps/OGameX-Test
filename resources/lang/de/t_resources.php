<?php

return [
    'metal_mine' => [
        'title'            => 'Metallmine',
        'description'      => 'Metallminen werden zur Förderung von Metallerz eingesetzt und sind für alle aufstrebenden und etablierten Imperien von größter Bedeutung.',
        'description_long' => 'Metall ist die wichtigste Ressource beim Aufbau deines Imperiums. In größeren Tiefen können die Minen mehr nutzbares Metall für den Bau von Gebäuden, Schiffen, Verteidigungsanlagen und die Forschung fördern. Je tiefer die Minen bohren, desto mehr Energie wird für die maximale Produktion benötigt. Da Metall die häufigste aller verfügbaren Ressourcen ist, gilt ihr Wert im Handel als der niedrigste aller Ressourcen.',
    ],

    'crystal_mine' => [
        'title'            => 'Kristallmine',
        'description'      => 'Kristall ist die Hauptressource für den Bau elektronischer Schaltkreise und bestimmter Legierungsverbindungen.',
        'description_long' => 'Kristallminen liefern die Hauptressource für die Herstellung elektronischer Schaltkreise und bestimmter Legierungsverbindungen. Der Abbau von Kristall verbraucht etwa eineinhalb Mal so viel Energie wie der Abbau von Metall, was Kristall wertvoller macht. Fast alle Schiffe und Gebäude benötigen Kristall. Die meisten Kristalle, die für den Bau von Raumschiffen benötigt werden, sind jedoch sehr selten und können wie Metall nur in einer bestimmten Tiefe gefunden werden. Daher erhöht der Bau von Minen in tieferen Schichten die Menge des geförderten Kristalls.',
    ],

    'deuterium_synthesizer' => [
        'title'            => 'Deuteriumsynthesizer',
        'description'      => 'Deuteriumsynthesizer gewinnen den geringen Deuteriumgehalt aus dem Wasser eines Planeten.',
        'description_long' => 'Deuterium wird auch als schwerer Wasserstoff bezeichnet. Es ist ein stabiles Isotop des Wasserstoffs mit einem natürlichen Vorkommen in den Ozeanen der Kolonien von etwa einem Atom pro 6500 Wasserstoffatomen (~154 PPM). Deuterium macht daher etwa 0,015 % (gewichtsbezogen 0,030 %) des gesamten Wasserstoffs aus. Deuterium wird durch spezielle Synthesizer verarbeitet, die mithilfe eigens entwickelter Zentrifugen das Wasser vom Deuterium trennen können. Das Upgrade des Synthesizers ermöglicht es, die Menge der verarbeiteten Deuteriumvorkommen zu erhöhen. Deuterium wird für Sensorphalanx-Scans, den Blick in Galaxien, als Treibstoff für Schiffe und für spezialisierte Forschungs-Upgrades benötigt.',
    ],

    'solar_plant' => [
        'title'            => 'Solarkraftwerk',
        'description'      => 'Solarkraftwerke absorbieren Energie aus der Sonnenstrahlung. Alle Minen benötigen Energie, um zu funktionieren.',
        'description_long' => 'Gigantische Solaranlagen werden eingesetzt, um Energie für die Minen und den Deuteriumsynthesizer zu erzeugen. Mit dem Ausbau des Solarkraftwerks vergrößert sich die Oberfläche der Photovoltaikzellen auf dem Planeten, was zu einer höheren Energieleistung im Stromnetz deines Planeten führt.',
    ],

    'fusion_plant' => [
        'title'            => 'Fusionsreaktor',
        'description'      => 'Der Fusionsreaktor nutzt Deuterium zur Energieerzeugung.',
        'description_long' => 'In Fusionskraftwerken werden Wasserstoffkerne unter enormem Druck und bei extremen Temperaturen zu Heliumkernen verschmolzen, wobei enorme Energiemengen freigesetzt werden. Für jedes verbrauchte Gramm Deuterium können bis zu 41,32*10^-13 Joule Energie erzeugt werden; mit 1 g lassen sich 172 MWh Energie produzieren.

Größere Reaktorkomplexe verbrauchen mehr Deuterium und können pro Stunde mehr Energie erzeugen. Der Energieeffekt kann durch die Erforschung der Energietechnologie gesteigert werden.

Die Energieproduktion des Fusionsreaktors wird wie folgt berechnet:
30 * [Stufe Fusionsreaktor] * (1,05 + [Stufe Energietechnologie] * 0,01) ^ [Stufe Fusionsreaktor]',
    ],

    'metal_store' => [
        'title'            => 'Metalllager',
        'description'      => 'Bietet Lagerplatz für überschüssiges Metall.',
        'description_long' => 'Dieses riesige Lager dient zur Lagerung von Metallerz. Jede Ausbaustufe erhöht die Menge des einlagerbaren Metallerzes. Wenn die Lager voll sind, wird kein weiteres Metall mehr abgebaut.

Das Metalllager schützt einen bestimmten Prozentsatz der täglichen Produktion der Mine (max. 10 Prozent).',
    ],

    'crystal_store' => [
        'title'            => 'Kristalllager',
        'description'      => 'Bietet Lagerplatz für überschüssigen Kristall.',
        'description_long' => 'Das unverarbeitete Kristall wird in diesen riesigen Lagerhallen zwischengelagert. Mit jeder Ausbaustufe wird die lagerbare Kristallmenge erhöht. Wenn die Kristalllager voll sind, wird kein weiterer Kristall mehr abgebaut.

Das Kristalllager schützt einen bestimmten Prozentsatz der täglichen Produktion der Mine (max. 10 Prozent).',
    ],

    'deuterium_store' => [
        'title'            => 'Deuteriumtank',
        'description'      => 'Riesige Tanks zur Lagerung des frisch gewonnenen Deuteriums.',
        'description_long' => 'Der Deuteriumtank dient zur Lagerung des frisch synthetisierten Deuteriums. Nachdem es vom Synthesizer verarbeitet wurde, wird es in diesen Tank geleitet, um später verwendet zu werden. Mit jedem Ausbau des Tanks wird die Gesamtlagerkapazität erhöht. Sobald die Kapazität erreicht ist, wird kein weiteres Deuterium mehr synthetisiert.

Der Deuteriumtank schützt einen bestimmten Prozentsatz der täglichen Produktion des Synthesizers (max. 10 Prozent).',
    ],

    // -------------------------------------------------------------------------
    // Station / Anlagen-Objekte (aus StationObjects.php)
    // -------------------------------------------------------------------------

    'robot_factory' => [
        'title'            => 'Roboterfabrik',
        'description'      => 'Roboterfabriken stellen Bauroboter zur Unterstützung beim Gebäudebau bereit. Jede Stufe erhöht die Ausbaugeschwindigkeit von Gebäuden.',
        'description_long' => 'Das primäre Ziel der Roboterfabrik ist die Herstellung hochmoderner Bauroboter. Jeder Ausbau der Roboterfabrik führt zur Produktion schnellerer Roboter, die die für den Bau von Gebäuden benötigte Zeit verkürzen.',
    ],

    'shipyard' => [
        'title'            => 'Raumschiffwerft',
        'description'      => 'Alle Schiffstypen und Verteidigungsanlagen werden in der planetaren Werft gebaut.',
        'description_long' => 'Die planetare Raumschiffwerft ist für den Bau von Raumschiffen und Verteidigungsanlagen verantwortlich. Mit dem Ausbau der Werft kann sie eine größere Auswahl an Fahrzeugen mit deutlich höherer Geschwindigkeit produzieren. Wenn eine Nanitenfabrik auf dem Planeten vorhanden ist, wird die Baugeschwindigkeit von Schiffen erheblich gesteigert.',
    ],

    'research_lab' => [
        'title'            => 'Forschungslabor',
        'description'      => 'Ein Forschungslabor wird benötigt, um Forschungen zu neuen Technologien durchzuführen.',
        'description_long' => 'Als wesentlicher Bestandteil jedes Imperiums sind Forschungslabore der Ort, an dem neue Technologien entdeckt und bestehende Technologien verbessert werden. Mit jeder ausgebauten Stufe des Forschungslabors erhöht sich die Geschwindigkeit, mit der neue Technologien erforscht werden können, und es werden neuere Technologien zum Erforschen freigeschaltet. Um Forschungen so schnell wie möglich durchzuführen, werden Forschungswissenschaftler sofort zur Kolonie entsandt, um mit Arbeit und Entwicklung zu beginnen. Auf diese Weise kann Wissen über neue Technologien leicht im gesamten Imperium verbreitet werden.',
    ],

    'alliance_depot' => [
        'title'            => 'Allianzdepot',
        'description'      => 'Das Allianzdepot versorgt befreundete Flotten in der Umlaufbahn mit Treibstoff zur Unterstützung der Verteidigung.',
        'description_long' => 'Das Allianzdepot versorgt befreundete Flotten in der Umlaufbahn mit Treibstoff zur Unterstützung der Verteidigung. Für jede Ausbaustufe des Allianzdepots kann eine bestimmte Menge Deuterium pro Stunde an eine orbitierende Flotte gesendet werden.',
    ],

    'missile_silo' => [
        'title'            => 'Raketensilo',
        'description'      => 'Raketensilos dienen zur Lagerung von Raketen.',
        'description_long' => 'Raketensilos werden zum Bau, zur Lagerung und zum Abfeuern von Interplanetarraketen und Abfangraketen verwendet. Mit jeder Silostufe können fünf Interplanetarraketen oder zehn Abfangraketen gelagert werden. Eine Interplanetarrakete belegt denselben Platz wie zwei Abfangraketen. Die gleichzeitige Lagerung von Interplanetarraketen und Abfangraketen im selben Silo ist erlaubt.',
    ],

    'nano_factory' => [
        'title'            => 'Nanitenfabrik',
        'description'      => 'Dies ist das Nonplusultra der Robotertechnologie. Jede Stufe verkürzt die Bauzeit von Gebäuden, Schiffen und Verteidigungsanlagen.',
        'description_long' => 'Eine Nanomaschine, auch Nanit genannt, ist ein mechanisches oder elektromechanisches Gerät, dessen Abmessungen in Nanometern (Millionstel eines Millimeters bzw. Einheiten von 10^-9 Metern) gemessen werden. Die mikroskopische Größe von Nanomaschinen führt zu einer höheren Betriebsgeschwindigkeit. Diese Fabrik produziert Nanomaschinen, die die ultimative Weiterentwicklung der Robotertechnologie darstellen. Nach dem Bau verringert jeder Ausbau die Produktionszeit für Gebäude, Schiffe und Verteidigungsanlagen erheblich.',
    ],

    'terraformer' => [
        'title'            => 'Terraformer',
        'description'      => 'Der Terraformer vergrößert die nutzbare Oberfläche von Planeten.',
        'description_long' => 'Durch den zunehmenden Bau auf Planeten wird selbst der Lebensraum für die Kolonie immer begrenzter. Traditionelle Methoden wie Hochhaus- und Untertagebau werden zunehmend unzureichend. Eine kleine Gruppe von Hochenergiephysikern und Nano-Ingenieuren fand schließlich die Lösung: das Terraformen.
Unter Einsatz enormer Energiemengen kann der Terraformer ganze Landstriche oder sogar Kontinente urbar machen. Dieses Gebäude beherbergt die Produktion von Naniten, die speziell für diesen Zweck geschaffen wurden und eine gleichbleibende Bodenqualität gewährleisten.

Jede Terraformerstufe ermöglicht die Bewirtschaftung von 5 Feldern. Mit jeder Stufe belegt der Terraformer selbst ein Feld. Alle 2 Terraformerstufen erhältst du 1 Bonusfeld.

Einmal gebaut, kann der Terraformer nicht mehr abgerissen werden.',
    ],

    'space_dock' => [
        'title'            => 'Raumdock',
        'description'      => 'Wracks können im Raumdock repariert werden.',
        'description_long' => 'Das Raumdock bietet die Möglichkeit, im Kampf zerstörte Schiffe zu reparieren, die Wracks hinterlassen haben. Die Reparaturzeit beträgt maximal 12 Stunden, es dauert jedoch mindestens 30 Minuten, bis die Schiffe wieder in Dienst gestellt werden können.

Reparaturen müssen innerhalb von 3 Tagen nach der Entstehung des Wracks beginnen. Die reparierten Schiffe müssen nach Abschluss der Reparaturen manuell wieder in Dienst gestellt werden. Wird dies nicht getan, werden einzelne Schiffe jeglichen Typs nach 3 Tagen automatisch in Dienst gestellt.

Wracks entstehen nur, wenn mehr als 150.000 Einheiten zerstört wurden, einschließlich eigener Schiffe, die an dem Kampf mit einem Wert von mindestens 5 % der Schiffspunkte teilgenommen haben.

Da das Raumdock in der Umlaufbahn schwebt, benötigt es kein Planetenfeld.',
    ],

    'lunar_base' => [
        'title'            => 'Mondbasis',
        'description'      => 'Da der Mond keine Atmosphäre hat, ist eine Mondbasis erforderlich, um bewohnbaren Raum zu schaffen.',
        'description_long' => 'Ein Mond hat keine Atmosphäre, daher muss zunächst eine Mondbasis gebaut werden, bevor eine Siedlung errichtet werden kann. Diese sorgt dann für Sauerstoff, Wärme und Schwerkraft. Mit jeder ausgebauten Stufe wird innerhalb der Biosphäre ein größerer Wohn- und Entwicklungsbereich bereitgestellt. Jede ausgebaute Stufe ermöglicht drei Felder für andere Gebäude. Mit jeder Stufe belegt die Mondbasis selbst ein Feld.
Einmal gebaut, kann die Mondbasis nicht mehr abgerissen werden.',
    ],

    'sensor_phalanx' => [
        'title'            => 'Sensorphalanx',
        'description'      => 'Mit der Sensorphalanx können Flotten anderer Imperien entdeckt und beobachtet werden. Je größer die Sensorphalanx-Anlage, desto größer ist ihre Reichweite.',
        'description_long' => 'Mithilfe hochauflösender Sensoren scannt die Sensorphalanx zunächst das Lichtspektrum, die Gaszusammensetzung und die Strahlenemissionen einer entfernten Welt und übermittelt die Daten zur Verarbeitung an einen Supercomputer. Sobald die Informationen vorliegen, vergleicht der Supercomputer Veränderungen im Spektrum, der Gaszusammensetzung und den Strahlenemissionen mit einem Referenzdiagramm bekannter Spektrumsveränderungen, die durch verschiedene Schiffsbewegungen verursacht werden. Die resultierenden Daten zeigen dann die Aktivität jeder Flotte innerhalb der Reichweite der Phalanx an. Um eine Überhitzung des Supercomputers während des Vorgangs zu verhindern, wird er durch den Einsatz von 5k verarbeitetem Deuterium gekühlt.
Um die Phalanx zu verwenden, klicke im Galaxie-Ansicht auf einen beliebigen Planeten innerhalb deiner Sensorreichweite.',
    ],

    'jump_gate' => [
        'title'            => 'Sprungtor',
        'description'      => 'Sprungtore sind riesige Transceiver, die selbst die größte Flotte in kürzester Zeit zu einem entfernten Sprungtor befördern können.',
        'description_long' => 'Ein Sprungtor ist ein System aus riesigen Transceivern, das selbst die größten Flotten ohne Zeitverlust zu einem empfangenden Tor irgendwo im Universum befördern kann. Durch den Einsatz einer Technologie ähnlich einem Wurmloch wird kein Deuterium für den Sprung benötigt. Zwischen den Sprüngen muss eine Aufladephase von einigen Minuten verstreichen, um eine Regeneration zu ermöglichen. Der Transport von Ressourcen durch das Tor ist ebenfalls nicht möglich. Mit jeder Ausbaustufe kann die Abklingzeit des Sprungtors verringert werden.',
    ],

    // -------------------------------------------------------------------------
    // Forschungs-Objekte (aus ResearchObjects.php)
    // -------------------------------------------------------------------------

    'energy_technology' => [
        'title'            => 'Energietechnologie',
        'description'      => 'Die Beherrschung verschiedener Energieformen ist für viele neue Technologien notwendig.',
        'description_long' => 'Im Zuge des Fortschritts verschiedener Forschungsgebiete wurde festgestellt, dass die damalige Technologie der Energieverteilung nicht ausreichend war, um bestimmte spezialisierte Forschungen zu beginnen. Mit jedem Ausbau der Energietechnologie können neue Forschungen durchgeführt werden, die die Entwicklung ausgefeilterer Schiffe und Verteidigungsanlagen ermöglichen.',
    ],

    'laser_technology' => [
        'title'            => 'Lasertechnologie',
        'description'      => 'Das Bündeln von Licht erzeugt einen Strahl, der beim Auftreffen auf ein Objekt Schaden verursacht.',
        'description_long' => 'Laser (Lichtverstärkung durch stimulierte Strahlungsemission) erzeugen eine intensive, energiereiche Emission von kohärentem Licht. Diese Geräte können in den verschiedensten Bereichen eingesetzt werden, von optischen Computern bis hin zu schweren Laserwaffen, die mühelos durch Panzerungstechnologie schneiden. Die Lasertechnologie bildet eine wichtige Grundlage für die Erforschung anderer Waffentechnologien.',
    ],

    'ion_technology' => [
        'title'            => 'Ionentechnologie',
        'description'      => 'Die Konzentration von Ionen ermöglicht den Bau von Kanonen, die enormen Schaden anrichten und die Abrisskosten pro Stufe um 4 % senken können.',
        'description_long' => 'Ionen können konzentriert und zu einem tödlichen Strahl beschleunigt werden. Diese Strahlen können dann enormen Schaden anrichten. Unsere Wissenschaftler haben außerdem eine Technik entwickelt, die die Abrisskosten für Gebäude und Systeme deutlich senkt. Für jede Forschungsstufe sinken die Abrisskosten um 4 %.',
    ],

    'hyperspace_technology' => [
        'title'            => 'Hyperraumtechnologie',
        'description'      => 'Durch die Integration der 4. und 5. Dimension ist es nun möglich, eine neue Art von Antrieb zu erforschen, der wirtschaftlicher und effizienter ist.',
        'description_long' => 'Theoretisch setzt die Idee des Hyperraumreisens die Existenz einer separaten und benachbarten Dimension voraus. Wenn ein Hyperraumantrieb aktiviert wird, versetzt er das Raumschiff in diese andere Dimension, in der es in einer stark reduzierten Zeit riesige Entfernungen zurücklegen kann, verglichen mit dem, was im "normalen" Raum nötig wäre. Sobald es den Punkt im Hyperraum erreicht, der seinem Ziel im realen Raum entspricht, taucht es wieder auf.
Sobald ein ausreichendes Niveau der Hyperraumtechnologie erforscht wurde, ist der Hyperraumantrieb nicht mehr nur Theorie. Jede Verbesserung dieses Antriebs erhöht die Ladekapazität deiner Schiffe um 5 % des Basiswerts.',
    ],

    'plasma_technology' => [
        'title'            => 'Plasmatechnologie',
        'description'      => 'Eine Weiterentwicklung der Ionentechnologie, die hochenergetisches Plasma beschleunigt, das dann verheerende Schäden verursacht und zusätzlich die Produktion von Metall, Kristall und Deuterium optimiert (1 %/0,66 %/0,33 % pro Stufe).',
        'description_long' => 'Eine Weiterentwicklung der Ionentechnologie, die keine Ionen, sondern hochenergetisches Plasma beschleunigt, das beim Aufprall auf ein Objekt verheerende Schäden anrichten kann. Unsere Wissenschaftler haben außerdem einen Weg gefunden, den Abbau von Metall und Kristall mithilfe dieser Technologie spürbar zu verbessern.

Die Metallproduktion steigt um 1 %, die Kristallproduktion um 0,66 % und die Deuteriumproduktion um 0,33 % pro Ausbaustufe der Plasmatechnologie.',
    ],

    'combustion_drive' => [
        'title'            => 'Verbrennungsantrieb',
        'description'      => 'Die Entwicklung dieses Antriebs macht einige Schiffe schneller, obwohl jede Stufe die Geschwindigkeit nur um 10 % des Basiswerts erhöht.',
        'description_long' => 'Der Verbrennungsantrieb ist die älteste aller Technologien, wird aber noch immer eingesetzt. Beim Verbrennungsantrieb entsteht der Ausstoß aus Treibstoffen, die vor dem Einsatz im Schiff mitgeführt werden. In einer geschlossenen Kammer sind die Drücke in jede Richtung gleich, und es tritt keine Beschleunigung auf. Wenn an der Unterseite der Kammer eine Öffnung vorgesehen ist, ist der Druck auf dieser Seite nicht mehr entgegengesetzt. Der verbleibende Druck erzeugt einen resultierenden Schub auf der der Öffnung gegenüberliegenden Seite, der das Schiff vorwärts antreibt, indem der Ausstoß mit extrem hoher Geschwindigkeit nach hinten ausgestoßen wird.

Mit jeder Stufe des entwickelten Verbrennungsantriebs wird die Geschwindigkeit von kleinen und großen Frachtern, leichten Jägern, Recyclern und Spionagesonden um 10 % erhöht.',
    ],

    'impulse_drive' => [
        'title'            => 'Impulsantrieb',
        'description'      => 'Der Impulsantrieb basiert auf dem Reaktionsprinzip. Die Weiterentwicklung dieses Antriebs macht einige Schiffe schneller, obwohl jede Stufe die Geschwindigkeit nur um 20 % des Basiswerts erhöht.',
        'description_long' => 'Der Impulsantrieb basiert auf dem Rückstoßprinzip, bei dem die stimulierte Strahlungsemission hauptsächlich als Abfallprodukt der Kernfusion zur Energiegewinnung erzeugt wird. Zusätzlich können weitere Massen injiziert werden. Mit jeder entwickelten Stufe des Impulsantriebs wird die Geschwindigkeit von Bombern, Kreuzern, schweren Jägern und Kolonieschiffen um 20 % des Basiswerts erhöht. Zusätzlich werden die kleinen Transporter mit Impulsantrieben ausgestattet, sobald ihr Forschungslevel 5 erreicht. Sobald die Impulsantrieb-Forschung Level 17 erreicht hat, werden Recycler mit Impulsantrieben ausgestattet.

Interplanetarraketen fliegen mit jeder Stufe ebenfalls weiter.',
    ],

    'hyperspace_drive' => [
        'title'            => 'Hyperraumantrieb',
        'description'      => 'Der Hyperraumantrieb krümmt den Raum um ein Schiff. Die Entwicklung dieses Antriebs macht einige Schiffe schneller, obwohl jede Stufe die Geschwindigkeit nur um 30 % des Basiswerts erhöht.',
        'description_long' => 'In der unmittelbaren Umgebung des Schiffes wird der Raum so gekrümmt, dass große Entfernungen sehr schnell zurückgelegt werden können. Je weiter der Hyperraumantrieb entwickelt wird, desto stärker ist die Raumkrümmung, wodurch die Geschwindigkeit der damit ausgestatteten Schiffe (Schlachtkreuzer, Schlachtschiffe, Zerstörer, Todessterne, Pathfinder und Reaper) um 30 % pro Stufe steigt. Zusätzlich wird der Bomber mit einem Hyperraumantrieb gebaut, sobald die Forschung Stufe 8 erreicht. Sobald die Hyperraumantrieb-Forschung Stufe 15 erreicht, wird der Recycler mit einem Hyperraumantrieb ausgestattet.',
    ],

    'espionage_technology' => [
        'title'            => 'Spionagetechnologie',
        'description'      => 'Mit dieser Technologie können Informationen über andere Planeten und Monde gewonnen werden.',
        'description_long' => 'Die Spionagetechnologie ist in erster Linie eine Weiterentwicklung der Sensortechnologie. Je fortschrittlicher diese Technologie ist, desto mehr Informationen erhält der Nutzer über Aktivitäten in seiner Umgebung.
Die Unterschiede zwischen dem eigenen Spionagelevel und dem des Gegners sind für Sonden entscheidend. Je fortschrittlicher die eigene Spionagetechnologie ist, desto mehr Informationen kann der Bericht sammeln und desto geringer ist die Chance, dass die Spionageaktivitäten entdeckt werden. Je mehr Sonden auf einer Mission geschickt werden, desto mehr Details können vom Zielplaneten gesammelt werden. Gleichzeitig erhöht sich aber auch die Entdeckungswahrscheinlichkeit.
Die Spionagetechnologie verbessert auch die Chance, fremde Flotten aufzuspüren. Das Spionagelevel ist dabei entscheidend. Ab Stufe 2 wird neben der normalen Angriffsbenachrichtigung auch die genaue Gesamtzahl der angreifenden Schiffe angezeigt. Ab Stufe 4 werden der Typ der angreifenden Schiffe sowie die Gesamtzahl angezeigt, und ab Stufe 8 wird die genaue Anzahl der verschiedenen Schiffstypen angezeigt.
Diese Technologie ist für einen bevorstehenden Angriff unverzichtbar, da sie darüber informiert, ob die Flotte des Opfers über Verteidigungsanlagen verfügt oder nicht. Deshalb sollte diese Technologie sehr früh erforscht werden.',
    ],

    'computer_technology' => [
        'title'            => 'Computertechnologie',
        'description'      => 'Mehr Flotten können durch erhöhte Computerkapazitäten befehligt werden. Jede Stufe der Computertechnologie erhöht die maximale Anzahl der Flotten um eins.',
        'description_long' => 'Einmal auf einer Mission gestartet, werden Flotten hauptsächlich von einer Reihe von Computern auf dem Ausgangsplaneten gesteuert. Diese leistungsstarken Computer berechnen die genaue Ankunftszeit, steuern Korrekturen des Kurses nach Bedarf, berechnen Trajektorien und regulieren die Fluggeschwindigkeiten.
Mit jeder erforschten Stufe wird der Bordcomputer aufgerüstet, um einen zusätzlichen Startplatz zu ermöglichen. Die Computertechnologie sollte beim Aufbau des Imperiums kontinuierlich weiterentwickelt werden.',
    ],

    'astrophysics' => [
        'title'            => 'Astrophysik',
        'description'      => 'Mit einem Astrophysik-Forschungsmodul können Schiffe auf lange Expeditionen aufbrechen. Alle zwei Stufen dieser Technologie erlauben die Kolonisierung eines weiteren Planeten.',
        'description_long' => 'Weitere Erkenntnisse auf dem Gebiet der Astrophysik ermöglichen den Bau von Laboren, die auf immer mehr Schiffen installiert werden können. Damit werden lange Expeditionen weit in unerforschte Gebiete des Weltraums möglich. Darüber hinaus können diese Fortschritte zur weiteren Kolonisierung des Universums genutzt werden. Für je zwei Stufen dieser Technologie kann ein weiterer Planet nutzbar gemacht werden.',
    ],

    'intergalactic_research_network' => [
        'title'            => 'Intergalaktisches Forschungsnetz',
        'description'      => 'Forscher auf verschiedenen Planeten kommunizieren über dieses Netzwerk.',
        'description_long' => 'Dies ist dein Tiefraumnetzwerk zur Übermittlung von Forschungsergebnissen an deine Kolonien. Mit dem IGF können schnellere Forschungszeiten erzielt werden, indem die Forschungslabore mit dem höchsten Level entsprechend dem entwickelten IGF-Level verknüpft werden.
Damit es funktioniert, muss jede Kolonie in der Lage sein, die Forschung eigenständig durchzuführen.',
    ],

    'graviton_technology' => [
        'title'            => 'Gravitontechnologie',
        'description'      => 'Das Abfeuern einer konzentrierten Ladung von Gravitonpartikeln kann ein künstliches Gravitationsfeld erzeugen, das Schiffe oder sogar Monde zerstören kann.',
        'description_long' => 'Ein Graviton ist ein elementares Teilchen, das masselos ist und keine Ladung trägt. Es bestimmt die Gravitationskraft. Durch das Abfeuern einer konzentrierten Ladung von Gravitonen kann ein künstliches Gravitationsfeld aufgebaut werden. Ähnlich wie ein Schwarzes Loch zieht es Masse in sich hinein. Damit kann es Schiffe und sogar ganze Monde zerstören. Um eine ausreichende Menge an Gravitonen zu erzeugen, werden riesige Energiemengen benötigt. Die Gravitonforschung ist Voraussetzung für den Bau eines zerstörerischen Todessterns.',
    ],

    'weapon_technology' => [
        'title'            => 'Waffentechnologie',
        'description'      => 'Die Waffentechnologie macht Waffensysteme effizienter. Jede Stufe der Waffentechnologie erhöht die Waffenstärke der Einheiten um 10 % des Basiswerts.',
        'description_long' => 'Die Waffentechnologie ist eine Schlüsselforschungstechnologie und für das Überleben gegen feindliche Imperien entscheidend. Mit jeder erforschten Stufe der Waffentechnologie werden die Waffensysteme auf Schiffen und die Verteidigungsanlagen immer effizienter. Jede Stufe erhöht die Basisstärke der Waffen um 10 % des Basiswerts.',
    ],

    'shielding_technology' => [
        'title'            => 'Schildtechnologie',
        'description'      => 'Die Schildtechnologie macht die Schilde auf Schiffen und Verteidigungsanlagen effizienter. Jede Stufe der Schildtechnologie erhöht die Schildstärke um 10 % des Basiswerts.',
        'description_long' => 'Mit der Erfindung des Magnetosphärengenerators entdeckten Wissenschaftler, dass ein künstlicher Schild produziert werden kann, um die Besatzung von Raumschiffen nicht nur vor der intensiven Sonnenstrahlung im Weltall zu schützen, sondern auch vor feindlichem Beschuss während eines Angriffs. Nachdem Wissenschaftler die Technologie schließlich perfektioniert hatten, wurde ein Magnetosphärengenerator in alle Schiffe und Verteidigungssysteme eingebaut.

Mit jeder Weiterentwicklung der Technologie wird der Magnetosphärengenerator aufgerüstet, was die Schilde um zusätzliche 10 % des Basiswerts verstärkt.',
    ],

    'armor_technology' => [
        'title'            => 'Rüstungstechnologie',
        'description'      => 'Spezielle Legierungen verbessern die Panzerung von Schiffen und Verteidigungsanlagen. Die Wirksamkeit der Panzerung kann pro Stufe um 10 % erhöht werden.',
        'description_long' => 'Die Bedingungen im Weltall sind hart. Piloten und Besatzungen auf verschiedenen Missionen waren nicht nur intensiver Sonnenstrahlung ausgesetzt, sie mussten auch mit dem Risiko rechnen, von Weltraumschutt getroffen oder im Angriff durch feindliches Feuer zerstört zu werden. Mit der Entdeckung einer Aluminium-Lithium-Titancarbid-Legierung, die sich als leicht und langlebig erwies, wurde der Besatzung ein gewisser Schutzgrad geboten. Mit jeder entwickelten Stufe der Rüstungstechnologie wird eine höherwertige Legierung hergestellt, die die Panzerungsstärke um 10 % erhöht.',
    ],

    // ---- Zivilschiffe ----

    'small_cargo' => [
        'title'            => 'Kleiner Transporter',
        'description'      => 'Der kleine Transporter ist ein wendiges Schiff, das Ressourcen schnell zu anderen Planeten transportieren kann.',
        'description_long' => 'Transporter sind etwa so groß wie Jäger, verzichten jedoch auf Hochleistungsantriebe und Bordwaffen zugunsten einer höheren Frachtkapazität. Daher sollte ein Transporter nur dann in Kämpfe geschickt werden, wenn er von kampfbereiten Schiffen begleitet wird.

Sobald der Impulsantrieb Forschungsstufe 5 erreicht, reist der kleine Transporter mit erhöhter Basisgeschwindigkeit und ist mit einem Impulsantrieb ausgestattet.',
    ],

    'large_cargo' => [
        'title'            => 'Großer Transporter',
        'description'      => 'Dieses Frachtschiff hat eine wesentlich größere Ladekapazität als der kleine Transporter und ist dank eines verbesserten Antriebs im Allgemeinen schneller.',
        'description_long' => 'Im Laufe der Zeit führten Überfälle auf Kolonien dazu, dass immer größere Mengen an Ressourcen erbeutet wurden. Infolgedessen wurden kleine Transporter in Massen entsandt, um die größeren Beute zu kompensieren. Es wurde schnell erkannt, dass eine neue Schiffsklasse benötigt wurde, um die bei Überfällen erbeuteten Ressourcen zu maximieren und gleichzeitig kostengünstig zu sein. Nach langer Entwicklung wurde der große Transporter geboren.

Um die in den Laderäumen lagerbaren Ressourcen zu maximieren, verfügt dieses Schiff kaum über Waffen oder Panzerung. Dank des hochentwickelten installierten Verbrennungsmotors dient es als wirtschaftlichster Ressourcenträger zwischen Planeten und ist am effektivsten bei Überfällen auf feindliche Welten.',
    ],

    'colony_ship' => [
        'title'            => 'Kolonieschiff',
        'description'      => 'Mit diesem Schiff können unbesiedelte Planeten kolonisiert werden.',
        'description_long' => 'Im 20. Jahrhundert beschloss die Menschheit, nach den Sternen zu greifen. Zuerst war es die Landung auf dem Mond. Danach wurde eine Raumstation gebaut. Mars wurde bald darauf kolonisiert. Es wurde schnell klar, dass unser Wachstum von der Kolonisierung anderer Welten abhängt. Wissenschaftler und Ingenieure aus aller Welt kamen zusammen, um die größte Errungenschaft der Menschheit zu entwickeln. Das Kolonieschiff war geboren.

Dieses Schiff wird verwendet, um einen neu entdeckten Planeten für die Kolonisierung vorzubereiten. Sobald es sein Ziel erreicht, wird das Schiff sofort in bewohnbaren Lebensraum umgewandelt, um bei der Besiedelung und dem Abbau der neuen Welt zu helfen. Die maximale Anzahl der Planeten wird dabei durch den Fortschritt in der Astrophysikforschung bestimmt. Zwei neue Stufen der Astrotechnologie ermöglichen die Kolonisierung eines weiteren Planeten.',
    ],

    'recycler' => [
        'title'            => 'Recycler',
        'description'      => 'Recycler sind die einzigen Schiffe, die Trümmerfelder ernten können, die nach einem Kampf in der Umlaufbahn eines Planeten schweben.',
        'description_long' => 'Kämpfe im Weltraum nahmen immer größere Ausmaße an. Tausende von Schiffen wurden zerstört, und die Ressourcen ihrer Überreste schienen für immer in den Trümmerfeldern verloren. Normale Frachtschiffe konnten diesen Feldern nicht nahe genug kommen, ohne erheblichen Schaden zu riskieren.
Eine neuere Entwicklung in der Schildtechnologie umging dieses Problem effizient. Es wurde eine neue Schiffsklasse geschaffen, die den Transportern ähnelte: die Recycler. Ihre Bemühungen halfen dabei, die als verloren geglaubten Ressourcen zu bergen und zu retten. Die Trümmer stellten dank der neuen Schilde keine wirkliche Gefahr mehr dar.

Sobald die Impulsantrieb-Forschung Stufe 17 erreicht hat, werden Recycler mit Impulsantrieben ausgestattet. Sobald die Hyperraumantrieb-Forschung Stufe 15 erreicht hat, werden Recycler mit Hyperraumantrieben ausgestattet.',
    ],

    'espionage_probe' => [
        'title'            => 'Spionagesonde',
        'description'      => 'Spionagesonden sind kleine, wendige Drohnen, die über große Entfernungen Daten über Flotten und Planeten liefern.',
        'description_long' => 'Spionagesonden sind kleine, wendige Drohnen, die Daten über Flotten und Planeten liefern. Ausgestattet mit speziell entwickelten Triebwerken können sie riesige Entfernungen in nur wenigen Minuten zurücklegen. Einmal in der Umlaufbahn um den Zielplaneten, sammeln sie schnell Daten und übermitteln den Bericht über dein Tiefraumnetzwerk zur Auswertung. Allerdings birgt das Sammeln von Informationen ein Risiko. Während der Bericht an dein Netzwerk übermittelt wird, kann das Signal vom Ziel entdeckt und die Sonden können zerstört werden.',
    ],

    'solar_satellite' => [
        'title'            => 'Solarsatellit',
        'description'      => 'Solarsatelliten sind einfache Plattformen aus Solarzellen in einer hohen, stationären Umlaufbahn. Sie sammeln Sonnenlicht und übertragen es per Laser zur Bodenstation.',
        'description_long' => 'Wissenschaftler entdeckten eine Methode zur Übertragung elektrischer Energie an die Kolonie mithilfe speziell entwickelter Satelliten in einer geosynchronen Umlaufbahn. Solarsatelliten sammeln Solarenergie und übertragen sie mithilfe fortschrittlicher Lasertechnologie an eine Bodenstation. Die Effizienz eines Solarsatelliten hängt von der Stärke der empfangenen Sonnenstrahlung ab. Grundsätzlich ist die Energieproduktion in Umlaufbahnen näher an der Sonne höher als für Planeten in weiter entfernten Umlaufbahnen.
Aufgrund ihres guten Preis-Leistungs-Verhältnisses können Solarsatelliten viele Energieprobleme lösen. Aber Vorsicht: Solarsatelliten können im Kampf leicht zerstört werden.',
    ],

    'crawler' => [
        'title'            => 'Crawler',
        'description'      => 'Crawler erhöhen die Produktion von Metall, Kristall und Deuterium auf ihrem zugewiesenen Planeten jeweils um 0,02 %, 0,02 % und 0,02 %. Als Sammler erhöht sich die Produktion zusätzlich. Der maximale Gesamtbonus hängt vom Gesamtlevel der Minen ab.',
        'description_long' => 'Der Crawler ist ein großes Schürffahrzeug, das die Produktion von Minen und Synthesizern erhöht. Er ist wendiger als er aussieht, aber nicht besonders robust. Jeder Crawler erhöht die Metallproduktion um 0,02 %, die Kristallproduktion um 0,02 % und die Deuteriumproduktion um 0,02 %. Als Sammler erhöht sich die Produktion zusätzlich. Der maximale Gesamtbonus hängt vom Gesamtlevel der Minen ab.',
    ],

    'pathfinder' => [
        'title'            => 'Pathfinder',
        'description'      => 'Der Pathfinder ist ein schnelles und wendiges Schiff, das speziell für Expeditionen in unbekannte Sektoren des Weltraums entwickelt wurde.',
        'description_long' => 'Der Pathfinder ist die neueste Entwicklung in der Erkundungstechnologie. Dieses Schiff wurde speziell für Mitglieder der Entdecker-Klasse entwickelt, um ihr Potenzial zu maximieren. Ausgestattet mit fortschrittlichen Scansystemen und einem großen Laderaum zum Bergen von Ressourcen, ist der Pathfinder ideal für Expeditionen. Seine hochentwickelten Sensoren können wertvolle Ressourcen und Anomalien entdecken, die anderen Schiffen unbemerkt bleiben würden. Das Schiff kombiniert eine hohe Geschwindigkeit mit guter Frachtkapazität und ist damit perfekt für schnelle Erkundungsmissionen und das Sammeln von Ressourcen aus entfernten Sektoren.',
    ],

    // ---- Militärschiffe ----

    'light_fighter' => [
        'title'            => 'Leichter Jäger',
        'description'      => 'Dies ist das erste Kampfschiff, das alle Herrscher bauen werden. Der leichte Jäger ist ein wendiges Schiff, aber allein anfällig. In großer Zahl können sie zu einer großen Bedrohung für jedes Imperium werden. Sie sind die ersten, die kleine und große Frachter zu feindlichen Planeten mit geringer Verteidigung begleiten.',
        'description_long' => 'Dies ist das erste Kampfschiff, das alle Herrscher bauen werden. Der leichte Jäger ist ein wendiges Schiff, aber allein anfällig. In großer Zahl können sie zu einer großen Bedrohung für jedes Imperium werden. Sie sind die ersten, die kleine und große Frachter zu feindlichen Planeten mit geringer Verteidigung begleiten.',
    ],

    'heavy_fighter' => [
        'title'            => 'Schwerer Jäger',
        'description'      => 'Dieser Jäger ist besser gepanzert und hat eine höhere Angriffsstärke als der leichte Jäger.',
        'description_long' => 'Bei der Entwicklung des schweren Jägers stießen die Forscher an einen Punkt, an dem herkömmliche Antriebe nicht mehr ausreichend Leistung lieferten. Um das Schiff optimal bewegen zu können, wurde erstmals der Impulsantrieb eingesetzt. Dies erhöhte die Kosten, eröffnete aber auch neue Möglichkeiten. Durch den Einsatz dieses Antriebs blieb mehr Energie für Waffen und Schilde; zudem wurden hochwertige Materialien für diese neue Jägerfamilie verwendet. Mit diesen Änderungen stellt der schwere Jäger eine neue Ära der Schiffstechnologie dar und bildet die Grundlage für die Kreuzertechnologie.

Etwas größer als der leichte Jäger, verfügt der schwere Jäger über dickere Rümpfe, die mehr Schutz bieten, und stärkere Bewaffnung.',
    ],

    'cruiser' => [
        'title'            => 'Kreuzer',
        'description'      => 'Kreuzer sind fast dreimal so stark gepanzert wie schwere Jäger und haben mehr als die doppelte Feuerkraft. Außerdem sind sie sehr schnell.',
        'description_long' => 'Mit der Entwicklung des schweren Lasers und der Ionenkanone erlitten leichte und schwere Jäger eine beunruhigend hohe Anzahl von Niederlagen, die mit jedem Überfall zunahm. Trotz vieler Modifikationen, Änderungen an der Waffenstärke und der Panzerung konnte dies nicht schnell genug gesteigert werden, um diesen neuen Verteidigungsmaßnahmen wirksam entgegenzuwirken. Daher wurde beschlossen, eine neue Schiffsklasse zu bauen, die mehr Panzerung und mehr Feuerkraft vereint. Als Ergebnis jahrelanger Forschung und Entwicklung wurde der Kreuzer geboren.

Kreuzer sind fast dreimal so stark gepanzert wie die schweren Jäger und besitzen mehr als die doppelte Feuerkraft aller im Einsatz befindlichen Kampfschiffe. Sie besitzen auch Geschwindigkeiten, die weit über denen aller jemals gebauten Raumschiffe liegen. Fast ein Jahrhundert lang dominierten Kreuzer das Universum. Mit der Entwicklung von Gausskanonen und Plasmageschützen endete jedoch ihre Vorherrschaft. Sie werden heute noch gegen Jägergruppen eingesetzt, allerdings nicht mehr so dominant wie früher.',
    ],

    'battle_ship' => [
        'title'            => 'Schlachtschiff',
        'description'      => 'Schlachtschiffe bilden das Rückgrat einer Flotte. Ihre schweren Kanonen, hohe Geschwindigkeit und großen Laderäume machen sie zu ernst zu nehmenden Gegnern.',
        'description_long' => 'Als deutlich wurde, dass der Kreuzer gegenüber der zunehmenden Zahl von Verteidigungsanlagen an Boden verlor und der Verlust von Schiffen auf Missionen inakzeptable Ausmaße annahm, wurde beschlossen, ein Schiff zu bauen, das diesen Verteidigungsanlagen mit möglichst geringen Verlusten begegnen kann. Nach umfangreicher Entwicklung wurde das Schlachtschiff geboren. Gebaut, um den größten Schlachten standzuhalten, verfügt das Schlachtschiff über große Laderäume, schwere Kanonen und eine hohe Hyperraumgeschwindigkeit. Nach seiner Fertigstellung erwies es sich schließlich als das Rückgrat der Flotte jedes plündernden Herrschers.',
    ],

    'battlecruiser' => [
        'title'            => 'Schlachtkreuzer',
        'description'      => 'Der Schlachtkreuzer ist hochspezialisiert auf das Abfangen feindlicher Flotten.',
        'description_long' => 'Dieses Schiff ist eines der fortschrittlichsten Kampfschiffe, das jemals entwickelt wurde, und ist besonders tödlich, wenn es darum geht, angreifende Flotten zu vernichten. Mit seinen verbesserten Laserkanonen an Bord und dem fortschrittlichen Hyperraumtriebwerk ist der Schlachtkreuzer eine ernsthafte Kraft, mit der bei jedem Angriff zu rechnen ist. Aufgrund des Schiffsdesigns und seines großen Waffensystems mussten die Laderäume reduziert werden, was jedoch durch den geringeren Treibstoffverbrauch kompensiert wird.',
    ],

    'bomber' => [
        'title'            => 'Bomber',
        'description'      => 'Der Bomber wurde speziell zur Zerstörung der planetaren Verteidigungsanlagen einer Welt entwickelt.',
        'description_long' => 'Im Laufe der Jahrhunderte, als Verteidigungsanlagen immer größer und ausgefeilter wurden, begannen Flotten in erschreckendem Ausmaß vernichtet zu werden. Es wurde entschieden, dass ein neues Schiff benötigt wird, um Verteidigungsanlagen zu durchbrechen und maximale Ergebnisse zu sichern. Nach jahrelanger Forschung und Entwicklung wurde der Bomber erschaffen.

Mit lasergestützter Zielausrüstung und Plasmabomben sucht der Bomber nach Verteidigungsanlagen und zerstört sie. Sobald der Hyperraumantrieb auf Stufe 8 entwickelt wurde, wird der Bomber mit dem Hyperraumtriebwerk ausgestattet und kann mit höherer Geschwindigkeit fliegen.',
    ],

    'destroyer' => [
        'title'            => 'Zerstörer',
        'description'      => 'Der Zerstörer ist der König der Kriegsschiffe.',
        'description_long' => 'Der Zerstörer ist das Ergebnis jahrelanger Arbeit und Entwicklung. Mit der Entwicklung von Todessternen wurde entschieden, dass eine Schiffsklasse benötigt wird, um gegen eine so massive Waffe zu verteidigen. Dank seiner verbesserten Zielsuchsensoren, Mehrfach-Phalanx-Ionenkanonen, Gausskanonen und Plasmageschütze erwies sich der Zerstörer als eines der furchteinflößendsten Schiffe.

Da der Zerstörer sehr groß ist, ist seine Manövrierfähigkeit stark eingeschränkt, was ihn eher zu einer Kampfstation als einem Kampfschiff macht. Der Mangel an Manövrierfähigkeit wird durch seine schiere Feuerkraft ausgeglichen, der Bau und Betrieb kostet jedoch erhebliche Mengen an Deuterium.',
    ],

    'deathstar' => [
        'title'            => 'Todesstern',
        'description'      => 'Die Zerstörungskraft des Todessterns ist unübertroffen.',
        'description_long' => 'Der Todesstern ist das mächtigste Schiff, das je erschaffen wurde. Dieses mondgroße Schiff ist das einzige Schiff, das mit bloßem Auge vom Boden aus gesehen werden kann. Bis man es erblickt, ist es leider zu spät, um noch etwas zu unternehmen.

Bewaffnet mit einer gigantischen Gravitonkanone, dem fortschrittlichsten Waffensystem, das je im Universum erschaffen wurde, hat dieses massive Schiff nicht nur die Fähigkeit, ganze Flotten und Verteidigungsanlagen zu zerstören, sondern auch ganze Monde zu vernichten. Nur die fortschrittlichsten Imperien sind in der Lage, ein Schiff dieser monumentalen Größe zu bauen.',
    ],

    'reaper' => [
        'title'            => 'Reaper',
        'description'      => 'Der Reaper ist ein mächtiges Kampfschiff, das auf aggressive Überfälle und das Ernten von Trümmerfeldern spezialisiert ist.',
        'description_long' => 'Der Reaper stellt den Höhepunkt des militärischen Ingenieurwesens der General-Klasse dar. Dieses schwer bewaffnete Schiff wurde für Kommandeure entwickelt, die sowohl Kampfstärke als auch taktische Flexibilität schätzen. Obwohl seine Hauptrolle der Kampf ist, verfügt der Reaper über verstärkte Laderäume, die es ihm ermöglichen, nach der Schlacht Trümmerfelder zu ernten. Seine fortschrittlichen Zielsysteme und die schwere Panzerung machen ihn zu einem gewaltigen Gegner, während sein zweckorientiertes Design bedeutet, dass er sowohl Schlachtchaos verursachen als auch davon profitieren kann. Das Schiff ist mit modernster Waffentechnologie ausgestattet und kann sich gegen weitaus größere Schiffe behaupten.',
    ],

    // ---- Verteidigung ----

    'rocket_launcher' => [
        'title'            => 'Raketenwerfer',
        'description'      => 'Der Raketenwerfer ist eine einfache, kostengünstige Verteidigungsoption.',
        'description_long' => 'Deine erste einfache Verteidigungslinie. Dies sind einfache bodengestützte Abschussanlagen, die konventionelle Sprengkopfraketen auf angreifende feindliche Ziele abfeuern. Da sie günstig zu bauen sind und keine Forschung erforderlich ist, eignen sie sich gut zur Abwehr von Überfällen, verlieren jedoch bei größeren Angriffen an Wirksamkeit. Sobald du mit dem Bau fortschrittlicherer Verteidigungswaffensysteme beginnst, werden Raketenwerfer zu einfachem Kanonenfutter, damit deine schadenstärker Waffen über einen längeren Zeitraum größere Schäden anrichten können.

Nach einem Kampf besteht eine bis zu 70 % ige Chance, dass zerstörte Verteidigungsanlagen wieder in Betrieb genommen werden können.',
    ],

    'light_laser' => [
        'title'            => 'Leichtes Lasergeschütz',
        'description'      => 'Das konzentrierte Beschießen eines Ziels mit Photonen kann deutlich größere Schäden verursachen als herkömmliche ballistische Waffen.',
        'description_long' => 'Als sich die Technologie weiterentwickelte und ausgeklügeltere Schiffe entwickelt wurden, wurde festgestellt, dass eine stärkere Verteidigungslinie benötigt wird, um die Angriffe abzuwehren. Mit dem Fortschritt der Lasertechnologie wurde eine neue Waffe entwickelt, um die nächste Verteidigungsstufe bereitzustellen. Leichte Lasergeschütze sind einfache bodengestützte Waffen, die spezielle Zielsysteme nutzen, um den Feind zu verfolgen und einen hochintensiven Laser abzufeuern, der den Rumpf des Ziels durchschneidet. Um sie kostengünstig zu halten, wurden sie mit einem verbesserten Schildsystem ausgestattet, jedoch ist die Strukturintegrität dieselbe wie beim Raketenwerfer.

Nach einem Kampf besteht eine bis zu 70 % ige Chance, dass zerstörte Verteidigungsanlagen wieder in Betrieb genommen werden können.',
    ],

    'heavy_laser' => [
        'title'            => 'Schweres Lasergeschütz',
        'description'      => 'Das schwere Lasergeschütz ist die logische Weiterentwicklung des leichten Lasergeschützes.',
        'description_long' => 'Das schwere Lasergeschütz ist eine praktische, verbesserte Version des leichten Lasergeschützes. Im Vergleich zum leichten Lasergeschütz ausgewogener und mit verbesserter Legierungszusammensetzung nutzt es stärkere, dichter gepackte Strahlen und noch bessere Bordzielsysteme.

Nach einem Kampf besteht eine bis zu 70 % ige Chance, dass zerstörte Verteidigungsanlagen wieder in Betrieb genommen werden können.',
    ],

    'gauss_cannon' => [
        'title'            => 'Gausskanone',
        'description'      => 'Die Gausskanone feuert tonnenschwere Projektile mit hoher Geschwindigkeit ab.',
        'description_long' => 'Lange Zeit galten Projektilwaffen im Zuge der modernen thermonuklearen und Energietechnologie sowie der Entwicklung des Hyperraumantriebs und verbesserter Panzerung als veraltet. Das änderte sich, als genau die Energietechnologie, die sie einst veraltet hatte, ihnen half, ihre etablierte Stellung zurückzugewinnen.
Eine Gausskanone ist eine große Version des Teilchenbeschleunigers. Extrem schwere Geschosse werden mit einer enormen elektromagnetischen Kraft beschleunigt und erreichen Mündungsgeschwindigkeiten, bei denen der das Geschoss umgebende Staub in der Luft verbrennt. Diese Waffe ist beim Abfeuern so kraftvoll, dass sie einen Überschallknall erzeugt. Moderne Panzerung und Schilde können die Kraft kaum standhalten; oft wird das Ziel von der Kraft des Geschosses vollständig durchdrungen. Verteidigungsanlagen deaktivieren sich, sobald sie zu stark beschädigt wurden.

Nach einem Kampf besteht eine bis zu 70 % ige Chance, dass zerstörte Verteidigungsanlagen wieder in Betrieb genommen werden können.',
    ],

    'ion_cannon' => [
        'title'            => 'Ionenkanone',
        'description'      => 'Die Ionenkanone feuert einen kontinuierlichen Strahl beschleunigter Ionen ab und verursacht erhebliche Schäden an den Objekten, die sie trifft.',
        'description_long' => 'Eine Ionenkanone ist eine Waffe, die Ionenstrahlen (positiv oder negativ geladene Teilchen) abfeuert. Die Ionenkanone ist eigentlich eine Art Partikelkanone; nur die verwendeten Teilchen sind ionisiert. Aufgrund ihrer elektrischen Ladungen können sie auch elektronische Geräte und alles, was eine elektrische oder ähnliche Energiequelle hat, durch ein Phänomen namens elektromagnetischer Impuls (EMP-Effekt) deaktivieren. Aufgrund des stark verbesserten Schildsystems der Kanone bietet diese Kanone verbesserten Schutz für deine größeren, zerstörerischeren Verteidigungswaffen.

Nach einem Kampf besteht eine bis zu 70 % ige Chance, dass zerstörte Verteidigungsanlagen wieder in Betrieb genommen werden können.',
    ],

    'plasma_turret' => [
        'title'            => 'Plasmageschütz',
        'description'      => 'Plasmageschütze setzen die Energie eines Sonnensturms frei und übertreffen in ihrer Zerstörungswirkung selbst den Zerstörer.',
        'description_long' => 'Eines der fortschrittlichsten jemals entwickelten Verteidigungswaffensysteme, das Plasmageschütz, verwendet eine große Kernreaktor-Brennstoffzelle, um einen elektromagnetischen Beschleuniger zu betreiben, der einen Impuls oder Toroid aus Plasma abfeuert. Beim Betrieb sperrt das Plasmageschütz zunächst auf ein Ziel ein und beginnt mit dem Abfeuerungsvorgang. Im Kern des Geschützes wird eine Plasmasphäre erzeugt, indem Gase stark erhitzt und komprimiert werden, wobei ihre Ionen abgestreift werden. Sobald das Gas stark erhitzt, komprimiert und eine Plasmasphäre erzeugt wurde, wird sie in den elektromagnetischen Beschleuniger geladen, der energetisiert wird. Sobald er vollständig energetisiert ist, wird der Beschleuniger aktiviert, was dazu führt, dass die Plasmasphäre mit einer extrem hohen Geschwindigkeit auf das beabsichtigte Ziel abgefeuert wird. Aus der Perspektive des Ziels ist der sich nähernde bläuliche Plasmaball beeindruckend, aber einmal eingeschlagen, verursacht er sofortige Zerstörung.

Verteidigungsanlagen deaktivieren sich, sobald sie zu schwer beschädigt sind. Nach einem Kampf besteht eine bis zu 70 % ige Chance, dass zerstörte Verteidigungsanlagen wieder in Betrieb genommen werden können.',
    ],

    'small_shield_dome' => [
        'title'            => 'Kleiner Schild',
        'description'      => 'Der kleine Schild bedeckt einen ganzen Planeten mit einem Kraftfeld, das enorme Energiemengen absorbieren kann.',
        'description_long' => 'Die Kolonisierung neuer Welten brachte eine neue Gefahr mit sich: Weltraumschutt. Ein großer Asteroid könnte die Welt und alle ihre Bewohner leicht auslöschen. Fortschritte in der Schildtechnologie gaben Wissenschaftlern die Möglichkeit, einen Schild zu entwickeln, der einen gesamten Planeten nicht nur vor Weltraumschutt, sondern auch vor feindlichen Angriffen schützt. Durch das Erzeugen eines großen elektromagnetischen Feldes um den Planeten wurde Weltraumschutt, der den Planeten normalerweise zerstört hätte, abgelenkt, und Angriffe feindlicher Imperien wurden vereitelt. Die ersten Generatoren waren groß und der Schild bot mäßigen Schutz, aber es wurde später festgestellt, dass kleine Schilde keinen ausreichenden Schutz vor größeren Angriffen boten. Der kleine Schild war das Vorspiel zu einem stärkeren, fortschrittlicheren planetaren Schildsystem.

Nach einem Kampf besteht eine bis zu 70 % ige Chance, dass zerstörte Verteidigungsanlagen wieder in Betrieb genommen werden können.',
    ],

    'large_shield_dome' => [
        'title'            => 'Großer Schild',
        'description'      => 'Die Weiterentwicklung des kleinen Schildes kann deutlich mehr Energie einsetzen, um Angriffen standzuhalten.',
        'description_long' => 'Der große Schild ist der nächste Schritt in der Weiterentwicklung planetarer Schilde; er ist das Ergebnis jahrelanger Arbeit zur Verbesserung des kleinen Schildes. Gebaut, um einem größeren Hagel feindlichen Beschusses standzuhalten, indem ein stärker energetisiertes elektromagnetisches Feld erzeugt wird, bieten große Schildkuppeln einen längeren Schutz, bevor sie zusammenbrechen.

Nach einem Kampf besteht eine bis zu 70 % ige Chance, dass zerstörte Verteidigungsanlagen wieder in Betrieb genommen werden können.',
    ],

    'anti_ballistic_missile' => [
        'title'            => 'Abfangrakete',
        'description'      => 'Abfangraketen zerstören angreifende Interplanetarraketen.',
        'description_long' => 'Abfangraketen (ABM) sind deine einzige Verteidigung, wenn dein Planet oder Mond mit Interplanetarraketen (IPM) angegriffen wird. Wenn ein Abschuss von IPMs erkannt wird, scharf schalten diese Raketen automatisch, verarbeiten einen Startcode in ihren Bordcomputern, nehmen die eingehende IPM ins Visier und starten zum Abfangen. Während des Fluges wird die Ziel-IPM kontinuierlich verfolgt und Korrekturen des Kurses werden angewendet, bis die ABM das Ziel erreicht und die angreifende IPM zerstört. Jede ABM zerstört eine eingehende IPM.',
    ],

    'interplanetary_missile' => [
        'title'            => 'Interplanetarrakete',
        'description'      => 'Interplanetarraketen zerstören feindliche Verteidigungsanlagen.',
        'description_long' => 'Interplanetarraketen (IPM) sind deine Angriffswaffe zur Zerstörung der Verteidigungsanlagen deines Ziels. Durch den Einsatz modernster Verfolgungstechnologie zielt jede Rakete auf eine bestimmte Anzahl von Verteidigungsanlagen zur Zerstörung. Bestückt mit einer Antimateriebombe liefern sie eine so zerstörerische Kraft, dass zerstörte Schilde und Verteidigungsanlagen nicht repariert werden können. Die einzige Möglichkeit, diesen Raketen entgegenzuwirken, sind ABMs.',
    ],

    // ---- Shop-Booster-Gegenstände ----

    'kraken' => [
        'title'       => 'KRAKEN',
        'description' => 'Reduziert die Bauzeit von Gebäuden, die sich derzeit im Bau befinden, um <b>:duration</b>.',
    ],

    'detroid' => [
        'title'       => 'DETROID',
        'description' => 'Reduziert die Bauzeit der aktuellen Werftaufträge um <b>:duration</b>.',
    ],

    'newtron' => [
        'title'       => 'NEWTRON',
        'description' => 'Reduziert die Forschungszeit für alle derzeit laufenden Forschungen um <b>:duration</b>.',
    ],
];
