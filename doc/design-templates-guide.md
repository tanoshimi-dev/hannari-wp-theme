# Creating Original Design Templates & Styles

A practical guide to designing and styling your WordPress theme from scratch.

---

## Table of Contents

1. [Design System Foundation](#design-system-foundation)
2. [CSS Architecture](#css-architecture)
3. [Creating Page Templates](#creating-page-templates)
4. [Component-Based Design](#component-based-design)
5. [Layout Patterns](#layout-patterns)
6. [Typography System](#typography-system)
7. [Color Schemes](#color-schemes)
8. [Responsive Design](#responsive-design)
9. [Animation & Interaction](#animation--interaction)
10. [Template Examples](#template-examples)

---

## Design System Foundation

### CSS Custom Properties (Variables)

Create a design token system in `style.css` or a dedicated `_variables.css`:

```css
:root {
    /* Colors */
    --color-primary: #1a1a1a;
    --color-secondary: #666666;
    --color-accent: #0066cc;
    --color-background: #ffffff;
    --color-surface: #f5f5f5;
    --color-border: #e0e0e0;
    --color-text: #1a1a1a;
    --color-text-muted: #666666;
    --color-success: #22c55e;
    --color-warning: #f59e0b;
    --color-error: #ef4444;

    /* Typography */
    --font-sans: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    --font-serif: Georgia, "Times New Roman", serif;
    --font-mono: SFMono-Regular, Menlo, Monaco, monospace;

    --font-size-xs: 0.75rem;    /* 12px */
    --font-size-sm: 0.875rem;   /* 14px */
    --font-size-base: 1rem;     /* 16px */
    --font-size-lg: 1.125rem;   /* 18px */
    --font-size-xl: 1.25rem;    /* 20px */
    --font-size-2xl: 1.5rem;    /* 24px */
    --font-size-3xl: 1.875rem;  /* 30px */
    --font-size-4xl: 2.25rem;   /* 36px */
    --font-size-5xl: 3rem;      /* 48px */

    --line-height-tight: 1.25;
    --line-height-normal: 1.6;
    --line-height-relaxed: 1.75;

    --font-weight-normal: 400;
    --font-weight-medium: 500;
    --font-weight-semibold: 600;
    --font-weight-bold: 700;

    /* Spacing */
    --space-1: 0.25rem;   /* 4px */
    --space-2: 0.5rem;    /* 8px */
    --space-3: 0.75rem;   /* 12px */
    --space-4: 1rem;      /* 16px */
    --space-5: 1.25rem;   /* 20px */
    --space-6: 1.5rem;    /* 24px */
    --space-8: 2rem;      /* 32px */
    --space-10: 2.5rem;   /* 40px */
    --space-12: 3rem;     /* 48px */
    --space-16: 4rem;     /* 64px */
    --space-20: 5rem;     /* 80px */

    /* Layout */
    --container-sm: 640px;
    --container-md: 768px;
    --container-lg: 1024px;
    --container-xl: 1200px;
    --container-content: 720px;

    /* Borders */
    --radius-sm: 0.25rem;
    --radius-md: 0.5rem;
    --radius-lg: 1rem;
    --radius-full: 9999px;
    --border-width: 1px;

    /* Shadows */
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.15);

    /* Transitions */
    --transition-fast: 150ms ease;
    --transition-normal: 250ms ease;
    --transition-slow: 350ms ease;

    /* Z-index */
    --z-dropdown: 100;
    --z-sticky: 200;
    --z-fixed: 300;
    --z-modal: 400;
    --z-tooltip: 500;
}

/* Dark Mode Variables */
@media (prefers-color-scheme: dark) {
    :root {
        --color-primary: #ffffff;
        --color-secondary: #a0a0a0;
        --color-background: #121212;
        --color-surface: #1e1e1e;
        --color-border: #333333;
        --color-text: #ffffff;
        --color-text-muted: #a0a0a0;
    }
}

/* Manual Dark Mode Class */
.dark-mode {
    --color-primary: #ffffff;
    --color-secondary: #a0a0a0;
    --color-background: #121212;
    --color-surface: #1e1e1e;
    --color-border: #333333;
    --color-text: #ffffff;
    --color-text-muted: #a0a0a0;
}
```

---

## CSS Architecture

### File Organization

```
theme/assets/css/
├── style.css              # Main entry (imports or all styles)
├── base/
│   ├── _reset.css         # CSS reset/normalize
│   ├── _variables.css     # Design tokens
│   └── _typography.css    # Base typography
├── components/
│   ├── _buttons.css
│   ├── _cards.css
│   ├── _forms.css
│   ├── _navigation.css
│   └── _widgets.css
├── layouts/
│   ├── _header.css
│   ├── _footer.css
│   ├── _sidebar.css
│   └── _grid.css
├── templates/
│   ├── _home.css
│   ├── _single.css
│   ├── _archive.css
│   └── _page.css
└── utilities/
    └── _helpers.css
```

### Using CSS Imports

```css
/* style.css - Import all partials */
@import url('assets/css/base/_reset.css');
@import url('assets/css/base/_variables.css');
@import url('assets/css/base/_typography.css');
@import url('assets/css/components/_buttons.css');
@import url('assets/css/components/_cards.css');
/* ... more imports */
```

### Alternative: Single File Sections

```css
/* ========================================
   1. Variables & Reset
   ======================================== */

/* ========================================
   2. Base Typography
   ======================================== */

/* ========================================
   3. Layout
   ======================================== */

/* ========================================
   4. Components
   ======================================== */

/* ========================================
   5. Templates
   ======================================== */

/* ========================================
   6. Utilities
   ======================================== */
```

---

## Creating Page Templates

### Template Structure

```php
<?php
/**
 * Template Name: Landing Page
 * Template Post Type: page
 *
 * @package Hannari
 */

get_header( 'landing' ); // Uses header-landing.php if exists
?>

<main id="primary" class="landing-page">

    <?php while ( have_posts() ) : the_post(); ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero__container">
            <h1 class="hero__title"><?php the_title(); ?></h1>
            <?php if ( has_excerpt() ) : ?>
                <p class="hero__subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>
            <div class="hero__cta">
                <a href="#contact" class="btn btn--primary">Get Started</a>
                <a href="#features" class="btn btn--outline">Learn More</a>
            </div>
        </div>
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="hero__image">
                <?php the_post_thumbnail( 'full' ); ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Content Sections -->
    <div class="page-content">
        <?php the_content(); ?>
    </div>

    <?php endwhile; ?>

</main>

<?php
get_footer( 'landing' );
```

### Custom Header for Template

```php
<?php
// header-landing.php - Minimal header for landing pages

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'landing' ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site site--landing">
    <header class="site-header site-header--transparent">
        <div class="header__container">
            <div class="site-branding">
                <?php the_custom_logo(); ?>
            </div>
            <nav class="header__nav">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav-list nav-list--horizontal',
                ) );
                ?>
            </nav>
        </div>
    </header>
```

### Template Styles

```css
/* templates/_landing.css */

/* Landing Page Layout */
.landing-page {
    --section-spacing: var(--space-20);
}

/* Hero Section */
.hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-12);
    align-items: center;
    min-height: 80vh;
    padding: var(--space-16) var(--space-8);
    max-width: var(--container-xl);
    margin: 0 auto;
}

.hero__title {
    font-size: var(--font-size-5xl);
    font-weight: var(--font-weight-bold);
    line-height: var(--line-height-tight);
    margin-bottom: var(--space-6);
}

.hero__subtitle {
    font-size: var(--font-size-xl);
    color: var(--color-text-muted);
    margin-bottom: var(--space-8);
}

.hero__cta {
    display: flex;
    gap: var(--space-4);
    flex-wrap: wrap;
}

.hero__image img {
    width: 100%;
    height: auto;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
}

/* Transparent Header */
.site-header--transparent {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background: transparent;
    z-index: var(--z-fixed);
}

/* Responsive */
@media (max-width: 768px) {
    .hero {
        grid-template-columns: 1fr;
        text-align: center;
        min-height: auto;
        padding: var(--space-12) var(--space-4);
    }

    .hero__title {
        font-size: var(--font-size-3xl);
    }

    .hero__cta {
        justify-content: center;
    }

    .hero__image {
        order: -1;
    }
}
```

---

## Component-Based Design

### Button Component

```css
/* components/_buttons.css */

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-6);
    font-family: inherit;
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-medium);
    line-height: 1;
    text-decoration: none;
    border: var(--border-width) solid transparent;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.btn:focus {
    outline: 2px solid var(--color-accent);
    outline-offset: 2px;
}

/* Variants */
.btn--primary {
    background-color: var(--color-primary);
    color: var(--color-background);
    border-color: var(--color-primary);
}

.btn--primary:hover {
    background-color: var(--color-secondary);
    border-color: var(--color-secondary);
}

.btn--secondary {
    background-color: var(--color-surface);
    color: var(--color-text);
    border-color: var(--color-border);
}

.btn--secondary:hover {
    background-color: var(--color-border);
}

.btn--outline {
    background-color: transparent;
    color: var(--color-primary);
    border-color: var(--color-primary);
}

.btn--outline:hover {
    background-color: var(--color-primary);
    color: var(--color-background);
}

.btn--ghost {
    background-color: transparent;
    color: var(--color-text);
    border-color: transparent;
}

.btn--ghost:hover {
    background-color: var(--color-surface);
}

/* Sizes */
.btn--sm {
    padding: var(--space-2) var(--space-4);
    font-size: var(--font-size-sm);
}

.btn--lg {
    padding: var(--space-4) var(--space-8);
    font-size: var(--font-size-lg);
}

.btn--full {
    width: 100%;
}

/* States */
.btn:disabled,
.btn--disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

/* Icon button */
.btn--icon {
    padding: var(--space-3);
}

.btn__icon {
    width: 1.25em;
    height: 1.25em;
}
```

### Card Component

```css
/* components/_cards.css */

.card {
    display: flex;
    flex-direction: column;
    background-color: var(--color-background);
    border: var(--border-width) solid var(--color-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: box-shadow var(--transition-normal);
}

.card:hover {
    box-shadow: var(--shadow-lg);
}

.card__image {
    aspect-ratio: 16 / 9;
    overflow: hidden;
}

.card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.card:hover .card__image img {
    transform: scale(1.05);
}

.card__body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: var(--space-6);
}

.card__meta {
    font-size: var(--font-size-sm);
    color: var(--color-text-muted);
    margin-bottom: var(--space-2);
}

.card__title {
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-3);
}

.card__title a {
    color: inherit;
    text-decoration: none;
}

.card__title a:hover {
    color: var(--color-accent);
}

.card__excerpt {
    flex: 1;
    color: var(--color-text-muted);
    margin-bottom: var(--space-4);
}

.card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: var(--space-4);
    border-top: var(--border-width) solid var(--color-border);
}

/* Card Variants */
.card--horizontal {
    flex-direction: row;
}

.card--horizontal .card__image {
    width: 40%;
    aspect-ratio: auto;
}

.card--horizontal .card__body {
    width: 60%;
}

.card--featured {
    grid-column: span 2;
}

.card--featured .card__image {
    aspect-ratio: 21 / 9;
}

/* Card Grid */
.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: var(--space-8);
}

@media (max-width: 768px) {
    .card--horizontal {
        flex-direction: column;
    }

    .card--horizontal .card__image,
    .card--horizontal .card__body {
        width: 100%;
    }

    .card--featured {
        grid-column: span 1;
    }
}
```

### Form Components

```css
/* components/_forms.css */

.form-group {
    margin-bottom: var(--space-6);
}

.form-label {
    display: block;
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    margin-bottom: var(--space-2);
    color: var(--color-text);
}

.form-label--required::after {
    content: " *";
    color: var(--color-error);
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: var(--space-3) var(--space-4);
    font-family: inherit;
    font-size: var(--font-size-base);
    color: var(--color-text);
    background-color: var(--color-background);
    border: var(--border-width) solid var(--color-border);
    border-radius: var(--radius-md);
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: var(--color-accent);
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.15);
}

.form-input::placeholder {
    color: var(--color-text-muted);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
}

.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23666' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right var(--space-4) center;
    padding-right: var(--space-10);
}

/* Input States */
.form-input--error {
    border-color: var(--color-error);
}

.form-input--success {
    border-color: var(--color-success);
}

.form-hint {
    font-size: var(--font-size-sm);
    color: var(--color-text-muted);
    margin-top: var(--space-2);
}

.form-error {
    font-size: var(--font-size-sm);
    color: var(--color-error);
    margin-top: var(--space-2);
}

/* Checkbox & Radio */
.form-check {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
}

.form-check-input {
    width: 1.25rem;
    height: 1.25rem;
    margin-top: 0.125rem;
    accent-color: var(--color-accent);
}

.form-check-label {
    font-size: var(--font-size-base);
    cursor: pointer;
}

/* Input Group */
.input-group {
    display: flex;
}

.input-group .form-input {
    flex: 1;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
```

---

## Layout Patterns

### Container System

```css
/* layouts/_grid.css */

.container {
    width: 100%;
    max-width: var(--container-xl);
    margin-left: auto;
    margin-right: auto;
    padding-left: var(--space-4);
    padding-right: var(--space-4);
}

.container--sm { max-width: var(--container-sm); }
.container--md { max-width: var(--container-md); }
.container--lg { max-width: var(--container-lg); }
.container--content { max-width: var(--container-content); }
.container--fluid { max-width: none; }

@media (min-width: 768px) {
    .container {
        padding-left: var(--space-8);
        padding-right: var(--space-8);
    }
}
```

### Grid System

```css
/* Flexible Grid */
.grid {
    display: grid;
    gap: var(--space-6);
}

.grid--2 { grid-template-columns: repeat(2, 1fr); }
.grid--3 { grid-template-columns: repeat(3, 1fr); }
.grid--4 { grid-template-columns: repeat(4, 1fr); }

.grid--auto {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
}

/* Responsive Grid */
@media (max-width: 1024px) {
    .grid--4 { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .grid--2,
    .grid--3,
    .grid--4 {
        grid-template-columns: 1fr;
    }
}

/* Blog Layout: Content + Sidebar */
.layout-sidebar {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: var(--space-12);
}

.layout-sidebar--left {
    grid-template-columns: 300px 1fr;
}

@media (max-width: 1024px) {
    .layout-sidebar,
    .layout-sidebar--left {
        grid-template-columns: 1fr;
    }

    .layout-sidebar .sidebar {
        order: 2;
    }
}

/* Masonry-like Grid */
.masonry {
    columns: 3;
    column-gap: var(--space-6);
}

.masonry > * {
    break-inside: avoid;
    margin-bottom: var(--space-6);
}

@media (max-width: 1024px) {
    .masonry { columns: 2; }
}

@media (max-width: 640px) {
    .masonry { columns: 1; }
}
```

### Section Spacing

```css
/* Section Layouts */
.section {
    padding-top: var(--space-16);
    padding-bottom: var(--space-16);
}

.section--sm {
    padding-top: var(--space-10);
    padding-bottom: var(--space-10);
}

.section--lg {
    padding-top: var(--space-20);
    padding-bottom: var(--space-20);
}

.section--dark {
    background-color: var(--color-primary);
    color: var(--color-background);
}

.section--gray {
    background-color: var(--color-surface);
}

.section__header {
    text-align: center;
    max-width: var(--container-md);
    margin: 0 auto var(--space-12);
}

.section__title {
    font-size: var(--font-size-3xl);
    font-weight: var(--font-weight-bold);
    margin-bottom: var(--space-4);
}

.section__subtitle {
    font-size: var(--font-size-lg);
    color: var(--color-text-muted);
}
```

---

## Typography System

```css
/* base/_typography.css */

/* Base */
body {
    font-family: var(--font-sans);
    font-size: var(--font-size-base);
    line-height: var(--line-height-normal);
    color: var(--color-text);
}

/* Headings */
h1, h2, h3, h4, h5, h6,
.h1, .h2, .h3, .h4, .h5, .h6 {
    font-weight: var(--font-weight-bold);
    line-height: var(--line-height-tight);
    color: var(--color-primary);
    margin-top: 0;
    margin-bottom: var(--space-4);
}

h1, .h1 { font-size: var(--font-size-4xl); }
h2, .h2 { font-size: var(--font-size-3xl); }
h3, .h3 { font-size: var(--font-size-2xl); }
h4, .h4 { font-size: var(--font-size-xl); }
h5, .h5 { font-size: var(--font-size-lg); }
h6, .h6 { font-size: var(--font-size-base); }

/* Display Headings (Extra Large) */
.display-1 { font-size: 5rem; }
.display-2 { font-size: 4rem; }
.display-3 { font-size: 3.5rem; }

/* Paragraphs */
p {
    margin-top: 0;
    margin-bottom: var(--space-4);
}

.lead {
    font-size: var(--font-size-xl);
    line-height: var(--line-height-relaxed);
    color: var(--color-text-muted);
}

.small, small {
    font-size: var(--font-size-sm);
}

/* Links */
a {
    color: var(--color-accent);
    text-decoration: underline;
    text-underline-offset: 2px;
    transition: color var(--transition-fast);
}

a:hover {
    color: var(--color-primary);
}

/* Lists */
ul, ol {
    margin: 0 0 var(--space-4);
    padding-left: var(--space-6);
}

li {
    margin-bottom: var(--space-2);
}

/* Prose (Article Content) */
.prose {
    max-width: var(--container-content);
}

.prose h2 {
    margin-top: var(--space-12);
}

.prose h3 {
    margin-top: var(--space-10);
}

.prose p,
.prose ul,
.prose ol {
    margin-bottom: var(--space-6);
}

.prose img {
    border-radius: var(--radius-lg);
    margin: var(--space-8) 0;
}

.prose blockquote {
    border-left: 4px solid var(--color-accent);
    padding-left: var(--space-6);
    margin: var(--space-8) 0;
    font-style: italic;
    color: var(--color-text-muted);
}

.prose pre {
    background-color: var(--color-surface);
    padding: var(--space-6);
    border-radius: var(--radius-md);
    overflow-x: auto;
    margin: var(--space-6) 0;
}

.prose code {
    font-family: var(--font-mono);
    font-size: 0.9em;
    background-color: var(--color-surface);
    padding: 0.2em 0.4em;
    border-radius: var(--radius-sm);
}

.prose pre code {
    background: none;
    padding: 0;
}

/* Text Utilities */
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }

.text-muted { color: var(--color-text-muted); }
.text-accent { color: var(--color-accent); }

.font-normal { font-weight: var(--font-weight-normal); }
.font-medium { font-weight: var(--font-weight-medium); }
.font-semibold { font-weight: var(--font-weight-semibold); }
.font-bold { font-weight: var(--font-weight-bold); }

.uppercase { text-transform: uppercase; letter-spacing: 0.05em; }
.capitalize { text-transform: capitalize; }

.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
```

---

## Color Schemes

### Theme Variations

```css
/* Light Theme (Default) */
:root {
    --color-scheme: light;
    color-scheme: light;
}

/* Dark Theme */
.theme-dark,
[data-theme="dark"] {
    --color-scheme: dark;
    color-scheme: dark;

    --color-primary: #ffffff;
    --color-secondary: #a0a0a0;
    --color-background: #0f0f0f;
    --color-surface: #1a1a1a;
    --color-border: #2a2a2a;
    --color-text: #e5e5e5;
    --color-text-muted: #888888;
}

/* Accent Color Variations */
.theme-blue {
    --color-accent: #0066cc;
}

.theme-green {
    --color-accent: #059669;
}

.theme-purple {
    --color-accent: #7c3aed;
}

.theme-orange {
    --color-accent: #ea580c;
}

/* Minimal Monochrome */
.theme-mono {
    --color-accent: var(--color-primary);
}
```

### Theme Switcher JavaScript

```javascript
// assets/js/theme-switcher.js

(function() {
    'use strict';

    const STORAGE_KEY = 'hannari-theme';
    const root = document.documentElement;

    // Get saved theme or system preference
    function getPreferredTheme() {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
            return saved;
        }
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // Apply theme
    function setTheme(theme) {
        root.setAttribute('data-theme', theme);
        localStorage.setItem(STORAGE_KEY, theme);
    }

    // Initialize
    setTheme(getPreferredTheme());

    // Toggle function (attach to button)
    window.toggleTheme = function() {
        const current = root.getAttribute('data-theme');
        setTheme(current === 'dark' ? 'light' : 'dark');
    };

    // Listen for system changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        if (!localStorage.getItem(STORAGE_KEY)) {
            setTheme(e.matches ? 'dark' : 'light');
        }
    });
})();
```

---

## Responsive Design

### Breakpoint System

```css
/* Breakpoint Variables (for reference) */
:root {
    --breakpoint-sm: 640px;
    --breakpoint-md: 768px;
    --breakpoint-lg: 1024px;
    --breakpoint-xl: 1280px;
    --breakpoint-2xl: 1536px;
}

/* Mobile First Approach */
.element {
    /* Base: Mobile styles */
    padding: var(--space-4);
    font-size: var(--font-size-base);
}

/* Small screens and up */
@media (min-width: 640px) {
    .element {
        padding: var(--space-6);
    }
}

/* Medium screens and up */
@media (min-width: 768px) {
    .element {
        padding: var(--space-8);
        font-size: var(--font-size-lg);
    }
}

/* Large screens and up */
@media (min-width: 1024px) {
    .element {
        padding: var(--space-10);
    }
}
```

### Responsive Utilities

```css
/* Show/Hide at breakpoints */
.hidden { display: none !important; }
.block { display: block !important; }

@media (min-width: 768px) {
    .md\:hidden { display: none !important; }
    .md\:block { display: block !important; }
}

@media (max-width: 767px) {
    .mobile-only { display: block !important; }
    .desktop-only { display: none !important; }
}

@media (min-width: 768px) {
    .mobile-only { display: none !important; }
    .desktop-only { display: block !important; }
}

/* Responsive Text */
.responsive-text {
    font-size: clamp(1rem, 2.5vw, 1.5rem);
}

.responsive-heading {
    font-size: clamp(2rem, 5vw, 4rem);
}

/* Fluid Spacing */
.section-spacing {
    padding-block: clamp(3rem, 8vw, 6rem);
}
```

---

## Animation & Interaction

### CSS Animations

```css
/* animations.css */

/* Fade In */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate-fade-in {
    animation: fadeIn var(--transition-normal) ease-out;
}

/* Fade In Up */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp var(--transition-normal) ease-out;
}

/* Scale In */
@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-scale-in {
    animation: scaleIn var(--transition-normal) ease-out;
}

/* Slide In */
@keyframes slideInLeft {
    from { transform: translateX(-100%); }
    to { transform: translateX(0); }
}

@keyframes slideInRight {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

/* Staggered Animation */
.stagger > * {
    opacity: 0;
    animation: fadeInUp 0.5s ease-out forwards;
}

.stagger > *:nth-child(1) { animation-delay: 0.1s; }
.stagger > *:nth-child(2) { animation-delay: 0.2s; }
.stagger > *:nth-child(3) { animation-delay: 0.3s; }
.stagger > *:nth-child(4) { animation-delay: 0.4s; }
.stagger > *:nth-child(5) { animation-delay: 0.5s; }

/* Hover Effects */
.hover-lift {
    transition: transform var(--transition-normal);
}

.hover-lift:hover {
    transform: translateY(-4px);
}

.hover-scale {
    transition: transform var(--transition-normal);
}

.hover-scale:hover {
    transform: scale(1.02);
}

/* Respect reduced motion */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
```

### Scroll-triggered Animations

```javascript
// assets/js/scroll-animations.js

(function() {
    'use strict';

    const animatedElements = document.querySelectorAll('[data-animate]');

    if (!animatedElements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const animation = entry.target.dataset.animate;
                entry.target.classList.add('animate-' + animation);
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    animatedElements.forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });
})();
```

Usage in HTML:
```html
<div data-animate="fade-in-up">This will animate when scrolled into view</div>
```

---

## Template Examples

### Blog Post Template

```php
<?php
// single.php - Refined blog post design

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

    <!-- Post Header -->
    <header class="post-header">
        <div class="container container--content">
            <?php if ( has_category() ) : ?>
                <div class="post-categories">
                    <?php the_category( ' ' ); ?>
                </div>
            <?php endif; ?>

            <h1 class="post-title"><?php the_title(); ?></h1>

            <div class="post-meta">
                <span class="post-author">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
                    <span><?php the_author(); ?></span>
                </span>
                <time class="post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </time>
                <span class="post-reading-time">
                    <?php echo esc_html( hannari_reading_time() ); ?>
                </span>
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'full' ); ?>
        </div>
    <?php endif; ?>

    <!-- Post Content -->
    <div class="post-content">
        <div class="container container--content prose">
            <?php the_content(); ?>
        </div>
    </div>

    <!-- Post Footer -->
    <footer class="post-footer">
        <div class="container container--content">
            <?php if ( has_tag() ) : ?>
                <div class="post-tags">
                    <?php the_tags( '<span class="tag-label">Tags:</span> ', ', ' ); ?>
                </div>
            <?php endif; ?>

            <div class="post-share">
                <span class="share-label">Share:</span>
                <!-- Add share buttons -->
            </div>
        </div>
    </footer>

    <!-- Author Bio -->
    <aside class="author-bio">
        <div class="container container--content">
            <div class="author-card">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                <div class="author-info">
                    <h3 class="author-name"><?php the_author(); ?></h3>
                    <p class="author-description"><?php the_author_meta( 'description' ); ?></p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Post Navigation -->
    <nav class="post-navigation">
        <div class="container">
            <?php
            the_post_navigation( array(
                'prev_text' => '<span class="nav-label">Previous</span><span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-label">Next</span><span class="nav-title">%title</span>',
            ) );
            ?>
        </div>
    </nav>

</article>

<?php
if ( comments_open() || get_comments_number() ) :
    ?>
    <div class="container container--content">
        <?php comments_template(); ?>
    </div>
    <?php
endif;

get_footer();
```

### Blog Post Styles

```css
/* templates/_single.css */

.single-post {
    padding-bottom: var(--space-16);
}

/* Header */
.post-header {
    padding: var(--space-16) 0 var(--space-10);
    text-align: center;
}

.post-categories {
    margin-bottom: var(--space-4);
}

.post-categories a {
    display: inline-block;
    padding: var(--space-1) var(--space-3);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-accent);
    background-color: rgba(0, 102, 204, 0.1);
    border-radius: var(--radius-full);
    text-decoration: none;
}

.post-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    max-width: 900px;
    margin: 0 auto var(--space-6);
}

.post-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: var(--space-6);
    font-size: var(--font-size-sm);
    color: var(--color-text-muted);
}

.post-author {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.post-author img {
    border-radius: var(--radius-full);
}

/* Featured Image */
.post-thumbnail {
    max-width: 1000px;
    margin: 0 auto var(--space-12);
    padding: 0 var(--space-4);
}

.post-thumbnail img {
    width: 100%;
    height: auto;
    border-radius: var(--radius-lg);
}

/* Content */
.post-content {
    margin-bottom: var(--space-12);
}

/* Footer */
.post-footer {
    padding: var(--space-8) 0;
    border-top: var(--border-width) solid var(--color-border);
    border-bottom: var(--border-width) solid var(--color-border);
}

.post-tags {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-2);
}

.post-tags a {
    padding: var(--space-1) var(--space-3);
    font-size: var(--font-size-sm);
    background-color: var(--color-surface);
    border-radius: var(--radius-sm);
    text-decoration: none;
}

/* Author Bio */
.author-bio {
    padding: var(--space-12) 0;
}

.author-card {
    display: flex;
    gap: var(--space-6);
    padding: var(--space-8);
    background-color: var(--color-surface);
    border-radius: var(--radius-lg);
}

.author-card img {
    border-radius: var(--radius-full);
    flex-shrink: 0;
}

.author-name {
    margin-bottom: var(--space-2);
}

.author-description {
    color: var(--color-text-muted);
    margin: 0;
}

/* Navigation */
.post-navigation {
    padding: var(--space-8) 0;
}

.post-navigation .nav-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-8);
}

.post-navigation .nav-previous,
.post-navigation .nav-next {
    padding: var(--space-6);
    background-color: var(--color-surface);
    border-radius: var(--radius-md);
    text-decoration: none;
}

.post-navigation .nav-next {
    text-align: right;
}

.post-navigation .nav-label {
    display: block;
    font-size: var(--font-size-sm);
    color: var(--color-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: var(--space-2);
}

.post-navigation .nav-title {
    font-weight: var(--font-weight-semibold);
    color: var(--color-text);
}

@media (max-width: 640px) {
    .post-navigation .nav-links {
        grid-template-columns: 1fr;
    }

    .post-navigation .nav-next {
        text-align: left;
    }

    .author-card {
        flex-direction: column;
        text-align: center;
    }

    .author-card img {
        margin: 0 auto;
    }
}
```

### Reading Time Function

```php
<?php
// In functions.php

/**
 * Calculate reading time
 */
function hannari_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 ); // 200 words per minute

    if ( $reading_time < 1 ) {
        $reading_time = 1;
    }

    return sprintf(
        /* translators: %d: reading time in minutes */
        _n( '%d min read', '%d min read', $reading_time, 'hannari' ),
        $reading_time
    );
}
```

---

## Summary

### Design Workflow

1. **Define Design Tokens** - Colors, typography, spacing in CSS variables
2. **Create Base Styles** - Reset, typography, default elements
3. **Build Components** - Buttons, cards, forms, navigation
4. **Design Layouts** - Grid, containers, section patterns
5. **Create Templates** - Page-specific layouts and styles
6. **Add Interactions** - Hover effects, animations
7. **Ensure Responsiveness** - Mobile-first approach
8. **Test Accessibility** - Contrast, focus states, reduced motion

### Files to Create/Modify

| File | Purpose |
|------|---------|
| `style.css` | Theme metadata + design tokens |
| `assets/css/main.css` | Components, layouts, utilities |
| `template-*.php` | Custom page templates |
| `template-parts/*.php` | Reusable components |
| `assets/js/main.js` | Interactions, theme switcher |

### Key Principles

- **Use CSS Custom Properties** for consistent theming
- **Mobile-first** responsive approach
- **Component-based** CSS organization
- **Semantic HTML** with minimal classes
- **Accessibility** built into every component
- **Performance** with efficient selectors and minimal code
