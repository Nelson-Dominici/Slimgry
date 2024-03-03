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

| Validation Method | Function | Attention! |
|----------|:-------------|:-------------|
| array | The field under validation must be a PHP `array` | |
| boolean | The field under validation must be a `boolean` | Only `true` or `false` is accepted |
| email | The field under validation must be a valid `email` | <a href='https://www.php.net/manual/en/function.filter-var.php'>filter_var()</a> is used with `FILTER_VALIDATE_EMAIL` |
| gt:value | The field under validation must be greater than a `numeric` value | Only `numeric` values are validated |
| gte:value | The field under validation must be greater than or equal to a `numeric` value | Only `numeric` values are validated |
| integer | The field under validation must be an `integer` | |
| ip | The field under validation must be an IP address | <a href='https://www.php.net/manual/en/function.filter-var.php'>filter_var()</a> is used with `FILTER_VALIDATE_IP |
| max:value | The field under validation must have a maximum number of `elements` | Only `arrays`, `strings`, and `numeric` values are validated |
| min:value | The field under validation must have a minimum number of `elements` | Only `arrays`, `strings`, and `numeric` values are validated |
| nullable | The field under validation may be `null` | |
| numeric | The field under validation must be `numeric` | |
| present | The field under validation must exist in request body | |
| regex:pattern | The field under validation must match the given regular expression | |
| required | The field under validation must be present in request body and not "empty" | Values considered "empty" are `null`, `empty string` and `empty array` |
| size:value | The field under validation must have a specific number of `elements` | Only `arrays`, `strings`, and `numeric` values are validated |
| string | The field under validation must be a `string` | |
| trim | Remove white space from The field under validation | |
| uuid | The field under validation must be a valid universally unique identifier (UUID) in 4 version | |

