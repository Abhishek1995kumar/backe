<?php

namespace App\Traits;

use Faker\Provider\UserAgent;
use Throwable;
use Illuminate\Support\Facades\Log;

trait UserActivityLogTraits {
    public function __construct() {
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    public function getIpAddressTrait() {
        try {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP'])){
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];

            } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

            } else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];

            } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

            } else if(isset($_SERVER['HTTP_FORWARDED'])) { 
                $ipaddress = $_SERVER['HTTP_FORWARDED'];

            } else if(isset($_SERVER['REMOTE_ADDR'])) {
                $ipaddress = $_SERVER['REMOTE_ADDR'];

            } else {
                $ipaddress = 'UNKNOWN';
            }
            return $ipaddress;
        } catch(Throwable $th) {
            Log::error([$th->getMessage()]);
        }
    }

    public function getBrowserNameTrait() {
        try {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $browser = "Unknown Browser";
            $browserArray = array(
                '/msie/i'  => 'Internet Explorer',
                '/Trident/i'  => 'Internet Explorer',
                '/firefox/i'  => 'Firefox',
                '/safari/i'  => 'Safari',
                '/chrome/i'  => 'Chrome',
                '/edge/i'  => 'Edge',
                '/opera/i'  => 'Opera',
                '/netscape/'  => 'Netscape',
                '/maxthon/i'  => 'Maxthon',
                '/knoqueror/i'  => 'Konqueror',
                '/ubrowser/i'  => 'UC Browser',
                '/mobile/i'  => 'Safari Browser',
            );

            foreach($browserArray as $regex => $value){
                if(preg_match($regex, $userAgent)){
                    $browser = $value;
                }
            }
            return $browser;

        } catch(Throwable $th) {

        }
    }

    public function getDeviceNameTrait() {
        try {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            /*
            $deviceTypes = [
                'Mobile' => 'mobile',
                'Tablet' => 'tablet',
                'Laptop' => 'laptop',
                'Desktop' => 'desktop',
            ];

            foreach ($deviceTypes as $deviceName => $identifier) {
                if (stripos($this->userAgent, $identifier) !== false) {
                    dd($deviceName . ' Device');
                    return $deviceName . ' Device';
                }
            } */

            /* if(stripos($userAgent, 'mobile') !== false) {
                return 'Mobile Device';

            } elseif(stripos($userAgent, 'tablet') !== false) {
                return 'Tablet Device';
                
            } elseif(stripos($userAgent, 'desktop') !== false) {
                return 'Desktop Device';

            } else {
                return 'Laptop Device';
            } */
           
            $tabletBrowser = 0;
            $mobileBrowser = 0;

            if(preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))){
                $tabletBrowser++;
            }

            if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))){
                $mobileBrowser++;
            }

            if((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml')> 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))){
                        $mobileBrowser++;
            }

  			$mobileUa = strtolower(substr($userAgent, 0, 4));
  			$mobileAgents = array(
  				'w3c','acs-','alav','alca','amoi','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
  				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',

  				'newt','noki','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',

  				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
  				'wapr','webc','winw','winw','xda','xda-');

  				if(in_array($mobileUa,$mobileAgents)){
  					$mobileBrowser++;
  				}

  				if(strpos(strtolower($userAgent),'opera mini') > 0){
  					$mobileBrowser++;
  					//Check for tables on opera mini alternative headers

  					$stockUa = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?
  					$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:
  					(isset($_SERVER['HTTP_DEVICE_stockUa'])?
  					$_SERVER['HTTP_DEVICE_stockUa']:''));

  					if(preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stockUa)){
  						$tabletBrowser++;
  					}
  				}

  				if($tabletBrowser > 0){
  					return 'Tablet';
  				}
  				else if($mobileBrowser > 0){
  					return 'Mobile';
  				} elseif($mobileBrowser > 0){
  					return 'Computer';
  				} else {
                    return 'Laptop';
                }

        
            } catch(Throwable $th) {
            return 'Error detecting device type';
        }
    }

    public function getOpertingSystemTrait() {
        try {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $osPlatform = "Unknown OS Platform";
            $osArray = array(
                '/windows nt 10/i'  => 'Windows 10',
                '/windows nt 6.3/i'  => 'Windows 8.1',
                '/windows nt 6.2/i'  => 'Windows 8',
                '/windows nt 6.1/i'  => 'Windows 7',
                '/windows nt 6.0/i'  => 'Windows Vista',
                '/windows nt 5.2/i'  => 'Windows Server 2003/XP x64',
                '/windows nt 5.1/i'  => 'Windows XP',
                '/windows xp/i'  => 'Windows XP',
                '/windows nt 5.0/i'  => 'Windows 2000',
                '/windows me/i'  => 'Windows ME',
                '/win98/i'  => 'Windows 98',
                '/win95/i'  => 'Windows 95',
                '/win16/i'  => 'Windows 3.11',
                '/macintosh|mac os x/i' => 'Mac OS X',
                '/mac_powerpc/i'  => 'Mac OS 9',
                '/linux/i'  => 'Linux',
                '/ubuntu/i'  => 'Ubuntu',
                '/iphone/i'  => 'iPhone',
                '/ipod/i'  => 'iPod',
                '/ipad/i'  => 'iPad',
                '/android/i'  => 'Android',
                '/blackberry/i'  => 'BlackBerry',
                '/webos/i'  => 'Mobile',
            );
  
            foreach ($osArray as $regex => $value){
                if(preg_match($regex, $userAgent)){
                    $osPlatform = $value;
                }
            }
            return $osPlatform;

        } catch(Throwable $th) {
            return 'Error detecting operating system';
        }
    }

    public function getLocationTrait() {
        try {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $apiURL = "http://ipinfo.io/{$ipAddress}/json";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            if($response) {
                $data = json_decode($response, true);
                if (isset($data['bogon']) && $data['bogon'] === true) {
                    return 'Local or private IP - location data unavailable';
                }
                
                $city = $data['city'] ?? 'Unknown City';
                // $region = $data['region'] ?? 'Unknown Region';
                // $country = $data['country'] ?? 'Unknown Country';
        
                // return $city . ', ' . $region . ', ' . $country;
                return $city;
            }

        } catch(Throwable $th) {
            
        }
    }
}