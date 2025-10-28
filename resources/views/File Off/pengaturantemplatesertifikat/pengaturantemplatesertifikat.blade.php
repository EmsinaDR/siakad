Route::resource('url', \App\Http\Controllers\Folder\NameController::class)->middleware(['auth', 'verified']);
php artisan make:custom-controller FolderData/NameController