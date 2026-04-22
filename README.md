# PHP_Laravel12_Implement_SEO_Using_Angular.JS

##  Introduction

This project demonstrates how to implement **SEO meta tags** using **Laravel (backend)** and **AngularJS (frontend)**.  
In this project, Laravel renders SEO meta data dynamically (title, description, keywords) while AngularJS renders the page content.

---

##  Project Overview

This is a small SEO-friendly application built using:

- **Laravel 12**
- **AngularJS 1.8**
- **MySQL Database**
- **Blade Templating**
- **Angular Routing**
- **SEO Meta Tags (Dynamic)**

---

##  Project Features

- Dynamic SEO meta tags for each page  
- SEO data stored in database  
- AngularJS single page application  
- Separate backend and frontend  
- SEO-friendly structure  
- Clean and modern design  

---

##  Project Structure

```
PHP_LarAVEL12_IMPLEMENT_SEO_USING_ANGULAR.JS/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   └── SeoController.php
│   │   │
│   ├── Models/
│   │   ├── SeoPage.php
│   │   
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── migrations/
│   │   └── 2026_01_21_063443_create_seo_pages_table.php
│  
│   
│
├── public/
│   ├── angular/
│   │   ├── controllers/
│   │   │   ├── HomeController.js
│   │   │   └── SeoController.js
│   │   ├── views/
│   │   │   ├── home.html
│   │   │   ├── about.html
│   │   │   
│   │   ├── app.js
│   │   └── routes.js
│   ├── index.php
│   ├── .htaccess
│   ├── robots.txt
│   └── favicon.ico
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   └── welcome.blade.php
│   ├── css/
│   └── js/
│
├── routes/
│   └── web.php
│
├── .env
├── composer.json
├── package.json
└── README.md
```

---

##  Step 1: Create Laravel Project

```bash
composer create-project laravel/laravel PHP_Laravel12_Implement_SEO_Using_Angular.JS "12.*"
cd PHP_Laravel12_Implement_SEO_Using_Angular.JS
```

---

## Step 2: Configure Environment (.env)

Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_seo_angular
DB_USERNAME=root
DB_PASSWORD=
```

After run migration to create databse:

```bash
php artisan migrate
```

---

##  Step 3: Create Migration (SEO Pages Table)

```bash
php artisan make:migration create_seo_pages_table
```

File: database/migrations/2026_01_21_063443_create_seo_pages_table.php

Migration Code:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo_pages');
    }
};
```

---


##  Step 4: Create Model (SeoPage)

```bash
php artisan make:model SeoPage
```

File: app/Models/SeoPage.php

Model Code:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'keywords'
    ];
}
```

---


##  Step 5. Create Controller (SeoController)

```bash
php artisan make:controller SeoController
```

File: app/Http/Controllers/SeoController.php

Controller Code:

```php
<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;

class SeoController extends Controller
{
    public function show($slug = 'home')
    {
        $seo = SeoPage::where('slug', $slug)->first();

        //  Invalid slug → 404
        if (!$seo) {
            abort(404);
        }

        //  SEO rendered by Laravel (inspect-visible)
        return view('layouts.app', compact('seo'));
    }
}
```

---


##  Step 6: Update Routes (web.php)

```php
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeoController;

// Home Route
Route::get('/', [SeoController::class, 'show'])->name('home');

// Angular Catch-All (ONLY for frontend routing if needed)
Route::get('/app/{any}', [SeoController::class, 'index'])
    ->where('any', '.*');



