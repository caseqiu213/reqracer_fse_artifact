<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Automatically generated strings for Moodle installer
 *
 * Do not edit this file manually! It contains just a subset of strings
 * needed during the very first steps of installation. This file was
 * generated automatically by export-installer.php (which is part of AMOS
 * {@link http://docs.moodle.org/dev/Languages/AMOS}) using the
 * list of strings defined in /install/stringnames.txt.
 *
 * @package   installer
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['admindirname'] = 'Admin-Verzeichnis';
$string['availablelangs'] = 'Verfügbare Sprachpakete';
$string['chooselanguagehead'] = 'Sprache wählen';
$string['chooselanguagesub'] = 'Wählen Sie eine Sprache, die Sie während der Installation verwenden wollen. Die ausgewählte Sprache wird nach der Installation als Standardsprache der Instanz benutzt, aber können Sie die Sprache jederzeit ändern.';
$string['clialreadyinstalled'] = 'Die Datei config.php existiert bereits. Bitte benutzen Sie admin/cli/upgrade.php falls Sie Ihre Website aktualisieren möchten.';
$string['cliinstallheader'] = 'Installation von Moodle {$a} über die Kommandozeile';
$string['databasehost'] = 'Datenbank-Server';
$string['databasename'] = 'Datenbank-Name';
$string['databasetypehead'] = 'Datenbank-Treiber wählen';
$string['dataroot'] = 'Datenverzeichnis';
$string['datarootpermission'] = 'Zugriffsrechte zum Datenverzeichnis';
$string['dbprefix'] = 'Tabellen-Prefix';
$string['dirroot'] = 'Moodle-Verzeichnis';
$string['environmenthead'] = 'Installationsvoraussetzungen werden geprüft ...';
$string['environmentsub2'] = 'Jede Moodle-Version hat Mindestvoraussetzungen für der PHP-Version und für einige verbindliche PHP-Extensions. Vor einer Installation oder einer Aktualisierung wird immer eine vollständige Prüfung der Serverausstattung durchgeführt. Bitte fragen Sie den Administrator Ihres Servers, wenn Sie mit der Installation einer neuen Version oder mit der Aktivierung von PHP-Extensions nicht weiterkommen.';
$string['errorsinenvironment'] = 'Fehler bei der Prüfung der Systemvoraussetzungen!';
$string['installation'] = 'Installation';
$string['langdownloaderror'] = 'Leider konnte das Sprachpaket \'{$a}\' nicht heruntergeladen werden. Die Installation wird in englischer Sprache fortgesetzt.';
$string['memorylimithelp'] = '<p>Die PHP-Einstellung memory_limit für Ihren Server ist zur Zeit auf {$a} eingestellt. </p>
<p>Wenn Sie Moodle mit vielen Aktivitäten oder vielen Nutzer/innen verwenden, wird dies vermutlich zu Problemen führen.</p>
<p>Wir empfehlen die Einstellung wenn möglich zu erhöhen, z.B. auf 40M oder mehr. Dies können Sie auf verschiedene Arten machen:</p>
<ol>
<li>Wenn Sie PHP neu kompilieren können, nehmen Sie die Einstellung <i>--enable-memory-limit</i>. Dann kann Moodle die Einstellung selber vornehmen.
<li>Wenn Sie Zugriff auf die Datei php.ini haben, können Sie die Einstellung <b>memory_limit</b> selber auf einen Wert von 40M setzen. Wenn Sie selber keinen Zugriff haben, fragen Sie den Server-Admin, dies für Sie zu tun.
<li>Auf einigen PHP-Servern können Sie eine .htaccess-Datei im Moodle-Verzeichnis einrichten. Tragen Sie darin die folgende Zeile ein: <p><blockquote><div>php_value memory_limit 40M</div></blockquote></p>
<p>Achtung: auf einigen Servern hindert diese Einstellung <b>alle</b> PHP-Seiten und Sie erhalten Fehlermeldungen. Entfernen Sie dann den Eintrag in der .htaccess-Datei wieder.</p></li>
</ol>';
$string['paths'] = 'Pfade';
$string['pathserrcreatedataroot'] = 'Das Datenverzeichnis ({$a->dataroot}) kann vom Installer nicht angelegt werden.';
$string['pathshead'] = 'Pfade bestätigen';
$string['pathsrodataroot'] = 'Das Verzeichnis dataroot ist schreibgeschützt.';
$string['pathsroparentdataroot'] = 'Das Verzeichnis ({$a->parent}) ist schreibgeschützt. Deswegen kann das Datenverzeichnis ({$a->dataroot})  vom Installer nicht angelegt werden.';
$string['pathssubadmindir'] = 'Einige Webserver benutzen /admin als speziellen Link, um auf Einstellungsseiten oder Ähnliches zu verweisen. Unglücklicherweise kollidiert dies mit dem standardmäßigen Verzeichnis für die Moodle-Administration. Sie können dieses Problem beheben, indem Sie das Verzeichnis admin in Ihrer Moodle-Installation umbenennen und den neuen Namen hier eingeben (z.B. <em>moodleadmin</em>). Mit dieser Änderung werden alle Admin-Links korrigiert.';
$string['pathssubdataroot'] = 'Sie benötigen einen Platz, wo Moodle hochgeladene Dateien abspeichern kann. Dieses Verzeichnis muss Lese- und Schreibrechte für das Nutzerkonto besitzen, mit dem Ihr Webservers läuft (üblicherweise \'nobody\', \'apache\' oder \'www\'). Außerdem sollte das Verzeichnis nicht direkt aus dem Internet erreichbar sein. Das Intallationsskript wird versuchen, ein solches Verzeichnis zu erstellen, falls es nicht existiert.</p>';
$string['pathssubdirroot'] = 'Vollständiger Pfad der Moodle-Installation';
$string['pathssubwwwroot'] = 'Vollständige Webadresse für den Zugriff auf Moodle. Es ist nicht möglich, über unterschiedliche Adressen auf Moodle zuzugreifen. Sollte Ihre Website mehrere öffentliche Adressen verwenden, so müssen Sie eine Adresse festlegen und für die übrigen Adressen dauerhafte Weiterleitungen dorthin einrichten.
<p>Falls Ihre Website gleichzeitig im Intranet und im Internet erreichbar ist, so tragen Sie die öffentliche Adresse ein. Konfigurieren Sie den DNS so, dass Moodle auch aus dem Intranet über die öffentliche Adresse erreichbar ist.
<p>Führen Sie Ihre Moodle-Installation unbedingt mit der richtigen Adresse durch, weil es andernfalls zu Problemen kommen könnte.';
$string['pathsunsecuredataroot'] = 'Der Speicherort des Verzeichnisses \'dataroot\' ist unsicher';
$string['pathswrongadmindir'] = 'Das Admin-Verzeichnis existiert nicht';
$string['phpextension'] = 'PHP-Extension {$a}';
$string['phpversion'] = 'PHP-Version';
$string['phpversionhelp'] = '<p>Moodle erwartet als PHP-Version mindestens 4.3.0/4.4.0 oder 5.1.0 (5.0.x weist eine Reihe bekannter Fehler auf).</p>
<p>Sie nutzen momentan die Version {$a}.</p>
<p>Sie müssen Ihre PHP-Version aktualisieren oder auf einen Rechner wechseln, der eine neuere Version von PHP nutzt.<br />
(Im Falle von 5.0.x könnten Sie auch zu einer Version 4.3.x/4.4.x downgraden)</p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'Sie haben das Paket <strong>{$a->packname} {$a->packversion}</strong> erfolgreich auf Ihrem Computer installiert.';
$string['welcomep30'] = 'Diese Version von <strong>{$a->installername}</strong> enthält folgende Anwendungen, mit denen Sie <strong>Moodle</strong> ausführen können:';
$string['welcomep40'] = 'Das Paket enthält: <strong>Moodle {$a->moodlerelease} ({$a->moodleversion})</strong>.';
$string['welcomep50'] = 'Die Nutzung dieser Anwendungen ist lizenzrechtlich geprüft. Alle Anwendungen von <strong>{$a->installername}</strong> sind
<a href="http://www.opensource.org/docs/definition_plain.html"> Open Source </a> und unterliegen der <a href="http://www.gnu.org/copyleft/gpl.html"> GPL</a> Lizenz.';
$string['welcomep60'] = 'Die folgenden Seiten führen Sie in einfachen Schritten durch die Konfiguration und Installation von <strong>Moodle</strong> auf Ihrem Computer. Sie können die vorgeschlagenen Einstellungen übernehmen oder an Ihre Bedürfnisse anpassen.';
$string['welcomep70'] = 'Klicken Sie auf die Taste \'Weiter\', um mit der Installation von Moodle fortzufahren.';
$string['wwwroot'] = 'Webadresse';
