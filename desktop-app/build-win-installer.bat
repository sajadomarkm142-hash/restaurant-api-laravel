# Restaurant Desktop App

Production-ready desktop wrapper for the restaurant POS system.

## Features
- Splash screen shown while services initialize
- Hidden background startup for Laravel backend and React frontend
- Auto-start of backend and frontend services
- Clean desktop-only experience without visible terminal windows
- Windows installer packaging with electron-builder
- Preserves existing app logic and functions

## Requirements
- Windows 10/11
- Node.js 18+
- npm
- PHP 8.2+
- Composer
- Laravel backend project in `../restaurant-api-laravel`
- React frontend project in `../restaurant-frontend`

## Install
```bash
cd desktop-app
npm install
```

## Run locally
```bash
npm start
```

## Build Windows installer
```bash
npm run package:win
```

The generated installer will appear in:
```text
desktop-app/dist
```

## Notes
- The app hides terminal windows to provide a clean desktop experience.
- The desktop app automatically starts the Laravel backend and React frontend in the background.
- The final `.exe` file must be generated on a Windows system.
