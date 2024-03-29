<?php

namespace App\Http\Controllers\Exports\User;
use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
{
    private $_users;
    public function __construct($users)
    {
        $this->_users = $users;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('user', [
            'users'=>$this->_users,
        ]);
    }


}
