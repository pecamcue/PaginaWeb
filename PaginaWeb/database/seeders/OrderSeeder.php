<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Order_item; // Importar OrderItem para usarlo en el seeder
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Supongamos que tomamos el primer usuario
        $user = User::first();

        // Supongamos que tomamos algunos productos
        $productos = Product::take(2)->get();

        // Crear un pedido
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pendiente',
            'total_amount' => $productos->sum('precio'),
            'order_date' => Carbon::now(),
            'payment_id' => null,
        ]);

       
    
    }
}
