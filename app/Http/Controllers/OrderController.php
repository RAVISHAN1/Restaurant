<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\order;
use App\Models\OrderFood;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get famous dishes
        $main_dish = $this->famousDish('Main Dish');
        $side_dish = $this->famousDish('Side Dish');

        $data = [];
        $metrics = new Collection();
        $metrics->push([
            'title' => 'Most Famous Main Dish',
            'dish' => $main_dish,
        ]);

        $metrics->push([
            'title' => 'Most Famous Side Dish',
            'dish' => $side_dish,
        ]);

        $data['metrics'] = $metrics;
        $data['sales'] = $this->sales();

        return view('admin', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'tableData' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $order = Order::create([
                'amount'            => $request->fullAmount,
                'reference_number'  => $this->getReferenceId(),
            ]);

            $orders_values = json_decode($request->tableData);

            foreach ($orders_values as $key => $value) {
                OrderFood::create([
                    'order_id'  => $order->id,
                    'food_id'   => $value->food_id,
                    'quantity'  => $value->quantity,
                    'price'     => $value->price,
                ]);
            }

            return response()->json([], 201);
        } catch (\Throwable $th) {
            // Log the exception
            Log::error('An error occurred while storing a order | ', ['exception' => $th->getMessage()]);
            // Handle the exception
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }

    public function getReferenceId(): string
    {
        $id = '#';
        foreach (range(1, 6) as $key) {
            $range = array_merge(range('A', 'Z'));
            $index = array_rand($range, 1);
            $id .= $range[$index];
        }
        return $id;
    }

    public function famousDish($category)
    {
        $dish_ids = Food::where('category', $category)->pluck('id');
        $famous_dish_id = OrderFood::whereIn('food_id', $dish_ids)
            ->groupBy('food_id')
            ->select('food_id', DB::raw('count(*) as count'))
            ->orderBy('count', 'desc')
            ->first();

        if ($famous_dish_id) {
            $dish = Food::find($famous_dish_id->food_id);
            return $dish->name;
        } else {
            return '';
        }
    }

    public function sales()
    {
        $records = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount) as revenue')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return $records;
    }
}
