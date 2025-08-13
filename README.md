
![Logo](https://dev-to-uploads.s3.amazonaws.com/uploads/articles/th5xamgrr6se0x5ro4g6.png)


# Quarkpayy
A modern, Vue-powered alternative to Paymenter â€” cleaner UI, faster DX, and a flexible plugin system.

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](#license)
[![Contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg)](#contributing)
[![Discord](https://img.shields.io/badge/chat-Discord-5865F2.svg)](https://discord.gg/your-invite)

Note: Quarkpayy is an independent, community-driven project and is not affiliated with Paymenter.

- Website: https://quarkpayy.dev
- Docs: https://docs.quarkpayy.dev
- Demo: https://demo.quarkpayy.dev (read-only)

---

## Why Quarkpayy?
Quarkpayy reimagines the Paymenter experience with a modern front end and a clean, accessible UI. Built as a Vue 3 SPA on top of a robust API, itâ€™s fast to use, easy to theme, and simple to extend.

- Updated UI: Responsive, accessible, dark-mode ready
- Vue 3 + Vite: Instant HMR, modular components, TypeScript-friendly
- API-first: Decoupled Laravel API for performance and flexibility
- Plug-in gateways: Stripe, PayPal, and bring-your-own gateway
- Billing essentials: Invoices, subscriptions, coupons, taxes, webhooks
- Multi-tenant ready: Scoped customer, product, and gateway data
- Translatable: i18n with lazy-loaded locales
- Theming: Tailwind CSS tokens and design system
- Dev experience: First-class Docker and one-command setup

---

## Screenshots
- Dashboard: ./assets/screenshots/dashboard.png
- Invoices: ./assets/screenshots/invoices.png
- Products: ./assets/screenshots/products.png

(Replace with your actual screenshots or a GIF walkthrough)

---

## Tech Stack
- Front end: Vue 3, Vite, Pinia, Vue Router, Tailwind CSS, Shadcn UI
- Back end: Laravel (API), Sanctum or JWT for auth, Laravel Scout (optional)
- Cache/Queue: Redis
- DB: MySQL/MariaDB or PostgreSQL
- Payments: Driver-based gateway system (Stripe, PayPal, custom)
- Tooling: TypeScript (optional), ESLint + Prettier, Husky, Commitlint

---

## Quick Start

### Prerequisites
- Node.js 18+ and PNPM/Yarn/NPM
- PHP 8.2+, Composer
- MySQL 8+ or PostgreSQL 14+, Redis
- Or Docker + Docker Compose

### Clone
```bash
git clone https://github.com/JsemOlik/quarkpayy.git
cd quarkpayy
```

### Configure environment
```bash
cp .env.example .env
php -r "file_exists('.env') && print('OK\n');"
```

Edit the .env values to match your DB and app URL.

### Install dependencies
```bash
# Backend
composer install
php artisan key:generate

# Frontend
pnpm install # or yarn / npm
```

### Database and seed
```bash
php artisan migrate --seed
```

### Run in dev
```bash
# Terminal 1 - API
php artisan serve

# Terminal 2 - Frontend
pnpm dev
```

Open http://localhost:5173 for the app and http://localhost:8000 for the API.

---

## One-command Docker
```bash
docker compose up -d
# First-time setup inside app container:
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```
- App: http://localhost:8080
- API: http://localhost:8080/api
- MailHog (dev): http://localhost:8025

---

## Project Structure
```txt
quarkpayy/
â”śâ”€ apps/
â”‚  â”śâ”€ api/                 # Laravel API
â”‚  â”‚  â”śâ”€ app/
â”‚  â”‚  â”śâ”€ routes/
â”‚  â”‚  â”śâ”€ database/
â”‚  â”‚  â””â”€ config/
â”‚  â””â”€ web/                 # Vue 3 SPA
â”‚     â”śâ”€ src/
â”‚     â”‚  â”śâ”€ components/
â”‚     â”‚  â”śâ”€ pages/
â”‚     â”‚  â”śâ”€ stores/
â”‚     â”‚  â”śâ”€ router/
â”‚     â”‚  â”śâ”€ composables/
â”‚     â”‚  â””â”€ styles/
â”śâ”€ packages/
â”‚  â””â”€ gateways/            # Payment gateway plugins
â”‚     â”śâ”€ stripe/
â”‚     â””â”€ paypal/
â”śâ”€ docker/
â””â”€ scripts/
```

---

## Configuration
Example .env (trim to what you need):
```env
APP_NAME=Quarkpayy
APP_ENV=local
APP_KEY=
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quarkpayy
DB_USERNAME=root
DB_PASSWORD=secret

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

FRONTEND_URL=http://localhost:5173

# Payments (examples)
STRIPE_KEY=pk_live_xxx
STRIPE_SECRET=sk_live_xxx
PAYPAL_CLIENT_ID=xxx
PAYPAL_CLIENT_SECRET=xxx
PAYPAL_MODE=sandbox
```

Frontend env (apps/web/.env):
```env
VITE_API_BASE=http://localhost:8000/api
VITE_APP_NAME=Quarkpayy
```

---

## Migrate from Paymenter
Quarkpayy is a fresh UI and architecture using Vue instead of Blade. A basic migration flow:

1) Backup your Paymenter DB.
2) Install Quarkpayy and configure .env.
3) Run the importer script:
```bash
php artisan quarkpayy:import --from=paymenter --dsn="mysql://user:pass@host/db"
```
4) Map gateways: confirm your keys and webhooks in Settings â†’ Gateways.
5) Verify customers, products, invoices, and subscriptions.
6) Switch DNS and webhooks to Quarkpayy endpoints.

