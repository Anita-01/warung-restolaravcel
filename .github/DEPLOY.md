# Deploy Guide

## How It Works

```
Push to master → GitHub Actions:
  1. Build Docker image (composer + npm build + PHP-FPM/Nginx)
  2. Push to ghcr.io/andreejait/warung-restolaravcel
  3. SSH into server via cloudflared
  4. Run deploy.sh:
     - Login to GHCR
     - Pull latest image
     - Ensure storage directories exist
     - docker compose up -d
     - artisan migrate --force
     - artisan db:seed --force
     - Cleanup old images
```

## GitHub Secrets

Add these in **Settings → Secrets and variables → Actions**:

| Secret | Description |
|--------|-------------|
| `DB_PASSWORD` | MariaDB user password |
| `DB_ROOT_PASSWORD` | MariaDB root password |
| `DEPLOY_SSH_HOST` | Cloudflared SSH hostname |
| `DEPLOY_SSH_USER` | SSH username on the server |
| `DEPLOY_SSH_KEY` | SSH private key |

## Server Setup

### 1. Directory structure

```
/home/andree/docker/warung-restolaravcel/
├── .env                          # Production config (mounted into container)
├── storage/                      # Persistent storage (mounted into container)
│   ├── app/public/
│   ├── framework/cache/
│   ├── framework/sessions/
│   ├── framework/views/
│   └── logs/
└── deploy/
    ├── docker-compose.yaml
    ├── Dockerfile
    ├── nginx.conf
    ├── supervisor.conf
    └── deploy.sh
```

### 2. Create production .env

```bash
cp .env.example .env
```

Edit `.env` with production values:

```env
APP_NAME=WarungMuslimLia
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=warung
DB_USERNAME=warung
DB_PASSWORD=your_secure_password

REDIS_HOST=redis
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=database
```

Generate `APP_KEY`:

```bash
php artisan key:generate --show
```

### 3. Create registry credentials

`/home/andree/docker/.env`:

```env
REGISTRY_USER=andreejait
REGISTRY_TOKEN=ghp_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

Token scope: `write:packages`, `read:packages`.

### 4. Create storage directories

```bash
mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
```

### 5. First deploy

```bash
cd /home/andree/docker
git clone https://github.com/AndreeJait/warung-restolaravcel.git
cd warung-restolaravcel
bash deploy/deploy.sh
```

## Manual Deploy

```bash
ssh andree@your-server
cd /home/andree/docker/warung-restolaravcel
git pull
bash deploy/deploy.sh
```

## Generate SSH Key for GitHub Actions

```bash
ssh-keygen -t ed25519 -C "github-deploy@warung" -f ~/.ssh/warung-deploy
```

- Private key (`~/.ssh/warung-deploy`) → GitHub secret `DEPLOY_SSH_KEY`
- Public key (`~/.ssh/warung-deploy.pub`) → add to server's `~/.ssh/authorized_keys`
