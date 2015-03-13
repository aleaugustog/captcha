<?php

namespace Thytanium\Captcha;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\URL;

class Captcha
{
    /**
     * Selected font
     * @var string
     */
    protected $font;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var SessionManager
     */
    protected $session;

    /**
     * @var string
     */
    protected $storeKey = 'captchaHash';

    /**
     * Class constructor
     * @param Repository $config
     * @param SessionManager $session+
     */
    public function __construct(Repository $config, SessionManager $session)
    {
        $this->config = $config;
        $this->session = $session;

        //Load font
        $this->font = __DIR__.'/../../../public/'
            .$this->config->get('captcha::fonts_path')
            .'/'.$this->config->get('captcha::font').'.ttf';
    }

    /**
     * Check if string matches captcha
     * @param $string
     * @param $formId
     * @return bool
     */
    public function check($string, $formId = null)
    {
        if (empty($formId)) {
            //$formId = $this->fromCurrentUrl();
            $formId = $this->fromAppKey();
        }

        $hash = $this->session->get("{$this->storeKey}.{$formId}");

        return $this->hash(
            $this->config->get('captcha::case_sensitive') ? $string : strtolower($string)
        ) == $hash;
    }

    /**
     * Create captcha image
     * @param null $formId
     */
    public function create($formId = null)
    {
        //Generate formId
        if (empty($formId)) {
            //$formId = $this->fromPreviousUrl();
            $formId = $this->fromAppKey();
        }

        //Generate random string
        $string = $this->randomString(
            $this->config->get('captcha::length'),
            $this->config->get('captcha::letters') && $this->config->get('captcha::numbers') ? 1 :
                ($this->config->get('captcha::letters') ? 2 : 3),
            $this->config->get('captcha::case') == 'upper' ? 2 :
                ($this->config->get('captcha::case') == 'lower' ? 3 : 1)
        );

        //Store in session
        $this->session->put(
            "{$this->storeKey}.{$formId}",
            $this->hash($this->config->get('captcha::case_sensitive') ? $string : strtolower($string))
        );

        //Colors
        $colors = $this->config->get('captcha::colors');

        //Create image
        $image = imagecreatetruecolor(
            $this->config->get('captcha::width'),
            $this->config->get('captcha::height')
        );

        //Colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $light = imagecolorallocate($image, 220, 220, 220);

        //Background
        imagefilledrectangle(
            $image,
            0,
            0,
            $this->config->get('captcha::width'),
            $this->config->get('captcha::height'),
            $white
        );

        //Background Horizontal lines
        for ($i = 1; $i < $this->config->get('captcha::h_lines'); $i++) {
            imageline(
                $image,
                0,
                ($this->config->get('captcha::height')/$this->config->get('captcha::h_lines'))*$i,
                $this->config->get('captcha::width'),
                ($this->config->get('captcha::height')/$this->config->get('captcha::h_lines'))*$i,
                $light
            );
        }

        //Background Vertical lines
        for ($i = 1; $i < $this->config->get('captcha::v_lines'); $i++) {
            imageline(
                $image,
                ($this->config->get('captcha::width')/$this->config->get('captcha::v_lines'))*$i,
                0,
                ($this->config->get('captcha::width')/$this->config->get('captcha::v_lines'))*$i,
                $this->config->get('captcha::height'),
                $light
            );
        }

        //Text
        for ($i = 0; $i < $this->config->get('captcha::length'); $i++) {
            $color = $colors[rand(0,count($colors)-1)];

            imagettftext(
                $image,
                $this->config->get('captcha::size'),
                rand(-$this->config->get('captcha::angle'), $this->config->get('captcha::angle')),
                10+($i*$this->config->get('captcha::separation')),
                $this->config->get('captcha::size')+10,
                imagecolorallocate($image, $color[0], $color[1], $color[2]),
                $this->font,
                substr($string, $i, 1)
            );
        }

        //Stream
        header('Content-Type: image/jpeg');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        imagejpeg($image, null, $this->config->get('captcha::quality'));
        imagedestroy($image);
    }

    /**
     * Generates a random string
     * @param $length
     * @param int $mode 1 = mixed | 2 = only letters | 3 = only numbers
     * @param int $case 1 = mixed | 2 = upper | 3 = lower
     * @return string
     */
    private function randomString($length, $mode = 1, $case = 1)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz";
        $numbers = "23456789"; //Ignore 0 & 1 because look like O & L
        $haystack = $string = "";

        switch ($mode) {
            default:
                $haystack = $chars.$numbers;
                break;
            case 2:
                $haystack = $chars;
                break;
            case 3:
                $haystack = $numbers;
        }

        for ($i = 0; $i < $length; $i++) {
            $char = substr($haystack, rand(0, strlen($haystack)-1), 1);

            if ($case == 2 || ($case == 1 && rand(0, 9) > 4)) {
                $char = strtoupper($char);
            }

            $string .= $char;
        }

        return $string;
    }

    /**
     * Generate form hash
     * @return string
     */
    private function fromCurrentUrl()
    {
        return $this->hash(URL::current());
    }

    /**
     * Generate form hash
     * @return string
     */
    private function fromPreviousUrl()
    {
        return $this->hash(URL::previous());
    }

    /**
     * Generate app key hash
     * @return string
     */
    private function fromAppKey()
    {
        return $this->hash($this->config->get('app.key'));
    }

    /**
     * Hash captcha string
     * @param $string
     * @return string
     */
    private function hash($string)
    {
        return hash('sha256', $string);
    }
}