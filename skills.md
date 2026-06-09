# PlacePulse AI — Agent Capabilities & Skills (skills.md)

This document details the specific capabilities, tools, and skills developed for both the design-time development agents and the runtime intelligence agents in the PlacePulse AI ecosystem.

---

## 1. Runtime Agent Skills & Capabilities

The **Location Intelligence Agent** possesses several key capabilities designed to extract, refine, and structure geographical insights:

### A. Geolocation & Reverse Geocoding Skill
- **Description**: Translates latitude and longitude coordinates obtained via the browser's Geolocation API into a recognizable address or place name.
- **Integration**: The front-end captures the browser's coordinates and passes them to the backend controller, ensuring the LLM receives precise geographical context.

### B. Structured Location Dossier Synthesis (JSON Schema)
- **Description**: Compiles complex geographical and cultural intelligence reports matching a strict JSON schema.
- **Constraint**: Must match the following JSON Schema structure exactly:

```json
{
  "type": "object",
  "properties": {
    "title": { "type": "string" },
    "subtitle": { "type": "string" },
    "soul": { "type": "string" },
    "history": {
      "type": "array",
      "items": {
        "type": "object",
        "properties": {
          "year": { "type": "string" },
          "title": { "type": "string" },
          "description": { "type": "string" }
        },
        "required": ["year", "title", "description"]
      }
    },
    "must_visit": {
      "type": "array",
      "items": {
        "type": "object",
        "properties": {
          "name": { "type": "string" },
          "category": { "type": "string" },
          "description": { "type": "string" },
          "why_visit": { "type": "string" }
        },
        "required": ["name", "category", "description", "why_visit"]
      }
    },
    "local_flavors": {
      "type": "array",
      "items": {
        "type": "object",
        "properties": {
          "title": { "type": "string" },
          "type": { "type": "string" },
          "description": { "type": "string" }
        },
        "required": ["title", "type", "description"]
      }
    },
    "practical_tips": {
      "type": "array",
      "items": {
        "type": "object",
        "properties": {
          "category": { "type": "string" },
          "tip": { "type": "string" }
        },
        "required": ["category", "tip"]
      }
    },
    "fun_facts": {
      "type": "array",
      "items": { "type": "string" }
    }
  },
  "required": [
    "title", "subtitle", "soul", "history", "must_visit", 
    "local_flavors", "practical_tips", "fun_facts"
  ]
}
```

---

## 2. Design-Time Agent Skills & Capabilities

The developer agent (**Antigravity**) utilized a specialized set of engineering skills to implement and refine the application:

### A. Layout & UI Polish Skill
- Styled custom layouts using **Tailwind CSS**.
- Implemented premium responsive design and dark/light mode toggles.
- Standardized text coloring to use the `text-primary-600` utility consistently across dark/light mode switches.

### B. DomPDF Layout Resolution Skill
- Resolved DomPDF's flexbox/grid layout limitations during export-pdf generation.
- Reconstructed dynamic PDF rows and grid-like columns using clean, standard HTML tables.

### C. Build & Asset Optimization Skill
- Handled automatic bundling and compilation of frontend styles and scripts using Laravel Vite integration.
