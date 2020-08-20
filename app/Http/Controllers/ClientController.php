<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cloudinary;

class ClientController extends Controller
{
	protected $data;

	protected $pictureClass;
	protected $pictureForeignId;
	protected $pictureChildForeignId;

    public function __construct()
    {
        $this->data['sideBar'] = '';
    }

    protected function initCloudinary($max)
    {
        $this->makeConfigCloudinary();

        return [
            'tag'           => $this->getCloudinaryTag($max),
            'script_config' => cloudinary_js_config(),
        ];
    }

    protected function getCloudinaryTag($max)
    {
        $this->makeConfigCloudinary();
        if( max($max, 0) == 0 )
        {
            return '';
        }
        else
        {
            return cl_image_upload_tag('image_id', [
                'html' => [ 
                    'multiple' => '',
                    'accept'   => 'image/*',
                    'class'    => 'form-control d-none'
                ],
                "chunk_size" => 2000000,
            ]);
        }
    }

    protected function saveImages($pictures, $folder)
    {
        $this->makeConfigCloudinary();

    	// create both cURL resources
        $resources = [];
        foreach ($pictures as $picture)
        {
            $resource = array (
                'largeHandle' => curl_init(),
                'smallHandle' => curl_init(),
                'path'        => $picture->path,
            );

            $largeUrl = cloudinary_url( $resource['path'], array("quality"=>"auto:eco", "width"=>800, "crop"=>"limit", "format"=>"jpg") );
            $smallUrl = cloudinary_url( $resource['path'], array("quality"=>"auto:low", "width"=>200, "crop"=>"limit", "format"=>"jpg") );

            // set URL and other appropriate options
            curl_setopt($resource['largeHandle'], CURLOPT_URL, $largeUrl);
            curl_setopt($resource['smallHandle'], CURLOPT_URL, $smallUrl);
            
            curl_setopt($resource['largeHandle'], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($resource['smallHandle'], CURLOPT_RETURNTRANSFER, 1);
            
            $picture->path         .= '_' . uniqid() . '.jpg';
            $resource['local_path'] = $picture->path;

            $resources[] = $resource;
        }

        //create the multiple cURL handle
        $mh = curl_multi_init();

        //add the two handles
        foreach ($resources as $resource)
        {
            curl_multi_add_handle($mh, $resource['largeHandle']);
            curl_multi_add_handle($mh, $resource['smallHandle']);
        }

        //execute the multi handle  
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        //close the handles
        foreach ($resources as $resource)
        {
            curl_multi_remove_handle($mh, $resource['largeHandle']);
            curl_multi_remove_handle($mh, $resource['smallHandle']);
        }
        curl_multi_close($mh);

        // all of our requests are done, we can now access the results
        foreach ($resources as $resource)
        {
            $large = curl_multi_getcontent($resource['largeHandle']);
            $small = curl_multi_getcontent($resource['smallHandle']);
        
            Storage::disk('public')->put($folder . '/large/' . $resource['local_path'], $large);
            Storage::disk('public')->put($folder . '/small/' . $resource['local_path'], $small);
        }

        return $pictures;
    }

    private function makeConfigCloudinary()
    {
        Cloudinary::config([
            "cloud_name" => "du2zijtxl",
            "api_key" => "178797857132988",
            "api_secret" => "xEc9_7_fNlrdZ72OWZVYS7Wl30o",
            "secure" => true
        ]);
    }

}
