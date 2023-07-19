## Installation

#### 1. Clone the project
```bash
git clone https://github.com/aliomidvar1995/tilleh.git
```

#### 2. Run `composer install`
Navigate into project folder using terminal and run

```bash
cd tilleh/laravel
```
```bash
composer install
```

#### 3. Copy `.env.example` into `.env`

```bash
cp .env.example .env
```

#### 4. Set encryption key

```bash
php artisan key:generate
```

#### 5. Create symbolic link

```bash
php artisan storage:link
```

#### 6. Build sqlite database

```bash
cd database
```
```bash
touch database.sqlite
```

#### 7. Run migrations

```bash
cd ..
```
```bash
php artisan migrate
```

#### 8. Start artisan development server

```bash
php artisan serve
```

#### 9. Front End section
Navigate into vue folder and run

```bash
npm install
```

#### 10. Run `npm run dev`

```bash
npm run dev
```