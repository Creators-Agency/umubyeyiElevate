<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\Program;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    
    public function analyticsData() {

        $clients = User::where('status',1)->count();
        $categories = Category::where('status',1)->count();
        $numberOfFocus = Program::where('status',1)->count();
        $numberOfPackage = Package::where('status',1)->count();
        $values = Subscription::selectRaw("count(*) as transaction, YEAR(created_at) AS year, DATE_FORMAT(created_at, '%b') AS month")
                    ->groupby('year', 'month')
                    ->where('status', 1)
                    ->get();

        $data = [];
        $labels = [];

        foreach ($values as $value) {
            array_push($data, $value->transaction);
            array_push($labels, $value->month);
        }

        return response()->json([
            'message' => 'Successfully fetched all Companies',
            'payload' => array(
                'clients'=> $clients,
                'programs' => $categories,
                'analytics'=>array(
                    'label'=>$labels,
                    'dataset'=>$data
                ),
                'focus' =>$numberOfFocus,
                'packages' => $numberOfPackage
            ),
            'status' => 200,
        ]);
    }
}