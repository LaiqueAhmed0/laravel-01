<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\CatalogController;
use App\Http\Controllers\Ecommerce\CheckoutController;
use App\Http\Controllers\Ecommerce\OrderController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SimController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::controller(RouteController::class)->group(function () {
    Route::get('/', 'root');
    Route::get('/home', 'root');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/validate/tax', [CheckoutController::class, 'validateTax']);

Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::get('/{sim:iccid}', 'sim');
    });

    // Ecom
    Route::controller(CartController::class)->prefix('cart')->group(function () {
        Route::get('/add', 'add');
        Route::get('/get', 'get');
        Route::get('/remove/{id}', 'remove');
        Route::get('/clear', 'clear');
        Route::get('/increase', 'increase');
        Route::get('/decrease', 'decrease');
        Route::get('/', 'cart')->name('cart');
        Route::post('/table', 'table');
    });

    Route::controller(CheckoutController::class)->prefix('checkout')->group(function () {
        Route::get('/', 'index');
        Route::post('/process', 'pay');
        Route::get('/success', 'success');
        Route::get('/failure', 'failure');
        Route::get('/cancel', 'cancel');
    });

    Route::controller(CatalogController::class)->prefix('catalog')->group(function () {
        Route::get('/', 'index');
        Route::get('/custom', 'custom');
    });

    //    Route::prefix('top-ups')->controller(TopupController::class)->group(function () {
    //        Route::get('/', 'index')->name('user.topups');
    //        Route::get('catalog', 'catalog');
    //        Route::get('/{endpoint:iccid}', 'show')->name('user.topups');
    //        Route::post('/table', 'table');
    //    });

    Route::get('api/plans', [PlanController::class, 'get']);

    Route::prefix('sim')->controller(SimController::class)->group(function () {
        Route::get('/register', 'registerView')->name('sim.register');
        Route::post('/register', 'register');
        Route::get('/remove/{endpoint}', 'remove');
        Route::post('{sim:iccid}/nickname', 'updateNickname');
        Route::get('{sim:iccid}/switch/{endpoint}', 'switchEndpoint');
        Route::post('plan/{orderItem}/scheduled', 'updateScheduled');
    });

    Route::prefix('profile')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'profile');
            Route::get('/personal-information', 'personal');
            Route::get('/change-password', 'changePassword');
            Route::get('/notifications', 'notifications');
            Route::get('/orders', 'orders');
            Route::post('/update', 'update');
            Route::post('/update-password', 'updatePassowrd');
            Route::post('/update-settings', 'updateSettings');
        });

        Route::controller(OrderController::class)->prefix('orders')->group(function () {
            Route::get('/{order}', 'show');
            Route::get('/{order}/invoice', 'invoice');
        });
    });

    Route::get('/admin/endpoints/unassigned', [EndpointController::class, 'unAssigned']);

    Route::post('/orders/table', [OrderController::class, 'table']);

    Route::middleware(['admin'])->name('admin.')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');

        Route::prefix('/users')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('admin.users');
            Route::post('/table', 'table');
            Route::get('/view/{id}', 'show');
            Route::post('/view/sims/table', 'sims');
            Route::post('/endpoints/table', 'endpointsTable');
            Route::post('/update/{user}', 'update');
            Route::post('/{user}', 'adminUpdate');
            Route::get('/{user}/edit', 'edit');
            Route::get('/{user}/delete', 'delete');
            Route::get('/create', 'create');
            Route::post('/', 'store');
            Route::get('/export', 'export');
        });

        Route::prefix('/benefits')->controller(BenefitController::class)->name('benefit.')->group(function () {
            Route::get('/create', 'create');
            Route::post('/', 'store');
        });

        Route::prefix('/plans')->controller(PlanController::class)->name('plans.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/set-markup', 'setMarkup');
            Route::post('/set-conversion', 'setConversion');
            Route::post('/', 'store');
            Route::get('/create', 'create');
            Route::post('/table', 'get')->name('get');
            Route::get('/edit/{plan}', 'edit');
            Route::get('/copy/{plan}', 'copy');
            Route::get('/delete/{plan}', 'delete');
            Route::post('{plan}', 'update');
        });

        Route::prefix('/pricing')->controller(PricingController::class)->name('pricing.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store');
            Route::get('/create', 'create');
            Route::post('/table', 'get')->name('get');
            Route::get('/edit/{pricing}', 'edit');
            Route::get('/delete/{pricing}', 'delete');
            Route::post('{pricing}', 'update');
        });

        Route::prefix('/orders')->controller(OrderController::class)->name('orders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/table', 'get')->name('get');
            Route::get('/{order}', 'adminView');
            Route::get('/{order}/invoice', 'adminInvoice');
            Route::get('/{order}/update-status/{status}', 'adminStatus');
        });

        Route::prefix('/countries')->controller(CountryController::class)->name('countries.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/table', 'get')->name('get');
            Route::get('/edit/{country}', 'edit');
            Route::post('/{country}', 'update');
        });

        Route::prefix('/regions')->controller(RegionController::class)->name('regions.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store');
            Route::get('/create', 'create');
            Route::post('/table', 'get')->name('get');
            Route::get('/edit/{region}', 'edit');
            Route::post('/{region}', 'update');
        });

        Route::prefix('/endpoints')->controller(EndpointController::class)->name('endpoints.')->group(function () {
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::get('/delete', 'delete');
            Route::get('/add-plan/{endpoint}', 'addBenefit');
            Route::post('/table', 'get')->name('get');
            Route::get('/view/{endpoint}', 'show');
            Route::get('/export', 'export');
        });

        Route::prefix('/sims')->controller(SimController::class)->name('sims.')->group(function () {
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::get('/delete', 'delete');
            Route::get('/add-plan/{sim}', 'addBenefit');
            Route::post('/table', 'get')->name('get');
            Route::get('/export', 'export');
        });

        Route::get('/sims/remove-claimant/{sim}', [EndpointController::class, 'removeClaimant']);
        Route::get('/sims/remove-retailer/{sim}', [EndpointController::class, 'removeRetailer']);

        Route::prefix('/retailers')->controller(RetailerController::class)->name('retailers.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store')->name('store');
            Route::get('/view/{retailer}', 'show')->name('view');
            Route::post('/table', 'getTableData');
            Route::get('/sims', 'getSims');
            Route::get('{retailer}/import', 'importView')->name('import.view');
            Route::post('{retailer}/import', 'import')->name('import');
            Route::prefix('/endpoints')->name('endpoints.')->group(function () {
                Route::post('/table', 'getEndpoints');
                Route::get('/import', 'importView');
                Route::post('/import', 'importEndpoints');
            });
        });

        Route::get('/sims', [AdminController::class, 'sims'])->name('admin.sims');
        Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
    });

    Route::middleware(['retailer'])->name('retailer.')->prefix('retailer')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\RetailerController::class, 'dashboard'])->name('index');

        Route::prefix('/endpoints')->name('endpoints.')->group(function () {
            Route::post('table', [App\Http\Controllers\RetailerController::class, 'getEndpoints'])->name('get');
            Route::post('claim', [App\Http\Controllers\RetailerController::class, 'claimEndpoints']);
            Route::post('send', [App\Http\Controllers\RetailerController::class, 'send']);
            Route::get('/remove-claimant/{sim}', [App\Http\Controllers\RetailerController::class, 'unclaimEndpoint']);
            Route::get('view/{endpoint}', [App\Http\Controllers\EndpointController::class, 'view']);
        });
    });
});

Route::get('/embed/catalog', [\App\Http\Controllers\Ecommerce\CatalogController::class, 'embed']);

Route::get('/callback/notification', [
    App\Http\Controllers\BenefitController::class,
    'notification',
]);

Route::post('/callback/notification', [
    App\Http\Controllers\BenefitController::class,
    'notification',
]);

Route::get('/callback/mobility', [
    App\Http\Controllers\SimController::class,
    'mobility',
]);

Route::post('/callback/mobility', [
    App\Http\Controllers\SimController::class,
    'mobility',
]);

Route::post('/checkout/notification', [
    App\Http\Controllers\Ecommerce\CheckoutController::class,
    'notification',
]);

Route::get('/checkout/notification', [
    App\Http\Controllers\Ecommerce\CheckoutController::class,
    'notification',
]);

Route::post('/callback/usage', function (Request $request) {
    Log::alert(print_r($request->all()));
});
