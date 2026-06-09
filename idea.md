**Full Project Plan: PlacePulse AI**

### 1. Project Overview
**Name**: PlacePulse AI  
**Tagline**: One-click instant deep-dive location reports powered by AI.

**Goal**: Build a clean, fast, single-page Laravel application where users click **"Scan Location"** (auto-detect via browser geolocation) or enter a place manually → receive a beautiful, comprehensive AI-generated report.

**Key Constraints Honored**:
- Laravel 13 + Blade + Tailwind 4
- OpenAI GPT (latest available via my $50 credit – use `gpt-5.5`)
- No image/DALL·E generation
- One main flow, no chat

### 2. Core Features & Report Structure
**Trigger**: "Scan Location" button

**Input Options**:
1. **Auto Geolocation** (primary – browser API → reverse to city/place)
2. **Manual Search** (text input: city, neighborhood, landmark)

**Generated Report Sections** (all in one scrollable page):
- **Hero / Title** (AI-generated catchy title)
- **The Soul of the Place** – 300-400 word engaging narrative
- **Hidden History & Untold Stories** – 3-5 key moments with fresh angles
- **Must-Visit Spots Nearby** – 5-7 curated places (name + short desc + why visit)
- **Local Flavors & Experiences** – Food, culture, unique activities
- **Practical Tips** – Best time, etiquette, hidden gems, safety
- **Fun Facts & Trivia** – 4-6 bullet points

### 3. Tech Stack & Tools
- **Backend**: Laravel 13
- **Frontend**: Blade templates + Tailwind 4
- **AI**: OpenAI PHP SDK (`openai-php/laravel`)
- **Geolocation**: Browser Geolocation API + optional reverse geocoding (e.g., OpenStreetMap Nominatim – free, no key)
- **Styling**: Tailwind 4 with clean, modern travel-guide aesthetic (cards, gradients, readable typography)
- **DB**: sqlite
- **Deployment**: Render (Free Tier)

### 4. Detailed Implementation Plan

**Project Setup**
- `laravel new placepulse --pest` (or without testing)
- Install Tailwind 4 + Vite setup (Laravel 13 starter makes this easy)
- Install OpenAI package:
  ```bash
  composer require openai-php/laravel
  php artisan openai:install
  ```
- Add `OPENAI_API_KEY` to `.env`
- Set up basic route: `/` → main page

**Frontend UI + Geolocation**
- Design clean homepage with:
  - Big "Scan Location" button
  - Manual input field + "Generate Report" button
  - Loading spinner (Tailwind + Alpine.js or simple JS)
- Implement browser geolocation in JS.
- Create Blade layout with Tailwind: hero, form, result area (initially hidden)

**Backend Logic & OpenAI Integration**
- Create `OpenAIReportService.php`:
  - Take location string (city or "lat,lng")
  - Optional: Call free reverse geocoding for better context
  - Call OpenAI Chat Completions with **structured output** (JSON schema)
- Use strong system prompt (see below)
- Controller handles both auto and manual requests
- Return JSON → Blade renders the report

**Hour 150-180 mins: Polish & Report Rendering**
- Create beautiful report Blade component (Tailwind cards, sections, icons via Heroicons or Lucide)
- Add "Regenerate" button (new seed or slight prompt variation)
- Error handling & loading states
- Mobile responsiveness
- Write README.md
- Add shareable report PDF
- Basic rate limiting
- Dark mode toggle

### 6. OpenAI Integration Details (Critical for Judging)

**Model**: `gpt-5.5`

**Use Structured Outputs** (recommended by OpenAI) via JSON schema in the API call.

### 7. UI/UX with Tailwind 4
- Clean hero with gradient background
- Large primary button (Scan Location) with location icon
- Report: Card-based layout, good typography, generous whitespace
- Responsive (mobile-first)
- Smooth loading animation

### 8. Submission Assets
1. Project name & description
2. Live demo link (deploy early)
3. GitHub repo (public)
4. OpenAI Usage section (models, structured outputs, why GPT-5.5)
5. Problem & Impact write-up
6. Screenshots + short Loom video (1-2 min demo)
7. X/LinkedIn post draft

### 9. Potential Enhancements
- User accounts to save reports
- Caching reports (Redis)
- Export to PDF