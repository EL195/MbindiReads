<?php

Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }
    return redirect()->route('admin.home');
});

Auth::routes(['register' => true]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    
    Route::get('/', 'HomeController@index')->name('home');
    
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Projects
    Route::delete('projects/destroy', 'ProjectsController@massDestroy')->name('projects.massDestroy');
    Route::resource('projects', 'ProjectsController');

    // Folders
    Route::delete('folders/destroy', 'FoldersController@massDestroy')->name('folders.massDestroy');
    Route::post('folders/media', 'FoldersController@storeMedia')->name('folders.storeMedia');
    Route::post('folders/ckmedia', 'FoldersController@storeCKEditorImages')->name('folders.storeCKEditorImages');
    Route::resource('folders', 'FoldersController');

    // Subjects
    Route::delete('subjects/destroy', 'SubjectController@massDestroy')->name('subjects.massDestroy');
    Route::post('subjects/media', 'SubjectController@storeMedia')->name('subjects.storeMedia');
    Route::post('subjects/ckmedia', 'SubjectController@storeCKEditorImages')->name('subjects.storeCKEditorImages');
    Route::resource('subjects', 'SubjectController');

    // Genres
    Route::delete('genres/destroy', 'GenreController@massDestroy')->name('genres.massDestroy');
    Route::post('genres/media', 'GenreController@storeMedia')->name('genres.storeMedia');
    Route::post('genres/ckmedia', 'GenreController@storeCKEditorImages')->name('genres.storeCKEditorImages');
    Route::resource('genres', 'GenreController');


    // Themes
    Route::delete('themes/destroy', 'ThemeController@massDestroy')->name('themes.massDestroy');
    Route::post('themes/media', 'ThemeController@storeMedia')->name('themes.storeMedia');
    Route::post('themes/ckmedia', 'ThemeController@storeCKEditorImages')->name('themes.storeCKEditorImages');
    Route::resource('themes', 'ThemeController');

    // Levels
    Route::delete('levels/destroy', 'LevelController@massDestroy')->name('levels.massDestroy');
    Route::post('levels/media', 'LevelController@storeMedia')->name('levels.storeMedia');
    Route::post('levels/ckmedia', 'LevelController@storeCKEditorImages')->name('levels.storeCKEditorImages');
    Route::resource('levels', 'LevelController');

    // Age group
    Route::delete('agegroups/destroy', 'AgegroupController@massDestroy')->name('agegroups.massDestroy');
    Route::post('agegroups/media', 'AgegroupController@storeMedia')->name('agegroups.storeMedia');
    Route::post('agegroups/ckmedia', 'AgegroupController@storeCKEditorImages')->name('agegroups.storeCKEditorImages');
    Route::resource('agegroups', 'AgegroupController');

    // Awards
    Route::delete('awards/destroy', 'AwardController@massDestroy')->name('awards.massDestroy');
    Route::post('awards/media', 'AwardController@storeMedia')->name('awards.storeMedia');
    Route::post('awards/ckmedia', 'AwardController@storeCKEditorImages')->name('awards.storeCKEditorImages');
    Route::resource('awards', 'AwardController');

    // Memberships
    Route::delete('memberships/destroy', 'MembershipController@massDestroy')->name('memberships.massDestroy');
    Route::post('memberships/media', 'MembershipController@storeMedia')->name('memberships.storeMedia');
    Route::post('memberships/ckmedia', 'MembershipController@storeCKEditorImages')->name('memberships.storeCKEditorImages');
    Route::resource('memberships', 'MembershipController');

    // Ressources
    Route::delete('ressources/destroy', 'RessourceController@massDestroy')->name('ressources.massDestroy');
    Route::post('ressources/media', 'RessourceController@storeMedia')->name('ressources.storeMedia');
    Route::post('ressources/ckmedia', 'RessourceController@storeCKEditorImages')->name('ressources.storeCKEditorImages');
    Route::resource('ressources', 'RessourceController');

    // Answers
    Route::delete('answers/destroy', 'AnswerController@massDestroy')->name('answers.massDestroy');
    Route::post('answers/media', 'AnswerController@storeMedia')->name('answers.storeMedia');
    Route::post('answers/ckmedia', 'AnswerController@storeCKEditorImages')->name('answers.storeCKEditorImages');
    Route::resource('answers', 'AnswerController');

    // Quiz
    Route::delete('quiz/destroy', 'QuizController@massDestroy')->name('quiz.massDestroy');
    Route::post('quiz/media', 'QuizController@storeMedia')->name('quiz.storeMedia');
    Route::post('quiz/ckmedia', 'QuizController@storeCKEditorImages')->name('quiz.storeCKEditorImages');
    Route::resource('quiz', 'QuizController');

    // Payement
    Route::delete('payement/destroy', 'PayementController@massDestroy')->name('payement.massDestroy');
    Route::post('payement/media', 'PayementController@storeMedia')->name('payement.storeMedia');
    Route::post('payement/ckmedia', 'PayementController@storeCKEditorImages')->name('payement.storeCKEditorImages');
    Route::resource('payement', 'PayementController');

    // Notifications
    Route::delete('notifications/destroy', 'NotificationController@massDestroy')->name('notifications.massDestroy');
    Route::post('notifications/media', 'NotificationController@storeMedia')->name('notifications.storeMedia');
    Route::post('notifications/ckmedia', 'NotificationController@storeCKEditorImages')->name('notifications.storeCKEditorImages');
    Route::resource('notifications', 'NotificationController');

    // Langues
    Route::delete('langues/destroy', 'LangueController@massDestroy')->name('langues.massDestroy');
    Route::post('langues/media', 'LangueController@storeMedia')->name('langues.storeMedia');
    Route::post('langues/ckmedia', 'LangueController@storeCKEditorImages')->name('langues.storeCKEditorImages');
    Route::resource('langues', 'LangueController');

    // Students
    Route::delete('students/destroy', 'StudentController@massDestroy')->name('students.massDestroy');
    Route::post('students/media', 'StudentController@storeMedia')->name('students.storeMedia');
    Route::post('students/ckmedia', 'StudentController@storeCKEditorImages')->name('students.storeCKEditorImages');
    Route::resource('students', 'StudentController');

    // Classes
    Route::delete('classes/destroy', 'ClasseController@massDestroy')->name('classes.massDestroy');
    Route::post('classes/media', 'ClasseController@storeMedia')->name('classes.storeMedia');
    Route::post('classes/ckmedia', 'ClasseController@storeCKEditorImages')->name('classes.storeCKEditorImages');
    Route::resource('classes', 'ClasseController');

    // pay
    Route::delete('pay/destroy', 'PayController@massDestroy')->name('pay.massDestroy');
    Route::post('pay/media', 'PayController@storeMedia')->name('pay.storeMedia');
    Route::post('pay/ckmedia', 'PayController@storeCKEditorImages')->name('pay.storeCKEditorImages');
    Route::resource('pay', 'PayController');
});


Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});
