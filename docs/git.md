# Git Workflow

## Basic Flow

```bash
git pull
git add .
git commit -m "v2.9.0: upgrade UI based on v2.8.1"
git push
```

## Tag Release

```bash
git tag v2.9.0
git push origin v2.9.0
```

## Recommended `.gitignore`

```text
node_modules/
.env
*.log
.DS_Store
Thumbs.db
```

## Avoid

- Do not commit ZIP files unless they are release artifacts
- Do not delete `.git`
- Do not commit from the wrong directory
