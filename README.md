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
#### Letters case
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
This is characters separation. Default is 30. **The higher the more separated**.
```php
'separation' => 30,
```
#### Background grid
By default, background shows 20 vertical lines and 5 horizontal lines (one every 10 pixels).
You can show as many lines as you want.
```php
'h_lines' => 5, //Horizontal lines
'v_lines' => 20 //Vertical lines
```
#### Colors
Colors must be provided in RGB notation [rrr,ggg,bbb].
##### Background color
By default is [250,250,250] (almost white)
```php
'background' => [250, 250, 250]
```
##### Line color
By default is [220,220,220] (very light gray)
```php
'line_color' => [220, 220, 220]
```
##### Font colors
This is an `array` of choices. You can add as many colors as you want and the characters will rendered is this colors randomly.
```php
'colors' => [
    [0, 83, 160],
    [33, 125, 211],
    [30, 134, 232],
    [11, 72, 130],
    [13, 119, 219],
    [0, 102, 150],
    [51, 113, 142],
],
```
### Font
This package works with **TrueType (.ttf) fonts**.

Four font choices are already provided: `Prototype` (default), `Impact`, `BrianJames` and `Spinwerad`. All of them thanks to [1001freefonts](http://www.1001freefonts.com).

##### Prototype
```php
'font' => 'Prototype' //Ignore .ttf extension
```
![Prototype](http://thytanium.info/github/C_Prototype.png)
##### Impact
```php
'font' => 'Impact' //Ignore .ttf extension
```
![Impact](http://thytanium.info/github/C_Impact.png)
##### BrianJames
```php
'font' => 'BrianJames' //Ignore .ttf extension
```
![BrianJames](http://thytanium.info/github/C_BrianJames.png)
##### Spinwerad
```php
'font' => 'Spinwerad' //Ignore .ttf extension
```
![Spinwerad](http://thytanium.info/github/C_Spinwerad.png)
#### Font size
By default, font size is `20px`. Change it to whatever you want.
```php
'size' => 30
```
#### Image quality
By default, and I recommend to keep it that way, image quality is 100.
```php
'quality' => 100,
```
