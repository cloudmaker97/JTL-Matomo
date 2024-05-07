# Matomo Tracking Plugin für JTL-Shop

## Informationen

> **Das Plugin ist nicht für den Produktiveinsatz freigegeben, da es noch nicht vollständig getestet wurde. Es wird empfohlen, das Plugin nur in einer Testumgebung zu verwenden.**

### Was macht dieses Plugin?

![2024-05-07 11_36_09-Fischer Modell - 2024-05-06 - Webanalytik-Berichte - Matomo](https://github.com/cloudmaker97/JTL-Matomo-Tracking/assets/4189795/1e7fc74e-8abb-4e3e-bcbb-101ec558ca2e)

Dieses Plugin ermöglicht es, Matomo Tracking in JTL-Shop zu integrieren. Es nutzt die HTTP-API von Matomo, um die Daten an den Matomo-Server zu senden. Das Plugin ist so konzipiert, dass es einfach in JTL-Shop integriert werden kann. So werden Umsatz-Ereignisse, Produktansichten und Warenkorb-Ereignisse an Matomo gesendet.

## Voraussetzungen

- NodeJS mit `npm` oder `pnpm`
- JTL Shop auf 5.3.1 oder höher
- PHP 8.0 oder höher

## Entwicklung starten

Hier sind einige Befehle, die für die Entwicklung des Plugins hilfreich sind.

### Webpack Befehle

Um die Abhängigkeiten für Webpack zu installieren, müssen folgende Befehle ausgeführt werden:
```shell
npm install # Für Nutzer, die npm nutzen
pnpm install # Für Nutzer, die pnpm nutzen
```

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

### Veröffentlichung des Plugins (Workflow)

```shell
git tag 1.0.0 # Für die Version 1.0.0
git push --tags # Tags auf GitHub hochladen
```