// SEO pages (about-us, services etc.)
Route::get('/{slug}', [SeoController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('seo.page');
```

---


##  Step 7: Create Blade Layout (app.blade.php)

File: resources/views/layouts/app.blade.php

```html
<!DOCTYPE html>
<html lang="en" ng-app="seoApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ========================= -->
    <!-- Laravel SEO (Visible in view source) -->
    <!-- ========================= -->
    <title>{{ $seo->title }}</title>

    <meta name="description" content="{{ $seo->description }}">
    <meta name="keywords" content="{{ $seo->keywords }}">

    <!-- Open Graph -->
    <meta property="og:slug" content="{{ $seo->slug }}">
    <meta property="og:title" content="{{ $seo->title }}">
    <meta property="og:description" content="{{ $seo->description }}">
    <meta property="og:keywords" content="{{ $seo->keywords }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Required -->
    <base href="/" />

    <!-- ========================= -->
    <!-- Pass SEO data to Angular -->
    <!-- ========================= -->
    <script>
        window.seo = {
            slug: "{{ $seo->slug }}",
            title: "{{ $seo->title }}",
            description: "{{ $seo->description }}",
            keywords: "{{ $seo->keywords }}"
        };
    </script>

    <!-- ========================= -->
    <!-- AngularJS -->
    <!-- ========================= -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.min.js"></script>

    <!-- Angular App -->
    <script src="/angular/app.js"></script>
    <script src="/angular/routes.js"></script>

    <!-- Angular Controllers -->
    <script src="/angular/controllers/HomeController.js"></script>
    <script src="/angular/controllers/SeoController.js"></script>
</head>
<body>

    <div ng-view></div>

</body>
</html>
```

---


## Step 8: Create Angular Folder & Files

Create folder:

```
public/angular/
```

Inside create:

```
public/angular/app.js
public/angular/routes.js
public/angular/controllers/HomeController.js
public/angular/controllers/SeoController.js
public/angular/views/home.html
public/angular/views/about.html
```
---

##  Step 9: app.js

File: public/angular/app.js

```
var app = angular.module('seoApp', ['ngRoute']);
```

---

##  Step 10: routes.js

File: public/angular/routes.js

```
app.config(function ($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(true);

    $routeProvider
        .when('/', {
            templateUrl: '/angular/views/home.html',
            controller: 'HomeController'
        })
        .when('/about-us', {
            templateUrl: '/angular/views/about.html',
            controller: 'SeoController'
        })
        .otherwise({
            redirectTo: '/'
        });
});
```

---

##  Step 11: Controllers (js file)

### 11.1) HomeController.js

File: public/angular/controllers/HomeController.js

```
app.controller('HomeController', function($scope) {
    $scope.message = "Welcome to SEO project built with Laravel + AngularJS";
});
```

### 11.2) SeoController.js

File: public/angular/controllers/SeoController.js

```
app.controller('SeoController', function($scope) {
    $scope.seo = window.seo;
});
```

---

##  Step 12: Angular Views

### 12.1) home.html

File: public/angular/views/home.html

```
<style>
    /* ====== Modern Home Page Design ====== */
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #f4f6ff 0%, #f8fbff 100%);
  color: #1f2937;
}

.container {
  max-width: 900px;
  margin: 70px auto;
  padding: 40px 30px;
  background: rgba(255, 255, 255, 0.85);
  border-radius: 22px;
  box-shadow: 0 18px 60px rgba(20, 25, 50, 0.12);
  border: 1px solid rgba(150, 170, 210, 0.25);
  backdrop-filter: blur(10px);
}

.container h1 {
  font-size: 44px;
  font-weight: 800;
  margin-bottom: 12px;
  letter-spacing: -0.5px;
}

.container p {
  font-size: 18px;
  color: #4b5563;
  line-height: 1.7;
  margin-top: 0;
}

/* Decorative line */
.container::before {
  content: "";
  display: block;
  width: 70px;
  height: 4px;
  background: linear-gradient(90deg, #2563eb, #7c3aed);
  border-radius: 999px;
  margin-bottom: 20px;
}

/* About Us link style */
.about-link {
  display: inline-block;
  margin-top: 20px;
  padding: 10px 18px;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  color: #2563eb;
  border: 1px solid rgba(37, 99, 235, 0.35);
  transition: all 0.3s ease;
}

.about-link:hover {
  background: rgba(37, 99, 235, 0.08);
  transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
  .container {
    margin: 40px 20px;
    padding: 30px 20px;
  }

  .container h1 {
    font-size: 34px;
  }

  .container p {
    font-size: 16px;
  }
}
</style>

<div class="container">
    <h1>Welcome</h1>
    <p>This is SEO Home Page</p>

    <!-- About Us Link -->
    <a href="/about-us" class="about-link">Go to About Us</a>
</div>
```

### 12.2) about.html

File: public/angular/views/about.html

```
<style>
    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background: #f6f7fb;
        margin: 0;
        padding: 0;
    }

    .page-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 30px;
        border: 1px solid #e6e9ef;
    }

    .top-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 20px;
    }

    .top-header h1 {
        font-size: 34px;
        margin: 0;
        color: #1f2a37;
    }

    .top-header .badge {
        background: #0f74ff;
        color: #fff;
        padding: 8px 14px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 13px;
    }

    .description {
        color: #5a6470;
        font-size: 16px;
        line-height: 1.6;
        margin-top: 12px;
    }

    .divider {
        height: 1px;
        background: #e6e9ef;
        margin: 22px 0;
    }

    .seo-title {
        font-size: 20px;
        margin-bottom: 12px;
        color: #1f2a37;
    }

    .seo-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .seo-card {
        background: #f9fbff;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e6e9ef;
    }

    .seo-card h4 {
        margin: 0 0 8px 0;
        font-size: 14px;
        color: #344054;
    }

    .seo-card p {
        margin: 0;
        font-size: 14px;
        color: #2f3a45;
        word-break: break-word;
    }

    @media (max-width: 650px) {
        .seo-grid {
            grid-template-columns: 1fr;
        }

        .top-header h1 {
            font-size: 28px;
        }
    }
