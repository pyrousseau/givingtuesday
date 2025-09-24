# Giving Tuesday FR — WordPress (theme + mu-plugins) !!!!!!!

Ce dépôt ne versionne **que le code que nous maitrisons** : thème, mu-plugins et éventuels plugins custom. Pas de coeur WordPress, pas d'uploads.

## Structure recommandée

```
wp-content/
  themes/
    givingtuesday/        # votre thème (ou child-theme)
  mu-plugins/
    gt-core/
  plugins/
    gt-custom-plugin/
```

## Démarrage rapide

1. **Créer le dépôt sur GitHub**
   - Repo public ou privé selon votre préférence.
   - Activer *Issues* et *Actions*.

2. **Initialiser en local**
   ```bash
   git init
   git remote add origin git@github.com:ORG/REPO.git
   # Copiez votre theme/mu-plugins/plugins dans wp-content/...
   echo "voir .gitignore" 
   git add .
   git commit -m "chore: initial import (theme + mu-plugins + plugins)"
   git branch -M main
   git push -u origin main
   ```

3. **Secrets pour le déploiement (optionnel, via FTP)**
   - Dans **Settings → Secrets and variables → Actions**, ajoutez :
     - `FTP_SERVER`
     - `FTP_USERNAME`
     - `FTP_PASSWORD`
     - `SERVER_DIR` (ex: `/htdocs/wp-content/themes/givingtuesday`)

4. **Déployer**
   - Le workflow GitHub Actions fourni déclenche sur chaque push sur `main` et ne transfère que `wp-content`.
   - Pour un déploiement partiel (seulement le thème par ex.), modifiez `local-dir` et `server-dir`.

## Bonnes pratiques

- **Jamais** de mots de passe ou `wp-config.php` dans Git.
- Commitez petit et souvent, avec des messages clairs.
- Travaillez en branches (`feat/`, `fix/`, `chore/`) et utilisez des Pull Requests.
- Exportez la base de données **en dehors** de ce dépôt (outil WP Migrate, Duplicator, etc.).
- Utilisez des fichiers `config.local.php` ignorés par Git pour vos devs locaux.

## Déploiement sans FTP

Si vous n'avez pas d'accès FTP/SSH, laissez le workflow créer un **ZIP d'artefact** que vous pourrez télécharger depuis l'onglet *Actions*, puis **uploader manuellement** via le File Manager de l'hébergeur.

## Licence

Choisissez la licence qui convient (MIT, GPL-2.0, etc.) ou laissez le repo privé.
