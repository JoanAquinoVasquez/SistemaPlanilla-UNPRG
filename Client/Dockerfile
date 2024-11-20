FROM node:18

WORKDIR /usr/src/app

COPY package*.json ./


# Limpieza completa y reinstalación
RUN rm -rf node_modules package-lock.json && npm install

COPY . .

EXPOSE 5173

CMD ["npm", "run", "dev"]
