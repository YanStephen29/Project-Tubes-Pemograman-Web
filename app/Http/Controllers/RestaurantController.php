<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductCategory;

class RestaurantController extends Controller
{
    // Menampilkan form untuk memilih role
    public function showSelectRole()
    {
        return view('registration.select-role');
    }

    public function processRoleSelection(Request $request){
    $role = $request->role;
    // Asumsikan Anda ingin mengarahkan pengguna ke form pendaftaran yang sesuai dengan role
    return redirect()->route('register.form', ['role' => $role]);
    }

    // Menampilkan form pendaftaran berdasarkan role
    public function showRegistrationForm(Request $request)
    {
        $role = $request->query('role');  // mengambil role dari URL
        if ($role === 'restaurant') {
            $categories = \App\Models\Category::all();
            return view('registration.register-resto',compact('categories'));
        } elseif ($role === 'customer') {
            return view('registration.register-customer');
        } else {
            return redirect()->route('home');
        }
    }

    // Proses pendaftaran
    public function register(Request $request)
    {
        $role = $request->input('role');
        if ($role === 'customer') {
            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required|date',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                // 'role' => 'required|in:customer,restaurant',

            ]);
    
            // Simpan data ke tabel `users`
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'customer',
            ]);

            // Simpan detail ke tabel `customers`
        $user->customer()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'],
        ]);

        Auth::login($user);
        return redirect()->route('customer.home');

    } elseif ($role === 'restaurant') {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'password' => 'required|confirmed',
            // 'role' => 'required|in:customer,restaurant',
        ]);

        // Simpan data ke tabel `users`
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            // 'role' => $validated['role'],
            'role' => 'restaurant'
        ]);

        // Simpan detail ke tabel `restaurants`
        $restaurant = $user->restaurant()->create([
            'restaurant_name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        $restaurant->categories()->attach($validated['categories']);
        Auth::login($user);

        return redirect()->route('restaurant.home');
    }

    return redirect()->route('home')->with('error', 'Invalid role selected.');
}
        
    // Menampilkan form login
    public function showLoginForm(){
        return view('registration.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();
    
            // Ambil data role pengguna dari database
            $role = Auth::user()->role;
    
            // Arahkan pengguna ke halaman beranda sesuai role
            if ($role === 'customer') {
                return redirect()->route('customer.home');
            } elseif ($role === 'restaurant') {
                return redirect()->route('restaurant.home');
            } else {
                // Jika role tidak valid, logout dan kembali ke halaman login
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'role' => 'Invalid user role. Please contact support.',
                ]);
            }
        }
    
        // Jika autentikasi gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    //Menghapus Restaurant
    public function deleteRestaurant($id)
{
    $restaurant = Restaurant::findOrFail($id);

    // Lakukan logika penghapusan, misalnya menghapus foto terkait, dan lainnya
    Storage::delete($restaurant->profile_photo);
    Storage::delete($restaurant->restaurant_photo);

    // Hapus restoran dari database
    $restaurant->delete();

    // Redirect ke halaman utama atau mana pun yang Anda inginkan dengan pesan sukses
    return redirect()->route('home')->with('success', 'Restaurant deleted successfully.');
}

