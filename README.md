# bike-service-apllication

Welcome to the Mini Bike Service Application repository! This application allows users to conveniently book appointments for bike services online.

![Screenshot (49)](https://github.com/programrit/bike-service-application/assets/95410082/47dd8f80-cf36-4f4f-af92-4b41a0bf27bf)
![Screenshot (48)](https://github.com/programrit/bike-service-application/assets/95410082/423334fd-2eed-4047-b4a5-9eb1ffa0e0d2)
![Screenshot (50)](https://github.com/programrit/bike-service-application/assets/95410082/733e5d57-bd94-487a-ab12-fe8afa0eedef)

## Features

- **Appointment Booking:** Users can schedule appointments for bike service by selecting preferred dates.
- **Admin Notification:** Appointment details are automatically sent to the admin's email for processing.
- **Service Status Tracking:** Users can track the status of their service, from booking to "Ready for Delivery."
- **Customer Notifications:** Customers receive email notifications when their bike service is complete and ready for delivery.
- **Service History:** Maintain a history of past services for each customer.

## Getting Started

These instructions will help you get a copy of the project up and running on your local machine for development and testing purposes.

## Prerequisites

Before you can use the email notification feature of the Mini Bike Service Application, you need to set up the following prerequisites:

1. **SMTP Email Configuration:** To send emails, you'll need to configure your SMTP (Simple Mail Transfer Protocol) settings. You will need an email account to send emails from and an app password for increased security. Make sure to note down the following details:
   - Your email address (e.g., `your.email@example.com`)
   - Your app password (generated for SMTP access)

2. **PHPMailer Library:** This application uses the PHPMailer library to send emails. You can find the library and installation instructions [here](https://github.com/PHPMailer/PHPMailer). Ensure that you include the library in your project.

## Installation

Follow these steps to set up and run the Mini Bike Service Application on your local machine:

1. **Download the Project:**
   - Download the project's source code from [GitHub Repository](https://github.com/your-username/bike-service).

2. **Move to htdocs Directory:**
   - Move the downloaded project directory into your web server's `htdocs` directory. For example, if you're using XAMPP, place the project directory inside `C:\xampp\htdocs\`.

3. **Database Setup:**
   - Create a MySQL database named `bike_service`.
   - Import the provided SQL file `bike_service.sql` into the `bike_service` database. This file contains the necessary tables and initial data.

4. **Configure PHPMailer:**
   - Open the project's configuration file (named `bike-service\include_class\verify_customer.class.php` and `bike-service\admin\include_class\mail.class.php`).
   - Locate the section related to email configuration.
   - Provide the necessary SMTP settings:
     - SMTP Host: [Your SMTP server's hostname]
     - SMTP Port: [Your SMTP server's port number]
     - SMTP Username: [Your email address]
     - SMTP Password: [Your app password generated for SMTP access]

5. **Access the Application:**
   - Open your web browser and navigate to `http://localhost/bike-service/signup`.
   - This URL should lead you to the sign-up page of the Mini Bike Service Application.

6. **Usage:**
   - Register a new account as a user.
   - Log in using your newly created account.
   - Explore the application, book appointments, and interact with the features.

## Contact

If you have any questions, feel free to contact us at [ramraj291101@gmail.com].
