<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Product;

use App\ProductPhoto;
use App\Settings;
use App\Users;
use Mail;
use App\Mail\UserEmail;


class ParseOLX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */function get_web_page( $url )
        {
            $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

            $options = array(

                CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
                CURLOPT_POST           =>false,        //set to GET
                CURLOPT_USERAGENT      => $user_agent, //set user agent
                CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
                CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
                CURLOPT_RETURNTRANSFER => true,     // return web page
                CURLOPT_HEADER         => false,    // don't return headers
                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                CURLOPT_ENCODING       => "",       // handle all encodings
                CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                CURLOPT_TIMEOUT        => 120,      // timeout on response
                CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            );

            $ch      = curl_init( $url );
            curl_setopt_array( $ch, $options );
            $content = curl_exec( $ch );
            $err     = curl_errno( $ch );
            $errmsg  = curl_error( $ch );
            $header  = curl_getinfo( $ch );
            curl_close( $ch );

            $header['errno']   = $err;
            $header['errmsg']  = $errmsg;
            $header['content'] = $content;
            return $header;
        }
        function slack($message, $channel, $token)
        {
            $ch = curl_init("https://slack.com/api/chat.postMessage");
            $data = http_build_query([
                "token" => $token,
                "channel" => $channel, //"#mychannel",
                "text" => $message, //"Hello, Foo-Bar channel message.",
                "username" => "MySlackBot",
            ]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            
            return $result;
        }

    public function handle()
    {
        


        $url='https://www.olx.ua/nedvizhimost/kvartiry-komnaty/prodazha-kvartir-komnat/pol/?utm_medium=cpc&utm_source=AdWords&utm_campaign=Brand%40_OLX_Poltavskaya_Oblast_Branding_Search_Adwords_Desktop&utm_content=%D0%9E%D0%9B%D0%A5&utm_term=%2B%D0%BE%D0%BB%D1%85&gclid=EAIaIQobChMI7YWdwKiZ2wIVE4GyCh17JQh4EAAYASAAEgLcHvD_BwE';
        
        $userSessions=Users::selectUserIdSession();
        foreach ($userSessions as $userSession) {
            $userIdForSettings=$userSession->id;

            $settings=Settings::selectSettingsForLink($userIdForSettings);
            
            if (!empty($settings)) {
                $floorFrom=$settings->floor_from;
                $floorTo=$settings->floor_to;
                $priceFrom=$settings->price_from;
                $priceFrom = str_replace(' грн', '', $priceFrom);
                $priceTo=$settings->price_to;
                $priceTo= str_replace(' грн', '', $priceTo);
                $numberOfRoomsFrom=$settings->number_of_rooms_from;
                $numberOfRoomsTo=$settings->number_of_rooms_to;
                
                if (
                !empty($floorFrom) || 
                !empty($floorTo) || 
                !empty($priceFrom) || 
                !empty($priceTo) || 
                !empty($numberOfRoomsFrom) || 
                !empty($numberOfRoomsTo)
                ) {
                    $url='https://www.olx.ua/nedvizhimost/kvartiry-komnaty/prodazha-kvartir-komnat/pol/';
                    $sign='?';
                    if (!empty($floorFrom)) {
                        $url.=$sign.'search%5Bfilter_float_floor%3Afrom%5D='.$floorFrom;
                        $sign='used';
                    }
                    if (!empty($floorTo)) {
                        if ($sign=='used') {
                            $sign='&';
                        }
                        $url.=$sign.'search%5Bfilter_float_floor%3Ato%5D='.$floorTo;
                        $sign='used';
                    }
                    if (!empty($priceFrom)) {
                        if ($sign=='used') {
                            $sign='&';
                        }
                        $url.=$sign.'search%5Bfilter_float_price%3Afrom%5D='.$priceFrom;
                        $sign='used';
                    }
                    if (!empty($priceTo)) {
                        if ($sign=='used') {
                            $sign='&';
                        }
                        $url.=$sign.'search%5Bfilter_float_price%3Ato%5D='.$priceTo;
                        $sign='used';
                    }
                    if (!empty($numberOfRoomsFrom)) {
                        if ($sign=='used') {
                            $sign='&';
                        }
                        $url.=$sign.'search%5Bfilter_float_number_of_rooms%3Afrom%5D='.$numberOfRoomsFrom;
                        $sign='used';
                    }
                    if (!empty($numberOfRoomsTo)) {
                        if ($sign=='used') {
                            $sign='&';
                        }
                        $url.=$sign.'search%5Bfilter_float_number_of_rooms%3Ato%5D='.$numberOfRoomsTo;
                    }  
                }
            }

            
            
        

            $linkCommand=$this->get_web_page( $url );

            $dom = new \DomDocument;
            $internalErrors = libxml_use_internal_errors(true);
            $dom->loadHTML($linkCommand["content"]);
            $dom->preserveWhiteSpace = false;
            $tables = $dom->getElementById ('offers_table');
            $smallTables = $tables->getElementsByTagName('table');

            

            foreach ($smallTables as $smallTable) {
                $td = $smallTable->getElementsByTagName('td');
                $a = $td->item(1)->getElementsByTagName('a');
                $linkFlat = $a->item(0)->getAttribute('href');
                $comparison=$this->selectFlatDataForComparison($linkFlat);
                
                if (empty($comparison)) {
                    
                    $strong = $td->item(2)->getElementsByTagName('strong')->item(0)->nodeValue;
                    $strongReplace = str_replace(' грн.', '', $strong);
                    $price = str_replace(' ', '', $strongReplace);
                    
                    $priseCommand=$this->get_web_page( $linkFlat );
                    $dom->loadHTML($priseCommand["content"]);
                    $priseId = $dom->getElementById ('offeractions');
                    $priseDiv = $priseId->getElementsByTagName('div');
                    $priceFlat = $priseDiv->item(0)->getElementsByTagName('strong')->item(0)->nodeValue;

                    $shortDescriptionCommand=$this->get_web_page( $linkFlat );
                    $dom->loadHTML($shortDescriptionCommand["content"]);
                    $shortDescriptionId = $dom->getElementById ('offerdescription');
                    $shortDescriptionH1 = $shortDescriptionId->getElementsByTagName('h1')->item(0)->nodeValue;
                    $shortDescriptionFlat=trim($shortDescriptionH1);

                    $descriptionCommand=$this->get_web_page( $linkFlat );
                    $dom->loadHTML($descriptionCommand["content"]);
                    $descriptionId = $dom->getElementById ('textContent');
                    $descriptionP = $descriptionId->getElementsByTagName('p')->item(0)->nodeValue;
                    $descriptionFlat=trim($descriptionP);

                    $commonDataCommand=$this->get_web_page( $linkFlat );
                    $dom->loadHTML($commonDataCommand["content"]);
                    $commonDataId = $dom->getElementById ('offerdescription');
                    $commonDataTable = $commonDataId->getElementsByTagName('table');
                    $commonDataTrs = $commonDataTable->item(0)->getElementsByTagName('tr');
                    foreach ($commonDataTrs as $commonDataTr) {
                        $commonDataSmallTables = $commonDataTr->getElementsByTagName('table');
                        
                        foreach ($commonDataSmallTables as $commonDataSmallTable) {
                            $commonDataTh = $commonDataSmallTable->getElementsByTagName('th')->item(0)->nodeValue;
                            $commonDataValue=trim($commonDataTh);
                            
                            if ($commonDataValue=='Этажность') {
                                $numberOfFloorsStrong = $commonDataSmallTable->getElementsByTagName('strong')->item(0)->nodeValue;
                                $numberOfFloorsFlat=trim($numberOfFloorsStrong);
                            }
                            elseif ($commonDataValue=='Этаж') {
                                $floorsStrong = $commonDataSmallTable->getElementsByTagName('strong')->item(0)->nodeValue;
                                $floorsFlat=trim($floorsStrong);
                            }
                            elseif ($commonDataValue=='Количество комнат') {
                                $numberOfRoomsStrong = $commonDataSmallTable->getElementsByTagName('strong')->item(0)->nodeValue;
                                $numberOfRoomsFlat=trim($numberOfRoomsStrong);
                            }
                            elseif ($commonDataValue=='Общая площадь') {
                                $areaStrong = $commonDataSmallTable->getElementsByTagName('strong')->item(0)->nodeValue;
                                $areaFlat=trim($areaStrong);
                            }
                        }
                    }

                    $MainPhotoCommand=$this->get_web_page( $linkFlat );
                   
                    $dom->loadHTML($MainPhotoCommand["content"]);
                    $MainPhotoId = $dom->getElementById ('photo-gallery-opener');
                    
                    $MainPhotoImg = $MainPhotoId->getElementsByTagName('img');
                    
                        
                    if ($MainPhotoImg->length=='0') {
                        $MainPhotoSrc='https://static-olxeu.akamaized.net/static/olxua/packed/img/2f91eb96754771ba16eac88d5cb09f654a.png';
                    }
                    else {
                        $MainPhotoSrc = $MainPhotoImg->item(0)->getAttribute('src');
                    }

                    $this->addFlatData($linkFlat, $price, $shortDescriptionFlat, $descriptionFlat, $numberOfFloorsFlat, $floorsFlat, $numberOfRoomsFlat, $areaFlat);
                    


                    $flatId=Product::selectFlatId($linkFlat);
                    $idFlat=$flatId->id;
                   
                    $photosCommand=$this->get_web_page( $linkFlat );
                    $dom->loadHTML($photosCommand["content"]);
                    $photosId = $dom->getElementById ('offerdescription');
                    $photosDivs = $photosId->getElementsByTagName('div');
                    foreach ($photosDivs as $photosDiv) {
                        $photosDivClass = $photosDiv->getAttribute('class');
                        if ($photosDivClass=='tcenter img-item') {
                            $Div=$photosDiv->getElementsByTagName('div');
                            $photosImg = $Div->item(0)->getElementsByTagName('img');
                            if ($photosImg->length=='0') {
                                $photosSrc='https://static-olxeu.akamaized.net/static/olxua/packed/img/2f91eb96754771ba16eac88d5cb09f654a.png';
                            }
                            else {
                                $photosSrc = $photosImg->item(0)->getAttribute('src');
                            }
                            $this->addMainPhoto($photosSrc, $idFlat);
                        }
                    }

                    $this->addMainPhoto($MainPhotoSrc, $idFlat);

                    $userInformations=Users::selectUserInformation();

                    foreach ($userInformations as $userInformation) {
                        $id=$userInformation->id;
                        $name=$userInformation->name;
                        $email=$userInformation->email;
                        $notification=$userInformation->email_notifications;
                        $slack=$userInformation->slack_notifications;
                        $channelName=$userInformation->channel_name;
                        $slackToken=$userInformation->slack_link;
                        $message=$name.', появилась новая квартира!!! Вот она: '.$linkFlat;

                        if ($notification=='1') {
                            Mail::to($email)->send(new \App\Mail\UserEmail($name));
                        }

                        if ($slack=='1') {
                            $this->slack($message, $channelName, $slackToken);
                        }
                    } 
                }
                
            }   
        }
    }

    public function addFlatData($linkFlat, $price, $shortDescriptionFlat, $descriptionFlat, $numberOfFloorsFlat, $floorsFlat, $numberOfRoomsFlat, $areaFlat)
    {
        
        Product::insertFlatData($linkFlat, $price, $shortDescriptionFlat, $descriptionFlat, $numberOfFloorsFlat, $floorsFlat, $numberOfRoomsFlat, $areaFlat);
        
    }

    public function addMainPhoto($MainPhotoSrc, $idFlat)
    {
       
        ProductPhoto::insertMainPhoto($MainPhotoSrc, $idFlat);
    }

    public function selectFlatDataForComparison($linkFlat)
    {   

        return Product::flatDataForComparison($linkFlat);
    }

}


