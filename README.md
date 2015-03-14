# Captcha validator for Laravel

This project borns from the need of a cool captcha validator for Laravel.

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
```html <img src="{{URL::to('captcha')}}">```
