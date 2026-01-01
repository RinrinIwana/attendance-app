<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class StaffController extends Controller
{
    public function list()
    {
        // 一般ユーザーのみ表示（adminは除外）
        $users = User::where('role', 'user')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.staff.list', compact('users'));
    }
}
