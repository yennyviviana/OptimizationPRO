const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = new Server(server);

// Servir archivos estáticos del dashboard.......
app.use(express.static('public'));

io.on('connection', (socket) => {
  console.log(' Usuario conectado');

  socket.on('chat message', (msg) => {
    console.log('Mensaje recibido:', msg);
    // Enviar a todos los clientes conectados
    io.emit('chat message', msg);
  });

  socket.on('disconnect', () => {
    console.log('Usuario desconectado');
  });
});

server.listen(3000, () => {
  console.log('Servidor escuchando en http://localhost:3000');
});
