FROM openjdk:8-jdk
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && apt-get install -qy \
    apt-transport-https \
    lsb-release \
    apt-transport-https ca-certificates \
    ca-certificates \
    wget \
    curl \
    supervisor \
    gnupg-agent \
    software-properties-common
RUN mkdir -p /var/log/supervisor

WORKDIR /app

RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg

RUN echo "deb https://packages.sury.org/php/ bullseye main" | tee /etc/apt/sources.list.d/php.list

RUN apt-get update &&  \
    apt-get install -yq php8.0 && \
    apt-get install -y php8.0-cli php8.0-curl php8.0-common php8.0-imap php8.0-gd php8.0-redis php8.0-snmp php8.0-xml php8.0-zip php8.0-mbstring -y && \
    apt-get clean && rm -rf /var/lib/apt/lists/* \

RUN apt-get update && curl -sL https://deb.nodesource.com/setup_16.x | bash - &&  apt-get -y install nodejs

RUN npm install -g serverless
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=amazon/dynamodb-local:latest /home/dynamodblocal /app/.dynamodb

COPY serverless/package.json /app/package.json

RUN npm install

COPY src/ .

RUN composer install

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY serverless/ .

EXPOSE 8080
EXPOSE 4569

CMD ["/usr/bin/supervisord"]

