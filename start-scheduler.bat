@echo off
echo ========================================
echo Railway Management System - Task Scheduler
echo ========================================
echo.
echo Starting Laravel Task Scheduler...
echo This will automatically expire pending bookings every minute.
echo.
echo Press Ctrl+C to stop the scheduler.
echo ========================================
echo.

cd /d "%~dp0"
php artisan schedule:work
