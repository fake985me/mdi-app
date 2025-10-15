# Frontend Structure

This document describes the frontend structure for the Laravel-Vue application with separation between admin and public sections.

## Directory Structure

```
resources/js/
├── admin/                 # Admin-specific frontend code
│   ├── components/        # Admin UI components
│   ├── views/            # Admin pages/views
│   ├── router/           # Admin-specific routes
│   ├── composables/      # Admin-specific Vue composables
│   ├── services/         # Admin-specific service utilities
│   ├── stores/           # Admin-specific Pinia stores
│   └── utils/            # Admin-specific utility functions
├── public/               # Public-facing frontend code
│   ├── components/       # Public UI components
│   ├── views/            # Public pages/views
│   ├── router/           # Public-specific routes
│   ├── composables/      # Public-specific Vue composables
│   ├── services/         # Public-specific service utilities
│   ├── stores/           # Public-specific Pinia stores
│   └── utils/            # Public-specific utility functions
├── assets/               # Static assets (images, fonts, etc.)
├── composables/          # Shared Vue composables
├── lib/                  # Third-party libraries
├── locales/              # Translation files
├── router/               # Main router combining admin and public routes
├── services/             # Shared service utilities
├── stores/               # Shared Pinia stores
├── app.js                # Application bootstrap
├── App.vue               # Main application component
├── bootstrap.js          # JavaScript bootstrap
├── main.js               # Application entry point
└── style.css             # Main stylesheet
```

## Admin Section

Contains all code related to the admin dashboard and management functionality:
- Inventory management
- Product management
- User management
- Sales/purchase tracking
- Warranty tracking
- Borrowing system
- Page builder and templates
- Navigation management

## Public Section

Contains all code related to the public-facing website:
- Landing page
- Product catalog
- Login/register pages
- Custom pages

## Shared Code

Code that is used by both admin and public sections:
- Authentication store
- Language service
- Common utilities
- General components that are used in both sections