public function deleteCustomer()
{
    $user = Auth::user();

    if ($user && $user->role === 'customer') {
        // Hapus profil customer
        if ($user->customer) {
            $user->customer->delete();
        }

        // Hapus user
        $user->delete();

        // Redirect ke halaman home dengan pesan sukses
        return redirect('home')->with('success', 'Account deleted successfully.');
    }

    return back()->withErrors('Unauthorized access.');
}


    public function restaurantHome(){
    $restaurant = Auth::user()->restaurant;

    if (!$restaurant) {
        // Redirect user atau tampilkan pesan error jika tidak ada data restoran
        return redirect()->route('home')->withErrors('No restaurant data found for the current user.');
    }

    // Mengambil total pendapatan dengan lebih efisien
    $totalProfit = $restaurant->orders()->with('orderDetails')
        ->get()
        ->reduce(function ($carry, $order) {
            return $carry + $order->orderDetails->sum('total');
        }, 0);

    // Mengambil produk terlaris dengan lebih efisien
    $bestSellingProducts = $restaurant->products()
        ->withCount(['orderDetails as sales' => function ($query) {
            $query->select(\DB::raw("SUM(quantity)"));
        }])
        ->orderBy('sales', 'desc')
        ->take(4)
        ->get();

        $categories = ProductCategory::all();

    return view('resto.berandaResto', compact('restaurant', 'totalProfit', 'bestSellingProducts','categories'));
}

    public function createProduct(){
        // Pastikan hanya restoran yang dapat mengakses
        if (!Auth::check() || Auth::user()->role !== 'restaurant') {
            return redirect()->route('login')->with('error', 'Unauthorized action.');
        }

        // Ambil kategori produk untuk dropdown
        $restaurant = Auth::user()->restaurant;
        $categories = \App\Models\ProductCategory::all();

        return view('resto.create-product', compact('categories', 'restaurant'));
    }

    public function storeProduct(Request $request)
    {
        // Pastikan user adalah restoran
        if (!Auth::check() || Auth::user()->role !== 'restaurant') {
            return redirect()->route('login')->with('error', 'Unauthorized action.');
        }

        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'Product name is required.',
            'price.required' => 'Price is required.',
            'stock.required' => 'Stock is required.',
            'category_id.required' => 'Please select a valid category.',
            'image.image' => 'Uploaded file must be an image.',
            'image.max' => 'Image size must not exceed 2MB.',
        ]);

        // Simpan produk
        $product = new Product();
        $product->restaurant_id = Auth::user()->restaurant->id;
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        if (!$product->save()) {
            return back()->with('error', 'Failed to add product. Please try again.');
        }
        $product->save();
        return redirect()->route('restaurant.home')->with('success', 'Product added successfully.');
    }

    public function editProductForm($id)
    {
        $product = Product::findOrFail($id);
        $categories = \App\Models\ProductCategory::all();
        return view('resto.edit-product', compact('product','categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id'];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if($product->image){
                Storage::delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }
        $product->save();

        return redirect()->route('restaurant.home')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        Storage::delete($product->image);
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }


    public function updateRestaurantProfile(Request $request)
    {
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image',
            'restaurant_photo' => 'nullable|image'
        ]);
        $restaurant = Auth::user()->restaurant;
        $restaurant->update([
            'restaurant_name' => $request->restaurant_name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);
        // Handle file upload for profile photo
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $restaurant->profile_photo = $path;
        }

        if ($request->hasFile('restaurant_photo')) {
            $path = $request->file('restaurant_photo')->store('restaurant_photos', 'public');
            $restaurant->restaurant_photo = $path;
        }
        $restaurant->save();
        return redirect()->route('restaurant.home')->with('success', 'Profile updated successfully.');
    }

    public function updateCustomerProfile(Request $request)
    {
        $customer = Auth::user()->customer;
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);

        $customer->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'],
        ]);
        return redirect()->route('customer.home')->with('success', 'Profile updated successfully.');
    }

    public function editRestaurantProfile()
    {
        $restaurant = Auth::user()->restaurant;
        return view('resto.editprofile-resto', compact('restaurant'));
    }

    public function editCustomerProfile()
    {
        // Pastikan user memiliki role "customer"
        if (Auth::user()->role !== 'customer') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        // Ambil data customer
        $customer = Auth::user()->customer;

        // Tampilkan view edit profile customer
        return view('customer.editprofile-customer', compact('customer'));
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home'); // Atau arahkan pengguna ke halaman yang diinginkan setelah logout
    }

    public function showOrders(){
        $user = Auth::user();
        if($user->role !== 'restaurant'){
            return redirect()->route('home')->with('error','Unauthorized acces');
        }

        $restaurant = $user->restaurant;

        $oddDates = DB::table('order_detail')
        ->select(DB::raw('Date(created_at) as date'))
        ->whereRaw('DAY(created_at) % 2 = 1')
        ->groupBy('date')
        ->pluck('date');

        $evenDates = DB::table('order_detail')
        ->select(DB::raw('DATE(created_at) as date'))
        ->whereRaw('DAY(created_at) % 2 = 0')
        ->groupBy('date')
        ->pluck('date');

        $lastOrder = DB::table('orders')
        ->join('customers', 'customers.user_id', '=', 'orders.customer_id')
        ->join('users', 'users.id', '=', 'orders.customer_id')
        ->selectRaw("CONCAT(customers.first_name, ' ', customers.last_name) as name, customers.profile_photo, orders.created_at as order_date, orders.id")
        ->orderByDesc('orders.created_at')
        ->first();

        $lastCustomer = null;
    if ($lastOrder) 
        {
            $lastCustomer = (object) 
            [
                'name' => $lastOrder->name,
                'profile_photo' => $lastOrder->profile_photo,
                'order_date' => $lastOrder->order_date,
                'orders' => DB::table('order_detail')
                    ->join('product_tables', 'product_tables.id', '=', 'order_detail.product_id')
                    ->where('order_detail.order_id', $lastOrder->id)
                    ->select('product_tables.name as product_name', 'order_detail.quantity', 'order_detail.price')
                    ->get(),
            ];
        }
        return view('resto.orderResto', compact('restaurant','oddDates', 'evenDates', 'lastCustomer'));
    }
}