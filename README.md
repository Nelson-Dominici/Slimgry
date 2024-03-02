<div align="center" style=" height: 100vh">
  <img src="https://github.com/Nelson-Dominici/Blog-API/assets/89428967/4abb20fb-269f-46ac-84bb-a115ad4a80f8" alt="Descrição da Imagem" style="width: 565px; height:295px;"> 
  <br>
  <img src="https://img.shields.io/badge/License-MIT-white.svg?style=flat-square" alt="License: MIT">
  <img src="https://img.shields.io/badge/php-%3E%3D%208.2-7377ac?style=flat-square" alt="Requires PHP ^8.2">
  <img src="https://img.shields.io/badge/Slim_Framework-%3E%3D%204-6D9C3C?style=flat-square" alt="Requires Slim Framework >=   4">

</div>

<h3>Slimgry is a <strong>validation middleware</strong> for the <a href='https://www.slimframework.com/'>Slim framework</a>, which validates the request body, with validation syntax similar to <a href='https://laravel.com/docs/10.x/validation'>Laravel</a>.</h3>

<h2>Install</h2>

```bash
$ composer require nelsondominici/slimgry
```

<h2>Usage</h2>

To add validations to a route, add the `NelsonDominici\Slimgry\Slimgry` middleware with the validations in the constructor.<br>
If any validation method fails, an `NelsonDominici\Slimgry\Exceptions\ValidationMethodException` exception will be thrown.<br>

```php
use NelsonDominici\Slimgry\Slimgry;

$app->post('/api/auth', [AuthController::class, 'login'])->add(new Slimgry(
    [
        'email' => ['required','email','trim','string','min:3','max:100'],
        'password' => ['required','trim','string','min:6','max:100']
    ]
));
```
You can also use `|`.
```php
[
    'email' => 'required|email|trim|string|min:3|max:100',
    'password' => 'required|trim|string|min:6|max:100'
]
```

## Validating nested fields
You can use "dot notation" to validate nested fields, example:

```php
[
    'users.adm.email' => ['required','email','trim','string','min:3','max:100'],
    'users.adm.password' => ['required','trim','string','min:6','max:100'],
]
```

## Adding custom message when validation method fails
Add a second array in the Slimgry class to store custom messages, choose which field the message refers to along with a "dot" and the validation method that failed.
```php
use NelsonDominici\Slimgry\Slimgry;

$app->post('/api/auth', [AuthController::class, 'auth'])->add(new Slimgry(
    [
        'email' => ['required','email','trim','string','min:3','max:100'],
        'password' => ['required','trim','string','min:6','max:100']
    ],
    [
        'email.email' => 'We need a valid email.',
        'password.required' => 'We need your password.'
    ]
));
```

## Validation Methods List

`string`: 
