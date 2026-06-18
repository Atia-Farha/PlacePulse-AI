# PlacePulse AI — Agent Capabilities & Skills (skills.md)

This document details the specific capabilities, tools, and skills developed for both the design-time development agents and the runtime intelligence agents in the PlacePulse AI ecosystem.

---

## 1. Runtime Agent Skills & Capabilities

The **Location Intelligence Agent** possesses several key capabilities designed to extract, refine, and structure geographical insights:

### A. Geolocation & Reverse Geocoding Skill
- **Description**: Translates latitude and longitude coordinates obtained via the browser's Geolocation API into a recognizable address or place name.
- **Integration**: The front-end captures browser coordinates via `navigator.geolocation.getCurrentPosition()` and sends them to `POST /api/reverse-geocode`, which calls OpenStreetMap Nominatim API with English language preference and proper User-Agent headers.
- **Output**: Returns district + country format (e.g., "Brooklyn, United States") for LLM consumption.

### B. Structured Location Dossier Synthesis (JSON Schema)
- **Description**: Compiles complex geographical and cultural intelligence reports matching a strict JSON schema.
- **Constraint**: Must match the following JSON Schema structure exactly:

```json
{
  "type": "object",
  "properties": {
    "title": { "type": "string", "description": "A catchy, creative title for this location report" },
    "subtitle": { "type": "string", "description": "A short poetic subtitle or tagline (max 15 words)" },
    "soul": { "type": "string", "description": "The Soul of the Place: a 300-400 word engaging narrative" },
    "history": {
      "type": "array",
      "description": "3-5 hidden history moments with fresh angles",
      "items": {
        "type": "object",
        "properties": {
          "year": { "type": "string", "description": "Year or era of the event" },
          "title": { "type": "string", "description": "Short title of the historical moment" },
          "description": { "type": "string", "description": "Engaging 2-3 sentence description with a fresh angle" }
        },
        "required": ["year", "title", "description"],
        "additionalProperties": false
      }
    },
    "must_visit": {
      "type": "array",
      "description": "5-7 curated must-visit spots nearby",
      "items": {
        "type": "object",
        "properties": {
          "name": { "type": "string", "description": "Name of the place" },
          "category": { "type": "string", "description": "Category like Museum, Park, Market, etc." },
          "description": { "type": "string", "description": "Short vivid description (1-2 sentences)" },
          "why_visit": { "type": "string", "description": "A compelling reason to visit (1 sentence)" }
        },
        "required": ["name", "category", "description", "why_visit"],
        "additionalProperties": false
      }
    },
    "local_flavors": {
      "type": "array",
      "description": "4-6 local food, culture, and unique experience items",
      "items": {
        "type": "object",
        "properties": {
          "title": { "type": "string", "description": "Name of the experience or food" },
          "type": { "type": "string", "description": "Category: Food, Culture, Activity, or Nightlife" },
          "description": { "type": "string", "description": "Vivid 1-2 sentence description" }
        },
        "required": ["title", "type", "description"],
        "additionalProperties": false
      }
    },
    "practical_tips": {
      "type": "array",
      "description": "5-7 practical travel tips",
      "items": {
        "type": "object",
        "properties": {
          "category": { "type": "string", "description": "Category: timing, etiquette, budget, safety, transport, other" },
          "tip": { "type": "string", "description": "The practical tip (1-2 sentences)" }
        },
        "required": ["category", "tip"],
        "additionalProperties": false
      }
    },
    "fun_facts": {
      "type": "array",
      "description": "4-6 fun facts and trivia about this place",
      "items": {
        "type": "string"
      }
    }
  },
  "required": [
    "title", "subtitle", "soul", "history", "must_visit",
    "local_flavors", "practical_tips", "fun_facts"
  ],
  "additionalProperties": false
}
```

### C. Report Caching & Retrieval Skill
- **Description**: Persists generated reports to SQLite database with deduplication logic.
- **Logic**: Cached reports are reused for normalized queries. Query strings are normalized using `Str::lower()` and `Str::squish()` to ensure consistent matching. The `fresh` parameter bypasses cache when `true`. Authenticated users automatically receive their own copy of public reports for personal history tracking.

### D. PDF Dossier Export Skill
- **Description**: Generates downloadable, formatted PDF reports.
- **Implementation**: Uses DomPDF with table-based layouts (avoiding flexbox/grid limitations) to produce print-ready dossiers.

---

## 2. Design-Time Agent Skills & Capabilities

The developer agent (**Codex**) utilized a specialized set of engineering skills to implement and refine the application:

### A. Layout & UI Polish Skill
- Styled custom layouts using **Tailwind CSS 4** with `@theme` directive and `@custom-variant` for dark mode.
- Implemented premium responsive design and dark/light mode toggles with localStorage persistence.
- Extended primary color palette to include `primary-950` for JavaScript usage.
- Added accessibility attributes (`aria-label`, `role="alert"`) to interactive elements.

### B. DomPDF Layout Resolution Skill
- **Description**: Resolved DomPDF's flexbox/grid layout limitations during export-pdf generation.
- **Implementation**: Reconstructed dynamic PDF rows and grid-like columns using clean, standard HTML tables with `array_chunk()` to create two-column layouts for `must_visit` and `local_flavors` sections.
- **File**: Created `resources/views/pdf/report.blade.php` with inline CSS optimized for PDF rendering.

### C. Build & Asset Optimization Skill
- **Description**: Handled automatic bundling and compilation of frontend styles and scripts using Laravel Vite integration.
- **Implementation**: Configured Tailwind 4 with custom color tokens and dark mode variants via `@theme` and `@custom-variant` directives. Integrated the Inter font via `bunny` loader in `vite.config.js`.

### D. Report Ownership & Security Skill
- Implemented user ownership checks for PDF export and history retrieval.
- Authenticated users can only export their own reports or public reports.
- Protected history deletion with authenticated route middleware.