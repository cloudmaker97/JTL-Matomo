# Entwicklungsvorlage für Plugins

Für Fragen zur Nutzung des Plugins kann man sich an mich per E-Mail wenden:

- Dennis Heinrich <der@dennis-heinri.ch>

## Mitgelieferte Features

Diese Vorlage kommt mit folgenden Technologien:

- Bootstrap Klasse
- Webpack Bundler
  - TypeScript
  - SCSS Loader
  - TailwindCSS

### Was ist Webpack?

Webpack ist ein Bundler, der alle Dateien (JavaScript, CSS und ggf. Bilder) in eine einzelne Datei 
bündelt: Das Resultat ist das Bundle. Dabei werden alle SCSS Dateien in CSS Dateien kompiliert. 
Der Vorteil darin ist, dass Anfragen an den Shop gespart werden und die Seitengeschwindigkeit erhöht wird.

### Was ist TailwindCSS?

TailwindCSS ist ein CSS-Framework, das es ermöglicht, CSS direkt im HTML zu schreiben (ohne dabei Inline)
zu sein. Es ist sehr flexibel und kann mit SCSS kombiniert werden und ist eine moderne Alternative zu
überladenen CSS-Frameworks wie Bootstrap, denn Tailwind kompiliert ausschließlich die verwendeten Klassen
und nicht das gesamte Framework in das Webpack Bundle.

Wenn man mit dem Umgang nicht vertraut ist, kann das einfach ignoriert werden, denn wie bereits erwähnt wurde,
werden nur benutzte Klassen kompiliert und erhöht nicht die Dateigröße vom Webpack Bundle.

### Was ist TypeScript?

TypeScript ist eine Programmiersprache, die auf JavaScript basiert. Sie bietet die Möglichkeit, Typen zu definieren,
was die Entwicklung qualitativ aufwerten kann. Statt .js Dateien werden .ts Dateien verwendet, die dann in .js Dateien
kompiliert werden. 

TypeScript zu schreiben ist optional und kann auch ignoriert werden, denn man kann auch reines JavaScript in die Datei
schreiben. Dennoch muss nach dem Ändern der Datei das Webpack Bundle neu gebaut werden.

## Entwicklung starten

### Namespace anpassen

Das Plugin benötigt einen einmaligen Namespace. Dieser muss in auch der Datei `./plugin.xml` angepasst werden.
Die einfachste Lösung ist, im gesamtem Plugin nach `plugin_test` zu suchen und durch den gewünschten Namespace zu
ersetzen, z.B. `meine_firma_plugin_fuer_funktion_xy`. Gängige Praxis ist es, ein Präfix zu verwenden, das allen
eigenen Plugins vorangestellt wird, z.B. `meine_firma` und anschließend der technische Name des Plugins, z.B. `plugin_fuer_funktion_xy`.

### README.md anpassen

Die Datei `README.md` ist die Datei, die auf GitHub und im Plugin unter dem Tab "Dokumentation" angezeigt wird. 
Sie sollte mit Informationen zum Plugin angepasst werden, damit Nutzer die Funktion des Plugins verstehen.

### Webpack Bundle bauen

Damit das Webpack Bundle gebaut werden kann, müssen die Projekt-Voraussetzungen erfüllt sein. Dann muss die
Kommandozeile im Ordner (`./frontend/webpack`) geöffnet werden.

Um die Abhängigkeiten für Webpack zu installieren, müssen folgende Befehle ausgeführt werden:
```shell
npm install # Für Nutzer, die npm nutzen
pnpm install # Für Nutzer, die pnpm nutzen
```

Wenn nun entwickelt wird, muss bei sämtlichen Änderungen das Webpack Bundle neu gebaut werden. Dafür gibt es zwei 
verschiedene Befehle: einen um das Bundle einmalig zu bauen und einen um das Bundle bei Änderungen automatisch neu
zu bauen. Bei der automatischen Variante muss die Kommandozeile offen bleiben.

Für das einmalige Bauen des Bundles:
```shell
npm run build # Für Nutzer, die npm nutzen
pnpm run build  # Für Nutzer, die pnpm nutzen
```

Für das automatische Bauen nach Änderung einer Datei:
```shell
npm run watch # Für Nutzer, die npm nutzen
pnpm run watch  # Für Nutzer, die pnpm nutzen
```

### Veröffentlichung eines Plugins (Workflow)

Wenn das Plugin fertig entwickelt wurde, kann es veröffentlicht werden. Dazu gehört u.a. das abschließende
Bauen des Webpack Bundles und das Erstellen eines ZIP-Archivs. Um dem Entwickler eine
einfache Möglichkeit zu geben, Versionen zu erstellen und zu veröffentlichen, gibt es ein GitHub-Workflow.

Der Workflow wird automatisch nach einem Push auf GitHub ausgeführt, wenn ein neuer Tag mit Git erstellt wurde. So kann man
wenn man eine neue Version erstellt hat, einen Tag mit der Versionsnummer erstellen und alle Schritte werden automatisch
ausgeführt. Das Plugin bekommt dann unter dem Tab "Releases" auf GitHub einen Eintrag mit der Versionsnummer und dem Link zum
Download des fertigen Plugins. Das erstellen eines Tags kann mit folgendem Befehl ausgeführt werden:

```shell
git tag 1.0.0 # Für die Version 1.0.0
git push --tags # Tags auf GitHub hochladen
```

## Voraussetzungen

- NodeJS mit `npm` oder `pnpm`
- JTL Shop auf 5.0.0 oder höher
- PHP 7.4 oder höher