# EtherIC

EtherIC is a PHP-based application designed for managing user authentication, network traffic routing, and anonymization through proxy and Tor services. The application includes separate interfaces for users and administrators, allowing for easy management of user accounts, proxy services, and the secure routing of network traffic.

## Table of Contents

1. [Overview](#overview)
2. [Features](#features)
3. [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Configuration](#configuration)
4. [Database Setup](#database-setup)
5. [File Structure](#file-structure)
    - [Controllers](#controllers)
    - [Models](#models)
    - [Services](#services)
    - [Views](#views)
    - [Routes](#routes)
6. [Detailed Component Breakdown](#detailed-component-breakdown)
    - [User Authentication](#user-authentication)
    - [Dashboard Functionality](#dashboard-functionality)
    - [Admin Functionality](#admin-functionality)
7. [Proxy and Tor Services](#proxy-and-tor-services)
    - [Proxy Integration](#proxy-integration)
    - [Tor Integration](#tor-integration)
8. [Deployment](#deployment)
9. [Contribution Guidelines](#contribution-guidelines)
10. [License](#license)

## Overview

EtherIC provides a robust framework for managing users and securely routing network traffic using proxies and the Tor network. It is built using the PHP language, providing the flexibility and power needed to implement complex traffic routing algorithms and maintain user anonymity online.

The system comes with a variety of built-in features, including:
- **User Management**: Registration, login, and profile management.
- **Admin Control Panel**: Manage users, configure services, and monitor network traffic.
- **Proxy Services**: Route traffic through configurable proxy servers.
- **Tor Network Integration**: Anonymize traffic via Tor for enhanced security.

EtherIC was designed with a modular structure to support easy extension and customization. Each component (user management, proxy service, Tor integration) is clearly separated, allowing developers to modify or replace individual parts without disrupting the whole system.

## Features

- **Secure User Authentication**: Users can register, log in, and manage their accounts using a secure authentication process, which includes password hashing and session management.
- **Role-Based Access Control**: Admin users have access to additional features, such as managing user accounts and monitoring proxy traffic.
- **Proxy Routing**: EtherIC allows users to route their internet traffic through proxy servers, which can be configured in the system to provide anonymity.
- **Tor Anonymization**: Integration with the Tor network provides an additional layer of security by routing user traffic through multiple encrypted nodes.
- **Dashboard Interface**: Both users and administrators have access to custom dashboard interfaces that provide access to core functionality.
- **Traffic Monitoring**: Admins can monitor proxy and Tor traffic, track usage, and manage the network.

## Getting Started

EtherIC can be easily set up on any server that supports PHP and MySQL. The following sections provide detailed instructions for getting started with installation, configuration, and deployment.

### Prerequisites

To run EtherIC, you need:

- **PHP 7.4 or higher**: The core programming language for the application.
- **Composer**: PHP dependency manager for installing required libraries.
- **MySQL or MariaDB**: The database system to store user and traffic data.
- **Apache or Nginx**: A web server to serve the application.

### Installation

Follow these steps to install EtherIC:

1. **Clone the repository**
   ```bash
   git clone https://github.com/username/EtherIC.git
   cd EtherIC
   ```

2. **Install dependencies**
   EtherIC uses Composer to manage its dependencies. Run the following command to install the necessary PHP packages:
   ```bash
   composer install
   ```

3. **Set up environment variables**
   Copy the example `.env` file and configure it with your own settings:
   ```bash
   cp .env.example .env
   ```

   In this file, configure your database settings and other necessary environment variables:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=etheric
   DB_USERNAME=root
   DB_PASSWORD=yourpassword
   ```

4. **Set up the database**
   Use the provided SQL migration file to create the necessary tables:
   ```bash
   mysql -u root -p etheric < database/migrations.sql
   ```

5. **Set up the web server**
   Point your web server's document root to the `public/` directory of the EtherIC project.

6. **Run the application**
   You can now start the web server and access the application in your browser:
   ```
   http://localhost/
   ```

### Configuration

After installation, you may need to configure certain aspects of the system, such as proxy servers and Tor settings. This is done through the configuration files in the `app/Services/` directory and the database.

- **Proxy Configuration**: Add your proxy servers to the `ProxyService.php` file.
- **Tor Configuration**: Ensure that the Tor service is properly configured and accessible.

## Database Setup

The database is a key component of EtherIC, as it stores all user data, proxy settings, and service usage records. The SQL migration file `migrations.sql` sets up the necessary tables for user management, orders, packages, and more.

### Core Tables

- **users**: This table stores user information such as usernames, emails, and hashed passwords.
- **orders**: This table tracks any purchases or service packages users may subscribe to.
- **packages**: This table defines the different proxy or Tor service packages available to users.
- **traffic_logs**: Logs and stores traffic routed through the proxies or Tor.

## File Structure

EtherIC's codebase is organized in a modular fashion. Each component is neatly separated into its own directory, making it easier to maintain and scale.

### Controllers

The `app/Controllers/` directory contains the logic for handling HTTP requests and managing the flow of data between models and views.

- **AdminController.php**: Manages administrator tasks, including user management and service configuration.
- **AuthController.php**: Handles user authentication processes, including registration and login.
- **DashboardController.php**: Provides user-facing dashboard functionality.
- **TestController.php**: A controller likely used for testing purposes.

### Models

Models in EtherIC represent the data entities and handle interactions with the database. They are located in `app/Models/`.

- **User.php**: Represents the `users` table and contains the logic for managing user data.
- **Order.php**: Represents the `orders` table and handles order-related functionality.
- **Package.php**: Represents the `packages` table and defines available service packages.

### Services

The `app/Services/` directory contains the business logic responsible for handling proxy and Tor operations.

- **ProxyService.php**: Manages proxy servers and ensures traffic is routed correctly.
- **TorService.php**: Integrates with the Tor network, ensuring secure, anonymized traffic routing.

### Views

Views in EtherIC are stored in the `resources/views/` directory and are organized into separate directories for each section of the application.

- **auth/**: Contains templates for login and registration pages (`login.view.php`, `register.view.php`).
- **dashboard/**: Contains the user dashboard template (`user_dashboard.view.php`).
- **admin/**: Contains the admin dashboard template (`admin_dashboard.view.php`).

### Routes

The `routes/web.php` file defines the web routes that map URLs to controller actions. This file is the central location for all HTTP route definitions in EtherIC.

Some key routes include:
- `/login` → `AuthController@login`
- `/register` → `AuthController@register`
- `/dashboard` → `DashboardController@index`
- `/admin` → `AdminController@index`

## Detailed Component Breakdown

### User Authentication

EtherIC provides a secure authentication mechanism using PHP's `password_hash()` function to store encrypted passwords in the database. The login process involves verifying the user’s credentials and establishing a session.

The **AuthController** is responsible for handling the following:
- **Login**: Validates credentials and starts a session.
- **Registration**: Creates a new user and stores encrypted credentials in the database.
- **Logout**: Destroys the session and logs the user out.

### Dashboard Functionality

Once logged in, users can access their dashboard at `/dashboard`, where they can view account details, proxy usage statistics, and manage their traffic settings. The dashboard is rendered by the **DashboardController** and the corresponding view file `user_dashboard.view.php`.

Key features of the user dashboard:
- **Service Usage**: Displays details of the current services the user has subscribed to, such as proxy or Tor packages.
- **Account Management**: Allows users to update their personal details, change passwords, and view traffic logs.

### Admin Functionality

Admins have their own dashboard interface, accessible at `/admin`. The **AdminController** handles administrative functions, such as:
- **User Management**: View, add, modify, or delete user accounts.
- **Traffic Monitoring**: View logs of traffic routed through the proxy and Tor services.
- **Service Configuration**: Modify proxy and Tor settings.

## Proxy and Tor Services

EtherIC’s key strength lies in its ability to route network traffic through proxy and Tor services to ensure user anonymity.

### Proxy Integration

The **ProxyService** handles all logic related to the use of proxy servers. This service includes:
- **Proxy Server

 Configuration**: Admins can add or remove proxy servers from the system.
- **Traffic Routing**: User traffic is directed through one of the configured proxy servers to hide their IP addresses and ensure anonymity.

The `storage/proxy_list.txt` file contains a list of available proxy servers that the service can use.

### Tor Integration

The **TorService** integrates with the Tor network, adding another layer of anonymity by routing traffic through Tor’s onion network.

Features of Tor integration include:
- **Automatic Routing**: Traffic is routed through multiple nodes in the Tor network to ensure maximum anonymity.
- **Privacy Preservation**: Data is encrypted in multiple layers and passed through a series of Tor nodes, hiding the original IP address of the user.

To use the Tor service, the Tor daemon must be installed and running on the server. The `TorService.php` class manages communication with the daemon and handles traffic anonymization.

## Deployment

To deploy EtherIC in a production environment, follow these steps:

1. **Server Setup**: Ensure that PHP, MySQL, and a web server (Apache or Nginx) are properly configured.
2. **Environment Configuration**: Set the environment variables for production, including secure database credentials and proxy configurations.
3. **Database Migration**: Ensure the production database is properly set up with the necessary tables using the migration script.
4. **Secure the Application**: Implement SSL (HTTPS) to secure all traffic between users and the server. 
5. **Monitor Performance**: Keep track of system performance, especially the proxy and Tor services, to ensure optimal routing of traffic.

## Contribution Guidelines

We welcome contributions to EtherIC! To contribute:

1. Fork the repository.
2. Create a new branch with a descriptive name.
3. Make your changes.
4. Open a pull request with a clear description of the changes.

Please follow these guidelines:
- **Code Style**: Follow the existing code style and conventions used in the project.
- **Testing**: Ensure that your changes are thoroughly tested before submitting a pull request.
- **Documentation**: Update the README and any other relevant documentation when making changes.

## License

EtherIC is open source and licensed under the MIT License. See the `LICENSE` file for details.
