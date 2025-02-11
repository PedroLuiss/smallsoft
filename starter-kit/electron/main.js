const { app, BrowserWindow } = require('electron');
const path = require('path');

function createWindow() {
  // Crear la ventana del navegador
  const win = new BrowserWindow({
    width: 1200,
    height: 800,
    webPreferences: {
      nodeIntegration: true,
      contextIsolation: false,
    },
  });

  // Cargar la aplicación Vue
  if (process.env.NODE_ENV === 'development') {
    win.loadURL('http://localhost:5173'); // URL de desarrollo de Vite
    win.webContents.openDevTools(); // Abrir herramientas de desarrollo
  } else {
    win.loadFile(path.join(__dirname, '../dist/index.html')); // Archivo de producción
  }
}

// Cuando la aplicación esté lista, crear la ventana
app.whenReady().then(createWindow);

// Salir cuando todas las ventanas estén cerradas
app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

// Activar la aplicación cuando se haga clic en el ícono del dock (macOS)
app.on('activate', () => {
  if (BrowserWindow.getAllWindows().length === 0) {
    createWindow();
  }
});
