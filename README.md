# Captcha for Laravel

![Captcha](http://thytanium.info/github/captcha.png)

## Install
Edit your `composer.json` file
### Laravel 4
```javascript
"require": {
  ...
  "thytanium/captcha": "1.*"
}
```
### Laravel 5
```javascript
"require": {
  ...
  "thytanium/captcha": "2.*"
}
```
Then, run `composer update` to install the package.

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
