FROM nginxinc/nginx-unprivileged:1.25-alpine

USER root

ARG USER_ID
ARG GROUP_ID

    # Remove user with the same uid if it exists
RUN (deluser --remove-home $(getent passwd $USER_ID | cut -d: -f1) || true) \
    # Remove user nginx
    && (deluser --remove-home nginx || true) \
    && apk add shadow \
    # Add group for nginx if it does not already exist
    && groupadd -g $GROUP_ID -f nginx \
    # Add user nginx
    && useradd -u $USER_ID -g $GROUP_ID -s /bin/bash -d /home/nginx -m nginx

RUN mkdir -p /var/log/nginx && chown -R nginx:nginx /var/log/nginx

USER nginx

COPY --chown=nginx:nginx ./conf.d/default.conf /etc/nginx/conf.d/default.conf