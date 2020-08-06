<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        foreach($user->notifications as $notification) {
            if($notification->id == $id) {
                $notification->delete();
                return $id;
            }
        }
        return false;
    }


    public function destroyAll()
    {
        $user = Auth::user();
        foreach($user->notifications as $notification) {
            $notification->delete();
        }
        return true;
    }



}
