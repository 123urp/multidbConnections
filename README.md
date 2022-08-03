Multidb connection with:

In this blog, we are going to talk how we can configure multiple different DBs in a single project dynamically. In this example, there are configured 3 types of db which are MySql, Sqlite, Postgresql Databases.

You can connect any databases with this. For example you can connect 2 or more different databases one by one. Same will come for Sqlite and Postgres database.

After connection in this view tables are created with help of adding query in display views as per database connection.

From below, all required steps are mentioned.
Note: Please get page code from mentioned GitHub link with their relative path : 

Step 1: Firstly intstall laravel with composer with using this command :
	- composer create-project laravel/laravel multidb
	- cd multidb
	- php artisan serve

Step 2: Next, create controller and blade view.
	1) Controller command is: php artisan make:controller SelectionContoller
	page is mentioned on app/Http/Controllers/
	2) In view folder create dbselection.blade.php and page is mentioned in resources/views/

Step 3: Now, create Helpers with name DatabaseConnection.php and file you can get from app/Helpers/

Step 4: Now, create DisplayController using below command.
	- php artisan make:controller DisplayController
	and file you can get from app/Helpers/
Step 5: create view file for Display controller functionality.
Step 6: Create Middleware with name Ensureconfigsession.php with command “ php artisan make:middleware Ensureconfigsession”
	Middleware is generated for check databse connection is good or expire.
	register into kernal.php like below
	protected $routeMiddleware = [
		...
		'ensureconfigsession' => \App\Http\Middleware\Ensureconfigsession::class,
	];
	then add below code into handle:
	$session_value = session('dbdetails');
	if (empty($session_value)) {
	return redirect('/selection');
	}
	return $next($request);
step 7: For make logout from connection just click on expire connection, then you will redirect to main page and connection will lost.
