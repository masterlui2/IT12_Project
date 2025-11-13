# IT12_Project

## Setup Instructions

### Requirements

- PHP >= 8.1
- Composer
- Node.js and NPM
- MySQL or other supported DB
- Laravel 10.x

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/masterlui2/IT12_Project.git
   cd IT12_Project

2. composer install

3. npm install && npm run dev

4. cp .env.example .env
    php artisan key:generate

5. DB_DATABASE=your_db
    DB_USERNAME=your_user
    DB_PASSWORD=your_password

6. php artisan migrate

7. php artisan serve

### Usage
Once the server is running, visit [http://127.0.0.1:8000] in your browser.