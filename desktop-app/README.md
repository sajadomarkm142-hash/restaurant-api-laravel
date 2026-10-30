# Restaurant Desktop App

Production-ready desktop wrapper for the restaurant system.

## Features
- Automatic background launch of Laravel backend
- Automatic background launch of React frontend
- Hidden console mode for clean desktop experience
- Splash-style loading screen
- Windows installer build with electron-builder
- Production-ready package for distribution

## Requirements
- Windows 10/11
- Node.js 18+
- npm
- Laravel backend at `../restaurant-api-laravel`
- React frontend at `../restaurant-frontend`

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
- This app hides terminal windows for a smoother desktop experience.
- The desktop app loads the local frontend automatically.
- The final `.exe` installer must be generated on a Windows machine.
