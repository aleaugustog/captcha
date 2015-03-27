# Captcha for Laravel

![Captcha](http://thytanium.info/github/captcha.png)

## Install
Edit your `composer.json` file
#### Laravel 4
```javascript
"require": {
  ...
  "thytanium/captcha": "1.*"
}
```
#### Laravel 5
```javascript
"require": {
  ...
  "thytanium/captcha": "2.*"
}
```
Run `composer update` to install the package.
Then add the following to `app.php`

```php
'providers' => array(
  ...
  'Thytanium\Captcha\CaptchaServiceProvider',
);
```

```php
'aliases' => array(
  'Captcha' => 'Thytanium\Captcha\Facades\Captcha',
);
```
Then, you have to **publish the configuration file**.
```console
php artisan vendor:publish --provider="Thytanium\Captcha\CaptchaServiceProvider"
```

## Use
To use it just put this HTML code in your form next to a text input.
```php 
<img src="{{URL::to('captcha')}}">
```

### Validate
To validate the entered text into the input, put this in your validation rules:
```php
$rules = [
  'text_input' => 'required|captcha'
];

Validator::make($rules, Input::all());
```

### Options
You can edit `config/catpcha.php` configuration file to change behavior of captcha.

#### String length
By default, string length is 6 characters.
You can change it to whatever length you want.
Remember, you might have to change width also, is not auto-calculated.
```php
'length' => 6
```
#### Width and height
By defaut, width and height are `200px` x `50px`.
You can change it to any other size.
```php
'width' => 200,
'height' => 50
```
#### Case sensitive
By default case verification is enabled.
Change it to `false` to disable it.
```php
'case_sensitive' => true
```
#### Characters case
If you want the captcha to show only upper letters, lower letters or mixed.
```php
'case' => 'upper' //For upper case letters only
'case' => 'lower' //For lower case letters only
'case' => 'mixed' //For both upper and lower case
```
#### Show letters/numbers
If you want a captcha with letters only:
```php
'letters' => true,
'numbers' => false
```
If you want a captcha with numbers only:
```php
'letters' => false,
'numbers' => true
```
If you want a captcha with both letters and numbers:
```php
'letters' => true,
'numbers' => true
```
#### Character angle
By default, character angle is 15.
This will generate an captcha with characters angle **between** 0 and 15 degrees.
Change it to whatever you want. If you want the characters in "straight" way, just put this value to 0 (zero).
```php
'angle' => 15
```
#### Separation
#### Image quality
By default, and I recommend to keep it that way, image quality is 100.
```php
'quality' => 100,
```