</style>

<div class="page-container">
    <div class="card">
        <div class="top-header">
            <h1>About Us</h1>
            <div class="badge">SEO + Angular</div>
        </div>

        <p class="description">
            Welcome to our SEO powered Angular website! This page is rendered by Angular for the user,
            while SEO meta tags are rendered by Laravel in the HTML source.
        </p>

        <div class="divider"></div>

        <div class="seo-title">SEO Data (Visible)</div>

        <div class="seo-grid">
            <div class="seo-card">
                <h4>Slug</h4>
                <p>{{ seo.slug }}</p>
            </div>

            <div class="seo-card">
                <h4>Title</h4>
                <p>{{ seo.title }}</p>
            </div>

            <div class="seo-card">
                <h4>Description</h4>
                <p>{{ seo.description }}</p>
            </div>

            <div class="seo-card">
                <h4>Keywords</h4>
                <p>{{ seo.keywords }}</p>
            </div>
        </div>
    </div>
</div>
```

---


##  Step 13: Insert SEO Data into Database Using Tinker 


### Open Tinker

Run:

```
php artisan tinker
```

### Insert SEO Data

Inside Tinker, run:

```
use App\Models\SeoPage;

SeoPage::create([
    'slug' => 'home',
    'title' => 'Home Page',
    'description' => 'This is home page description',
    'keywords' => 'home, seo, angular,',
]);

SeoPage::create([
    'slug' => 'about-us',
    'title' => 'About Us',
    'description' => 'This is About Us Page',
    'keywords' => 'about, contact',
]);
```

---

## Step 14: Run Project

```bash
php artisan serve
```

Open:

```
http://127.0.0.1:8000/
```

### Final Output

Now the SEO meta tags will dynamically change based on the slug:

/ → Home SEO meta tags

/about-us → About Us SEO meta tags

---

##  Output

### Home Page (SEO)

<img width="1919" height="1032" alt="Screenshot 2026-01-22 125515" src="https://github.com/user-attachments/assets/05787ad9-8ef8-45eb-b277-463eda2057cb" />

<img width="1915" height="971" alt="Screenshot 2026-01-22 125559" src="https://github.com/user-attachments/assets/f266f712-4617-4986-8963-e154a01be3f7" />

### About Us (SEO)

<img width="1762" height="1086" alt="image" src="https://github.com/user-attachments/assets/d89c78c0-f477-4ac0-8c5e-5e22d1048161" />

<img width="1511" height="1087" alt="Screenshot 2026-01-22 130120" src="https://github.com/user-attachments/assets/d8474888-6869-43f2-a3e9-68f7a26a15ce" />

---

Your PHP_Laravel12_Implement_SEO_Using_Angular.JS Project is Now Ready!
<<<<<<< HEAD





=======
>>>>>>> development
