<?php

use App\Category;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
*/

//  Route::resource('Nombre del recuerso(o modelo) en plural', 'Controlador', [puede indicarsele los metodos que se usaran]); 


/*
    Buyers
*/
Route::resource('buyers', 'Buyer\buyerController', ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);

/*
    Category
*/
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);
Route::resource('categories.sellers', 'Category\CategorySellerController', ['only' => ['index']]);
Route::resource('categories.transactions','Category\CategoryTransactionController' ,['only' => ['index']]);
Route::resource('categories.buyers','Category\CategoryBuyerController' ,['only' => ['index']]);
/*
   Products
*/
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);


/*
    transactions
*/
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index']]);
/*
    sellers
*/
Route::resource('sellers', 'Seller\sellerController', ['only' => ['index', 'show']]);
Route::resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::resource('sellers.categories', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::resource('sellers.buyers', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create','edit','show']]);

/*
    Users
*/
Route::resource('users', 'User\userController', ['except' => ['create', 'edit']]);