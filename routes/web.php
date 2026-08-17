<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ApplicationTrackingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\AgentRegistrationController;
use App\Http\Controllers\Admin\ServiceImageController;
use App\Http\Controllers\Admin\ServiceCategoryImageController;
use App\Http\Controllers\CscDirectoryController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test-widget', function () {
    return view('chatbot.Widget');
});

// Route::get('/',         [HomeController::class, 'index'])->name('home');
// Old:
Route::get('/', [HomeController::class, 'index'])->name('home');

// // New — root shows Coming Soon:
// Route::get('/{any}', function () {
//     return view('coming-soon');
// })->where('any', '.*');


Route::get('/about',    [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
Route::get('/blog',     [HomeController::class, 'blog'])->name('blog');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
// Contact Us page
Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
// ── Add these routes to your routes/web.php ──────────────────────────────────
// Services listing (replaces your existing /services route if any)
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
 
// Service detail page — slug-based, SEO-friendly
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
 
// Application form submission
Route::post('/services/{service}/apply', [ServiceController::class, 'apply'])->name('services.apply');

Route::get('/track-application', [ApplicationTrackingController::class, 'show'])->name('application.track');
Route::post('/track-application', [ApplicationTrackingController::class, 'search'])->name('application.search');


/**/
// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');
// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
// Forms
Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
Route::get('/forms/{slug}', [FormController::class, 'show'])->name('forms.show');
Route::get('/forms/{slug}/download', [FormController::class, 'download'])->name('forms.download');
/*BLOGS*/
Route::get('/blog',                 [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}',          [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/comment', [BlogController::class, 'storeComment'])->name('blog.comment');
;
/*BLOGS*/

/**/
// Protected admin routes
// Public auth routes
Route::prefix('admin-legacy')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Protected routes
Route::prefix('admin-legacy')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('blogs', BlogController::class);
    Route::resource('services', AdminServiceController::class);

});
Route::prefix('api/chatbot')->group(function () {

    // Debug/manual-testing view — intentionally left outside the rate
    // limiter so opening the widget itself is never throttled.
    Route::get('widget', function () {
        return view('chatbot.Widget');
    });

    Route::middleware('chatbot.rate')->group(function () {
        Route::post('/session', [ChatbotController::class, 'startSession']);
        Route::post('/message', [ChatbotController::class, 'sendMessage']);
        Route::get('/history', [ChatbotController::class, 'getHistory']);
    });

});

Route::prefix('jobs')->name('jobs.')->group(function () {
    Route::get('/',                         [JobsController::class, 'index'])->name('index');
    Route::get('/admit-cards',              [JobsController::class, 'admitCards'])->name('admit-cards');
    Route::get('/results',                  [JobsController::class, 'results'])->name('results');
    Route::get('/answer-keys',              [JobsController::class, 'answerKeys'])->name('answer-keys');
    Route::get('/form-help',                [JobsController::class, 'formHelp'])->name('form-help');
    Route::post('/form-help',               [JobsController::class, 'formHelpSubmit'])->name('form-help.submit');
    Route::get('/category/{slug}',          [JobsController::class, 'category'])->name('category');
    Route::get('/{slug}',                   [JobsController::class, 'show'])->name('show');
});


// Public "Register Agent" pages
Route::get('/register-agent',          [AgentRegistrationController::class, 'show'])
    ->name('agent.registration');

Route::post('/register-agent',         [AgentRegistrationController::class, 'register'])
    ->name('agent.register');

Route::get('/register-agent/success',  [AgentRegistrationController::class, 'success'])
    ->name('agent.registration.success');

// Public CSC directory — pincode + nearest-location search
Route::get('/csc-centers', [CscDirectoryController::class, 'index'])
    ->name('csc.directory');

// Single CSC center public profile page
Route::get('/csc-centers/{cscCenter}', [CscDirectoryController::class, 'show'])
    ->name('csc.show');

// Legal pages — static content, no backend/database management needed
Route::get('/privacy-policy', fn () => view('pages.privacy-policy'))->name('privacy-policy');
Route::get('/terms-conditions', fn () => view('pages.terms-conditions'))->name('terms-conditions');
Route::get('/refund-cancellation-policy', fn () => view('pages.refund-cancellation-policy'))->name('refund-cancellation-policy');
Route::get('/disclaimer', fn () => view('pages.disclaimer'))->name('disclaimer');

// Sitemap — generated live from the database (not a static file) so it
// never goes stale. CSC centers (36,000+ rows) are split into their own
// sub-sitemap, referenced from the index, instead of one giant file.
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-pages.xml', [\App\Http\Controllers\SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap-csc-centers.xml', [\App\Http\Controllers\SitemapController::class, 'cscCenters'])->name('sitemap.cscCenters');

// ─────────────────────────────────────────────────────────────────────────────
// ADD THESE LINES TO YOUR routes/api.php
// ─────────────────────────────────────────────────────────────────────────────

// Live mobile-number check (called from the registration form via JS)
Route::get('/agent/check-mobile', [AgentRegistrationController::class, 'checkMobile'])
    ->name('agent.check-mobile');

// Plain (non-Livewire) service image upload — see ServiceImageController
// for why this exists instead of just using Filament's FileUpload field.
Route::middleware('auth')->group(function () {
    Route::get('/admin/services/{service}/image', [ServiceImageController::class, 'edit'])
        ->name('admin.services.image.edit');
    Route::post('/admin/services/{service}/image', [ServiceImageController::class, 'update'])
        ->name('admin.services.image.update');

    Route::get('/admin/service-categories/{serviceCategory}/image', [ServiceCategoryImageController::class, 'edit'])
        ->name('admin.service-categories.image.edit');
    Route::post('/admin/service-categories/{serviceCategory}/image', [ServiceCategoryImageController::class, 'update'])
        ->name('admin.service-categories.image.update');
});
