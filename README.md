# 🚂 Railway Management System

A comprehensive web-based railway ticket booking system built with Laravel 12, featuring class-based pricing, real-time seat selection, automated booking management, and admin analytics.

![Laravel](https://img.shields.io/badge/Laravel-12.32.5-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.4.0-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.4-38bdf8.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952b3.svg)

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [User Roles](#user-roles)
- [Key Features](#key-features)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### 🎫 Customer Features

#### Train Search & Booking
- **Advanced Search**: Search trains by source, destination, journey date, train number, route, and departure time
- **Real-time Availability**: View live seat availability across all coach types
- **Visual Seat Selection**: Interactive seat map with color-coded availability
- **Class-based Pricing**: Dynamic pricing based on coach type:
  - Sleeper: 1.0x base fare
  - Second Class: 1.3x base fare
  - First Class: 1.8x base fare
  - AC Chair: 2.0x base fare
  - AC First Class: 2.5x base fare
- **Single Passenger Booking**: Simplified booking with one passenger per reservation

#### Booking Management
- **My Bookings Dashboard**: View all bookings with status filtering
- **Status Tracking**: Real-time booking status (Pending, Confirmed, Cancelled, Completed)
- **Booking Details**: Comprehensive view of journey, passenger, and payment information
- **Ticket Download**: Generate and download PDF tickets for confirmed bookings
- **Flexible Cancellation**: Cancel bookings anytime before departure with time-based refunds:
  - More than 48 hours: 90% refund
  - 24-48 hours: 75% refund
  - 12-24 hours: 50% refund
  - 6-12 hours: 20% refund
  - Less than 6 hours: 10% refund
  - After departure: No cancellation allowed

#### Payment System
- **Multiple Payment Methods**:
  - bKash
  - Nagad
  - Rocket
  - Credit/Debit Card
  - Bank Transfer
- **5-Minute Payment Window**: Countdown timer with automatic expiration
- **Auto-Cancellation**: Unpaid bookings automatically cancelled after 5 minutes
- **Seat Release**: Seats automatically released back to available pool
- **Instant Confirmation**: Immediate booking confirmation upon payment

#### User Profile
- **Profile Management**: Update personal information (name, email, phone, address)
- **Password Security**: Change password with validation
- **Account Status**: View account status and membership details
- **Booking History**: Access complete booking history

### 👨‍💼 Admin Features

#### Dashboard
- **Real-time Statistics**:
  - Total Revenue (confirmed bookings)
  - Active Bookings count
  - Total Registered Users
  - Available Trains
- **Recent Bookings**: Quick view of latest 10 bookings with details
- **Visual Analytics**: Overview of system activity

#### Train Management
- **CRUD Operations**: Create, Read, Update, Delete trains
- **Train Details**:
  - Train name and number
  - Route (source and destination)
  - Departure and arrival times
  - Train type (Express, Mail, Local, Intercity)
  - Facilities (AC, WiFi, Food, etc.)
  - Base fare per seat
- **Search & Filter**: Filter trains by type, route, status
- **Validation**: Comprehensive input validation

#### Booking Management
- **Complete Overview**: View all bookings across the system
- **Advanced Filters**:
  - Filter by booking status
  - Filter by train
  - Search by booking reference or passenger name
  - Date range filtering
- **Booking Actions**:
  - View detailed booking information
  - Update booking status
  - Cancel bookings with refund calculation
  - View passenger details
  - Track payment information
- **Refund Processing**: Automatic refund calculation based on cancellation time

#### User Management
- **User CRUD**: Complete user management system
- **Role Assignment**: Assign roles (Admin, Staff, Customer)
- **User Search**: Search by name, email, or role
- **Account Status**: Activate/deactivate user accounts
- **User Details**: View user profile and booking history

#### Reports & Analytics
- **Revenue Dashboard** with Chart.js visualizations:
  - **Monthly Revenue Chart**: Bar chart showing revenue trends
  - **Booking Status Distribution**: Pie chart of booking statuses
  - **Popular Routes Chart**: Horizontal bar chart of top routes
- **Booking Statistics**:
  - Total bookings and confirmed bookings count
  - Total and average revenue
  - Cancellation rate
- **Recent Bookings Table**: Detailed list with passenger info
- **Export Functionality**: Generate reports for specific date ranges

#### Route Management
- **Popular Routes**: Track and manage frequently booked routes
- **Route Statistics**: View booking counts per route
- **Route Analysis**: Identify profitable routes

#### System Settings
- **Application Settings**: Configure system-wide settings
- **Email Configuration**: Set up email notifications
- **Payment Gateway**: Configure payment methods
- **System Maintenance**: Manage system maintenance mode

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12.32.5
- **PHP**: 8.4.0
- **Database**: MySQL 8.0
- **Authentication**: Laravel Breeze
- **Queue**: Laravel Queue for background jobs

### Frontend
- **CSS Frameworks**: 
  - Tailwind CSS 3.4 (Customer interface)
  - Bootstrap 5.3 (Admin panel)
- **JavaScript**: Alpine.js for interactive components
- **Charts**: Chart.js 4.4.0 for analytics
- **Build Tool**: Vite 5.x

### Design Patterns Implemented
- **Adapter Pattern**: Payment gateway integration
- **Factory Pattern**: Payment gateway factory
- **Flyweight Pattern**: Seat type optimization
- **Proxy Pattern**: Train availability caching

### Additional Tools
- **PDF Generation**: DomPDF for ticket generation
- **Task Scheduling**: Laravel Scheduler for automated tasks
- **Validation**: Comprehensive form validation
- **Middleware**: Custom authentication and authorization

## 📥 Installation

### Prerequisites
- PHP >= 8.4.0
- Composer
- Node.js & NPM
- MySQL >= 8.0

### Step-by-Step Installation

#### Step 1: Clone Repository
```bash
git clone https://github.com/Torikul-048/Railway-Management-System.git
cd Railway-Management-System
```

#### Step 2: Install PHP Dependencies
```bash
composer install
```

#### Step 3: Install Node Dependencies
```bash
npm install
```

#### Step 4: Environment Configuration
```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

#### Step 5: Configure Database
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=railway_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### Step 6: Configure Application
Update `.env` with your settings:
```env
APP_NAME="Railway Management System"
APP_ENV=local
APP_DEBUG=true
APP_TIMEZONE=Asia/Dhaka
APP_URL=http://localhost:8000

# Email Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@railway.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Step 7: Database Migration & Seeding
```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

This will create:
- 4 users (1 admin, 2 customers)
- 6 trains with different routes
- 20 train coaches (varied types)
- 950 seats across all coaches
- 3 sample bookings

#### Step 8: Build Frontend Assets
```bash
npm run build
```

#### Step 9: Start Development Server
```bash
php artisan serve
```

#### Step 10: Start Task Scheduler (Important!)
**The scheduler automatically cancels unpaid bookings after 5 minutes.**

Open a **new terminal** and run:
```bash
# Windows
start-scheduler.bat

# Or manually
php artisan schedule:work
```

⚠️ **Important:** Keep this terminal running! Without the scheduler:
- Pending bookings won't auto-expire after 5 minutes
- Seats won't be released automatically
- Payment timer will show but won't enforce cancellation

Visit `http://localhost:8000` in your browser.

## 💾 Database Setup

### Default Users
After seeding, you'll have the following accounts:

**Admin Account:**
- Email: `admin@railway.com`
- Password: `password`
- Role: Admin

**Customer Accounts:**
- Email: `customer@railway.com`
- Password: `password`
- Role: Customer

- Email: `john@example.com`
- Password: `password`
- Role: Customer

### Database Schema Overview

**Users Table:**
- id, name, email, password
- phone, date_of_birth, gender
- national_id, address
- role (admin/staff/customer)
- timestamps

**Trains Table:**
- id, train_number, name
- source_station, destination_station
- departure_time, arrival_time
- route, train_type
- total_seats, available_seats
- fare_per_seat, facilities
- status (active/inactive)
- timestamps

**Train Coaches Table:**
- id, train_id, coach_number
- coach_type (sleeper/second_class/first_class/ac_chair/ac_first)
- total_seats, price_per_seat
- timestamps

**Seats Table:**
- id, train_coach_id, seat_number
- is_available, is_reserved
- reserved_until
- timestamps

**Bookings Table:**
- id, user_id, train_id, booking_reference
- booking_date, journey_date
- seat_numbers (JSON)
- passenger_details (JSON)
- total_fare
- booking_status (pending/confirmed/cancelled/completed)
- payment_status (pending/paid/refunded)
- payment_method, payment_reference
- refund_amount, refund_percentage
- cancelled_at, cancellation_reason
- timestamps

## 🎯 Usage

### For Customers

1. **Register/Login**: Create account or login
2. **Search Trains**: Enter journey details
3. **Select Train**: Choose from available trains
4. **Select Seats**: Pick seats from visual seat map
5. **Enter Details**: Provide passenger information
6. **Make Payment**: Choose payment method and complete within 5 minutes
7. **Download Ticket**: Get PDF ticket after confirmation
8. **Manage Bookings**: View, cancel, or download tickets

### For Admins

1. **Login**: Access admin panel at `/admin/login`
2. **Dashboard**: View system overview and statistics
3. **Manage Trains**: Add, edit, or remove trains
4. **Manage Bookings**: Monitor and manage all bookings
5. **User Management**: Manage user accounts and roles
6. **View Reports**: Analyze revenue and booking trends
7. **System Settings**: Configure application settings

## 👥 User Roles

### Customer
- Search and book train tickets
- View and manage own bookings
- Cancel bookings with refunds
- Update profile information
- Download tickets

### Admin
- Full system access
- User management (CRUD)
- Train management (CRUD)
- Booking management (CRUD)
- Access to all reports and analytics
- System settings configuration

## 🔑 Key Features Explained

### 1. 5-Minute Payment Window

When a customer creates a booking:
1. Status: **Pending** (seats reserved)
2. Timer starts: 5:00 countdown
3. Two outcomes:
   - **Paid within 5 minutes**: Status → Confirmed ✅
   - **Not paid**: Automatic cancellation, seats released ❌

The `bookings:expire-pending` command runs every minute via Laravel Scheduler to check and cancel expired bookings.

### 2. Class-Based Pricing

Each coach type has a multiplier on the train's base fare:
```php
Sleeper:      Base Fare × 1.0
Second Class: Base Fare × 1.3
First Class:  Base Fare × 1.8
AC Chair:     Base Fare × 2.0
AC First:     Base Fare × 2.5
```

Example: Train base fare = ৳500
- Sleeper seat = ৳500
- AC First seat = ৳1,250

### 3. Time-Based Refund System

Refund percentage calculated based on time before departure:
```php
if (hours_before >= 48) → 90% refund
else if (hours_before >= 24) → 75% refund
else if (hours_before >= 12) → 50% refund
else if (hours_before >= 6) → 20% refund
else if (hours_before > 0) → 10% refund
else → 0% (departed)
```

The `calculateRefundPercentage()` method in Booking model handles this logic.

### 4. Visual Seat Selection

Interactive seat map with:
- ✅ Green = Available
- 🔴 Red = Booked
- 🟡 Yellow = Selected (by user)
- Real-time price calculation
- Coach type identification
- Seat number display

### 5. Automated Cancellation

Laravel Scheduler runs `bookings:expire-pending` every minute:
1. Finds bookings with status=pending and payment_status=pending
2. Checks if booking_date <= 5 minutes ago
3. Updates booking status to cancelled
4. Releases all reserved seats
5. Logs cancellation reason

### 6. Bangladesh Localization

- Timezone: Asia/Dhaka (UTC+6)
- Date pickers show Bangladesh dates
- Journey date validation uses BD time
- All timestamps in BD timezone

## 📁 Project Structure

```
Railway-Management-System/
├── app/
│   ├── Adapters/              # Payment adapter pattern
│   ├── Console/Commands/      # Artisan commands
│   │   └── ExpirePendingBookings.php
│   ├── Factories/             # Factory pattern
│   ├── Flyweights/            # Flyweight pattern
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Admin controllers
│   │   │   ├── Auth/          # Authentication
│   │   │   ├── BookingController.php
│   │   │   ├── ProfileController.php
│   │   │   └── TrainSearchController.php
│   │   └── Middleware/
│   │       └── RedirectIfAdmin.php
│   ├── Models/
│   │   ├── Booking.php        # Booking model with refund logic
│   │   ├── Seat.php
│   │   ├── Train.php
│   │   ├── TrainCoach.php
│   │   └── User.php
│   └── Proxies/               # Proxy pattern
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── public/                    # Public assets
├── resources/
│   ├── css/
│   │   └── app.css           # Tailwind CSS
│   ├── js/
│   │   ├── app.js            # Main JavaScript
│   │   └── bootstrap.js      # Bootstrap setup
│   └── views/
│       ├── admin/            # Admin panel views
│       ├── auth/             # Authentication views
│       ├── bookings/         # Booking views
│       ├── layouts/          # Layout templates
│       ├── profile/          # Profile views
│       └── trains/           # Train search views
├── routes/
│   ├── console.php           # Scheduler configuration
│   └── web.php               # Web routes
├── storage/                  # File storage
├── tests/                    # Unit & feature tests
├── .env.example              # Environment template
├── composer.json             # PHP dependencies
├── package.json              # Node dependencies
├── README.md                 # This file
├── start-scheduler.bat       # Scheduler startup script
└── vite.config.js           # Vite configuration
```

## 🔌 API Endpoints

### Public Routes
- `GET /` - Home page
- `GET /login` - Login page
- `POST /login` - Login action
- `GET /register` - Registration page
- `POST /register` - Registration action

### Customer Routes (Auth Required)
- `GET /trains/search` - Search trains
- `GET /trains/{train}/details` - Train details
- `GET /trains/{train}/select-seats` - Seat selection
- `POST /bookings/reserve-seats` - Reserve seats
- `POST /trains/{train}/book` - Create booking
- `GET /bookings/{booking}/payment` - Payment page
- `POST /bookings/{booking}/process-payment` - Process payment
- `GET /bookings/{booking}/confirmation` - Booking confirmation
- `GET /my-bookings` - View bookings
- `GET /bookings/{booking}/download-ticket` - Download ticket
- `GET /bookings/{booking}/cancel` - Cancel booking form
- `POST /bookings/{booking}/cancel` - Cancel booking action
- `GET /profile` - User profile
- `PATCH /profile` - Update profile
- `DELETE /profile` - Delete account

### Admin Routes (Admin Only)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/users` - User management
- `POST /admin/users` - Create user
- `GET /admin/users/{user}` - View user
- `PUT /admin/users/{user}` - Update user
- `DELETE /admin/users/{user}` - Delete user
- `GET /admin/trains` - Train management
- `POST /admin/trains` - Create train
- `GET /admin/trains/{train}` - View train
- `PUT /admin/trains/{train}` - Update train
- `DELETE /admin/trains/{train}` - Delete train
- `GET /admin/bookings` - Booking management
- `GET /admin/bookings/{booking}` - View booking
- `PUT /admin/bookings/{booking}` - Update booking
- `POST /admin/bookings/{booking}/cancel` - Cancel booking
- `GET /admin/reports` - Reports & analytics
- `GET /admin/routes` - Route management
- `GET /admin/settings` - System settings

## 🔒 Security Features

- ✅ CSRF protection on all forms
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade templating)
- ✅ Password hashing (bcrypt)
- ✅ Role-based access control
- ✅ Middleware authentication
- ✅ Input validation
- ✅ Session management
- ✅ Environment variable protection
- ✅ HTTPS ready (production)

## 🧪 Testing

Run tests:
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter BookingTest

# Run with coverage
php artisan test --coverage
```

## 📊 Scheduler Commands

The system uses Laravel Scheduler for automated tasks:

**Expire Pending Bookings:**
```bash
php artisan bookings:expire-pending
```
- Runs every minute via scheduler
- Cancels bookings older than 5 minutes
- Releases reserved seats
- Updates booking status

To run scheduler manually:
```bash
php artisan schedule:work
```

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure proper database credentials
- [ ] Set up SSL certificate (HTTPS)
- [ ] Configure email service
- [ ] Set up cron job for scheduler:
  ```bash
  * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
  ```
- [ ] Optimize application:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan optimize
  ```
- [ ] Set proper file permissions
- [ ] Configure backup strategy
- [ ] Set up monitoring and logging


## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

## 👨‍💻 Developers

**Torikul Islam**
- GitHub: [@Torikul-048](https://github.com/Torikul-048)
- Email: torikulislam732978@gmail.com

**Farid Patwary**
- GitHub: [@Farid-43](https://github.com/Farid-43)
- Email: faridpatwary2020@gmail.com

**Sayeem**
- GitHub: [@Sayeem33](https://github.com/Sayeem33)
- Email: Sayeem2107033@stud.kuet.ac.bd

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Bootstrap
- Chart.js
- Alpine.js
- All open-source contributors

## 📞 Support

For support, email torikulislam732978@gmail.com, faridpatwary2020@gmail.com, Sayeem2107033@stud.kuet.ac.bd or open an issue on GitHub.

---

