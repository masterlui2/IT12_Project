<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.contents.dashboard');
    }

    public function systemManagement(){
        return view('admin.contents.system-management');
    }

    public function userAccess(){
        return view('admin.contents.users-access');
    }

    public function activity(){
        return view('admin.contents.activity-log');
    }

    public function analytics(){
        return view('admin.contents.analytics');
    }

    public function developerTools(){
        return view('admin.contents.developer-tools');
    }

    public function documentation(){
        return view('admin.contents.documentation');
    }
}
