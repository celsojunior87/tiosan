FROM node:10-alpine

WORKDIR /var/www

CMD npm install && npm rebuild node-sass && npm run watch
