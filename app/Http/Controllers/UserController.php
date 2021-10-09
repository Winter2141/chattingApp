<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function show(Request $request)
    {   
        $address = "auto";
        if($request->has("address")){
            $address = $request->get("address");
        }
        $config = array();
        $config['center'] = $address;
        $config['onboundschanged'] = 'if (!centreGot) {
                var mapCentre = map.getCenter();
                marker_0.setOptions({
                    position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
                });
            }
            centreGot = true;';
        /*$config['zoom'] = '14';
        $config['map_height'] = '400px';
        $config['geocodeCaching'] = true;*/
    
        app('map')->initialize($config);
    
        // set up the marker ready for positioning
        // once we know the users location
        $marker['position'] = $address;
        $marker['infowindow_content'] = $address;
        app('map')->add_marker($marker);

        /*$marker['position'] = 'The Lakes Golf Club,Sydney';
        $marker['infowindow_content'] = 'The Lakes Golf Club,Sydney';
        app('map')->add_marker($marker);*/
    
        $map = app('map')->create_map();
        $user = User::findOrFail(auth()->id());
        return view('profile.index', [
            'user'=>$user,
            'map'=>$map
        ]);
    }

    public function udpate(Request $request)
    {
        $download_file = $request->file('vfile');
        $new_filename = Str::random(40).'.'. $download_file->getClientOriginalExtension();
        $path = $request->file('vfile')->storeAs('public/temp', $new_filename);

        if(isset($new_filename) && Storage::disk('temp')->has($new_filename)) {
            $file = Storage::disk('temp')->get($new_filename);
            Storage::disk('users')->put(auth()->id().'/'.$new_filename, $file);
            $user = User::findOrFail(auth()->id());

            $user->avatar = $new_filename;

            $user->save();
        }

        die($new_filename);
    }

    public function mapControl()
    {
    }
}
