# PlacePulse AI

**One-click instant deep-dive location reports powered by OpenAI.**

PlacePulse AI turns any place into a structured cultural intelligence dossier. Scan your coordinates or search manually — the Location Intelligence Agent synthesizes history, must-visit spots, local flavors, practical tips, and fun facts into a polished, scrollable report you can save and export as PDF.

Built for the **Codex Community Challenge** with agentic development patterns (`AGENTS.md`, `skills.md`) and meaningful OpenAI platform integration.

---

## Demo

There is no public deployment for this submission. Judges and reviewers can run the app locally using the steps below (typically under five minutes with an OpenAI API key).

For a quick walkthrough without setup, see the **recorded demo** linked in [SUBMISSION.md](./SUBMISSION.md).

**Local URL after setup:** [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Features

| Feature | Description |
|---------|-------------|
| **Scan Geolocation** | Browser GPS → reverse geocode (English, district + country) → instant report |
| **Manual search** | Enter any city, district, landmark, or region |
| **AI location dossier** | 8 structured sections: title, soul narrative, history, must-visit, local flavors, tips, fun facts |
| **Structured JSON outputs** | Strict OpenAI `json_schema` — every field validated before render |
| **Report caching** | SQLite-backed cache avoids repeat API calls for the same query |
| **Regenerate** | Force a fresh AI analysis on demand |
| **PDF export** | Download a formatted intelligence dossier |
| **User accounts** | Register/login to persist report history |
| **Dark mode** | System-aware toggle with local persistence |
| **Responsive UI** | Tailwind CSS 4, mobile-first layout |

---

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3+
- **Frontend:** Blade, Tailwind CSS 4, Vite
- **AI:** OpenAI Chat Completions (`gpt-5-mini`) via `openai-php/laravel`
- **Geocoding:** OpenStreetMap Nominatim (no API key required)
- **Database:** SQLite
- **PDF:** DomPDF

---

## Requirements

- PHP **8.3+** with extensions: `sqlite3`, `pdo_sqlite`, `mbstring`, `openssl`, `curl`
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) 18+ and npm
- An [OpenAI API key](https://platform.openai.com/api-keys)

---

## Running Locally

### 1. Clone the repository

```bash
git clone https://github.com/Atia-Farha/PlacePulse-AI.git
cd PlacePulse-AI
```

### 2. One-command setup

```bash
composer setup
```

This installs PHP dependencies, creates `.env`, generates an app key, runs migrations, installs npm packages, and builds frontend assets.

### 3. Configure environment

Open `.env` and set your OpenAI credentials:

```env
APP_NAME="PlacePulse AI"
OPENAI_API_KEY=sk-your-key-here
OPENAI_MODEL=gpt-5-mini
OPENAI_MAX_COMPLETION_TOKENS=8000
OPENAI_REASONING_EFFORT=low
```

Ensure SQLite is ready (usually created automatically):

```bash
touch database/database.sqlite
php artisan migrate
```

### 4. Start the application

**Option A — development (hot reload for CSS/JS):**

```bash
composer dev
```

Starts the Laravel server, Vite, queue worker, and log tail concurrently.

**Option B — simple server (after `npm run build`):**

```bash
php artisan serve
```

### 5. Open in browser

Visit **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

1. Click **Scan Geolocation** (allow location permission), or type a place and submit.
2. Wait ~30–60 seconds while the Location Intelligence Agent generates the dossier.
3. Scroll the report, export PDF, or register to save history.

---

## Manual setup (alternative)

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run build
php artisan serve
```

---

## OpenAI Integration

PlacePulse AI uses OpenAI as the **core intelligence layer** — not as a bolt-on chat widget.

### Model & API

| Setting | Value |
|---------|-------|
| Model | `gpt-5-mini` |
| Endpoint | Chat Completions |
| Response format | Strict `json_schema` (structured outputs) |
| Max completion tokens | `8000` |
| Reasoning effort | `low` |

### Why structured outputs?

Reports must render reliably in Blade templates and PDF exports. A strict JSON schema guarantees every section (`title`, `soul`, `history`, `must_visit`, etc.) is present and typed correctly — no fragile markdown parsing.

### Why reasoning effort tuning?

`gpt-5-mini` is a reasoning model. Internal reasoning tokens count against the completion budget. With the default 4000-token limit, the model could exhaust its budget on reasoning and return **empty content**. Setting `reasoning_effort=low` and `max_completion_tokens=8000` ensures the full dossier is generated.

### Architecture

```
User → ReportController → OpenAIReportService → OpenAI API
                              ↓
                     JSON schema validation
                              ↓
                     SQLite cache → Blade UI / PDF
```

See [AGENTS.md](./AGENTS.md) for the runtime agent persona, workflow diagrams, and configuration reference.  
See [skills.md](./skills.md) for geocoding, schema synthesis, and design-time agent capabilities.

---

## Project Structure

```
app/
├── Http/Controllers/
│   ├── ReportController.php      # Report generation, geocoding, PDF
│   ├── AuthController.php        # Login / register
│   └── HistoryController.php     # Saved reports
├── Services/
│   └── OpenAIReportService.php   # OpenAI agent + JSON schema
resources/
├── js/app.js                     # Geolocation, report UI, API calls
├── views/                        # Blade templates
config/openai.php                 # Model, tokens, reasoning effort
AGENTS.md                         # Agent architecture (Codex challenge)
skills.md                         # Agent capabilities (Codex challenge)
SUBMISSION.md                     # Devpost submission copy
```

---

## Troubleshooting

| Issue | Fix |
|-------|-----|
| `could not find driver` (SQLite) | Install PHP SQLite: `sudo apt install php-sqlite3` |
| `Failed to generate report` | Check `OPENAI_API_KEY` in `.env`, run `php artisan config:clear` |
| Empty AI response / JSON error | Ensure `OPENAI_MAX_COMPLETION_TOKENS=8000` and `OPENAI_REASONING_EFFORT=low` |
| Geolocation blocked | Use HTTPS or `localhost`; grant browser location permission |
| Assets not loading | Run `npm run build` or use `composer dev` for Vite |

Logs: `storage/logs/laravel.log`

---

## Challenge Submission

Full Devpost fields, OpenAI usage write-up, problem/impact statement, and social post drafts are in **[SUBMISSION.md](./SUBMISSION.md)**.

---

## License

MIT
