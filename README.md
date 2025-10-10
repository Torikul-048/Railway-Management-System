# 🚂 Railway Management System

A comprehensive web-based railway ticket booking system built with Laravel 12, featuring class-based pricing, seat selection, booking management, and admin analytics.

![Laravel](https://img.shields.io/badge/Laravel-12.32.5-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.4.0-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.4-38bdf8.svg)

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [User Roles](#user-roles)
- [Screenshots](#screenshots)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### 🎫 Customer Features
- **Train Search & Booking**
  - Search trains by source, destination, and journey date
  - View detailed train information with facilities
  - Visual seat selection with real-time availability
  - Class-based pricing (Sleeper, Second Class, First Class, AC Chair, AC First)
  - Multiple passenger booking support
  
- **Booking Management**
  - View all bookings with status tracking
  - Download booking tickets (PDF)
  - Flexible cancellation with time-based refunds:
    - Within 6 hours: 90% refund
    - 6-12 hours: 75% refund
    - 12-24 hours: 50% refund
    - 24-48 hours: 20% refund
    - Less than 6 hours before departure: 10% refund
    - After departure: No refund

- **Payment Processing**
  - Multiple payment methods (Credit Card, Debit Card, Mobile Banking)
  - Secure payment confirmation
  - Instant booking confirmation

- **User Profile**
  - Update personal information
  - Change password
  - View booking history

### 👨‍💼 Admin Features
- **Dashboard**
  - Real-time statistics (Total Trains, Bookings, Users, Revenue)
  - Recent bookings overview
  - Quick navigation to all modules

- **Train Management**
  - Add/Edit/Delete trains
  - Manage train routes, timings, and facilities
  - Set seat configuration by class
  - Base fare management

- **Booking Management**
  - View all bookings with filters
  - Update booking status
  - Cancel bookings with refund calculation
  - Export bookings to CSV

- **User Management**
  - Full CRUD operations for users
  - Search and filter users by name, email, role, status
  - Toggle user account status (Active/Inactive)
  - View user booking history
  - Prevent self-deletion

- **Reports & Analytics**
  - Revenue summary dashboard
  - Booking statistics with Chart.js visualizations
  - Revenue trend analysis (bar charts)
  - Booking status distribution (doughnut charts)
  - Daily booking statistics (line charts)
  - Top performing trains
  - Date range filtering
  - CSV export functionality

- **Route Management**
  - View all available routes
  - Station management
  - Route statistics

- **System Settings**
  - General settings configuration
  - Email settings
  - Payment gateway settings
  - Maintenance mode

### 🔐 Authentication & Security
- User registration with email verification
- Secure login/logout
- Password reset functionality (without email)
- Role-based access control (Admin/Staff/Customer)
- Admin-only middleware protection
- CSRF protection on all forms
- Password hashing with bcrypt
- Session-based authentication

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel 12.32.5
- **Language:** PHP 8.4.0
- **Database:** MySQL 8.0
- **Authentication:** Laravel's built-in authentication

### Frontend
- **CSS Framework:** Tailwind CSS 3.4.18
- **JavaScript:** Vanilla JS + Alpine.js
- **Charts:** Chart.js 4.4.0
- **Icons:** Font Awesome 6.x

### Development Tools
- **Build Tool:** Vite 7.0.7
- **Package Manager:** npm & Composer
- **Version Control:** Git

## 📦 Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL
- Git

### Step 1: Clone the Repository
```bash
git clone https://github.com/Torikul-048/Railway-Management-System.git
cd Railway-Management-System
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Install Node Dependencies
```bash
npm install
```

### Step 4: Environment Configuration
```bash
# Copy the example env file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Step 5: Configure Database
Edit the `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=railway_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 6: Run Migrations
```bash
php artisan migrate
```

### Step 7: Seed Database
```bash
# Seed users, trains, and initial data
php artisan db:seed

# Seed train coaches and seats
php artisan db:seed --class=TrainCoachSeeder
```

### Step 8: Build Frontend Assets
```bash
npm run build
```

### Step 9: Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 💾 Database Setup

### Default Users
After seeding, you'll have the following accounts:

**Admin Account:**
- Email: `admin@railway.com`
- Password: `password`

**Customer Account:**
- Email: `customer@railway.com`
- Password: `password`

### Database Schema
- **users** - User authentication and profiles
- **trains** - Train information and base fares
- **train_coaches** - Coach details with class-specific pricing
- **seats** - Individual seat management
- **bookings** - Booking records with refund tracking

## 🚀 Usage

### For Customers

1. **Register/Login**
   - Create a new account or login with existing credentials
   - Navigate to "Book Tickets" from the homepage

2. **Search Trains**
   - Enter source station, destination station, and journey date
   - Click "Search Trains" to view available options

3. **Select Seats**
   - Choose your train and click "Book Now"
   - Select seats from the visual seat layout
   - Note: Prices vary by coach class
   - Different classes show different prices

4. **Enter Passenger Details**
   - Fill in passenger information for each seat
   - Add contact details and special requests
   - Review fare breakdown by coach class

5. **Make Payment**
   - Choose payment method
   - Complete payment process
   - Download booking confirmation

6. **Manage Bookings**
   - View all bookings from "My Bookings"
   - Download tickets
   - Cancel bookings (with refund calculation)

### For Admins

1. **Login to Admin Panel**
   - Use admin credentials
   - Access at `http://localhost:8000/admin/dashboard`

2. **Manage Trains**
   - Add new trains with details
   - Set seat configuration by class
   - Configure base fares (multipliers apply per class)

3. **Monitor Bookings**
   - View all bookings with filters
   - Update booking status
   - Handle cancellations and refunds

4. **Manage Users**
   - Create/edit/delete users
   - Assign roles (Admin/Staff/Customer)
   - View user activity and bookings

5. **View Reports**
   - Access analytics dashboard
   - View revenue trends
   - Analyze booking patterns
   - Export data to CSV

## 👥 User Roles

### Admin
- Full system access
- Train management
- User management
- Booking management
- Reports and analytics
- System settings

### Staff (Future Implementation)
- Booking management
- Customer support
- Limited train management

### Customer
- Train search and booking
- Profile management
- Booking history
- Ticket cancellation

## 📸 Screenshots

### Customer Portal
- Homepage with search
- Train search results
- Seat selection interface
- Booking confirmation
- My Bookings page

### Admin Panel
- Dashboard with analytics
- Train management
- User management interface
- Reports with charts
- Booking management

## 📁 Project Structure

```
Railway-Management-System/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── BookingController.php
│   │   │   │   ├── ReportController.php
│   │   │   │   ├── RouteManagementController.php
│   │   │   │   ├── SettingsController.php
│   │   │   │   ├── TrainController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Auth/
│   │   │   │   ├── ForgotPasswordController.php
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── BookingController.php
│   │   │   ├── ProfileController.php
│   │   │   └── TrainSearchController.php
│   │   └── Middleware/
│   │       └── RedirectIfAdmin.php
│   └── Models/
│       ├── Booking.php (with refund calculation)
│       ├── Seat.php
│       ├── Train.php
│       ├── TrainCoach.php (with price_per_seat)
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_trains_table.php
│   │   ├── create_train_coaches_table.php
│   │   ├── create_seats_table.php
│   │   ├── create_bookings_table.php
│   │   ├── add_refund_fields_to_bookings_table.php
│   │   └── add_price_per_seat_to_train_coaches_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── TrainSeeder.php
│       ├── TrainCoachSeeder.php
│       └── BookingSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── trains/
│       │   ├── bookings/
│       │   ├── users/
│       │   ├── reports/
│       │   ├── routes/
│       │   └── settings/
│       ├── auth/
│       ├── bookings/
│       ├── layouts/
│       ├── profile/
│       ├── trains/
│       └── welcome.blade.php
├── routes/
│   └── web.php
├── .env.example
├── composer.json
├── package.json
└── README.md
```

## 🔑 Key Features Implementation

### Class-Based Pricing System
Prices are calculated using multipliers on the base fare:
- **Sleeper:** 1.0x (Base price)
- **Second Class:** 1.3x (30% more)
- **First Class:** 1.8x (80% more)
- **AC Chair:** 2.0x (100% more)
- **AC First Class:** 2.5x (150% more)

### Time-Based Refund Calculation
The system automatically calculates refunds based on:
1. Time elapsed since booking
2. Time remaining before departure

Formula in `Booking` model:
```php
public function calculateRefundPercentage()
{
    // Check hours since booking and hours before departure
    // Returns percentage (0-100)
}
```

### Real-Time Seat Availability
- Visual seat layout with color coding
- Automatic reservation expiry (10 minutes)
- Conflict prevention with database transactions

### Admin Analytics
- Chart.js integration for visualizations
- Revenue trends with date filtering
- Booking status distribution
- Top performing trains analysis

## 🧪 Testing

### Manual Testing Checklist
- [ ] User registration and login
- [ ] Train search with filters
- [ ] Seat selection across different classes
- [ ] Booking with multiple passengers
- [ ] Payment processing
- [ ] Booking cancellation with refund
- [ ] Admin dashboard statistics
- [ ] Train CRUD operations
- [ ] User management
- [ ] Report generation and CSV export

### Test Accounts
Use the seeded accounts mentioned in [Database Setup](#database-setup)

## 🔒 Security Features

- ✅ CSRF Protection on all forms
- ✅ SQL Injection prevention (Eloquent ORM)
- ✅ XSS Protection (Blade templating)
- ✅ Password hashing (bcrypt)
- ✅ Role-based access control
- ✅ Input validation on all forms
- ✅ Session security
- ✅ Middleware authentication

## 🚧 Future Enhancements

- [ ] Email notifications for bookings
- [ ] SMS alerts for journey reminders
- [ ] Multi-language support
- [ ] Mobile application (Flutter/React Native)
- [ ] Train delay notifications
- [ ] Seat upgrade options
- [ ] Loyalty program/rewards
- [ ] Online check-in
- [ ] QR code tickets
- [ ] Payment gateway integration (Stripe/PayPal)
- [ ] Real-time train tracking
- [ ] Chatbot support

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Open a Pull Request

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

## 👨‍💻 Developer

**Torikul Islam**
- GitHub: [@Torikul-048](https://github.com/Torikul-048)

## 📞 Support

For support, email torikul@example.com or open an issue on GitHub.

## 🙏 Acknowledgments

- Laravel Framework Team
- Tailwind CSS Team
- Chart.js Contributors
- Font Awesome Icons
- All open-source contributors

---

**⭐ Star this repository if you find it helpful!**

Built with ❤️ using Laravel
