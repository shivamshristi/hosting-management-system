# Billing Management System (Prototype)

This project provides a basic prototype for a PHP/MySQL billing system.
It demonstrates a modular structure with user authentication, product and client management, and invoice generation in PDF format.

## Features

- Login system with role field (admin, cashier, etc.)
- Manage products and clients
- Create invoices with GST or non-GST items
- Generate PDF invoices using FPDI (requires Composer install)
- Bootstrap-based web interface
- Example database schema in `schema.sql`

## Installation

1. Create a MySQL database named `billing` (or set environment variables `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`).
2. Import `schema.sql` to create tables.
3. Run `composer install` to install the FPDI dependency (internet access required).
4. Configure your web server to serve files from the `public` directory.
5. Access `index.php` to log in. Default users must be added manually via the database.

## Notes

This repository only contains a small subset of the requested functionality. Advanced features such as inventory alerts, multi-branch support, SMS notifications, and return/refund modules are **not** fully implemented. They can be added by extending the existing classes.
