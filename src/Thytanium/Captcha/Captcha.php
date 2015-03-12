<?php

namespace Thytanium\Captcha;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;

class Captcha
{
    protected $font;

    protected $config;

    protected $session;

    public function __construct(Repository $config, SessionManager $session)
    {
        $this->config = $config;
        $this->session = $session;

        //Load font
        $this->font = __DIR__.'/../../../public/'
            .$this->config->get('captcha::fonts_path')
            .'/'.$this->config->get('captcha::font').'.ttf';
    }

    public function create($formId = null)
    {
        $string = str_random($this->config->get('captcha::length'));

        //Colors
        $colors = $this->config->get('captcha::colors');

        //Create image
        $image = imagecreatetruecolor(
            $this->config->get('captcha::width'),
            $this->config->get('captcha::height')
        );

        //Colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $dark = imagecolorallocate($image, 20, 20, 20);

        //Background
        imagefilledrectangle(
            $image,
            0,
            0,
            $this->config->get('captcha::width'),
            $this->config->get('captcha::height'),
            $white
        );

        //Text
        for ($i = 0; $i < $this->config->get('captcha::length'); $i++) {
            $color = $colors[rand(0,count($colors)-1)];

            imagettftext(
                $image,
                $this->config->get('captcha::size'),
                rand(-$this->config->get('captcha::angle'), $this->config->get('captcha::angle')),
                10+($i*30),
                $this->config->get('captcha::size')+10,
                imagecolorallocate($image, $color[0], $color[1], $color[2]),
                $this->font,
                substr($string, $i, 1));
        }

        //Stream
        header('Content-Type: image/jpeg');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        imagejpeg($image, null, $this->config->get('captcha::quality'));
        imagedestroy($image);
        imagecolordeallocate($image, $white);
        imagecolordeallocate($image, $dark);
    }
}