const { app, BrowserWindow } = require('electron');
const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

let backendProcess = null;
let frontendProcess = null;

function startBackend() {
  const backendPath = path.join(__dirname, '..', 'restaurant-api-laravel');

  if (!fs.existsSync(path.join(backendPath, 'artisan'))) {
    return;
  }

  backendProcess = spawn('php', ['artisan', 'serve', '--host', '127.0.0.1', '--port', '8000'], {
    cwd: backendPath,
    detached: true,
    stdio: 'ignore',
    windowsHide: true,
    shell: false
  });

  backendProcess.unref();
}

function startFrontend() {
  const frontendPath = path.join(__dirname, '..', 'restaurant-frontend');

  if (!fs.existsSync(path.join(frontendPath, 'package.json'))) {
    return;
  }

  const builtFrontendExists = fs.existsSync(path.join(frontendPath, 'dist', 'index.html'));
  if (builtFrontendExists) return;

  frontendProcess = spawn('npm', ['run', 'dev', '--', '--host', '127.0.0.1', '--port', '5173'], {
    cwd: frontendPath,
    detached: true,
    stdio: 'ignore',
    windowsHide: true,
    shell: true
  });

  frontendProcess.unref();
}

function createWindow() {
  const win = new BrowserWindow({
    width: 1400,
    height: 900,
    minWidth: 1100,
    minHeight: 700,
    backgroundColor: '#0f172a',
    autoHideMenuBar: true,
    show: true,
    title: 'Restaurant POS',
    icon: path.join(__dirname, 'build', 'icon.ico'),
    webPreferences: {
      preload: path.join(__dirname, 'preload.js'),
      contextIsolation: true,
      nodeIntegration: false,
      enableRemoteModule: false
    }
  });

  win.setMenuBarVisibility(false);

  const builtFrontend = path.join(__dirname, '..', 'restaurant-frontend', 'dist', 'index.html');

  if (fs.existsSync(builtFrontend)) {
    win.loadFile(builtFrontend);
  } else {
    win.loadURL('http://127.0.0.1:5173');
  }

  win.webContents.setWindowOpenHandler(() => ({ action: 'deny' }));
}

app.whenReady().then(() => {
  startBackend();
  startFrontend();
  createWindow();

  app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
      createWindow();
    }
  });
});

app.on('window-all-closed', () => {
  if (backendProcess) {
    try { backendProcess.kill(); } catch (e) {}
  }

  if (frontendProcess) {
    try { frontendProcess.kill(); } catch (e) {}
  }

  if (process.platform !== 'darwin') {
    app.quit();
  }
});
