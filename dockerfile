# Base image com PHP 8.2 e Apache
FROM php:8.2-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    apt-utils \
    git \
    unzip \
    vim \
    zip \
    curl \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libbz2-dev \
    libwebp-dev \ 
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Node.js (versão LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*FROM php:8.2-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    apt-utils \
    git \
    unzip \
    vim \
    zip \
    curl \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libbz2-dev \
    libwebp-dev \ 
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Node.js (versão LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    bcmath \
    zip \
    xml \
    gd \
    opcache

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    bcmath \
    zip \
    xml \
    gd \
    opcache

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar a configuração do Apache
COPY --chown=www-data:www-data apache-config.conf /etc/apache2/sites-available/000-default.conf

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# Expor a porta 80
EXPOSE 80

# Iniciar Apache em modo foreground
CMD ["apache2-foreground"]
