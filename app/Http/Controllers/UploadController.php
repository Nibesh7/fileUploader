<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Exports\User\UserExport;
use App\Jobs\ProcessUserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function uploadJson(Request $request)
    {

        try {
            $file = $request->file('json_file');

            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            $filePath = 'uploads/'.$fileName;
            $absolutePath = public_path($filePath);

            if (File::exists($absolutePath)) {
                $datas = json_decode(file_get_contents($absolutePath));
                if(!$datas) return redirect()->back()->with('error', "Invalid file");
                ProcessUserData::dispatch($datas);

                return redirect()->back()->with('success', 'Data processing has been queued');

            } else {
                return response()->json(['error' => 'File not found.'], 404);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());

        }


    }

    public function exportData() {
        $userId = Auth::user()->id;
        $users = User::where('id', '!=', $userId)->get();
        return Excel::download((new UserExport($users)), "users.xlsx");

        return view('user', ['users' => $users]);

    }
}
