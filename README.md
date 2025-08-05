# TeenUp Student Management System

A comprehensive web application for managing students, parents, classes, and subscriptions built with Laravel, React, and PostgreSQL.

## Features

### Core Functionality

- **Parent Management**: Create and manage parent information (name, phone, email)
- **Student Management**: Create and manage student profiles with parent relationships
- **Class Management**: Create classes with scheduling, teacher assignments, and capacity limits
- **Class Registration**: Register students to classes with conflict checking
- **Subscription Management**: Track learning packages with session usage

### Technical Features

- **RESTful API**: Complete API endpoints for all operations
- **Modern UI**: React-based frontend with shadcn/ui components
- **Database Design**: Well-structured PostgreSQL schema with relationships
- **Docker Support**: Complete containerization with Docker Compose
- **Authentication**: Laravel's built-in authentication system

## Database Schema

### Tables

1. **parents**: id, name, phone, email
2. **students**: id, name, dob, gender, current_grade, parent_id
3. **classes**: id, name, subject, day_of_week, time_slot, teacher_name, max_students
4. **class_registrations**: class_id, student_id (with unique constraint)
5. **subscriptions**: id, student_id, package_name, start_date, end_date, total_sessions, used_sessions

### Relationships

- Parent has many Students
- Student belongs to Parent
- Student has many ClassRegistrations
- Class has many ClassRegistrations
- Student has many Subscriptions

## API Endpoints

### Parents

- `POST /api/parents` - Create a new parent
- `GET /api/parents/{id}` - Get parent details with students

### Students

- `POST /api/students` - Create a new student
- `GET /api/students/{id}` - Get student details with parent and classes

### Classes

- `POST /api/classes` - Create a new class
- `GET /api/classes?day={weekday}` - Get classes by day of week

### Class Registrations

- `POST /api/classes/{class_id}/register` - Register student to class

### Subscriptions

- `POST /api/subscriptions` - Create a new subscription
- `GET /api/subscriptions/{id}` - Get subscription details
- `PATCH /api/subscriptions/{id}/use` - Mark session as used

## Quick Start

### Prerequisites

- Docker and Docker Compose
- Git

### Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd TeenUp-Manhlicious
    ```

2. **Build the application**

    ```bash
    ./scripts/build.sh
    ```

3. **Access the application**
    - Web Application: http://localhost:8000
    - Database: localhost:5432

## Usage

### Web Interface

1. Navigate to http://localhost:8000
2. Register/Login to access the system or use the example user:
    - Username: admin@example.com
    - Password: password
3. Use the "Student Management" page to:
    - Create parents and students
    - Register students to classes

### API Usage

All API endpoints return JSON responses and support standard HTTP methods.

Example API calls:

```bash
# Create a parent
curl -X POST http://localhost:8000/api/parents \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","phone":"1234567890","email":"john@example.com"}'

# Create a student
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{"name":"Jane Doe","dob":"2010-01-01","gender":"female","current_grade":"5th","parent_id":1}'

# Get classes for Monday
curl http://localhost:8000/api/classes?day=monday
```

## Docker Commands

### Start the application

```bash
./scripts/run.sh
```

**Update application files (for development):**

```bash
./scripts/update-app.sh
```

### Stop the application

```bash
./scripts/stop.sh
```

### View logs

```bash
docker-compose logs -f
```

### Access container shell

```bash
docker-compose exec app bash
```

### Run migrations

```bash
docker-compose exec app php artisan migrate
```

## Development

### Project Structure

```
├── app/
│   ├── Http/Controllers/Api/     # API Controllers
│   └── Models/                   # Eloquent Models
├── database/migrations/          # Database migrations
├── resources/js/
│   ├── pages/                   # React pages
│   └── components/ui/           # UI components
├── routes/
│   ├── api.php                  # API routes
│   └── web.php                  # Web routes
├── docker/                      # Docker configuration
├── scripts/                     # Build and run scripts
└── docker-compose.yml           # Docker services
```

### Adding New Features

1. Create migration: `php artisan make:migration create_table_name`
2. Create model: `php artisan make:model ModelName`
3. Create controller: `php artisan make:controller Api/ControllerName --api`
4. Add routes to `routes/api.php`
5. Create React components in `resources/js/pages/`

## Testing

### Run tests

```bash
php artisan test
```

### API testing

Use tools like Postman to load collection file named TeenUp.postman_collection.json

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please open an issue in the repository.