Note: Depending on your Paymenter version/customizations, you may need to write a small mapping file. See docs/migration.md.

---

## Gateway Plugin Development
Create a new gateway in packages/gateways/my-gateway:

Backend (Laravel service provider skeleton):
```php
<?php

namespace Quarkpayy\Gateways\Acme;

use Illuminate\Support\ServiceProvider;

class AcmeGatewayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('acme.gateway', fn () => new AcmeGateway());
    }

    public function boot(): void
    {
        // Routes, config, webhook registration
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->mergeConfigFrom(__DIR__ . '/config/acme.php', 'gateways.acme');
    }
}
```

Gateway driver interface:
```php
<?php

namespace App\Contracts;

interface PaymentGateway
{
    public function createCheckout(array $payload): array;
    public function capture(string $paymentId): array;
    public function refund(string $paymentId, int $amount): array;
    public function handleWebhook(array $request): void;
}
```

Frontend settings panel (Vue single-file component):
```vue
<script setup lang="ts">
import { ref } from "vue";
import { useGatewayStore } from "@/stores/gateways";

const form = ref({
  apiKey: "",
  secret: "",
  mode: "sandbox",
});

const gateways = useGatewayStore();
function save() {
  gateways.saveConfig("acme", form.value);
}
</script>

<template>
  <section class="space-y-4">
    <h3 class="text-lg font-semibold">Acme Gateway</h3>
    <div class="grid gap-4 sm:grid-cols-2">
      <label class="flex flex-col">
        <span class="text-sm text-gray-500">API Key</span>
        <input class="input" v-model="form.apiKey" />
      </label>
      <label class="flex flex-col">
        <span class="text-sm text-gray-500">Secret</span>
        <input class="input" v-model="form.secret" type="password" />
      </label>
      <label class="flex flex-col sm:col-span-2">
        <span class="text-sm text-gray-500">Mode</span>
        <select class="select" v-model="form.mode">
          <option value="sandbox">Sandbox</option>
          <option value="live">Live</option>
        </select>
      </label>
    </div>
    <button class="btn btn-primary" @click="save">Save</button>
  </section>
</template>

<style scoped>
.input,
.select {
  @apply border rounded px-3 py-2 bg-white/5 border-gray-300;
}
.btn {
  @apply inline-flex items-center px-4 py-2 rounded;
}
.btn-primary {
  @apply bg-indigo-600 text-white hover:bg-indigo-500;
}
</style>
```

See docs/gateways.md for full lifecycle hooks and examples.

---

## Scripts
- pnpm dev: Frontend dev server with HMR
- pnpm build: Production build
- pnpm lint: Lint Vue/TS with ESLint + Prettier
- composer test: Run backend tests
- php artisan queue:work: Start worker

---

## Roadmap
- [ ] More gateways (Mollie, Adyen)
- [ ] Advanced tax/VAT rules and invoices PDF designer
- [ ] Multi-currency price books
- [ ] Audit log and admin activity feed
- [ ] App store for community plugins
- [ ] Native themes and UI kit tokens

Vote or propose features in GitHub Discussions.

---

## Contributing
We love contributions!
- Fork the repo and create a feature branch
- Follow conventional commits (feat:, fix:, docs:, chore:)
- Run formatters before pushing:
  - pnpm format and composer normalize
- Add tests where it makes sense
- Open a PR with a clear description and screenshots for UI changes

See CONTRIBUTING.md for details. Good first issues are labeled â€śgood first issueâ€ť.

---

## Security
If you discover a security issue, please email security@quarkpayy.dev. Do not open public issues for vulnerabilities. Weâ€™ll acknowledge within 48 hours.

---

## License
MIT Â© Quarkpayy Contributors

---

## Acknowledgements
- Inspired by the Paymenter ecosystem and its community
- Vue, Laravel, Tailwind, and the OSS projects that make this possible
