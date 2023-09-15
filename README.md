
# Laravel Microservices Consumer

This is a consumer project for the Laravel Microservices system. This project is designed to receive messages from a RabbitMQ exchange and perform specific actions based on the received messages.

## Requirements

Before you get started with the installation, make sure you have the following requirements:

- PHP 7.4 or higher
- Composer
- Running RabbitMQ Server
- Laravel Development Environment

## Installation

Clone the project

```bash
  git clone https://github.com/anandaricky01/laravel-microservices-consumer.git
```

Go to the project directory

```bash
  cd laravel-microservices-consumer
```

Install dependencies

```bash
  composer update
```

Configure Environment

```bash
  cp .env.example .env
```
then, open the `.env` file and configure the environment settings such as the RabbitMQ connection and other settings as needed.
```bash
  cp .env.example .env
```
Run Migrations
```bash
  php artisan migrate
```
Run the Consumer
```bash
  php artisan rabbitmq:consume-hello-world
```

