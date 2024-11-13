FROM nginx:1.25.4

COPY nginx/templates/local.conf.template /etc/nginx/templates/default.conf.template
RUN rm /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www/project
COPY laravel/public /var/www/project/public
