# Haya Real Estate

Haya Real Estate is a modern web application for managing property listings. It's built with a powerful backend and a dynamic frontend, all running in a fully containerized Docker environment.
![Screenshot](./assets/screenshot.png)

## Features

- **List, Add, Edit, and Delete Properties**: A full CRUD interface for managing property data.
- **Dynamic Frontend**: Built with Vue.js 3 for a reactive and seamless user experience.
- **RESTful API**: Powered by API Platform for robust and well-structured API endpoints.
- **Dockerized Environment**: Ensures a consistent and easy-to-set-up development environment.

## Tech Stack

- **Backend**:
  - PHP 8.2
  - Symfony 7.2
  - API Platform 4
  - Doctrine ORM
- **Frontend**:
  - Vue.js 3
  - Webpack Encore
  - Sass
- **Database**:
  - MySQL 8.0
- **Web Server**:
  - Nginx

## Requirements

- Docker and Docker Compose (V2 recommended)
- `make` (optional, for convenience)

## Setup and Installation

The project is fully dockerized. To set up the entire environment from scratch—including installing Composer and npm dependencies, building assets, and running database migrations—simply use the provided `Makefile`:

```bash
make install
```

This single command handles everything you need to get started.

## Available Commands

A `Makefile` is included to simplify common development tasks.

- `make up`: Start all Docker containers in the background.
- `make down`: Stop all running containers.
- `make build`: Build the Docker images for the application.
- `make install`: A one-stop command to set up the project from a clean slate.
- `make bash`: Open an interactive bash shell inside the PHP container.
- `make logs`: Tail the logs from all running containers.

## Accessing the Application

Once the containers are running, you can access the application in your browser:

- **Homepage**: [http://localhost:8000/](http://localhost:8000/)
- **API**: [http://localhost:8000/api](http://localhost:8000/api)
