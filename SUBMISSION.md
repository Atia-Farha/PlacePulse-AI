# PlacePulse AI — Codex Community Challenge Submission

## 1. Project Information

### Project name

**PlacePulse AI**

### Short project description

One-click AI location intelligence. Scan your coordinates or search any place to receive a structured cultural dossier — hidden history, must-visit spots, local flavors, practical travel tips, and fun facts — powered by OpenAI structured outputs and agentic development workflows.

### Team name

**Atia Farha** *(solo)*

### Repository

https://github.com/Atia-Farha/PlacePulse-AI

---

## 2. Project Demo

### Live demo link

**Render (recommended):** Deploy via Blueprint — see [README.md § Deploy on Render](./README.md#deploy-on-render-free-tier).

**[Add your Render URL here, e.g. https://placepulse-ai.onrender.com]**

**Local fallback** (under five minutes):

```bash
git clone https://github.com/Atia-Farha/PlacePulse-AI.git
cd PlacePulse-AI
composer setup
# Add OPENAI_API_KEY to .env
php artisan serve
# Open http://127.0.0.1:8000
```

Full instructions: [README.md](./README.md#running-locally)

### Recorded demo video

**[Add your Loom / YouTube link here]**

Suggested 90-second script:

1. Homepage overview (0:00–0:15)
2. Click **Scan Geolocation** → district + country detected → loading animation (0:15–0:35)
3. Scroll generated dossier: Soul, History, Must-Visit, Tips (0:35–0:60)
4. Export PDF + toggle dark mode (0:60–0:75)
5. Register → view saved history; mention OpenAI + AGENTS.md (0:75–0:90)

---

## 3. Source Code

**Public GitHub repository:**  
https://github.com/Atia-Farha/PlacePulse-AI

Key files for reviewers:

| File | Purpose |
|------|---------|
| `app/Services/OpenAIReportService.php` | OpenAI agent, system prompt, JSON schema |
| `app/Http/Controllers/ReportController.php` | Report API, reverse geocoding, PDF |
| `config/openai.php` | Model, token limits, reasoning effort |
| `AGENTS.md` | Runtime + design-time agent architecture |
| `skills.md` | Agent capabilities and schema documentation |
| `resources/js/app.js` | Geolocation scan and report UI |

---

## 4. OpenAI Usage Details

### Which OpenAI models, APIs, or platform features were used?

- **Model:** `gpt-5-mini` (OpenAI reasoning model)
- **API:** Chat Completions (`/v1/chat/completions`)
- **Feature:** Structured outputs via strict `json_schema` response format
- **Parameters:**
  - `max_completion_tokens: 8000`
  - `reasoning_effort: low`
- **SDK:** `openai-php/laravel`

No DALL·E, Assistants API, or fine-tuning — the product is entirely text intelligence with schema-constrained generation.

### How was OpenAI integrated into the solution?

1. **Input:** User provides a location via browser geolocation (reverse-geocoded to English district + country) or manual text search.
2. **Agent invocation:** `OpenAIReportService` sends a system prompt defining the **PlacePulse Intelligence Agent** persona (travel writer, cultural anthropologist, historian) plus the user's location.
3. **Structured output:** OpenAI returns a strict JSON object with eight required sections: `title`, `subtitle`, `soul`, `history`, `must_visit`, `local_flavors`, `practical_tips`, `fun_facts`.
4. **Validation & cache:** JSON is parsed and validated; results are stored in SQLite to avoid duplicate API calls.
5. **Delivery:** Laravel renders the dossier in a responsive Blade UI and supports PDF export via DomPDF.

### Why were these capabilities chosen?

| Choice | Reason |
|--------|--------|
| `gpt-5-mini` | Strong long-form synthesis at reasonable cost for hackathon-scale usage |
| Strict JSON schema | Guarantees parseable, UI-ready output every time — no regex on free-form markdown |
| `reasoning_effort: low` | Reasoning models spend tokens on internal thinking; lowering effort leaves budget for the full report |
| Higher token limit (8000) | Prevents empty responses when reasoning consumes the completion budget |
| System prompt persona | Produces vivid, non-generic travel writing with fresh historical angles |

### Agentic development (Codex challenge criteria)

| Artifact | Role |
|----------|------|
| `AGENTS.md` | Documents runtime Location Intelligence Agent architecture, Mermaid workflows, and configuration |
| `skills.md` | Defines geocoding, structured dossier synthesis, PDF layout, and UI skills |
| Cursor / Codex agents | Co-engineered the Laravel app using agentic pair programming patterns |

---

## 5. Problem & Impact

### What problem does the project solve?

Travel and local discovery content is scattered, generic, or shallow. Getting a rich, structured picture of a place — its history, culture, food, and practical advice — usually requires hours of research across multiple sources.

### Who benefits?

- **Travelers** exploring unfamiliar cities or districts
- **Students and researchers** needing quick cultural context
- **Remote workers** relocating or visiting new areas
- **Local communities** rediscovering their own region through AI-curated narratives

### What is the potential impact?

PlacePulse AI democratizes location intelligence: one click or one search produces a magazine-quality dossier that would be impractical to assemble manually. It is especially valuable for lesser-known districts where mainstream travel guides offer little depth.

Category fit: **Creative Applications**, **Education & Learning**, **Local Problem Solving**, **AI Agents**.

---

## 6. Social Post

Post on **X (Twitter)** or **LinkedIn** and include the link in your Devpost submission.

### LinkedIn draft

```
I built PlacePulse AI for the Codex Community Challenge.

One click → scan your location → get an AI-generated cultural dossier:
• Hidden history & untold stories
• Must-visit spots
• Local flavors & experiences
• Practical travel tips

Powered by OpenAI gpt-5-mini with strict JSON schema structured outputs.
Built with Laravel, agentic workflows (AGENTS.md + skills.md), and Codex.

No live deploy — run locally in 5 minutes or use Render Blueprint:
https://github.com/Atia-Farha/PlacePulse-AI#deploy-on-render-free-tier

[Add demo video link when ready]

#OpenAI #CodexCommunity #AIAgents #BuildInPublic #Laravel
```

### X (Twitter) draft

```
Built PlacePulse AI for the @OpenAI Codex Community Challenge 🌍

Scan your location → instant AI cultural dossier (history, food, tips, hidden gems).

OpenAI gpt-5-mini + strict JSON schema + AGENTS.md agentic workflow.

Run locally: https://github.com/Atia-Farha/PlacePulse-AI

#BuildInPublic #AIAgents
```

---

## 7. Screenshots (Optional)

Add these to your Devpost submission and/or a `docs/screenshots/` folder in the repo:

1. **Homepage** — hero, Scan Geolocation button, manual search
2. **Loading state** — animated analysis messages
3. **Report view** — title, soul section, history timeline
4. **Must-visit & tips** — card layout
5. **Dark mode** — toggled report view
6. **PDF export** — downloaded dossier preview
7. **History page** — saved reports (logged-in user)

---

## 8. Judging Criteria Alignment

### Creativity & Innovation (40%)

- Original concept: not a chatbot — a one-click **location intelligence dossier**
- Fresh AI angles on history and culture, not Wikipedia summaries
- Geolocation → district-level detection → instant deep-dive report

### Effective Use of Codex & OpenAI Platform (30%)

- Core product depends on OpenAI structured outputs
- Documented agent architecture in `AGENTS.md` and `skills.md`
- Reasoning model tuning (`reasoning_effort`, token budget) shows platform-aware engineering

### Technical Execution (20%)

- Full-stack Laravel app: auth, caching, PDF, responsive UI, dark mode
- Reliable JSON schema pipeline with error handling and logging
- English geocoding with district + country formatting

### Real-World Impact (10%)

- Practical value for travelers, students, and local discovery
- Works globally; tuned for accurate district-level auto-detection

### Devpost-specific criteria

| Criterion | How PlacePulse AI addresses it |
|-----------|-------------------------------|
| **AI-Native Thinking** | Entire report is AI-generated structured intelligence impossible with static templates alone |
| **Agent Design & Workflow** | Runtime agent persona + schema + `AGENTS.md` / `skills.md` design-time documentation |
| **Creativity & Originality** | Magazine-style dossier UX, not generic Q&A |
| **Practical Impact** | Solves real research friction for place discovery |

---

## 9. Contact & Support

Challenge contact: mitulshahriyar@gmail.com

---

## 10. Checklist Before Submitting

- [ ] `OPENAI_API_KEY` removed from any committed files (use `.env` only)
- [ ] README.md reviewed — local setup instructions verified
- [ ] Recorded demo video uploaded (Loom/YouTube) — link added above
- [ ] 3–7 screenshots captured and attached to Devpost
- [ ] Social post published on LinkedIn or X — link added to Devpost
- [ ] GitHub repository is public and up to date
- [ ] Test fresh clone + `composer setup` + `php artisan serve` on a clean machine
