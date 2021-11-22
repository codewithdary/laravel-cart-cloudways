## Shopping Cart in Laravel 

The following documentation is based on my [Laravel 8 - Creating a shopping cart in Laravel 8]() tutorial where we will be creating a shopping cart in Laravel. <br> <br>
•	Author: [Code With Dary](https://github.com/codewithdary) <br>
•	Twitter: [@codewithdary](https://twitter.com/codewithdary) <br>
•	Instagram: [@codewithdary](https://www.instagram.com/codewithdary/) <br>


## Technical Requirements
•	PHP => 7.2.5 <br>

## Prerequisites
•	Basic Laravel knowledge <br>
•	Low level HTML & CSS/TailwindCSS knowledge <br>
•	Object-Oriented Programming <br>

## Course Overview

| **Episode**   | **Subject** |
| ------------- |-------------|
| Ep. 1         | Introduction to this course |
| Ep. 2         | Creating our GitHub repository + Laravel project |
| Ep. 3         | Creating all Controllers, Models, Migrations & Routes |
| Ep. 4         | Setting up our database & credentials |
| Ep. 5         | Setting up our migrations & data structure |
| Ep. 6         | Creating our database seeding |
| Ep. 7         | Storing images & adding |
| Ep. 8         | Building the frontend |
| Ep. 9         | Making our shop dynamic |
| Ep. 10        | Saving products to our session/cart |
| Ep. 11        | Making our cart dynamic |
| Ep. 12        | Deleting products from our session/cart |

## Usage <br>
Setup your coding environment <br>
```
git clone git@github.com:codewithdary/laravel-cart-cloudways.git
cd laravel-cart-cloudways
composer install
cp .env.example .env 
php artisan key:generate
php artisan cache:clear && php artisan config:clear 
php artisan serve 
```

# 1. Introduction to this course

Working on a shopping cart in any type of programming language does require some kind of skip, and that applies for this course as well. We are going to work inside a Laravel 8 project, where we won’t be styling our pages, but we will be using a repository I have created before.

There are multiple ways on how you can get in touch if you’re running into issues. I got to say that it’s difficult at times to maintain and respond to everyone, but I’ll definitely do my best.

### Instagram
My Instagram username is codewithdary as well, and next to coding issues, you’ll find more personal stuff about me over here.

### YouTube
If you are interested in learning more about coding, you can check me out on YouTube where you’ll can find me under the name of Code With Dary. I’m a developer and educator who created online courses in PHP, JavaScript, Laravel and TailwindCSS to help everyone out.

### Patreon
If you are interested in getting into my Discord group and interact with other up and coming developers (and me) about your coding issues, my Patreon will be the right place for you!

## 2. Creating our GitHub repository + Laravel project

When you want to deploy a Laravel project into the cloud, you should be working with ```GitHub```. GitHub is an open source platform where all developers over the entire world contribute to source codes, and where you can control your software. 

Once you are logged into your GitHub account, you need to make sure that you create a new repository. A ```repository``` is the location where you store your project files.

The following fields needs to be defined:
```
Repository name: Laravel-cart-cloudways
Visibility: public
Select: Add a README file & add .gitignore
```

Once you have created your repository, the GitHub needs to be cloned somewhere on your local machine. I personally have a folder on my Desktop called Workspace where I store my coding projects. Make sure that you copy the ```HTTPS``` or ```SSH``` from your GitHub repository, open a terminal and execute the following commands.

```
cd /Desktop/workspace
git clone https://github.com/{username}/{repository_name}
```

This will create a new directory inside your workspace directory with the name of ```Laravel-cart-cloudways```. When performing commands for your coding project, you need to be located inside the project.

```
cd laravel-cart-cloudways/
```

We have not added our Laravel project into our GitHub repository. This can be done in two ways. The first method does not work on a Mac but will most likely work on Linux and/or Windows.

```
laravel new .
```

The command above will create a new Laravel project in the root of your GitHub repository.

If this command throws an error, you need to create a new Laravel project with a folder name, and drag all files and folders into the root of your directory.

```
laravel new laravel-cart-cloudways
```

Finally, let’s run out project inside the browser.

```
php artisan serve
```

## 3. Creating Controllers, Models, Migrations & Routes

Laravel has the power to create Controllers in a pretty fast way through the CLI. Controllers are used to interact with the right Model, which will get the right data from the database that has been built with the migration, which will finally send data back to a view through the route.

When creating a shopping cart, you will most likely have a ```Home page```, ```Product page``` and a ```Cart page```. 

The Home page will not have any interaction with models, but it will simply return the frontpage of our application.

```
php artisan make:controller PagesController
```

There will be a total of two product pages. One product that will show the overview of all pages, and one product page that accepts a route parameter, which allows us to dynamically render a page.

```
php artisan make:model Product -c -m
```

The ```-c``` flag will add the correct Controller to our ```Product``` model, and the ```-m``` flag adds the correct migration to our Product model.

Our shopping cart does not need to have a model since we’re not going to save products into our database. We simply need to define a Controller for it.

```
php artisan make:controller CartController
```

Routes can be defined inside the ```/routes/web.php``` file. We will not be using the default route that Laravel provides for us, since we will be passing views directly into our Controller.

```ruby
Route::get('/', function() {
    return view('welcome');
});
```

We will be defining a total of 4 routes to interact with our home page, product pages, and shopping cart.

```ruby
Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/shop/{id}', [ProductController::class, 'show'])->name('product');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
```

## 4. Setting up our database & credentials

When dealing with migrations in Laravel, you obviously need to have your database credentials and database itself setup.

The root of every Laravel project has a hidden file named ```.env``` inside of it. By default, Laravel adds the project name as your database name, sets the ```DB_USERNAME``` to root, but keeps the password empty. These values need to be changed in order to interact with your local database.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_cart_cloudways
DB_USERNAME=root
DB_PASSWORD=
```

Laravel will not create the database itself, so that is something that needs to be done as well. I’m using a Database extension in ```Visual Studio Code``` called “```Database Client```”, which allows me to interact with my databases. It also allows me to simply create a database through an interface.

If you prefer to use the CLI, you can simply perform the following commands.
```
mysql;
create database laravel_cart_cloudways;
exit;
```

## 5. Setting up our migrations

A good back-end project always starts with the correct database. This will prevent a lot of issues when creating relationships inside your code. 

Our migration has already been defined in ```Chapter 3: Creating Controllers, Models, Migrations & Routes```, where we added the ```-m``` flag when defining our Product model.

This migration can be found inside the ```/database/migrations``` folder, where a couple pre-defined migrations will be found that start with a timestamp, followed with the migration name. We need the last one, since it’s the last migration we have created.

Our table structure needs to be defined inside the``` up()``` method. Replace the method that you have with the following.

```ruby
 public function up() {
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique()->nullable(false);
        $table->string('details')->nullable(false);
        $table->text('description')->nullable(false);
        $table->text('brand')->nullable(false);
        $table->double('price')->nullable(false);
        $table->double('shipping_cost');
        $table->string('image_path')->nullable(false);
        $table->timestamps();
    });
}
```
Once you have setup your migration, we need to migrate it into our database through the CLI.
```
php artisan migrate
```

This command will execute all ```up()``` methods from our ```/database/migrations``` folder.

## 6. Creating database seeders

When it comes to creating dummy data in Laravel, I prefer to use database seeders rather than creating the data through a database client. A database seeder can simply be created through the CLI.

```
php artisan make:seeder ProductSeeder
```

The seeder will be added inside the ```/database/seeder``` folder, with a file name of ```ProductSeeder.php```.

I prefer to define my products inside an array, and then loop over the array and perform an ```create()``` method.

```php
    public function run()
    {
        $products = [
            [
                'name' => 'Apple Macbook Pro 16',
                'details' => 'Apple M1 Pro, 16 GPU, 16 GB, 512 GB,
                'description' => Description',
                'brand' => 'Apple',
                'price' => 2499,
                'shipping_cost' => 25,
                'image_path' => 'storage/product.png'
            ],
            [
                'name' => 'Samsung Galaxy Book Pro',
                'details' => '13.3 inch, 8GB, DDR4 SDRAM, 256GB',
                'description' => ‘Description',
                'brand' => 'Samsung',
                'price' => 1400,
                'shipping_cost' => 25,
                'image_path' => 'storage/product2.png'
            ],
        ];
```

Right below our array, we need to iterate over it and create new products through the ```Product``` model.

```php        
foreach($products as $key => $value) {
    Product::create($value);
}
```

We’re almost done. The last step is defining our ProductSeeder inside the DatabaseSeeder, so it 

```php    
public function run()
{
    $this->call(ProductSeeder::class);
}
```

Alright! Let’s seed it through the CLI!

```
php artisan db:seed
```

If you open your database client, refresh the ```“Products”``` table, you will see that two new rows have been added. 

## 7. Storing images & symbolic links

When we defined our seeders, we added an ```image_path``` that we haven’t added inside our application. In Laravel, you can store images where ever you want if you have permission to access it from the view. Personally, storing them inside the public folder and creating a symbolic link is the way to go.

```
php artisan storage:link
```

This command will create a link between the ```/public/storage``` folder with the ```/storage``` folder inside the root of our directory.

Make sure that you download the zip file attached to this specific video, open the ```laravel-cart-cloudways``` folder, and place them inside the ```/public/storage``` folder of your Laravel project.

## 8. Building the frontend

In order to save time, I have already developed the entire frontend of our application, which can be found inside my [laravel-shopping-cart-static](https://github.com/codewithdary/laravel-shopping-cart-static) repository.

The frontend of any Laravel application can be found inside the ```/resources/views``` folder. In the demonstration of the video, I copy pasted the files separately. This can be done a lot easier if you download the [/resources/views folder](https://github.com/codewithdary/laravel-shopping-cart-static/tree/main/resources/views), and add it inside the project directory.

This does not work if we run it in the browser, since the methods inside our controllers have not been defined.

PagesController

```php    
public function index()
{
    return view('index');
}
```

ProductController

```php   
public function index()
{
    return view('shop.index');
}
```

```php    
public function show() 
{
    return view('shop.show')
}
```

CartController

```php    
public function index()
{
    return view(cart.cart);
}
```

## 9. Making our shop dynamic

We have added products inside our database, and we also have a static frontend. If we combine those things together, we can basically render dynamic products into our shops.

This needs to be done from the ```ProductController```, where we need to change the ```index()``` method.

```php
public function index()
{
    $products = Product::all();
        
    return view('shop.index', compact('products'));
}
```

Inside our ```/resources/views/shop/index.blade.php```, we can simply loop over our products. Let’s adjust our parent div with the following.

```php
<div class="grid sm:grid-cols-4 gap-8 pt-20 mx-auto w-4/5">
    @foreach ($products as $product)
    <div class="mx-auto">
	…
    </div>
    @endforeach
</div>
@endsection
```

Don’t forget to replace static content inside the loop with dynamic content from the database.

```php
{{ asset($product->image_path) }}
{{ $product->name }}
{{ $product->name }}
{{ $product->details }}
{{ $product->id }}
```

The same things needs to happen for our ```show()``` method and page, because we want to show Products from the database.

```php   
public function show($id) 
{
    $product = Product::FindOrFail($id);
        
    return view('shop.show', compact('product'));
}
```

Also for the ```/resources/views/shop/show.blade.php``` file, Don’t forget to replace static content with dynamic content from the database.

```php
{{ asset($product->image_path) }}
{{ $product->name }}
{{ $product->name }}
{{ $product->details }}
{{ $product->id }}
```

## 10. Saving products to our session

We will be storing products inside the session of our application because we are not dealing with logged in users. When dealing with a shopping cart on ecommerce sites, you have to keep in mind that you are dealing with critical data, because the entire web app is based on it.

Since we’re not working with logged in users, we need to store our cart items into the web storage. This can be the cookie, session or local storage. Between these 3, I personally find sessions the most valid method.

If you want to upgrade this application and add authentication, I recommend you to use a database to store cart items temporary. That allows you to easily trace cart items of a user.

Before we can add our functionality, we need to define a new route that allows us to click on the ```“add to cart”``` button.

```php
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add.to.cart');
```

The named route needs to be added inside the “add to cart” button from our ```/resources/views/shop/show.blade.php``` file.

```php
<a 
    href="{{ route('add.to.cart', $product->id) }}"
    class="px-10 py-6 text-l uppercase text-white font-bold bg-blue-600 rounded-full w-full" 
    role="button" 
    aria-pressed="true">
    Add To Cart
</a>
```
The ```add.to.cart``` route interacts with the ```addToCart()``` method that we still need to define. There are two possible scenarios when adding products to a cart: one where a product already exists and needs to be increased, or a product does not exist in our session, and the session needs to be created.

```php   
public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cartItems = session()->get('cartItems', []);

        if(isset($cartItems[$id])) {
            $cartItems[$id]['quantity']++;
        } else {
            $cartItems[$id] = [
                "image_path" => $product->image_path,
                "name" => $product->name,
                "brand" => $product->brand,
                "details" => $product->details,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        session()->put('cartItems', $cartItems);
        return redirect()->back()->with('success', 'Product added to cart!');
    }
```

You can see the output by adding a ```dd()``` inside the cart method, which output the session. In here, you can see that the array has a key which is equal to the product id, and values that are coming from the database inside of it.

```php   
public function cart()
{
    dd(session('cartItems'));
    return view('cart.cart');
}
```

## 11. Making our cart dynamic

With the information that we got inside our session, we should be able to print that data inside the shopping cart. There is a lot of ```HTML``` and ```CSS``` inside the ```/resources/views/cart/cart.blade.php``` file. Try to find the ```<tbody>```tag, since that’s one row that needs to be outputted dynamically.

```php
<tbody class="bg-white divide-y divide-gray-200">
…
</tbody>
```

Our ```<tbody>``` tag and content need to be wrapped inside a foreach loop, that will loop over our products. First, we do need to check if our session has been set.


```php
@if (session('cartItems'))
    @foreach (session('cartItems') as $key => $value)
        <tbody class="bg-white divide-y divide-gray-200">
            …
        </tbody>
    @endforeach
@endif
```

Once again, don’t forget to change the static content that we have with dynamic data.

```php
{{ asset($value['image_path']) }}
{{ $value['name'] }}
{{ $value['name'] }}
{{ $value['details'] }}
{{ $value['price'] }}
{{ $value['quantity'] * $value['price'] }}
```
 
In most cases, you want to showcase a message if the shopping cart is empty. This can be done by adding an else statement right after the ```endforeach``` directive.

```php
@else
    <td align="left" colspan="3">
        <p class="font-bold text-l text-black py-6 px-4">
            Shopping cart is empty.
        </p>
    </td>
```

## 12. Deleting products from our cart

Whenever you reach the delete something part in any course, you know that you’re reaching the end of the coding part.

Just like adding products, we need to make sure that we define a new route to delete products.

```php
Route::get('/delete-from-cart/{id}', [CartController::class, 'delete'])->name('delete.from.cart');
```

Deleting something from the cart needs to be handled inside the ```CartController```.

```php    
public function delete(Request $request)
    {
        if($request->id) {
            $cartItems = session()->get('cartItems');

            if(isset($cartItems[$request->id])) {
                unset($cartItems[$request->id]);
                session()->put('cartItems', $cartItems);
            }

            return redirect()->back()->with('success', 'Product deleted successfully');
        }
    }
```

To make the button work, we simply need to add the named route, into our delete button from the ```/resources/views/cart/cart.blade.php``` file.

```html
<td class="px-6 whitespace-nowrap text-right text-sm font-medium">
    <a 	
        href="{{ route('delete.from.cart', $key) }}" 
        role="button" class="text-red-600 hover:text-red-900">
        Delete
    </a>
</td>
```
