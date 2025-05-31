# JobBoard - Modern Job Posting Platform

A robust and feature-rich job board platform built with PHP, MySQL, and Docker. This platform connects employers with potential candidates through an intuitive interface, offering comprehensive job posting and application management features.

![JobBoard Platform](html/images/logo.png)

## 🚀 Features

- **User Management**
  - Role-based authentication (Admin, Employer, Job Seeker)
  - Profile management with resume upload
  - Email verification system
  - Password recovery functionality

- **Job Management**
  - Advanced job posting with detailed descriptions
  - Job search with multiple filters
  - Application tracking system
  - Real-time job notifications

- **Admin Dashboard**
  - User management and moderation
  - Job post moderation
  - Analytics and reporting
  - System settings management

- **Employer Features**
  - Company profile management
  - Job post management
  - Applicant tracking
  - Premium features access

## 🛠️ Tech Stack

- PHP 8.0+
- MySQL 8.0
- Docker & Docker Compose
- PHPMailer
- Bootstrap (Frontend)
- JavaScript/jQuery

## 📋 Prerequisites

- Docker and Docker Compose installed
- Git
- Composer (for local development)

## 🔧 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/job-board.git
   cd job-board
   ```

2. Create environment file:
   ```bash
   cp .env.example .env
   ```

3. Start the Docker containers:
   ```bash
   docker-compose up -d
   ```

4. Access the application:
   - Main application: http://localhost:8080
   - PHPMyAdmin: http://localhost:8081

## 🔐 Environment Configuration

Configure the following in your `.env` file:

```env
DB_HOST=jobboard-db
DB_NAME=job_board
DB_USER=jobuser
DB_PASSWORD=job_password

# Mail Configuration
SMTP_HOST=your-smtp-host
SMTP_PORT=587
SMTP_USERNAME=your-username
SMTP_PASSWORD=your-password
```

## 📁 Project Structure

```
job-board/
├── html/               # Application source code
│   ├── css/           # Stylesheets
│   ├── js/            # JavaScript files
│   ├── images/        # Image assets
│   ├── includes/      # PHP includes
│   └── uploads/       # User uploads
├── vendor/            # Composer dependencies
├── Dockerfile         # PHP container configuration
├── docker-compose.yml # Docker services configuration
└── composer.json      # PHP dependencies
```

## 🔒 Security

- Password hashing using PHP's password_hash()
- SQL injection prevention
- XSS protection
- CSRF protection
- Secure file upload handling

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📧 Contact

For support or queries, please contact us at support@jobboard.com

## 🙏 Acknowledgments

- [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [Bootstrap](https://getbootstrap.com)
- [MySQL](https://www.mysql.com)
