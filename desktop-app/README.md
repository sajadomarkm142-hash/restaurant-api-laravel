# Restaurant Desktop App

This folder packages the restaurant project as a desktop application using Electron.

## Requirements
- Node.js 18+
- npm
- Windows machine for final .exe generation
- Backend project running on `http://localhost:8000`
- Frontend project running on `http://localhost:5173`

## Install

```bash
cd desktop-app
npm install
```

## Run locally

```bash
npm start
```

## Build Windows EXE

Run this on a Windows machine:

```bash
npm run package:win
```

The built installer will appear inside the `desktop-app/dist` folder.

## Notes
- This desktop app loads the local frontend app at `http://localhost:5173`.
- If the frontend is not running, the app shows a fallback window.
- The actual `.exe` must be generated on Windows using `electron-builder`.
