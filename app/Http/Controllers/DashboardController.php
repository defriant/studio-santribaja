<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function fetch_today_visitor()
    {
        $chart = [
            [
                "from" => "00:00",
                "to" => "02:00"
            ],
            [
                "from" => "02:00",
                "to" => "04:00"
            ],
            [
                "from" => "04:00",
                "to" => "06:00"
            ],
            [
                "from" => "06:00",
                "to" => "08:00"
            ],
            [
                "from" => "08:00",
                "to" => "10:00"
            ],
            [
                "from" => "10:00",
                "to" => "12:00"
            ],
            [
                "from" => "12:00",
                "to" => "14:00"
            ],
            [
                "from" => "14:00",
                "to" => "16:00"
            ],
            [
                "from" => "16:00",
                "to" => "18:00"
            ],
            [
                "from" => "18:00",
                "to" => "20:00"
            ],
            [
                "from" => "20:00",
                "to" => "22:00"
            ],
            [
                "from" => "22:00",
                "to" => "24:00"
            ],
        ];

        $visitors = Visitor::all();
        $firstVisitor = Visitor::orderBy('created_at', 'ASC')->first();
        $firstVisitor = $firstVisitor ? date('Y-m-d H:i:s', strtotime($firstVisitor->created_at)) : date('2023-01-01 00:00:00');

        $daily = $this->createDateRange(date('Y-m-d', strtotime($firstVisitor)), date('Y-m-d'));

        foreach ($visitors as $v) {
            $date = date('Y-m-d', strtotime($v->created_at));
            $cek = array_search($date, $daily);
            if ($cek === false) {
                $daily[] = $date;
            }
        }

        foreach ($chart as $key => $value) {
            $from = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . ' ' . $value["from"]));
            $to = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . ' ' . $value["to"]));
            $chart[$key]["total"] = Visitor::whereBetween('created_at', [$from, $to])->count();
            $avg = 0;
            foreach ($daily as $d) {
                $from = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($d)) . ' ' . $value["from"]));
                $to = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($d)) . ' ' . $value["to"]));
                $avg = $avg + Visitor::whereBetween('created_at', [$from, $to])->count();
            }

            $chart[$key]["average"] = intval($avg / count($daily));
        }

        $todayVisits = Visitor::whereDate('created_at', date('Y-m-d'))->count();

        $averageDaily = $visitors->count() / count($daily);

        return [
            "chart" => $chart,
            "todayVisits" => $todayVisits,
            "averageDaily" => intval($averageDaily),
            "date" => date('d F Y')
        ];
    }

    public function today_visitor()
    {
        $todayVisitorData = $this->fetch_today_visitor();

        $response = [
            "response" => "success",
            "todayChart" => $todayVisitorData["chart"],
            "todayVisits" => $todayVisitorData["todayVisits"],
            "averageDaily" => $todayVisitorData["averageDaily"],
            "date" => $todayVisitorData["date"]
        ];

        return response()->json($response);
    }

    public function fetch_yearly_visitor($request)
    {
        $year = $request["year"];

        $yearly = [
            [
                "month" => '1',
                "month_text" => "Jan"
            ],
            [
                "month" => '2',
                "month_text" => "Feb"
            ],
            [
                "month" => '3',
                "month_text" => "Mar"
            ],
            [
                "month" => '4',
                "month_text" => "Apr"
            ],
            [
                "month" => '5',
                "month_text" => "May"
            ],
            [
                "month" => '6',
                "month_text" => "Jun"
            ],
            [
                "month" => '7',
                "month_text" => "Jul"
            ],
            [
                "month" => '8',
                "month_text" => "Aug"
            ],
            [
                "month" => '9',
                "month_text" => "Sep"
            ],
            [
                "month" => '10',
                "month_text" => "Oct"
            ],
            [
                "month" => '11',
                "month_text" => "Nov"
            ],
            [
                "month" => '12',
                "month_text" => "Des"
            ],
        ];

        foreach ($yearly as $yKey => $yVal) {
            $yearly[$yKey]["total"] = Visitor::whereYear('created_at', $year)->whereMonth('created_at', $yVal["month"])->count();
        }

        $years = [];

        $visitorFirstYear = Visitor::orderBy('created_at')->first();
        $visitorFirstYear = $visitorFirstYear ? date('Y-m-d H:i:s', strtotime($visitorFirstYear->created_at)) : date('2023-01-01 00:00:00');
        $visitorFirstYear = (int) date('Y', strtotime($visitorFirstYear));
        $currentYear = (int) date('Y');

        for ($i = 0; $i <= $currentYear - $visitorFirstYear; $i++) {
            $years[] = $visitorFirstYear + $i;
        }

        $countries = [];
        $visitors = Visitor::all();

        foreach ($visitors as $v) {

            $cek = array_search($v->country, array_column($countries, "country"));

            if ($cek === false) {
                $countries[] = [
                    "iso" => $v->iso_code,
                    "country" => $v->country
                ];
            }
        }

        foreach ($countries as $cKey => $cVal) {
            $countries[$cKey]["number_visit"] = Visitor::where('country', $cVal["country"])->whereYear('created_at', $year)->count();
        }

        return [
            "response" => "success",
            "years" => $years,
            "chart" => $yearly,
            "countries" => $countries
        ];
    }

    public function yearly_visitor(Request $request)
    {
        $yearlyVisitorData = $this->fetch_yearly_visitor($request->all());

        $response = [
            "response" => "success",
            "years" => $yearlyVisitorData["years"],
            "yearlyChart" => $yearlyVisitorData["chart"],
            "countries" => $yearlyVisitorData["countries"]
        ];

        return response()->json($response);
    }

    public function yearly_by_country(Request $request)
    {
        $visitors = Visitor::where('country', $request->country)->whereYear('created_at', $request->year)->get();
        $data = [];

        foreach ($visitors as $v) {
            $cek = array_search($v->city, array_column($data, "city"));
            if ($cek === false) {
                $data[] = [
                    "state" => $v->state,
                    "city" => $v->city
                ];
            }
        }

        foreach ($data as $dKey => $dValue) {
            $data[$dKey]["number_visit"] = Visitor::where('state', $dValue["state"])->where('city', $dValue["city"])->whereYear('created_at', $request->year)->count();
        }

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function visitor_update(Request $request, $token)
    {
        if ($token === "eb6FX5KN6URhSafTY6kp7TYwkk2365") {
            $todayVisitorData = $this->fetch_today_visitor();

            $yearlyVisitorData = $this->fetch_yearly_visitor($request->all());

            $response = [
                "response" => "success",
                "todayChart" => $todayVisitorData["chart"],
                "todayVisits" => $todayVisitorData["todayVisits"],
                "averageDaily" => $todayVisitorData["averageDaily"],
                "date" => date('d F Y'),
                "years" => $yearlyVisitorData["years"],
                "yearlyChart" => $yearlyVisitorData["chart"],
                "countries" => $yearlyVisitorData["countries"]
            ];
        } else {
            $response = [
                "response" => "failed",
                "message" => "Token missmatch"
            ];
        }

        return response()->json($response);
    }
}
