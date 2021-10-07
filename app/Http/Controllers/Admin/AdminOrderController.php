<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $data['users'] = DB::table('users')->get();
        $data['orders'] = DB::table('orders')
            ->select('orders.id', 'orders.user_id', 'users.name', 'orders.tanggal_order')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->orderBy('orders.id', 'DESC')
            ->paginate(5);

        return view('admin/order/order', $data);
    }

    public function insert()
    {
        $data['users'] = DB::table('users')->get();
        return view('admin/order/insert', $data);
    }

    public function InsertAction(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id|unique:users,id',
            'date_order' => 'required',
        ]);

        $user_id = $request->input('user_id');
        $date_order = $request->input('date_order');

        $order = new Order;
        $order->user_id = $user_id;
        $order->tanggal_order = $date_order;
        $order->save();

        //get last id
        $Lastid = $order->id;

        //get user's name
        $LastUserId = $order->user_id;
        $user = User::find($LastUserId);
        $nameUser = $user->name;


        return redirect('admin/order_item/' . $nameUser . '/' . $Lastid)->with('status', 'Success add Order');
    }

    public function edit($id)
    {
        $data['users'] = DB::table('users')->get();
        $data['orders'] = DB::table('orders')
            ->select('orders.id', 'orders.user_id', 'users.name', 'orders.tanggal_order')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.id', $id)->first();

        return view('admin/order/edit', $data);
    }

    public function editAction(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'date_order' => 'required',
        ]);

        $user_id = $request->input('user_id');
        $date_order = $request->input('date_order');

        DB::table('orders')->where('id', $id)
            ->update([
                'user_id' => $user_id,
                'tanggal_order' =>  $date_order,
            ]);

        return redirect('admin/order/')->with('status', 'Data was updated');
    }

    public function delete($id)
    {
        DB::table('orders')->where('id', $id)->delete();

        return redirect('admin/order/')->with('status', 'Data was deleted');
    }
}
