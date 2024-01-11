1. composer create-project --prefer-dist laravel/laravel myAppName

2. open folder in vsCode

3. configure .env file change db name, set db port e.t.c

4. run terminal command php artisan migrate to create migration

5. make models with php artisan make:model Modelname -m 
(singular and first letter capital -m to run migration flag)

6. make controllers 
php artisan make:controller ModelController --resource
			Or
php artisan make:controller Api/ModelController --api

(--resource creates complete CRUD, --api excludes create and edit)

7. edit database migration table columns as per needed 
creating foreign id $table->foreignIdFor(User::class);
$table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
$table->string('name');
$table->text('description')->nullable(); e.t.c

8. add relationships to the Models. 
inside class event {
	public function user() : BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
keep notice of use statements.

9. Defining routes either in api.php or web.php depending on usecase
Route::apiResource('events', EventController::class);
Route::apiResource('events.ateendees', AttendeeController::class)->scoped(['attendee'=> 'event']);
you can check routes using php artisan route:list

10. Define guarded or fillable elements in the model
protected $fillable = ['title', 'description', 'long_description'];
    // protected $guarded = ['id'];
    
11. Create factories and seeders for data seeding
php artisan make:factory EventFactory --model=Event
php artisan make:seeder EventSeeder

12. set column definitions in the factory
	'title'=> $this->faker->sentence(3),
	'name' => fake()->unique()->sentence(3),
	'description' => fake()->text,
        'created_at' => $this->faker->dateTimeBetween('-2 years'),
	'updated_at' => function (array $attributes) 
         {return fake()->dateTimeBetween($attributes['created_at'], 'now');}

13. set rules in the generated seeder in the run function:
        Book::factory(33)->create()->each(function (Book $book) {
            $numReviews = random_int(5, 30);

            Review::factory()->count($numReviews)->good()->for($book)->create();
        });
        			X--------X
                $users = User::all();

        for( $i = 0; $i < 200; $i++ ) 
        {
            $user = $users->random();
            Event::factory()->create(["user_id"=> $user->id,]);
        }
14. Modify users in the main database seeder and call the the other generated seeders in run:

        $this->call(EventSeeder::class);
        $this->call(AteendeeSeeder::class);
        
15. Refresh migrations and seed
php artisan migrate:refresh --seed 

and check data in phpMyAdmin afterwards

16. make request file for storing validations 
php artisan make:request TaskRequest
example
public function rules(): array
    {
        return [
            'title'=> 'required|max:255',
            'description'=> 'required',
            'long_description'=> 'required'
          ];
    }
    
17. import case statements and use validations in controller functions 
like $task = Task::create($request->validated()); for storing e.t.c

shorter validations can also be done using 
	$request->validate([
		'name'=> 'required|string|max:255',
	]),
inside the controller functions.


18. Implement basic CRUD functionality in the Controller's available functions.

19. making resources for transforming json responses
php artisan make:resource EventResource


20. making traits in http folder for optional or universal relationship loading

21. adding traits to the controllers

22. protecting routes using Authcontroller
using public construct_ func to use middleware sanctum
define a login and logout function for routes (use auth:sanctum on logout)
for setting expiration time change value in sanctum.php of expiration from null to e.g (60 * 24)
$schedule->command('sanctum:purne-expired --hours=24')->daily(); // to remove expired tokens in db

23. making gates for authentication in the authserviceprovider
then use $this->authorize('said-function', $param) in the respective controller.

24. making policies instead of gates
php artisan make:policy EventPolicy --model=Event
authrize resource in the construct func using model::class and route {param}
controller methods and policy methods must have standard naming conventions 
for making guest access either make $user nullable or optional using ? before the model
use the gate function logic in the respective functions.

-------------------------------------------------

1. making custom artisan commands
php artisan make:command CommandName

2. task scheduling (check frequency scheduler in docs)
specify the schedule command in kernel.php
use php artisan schdeule:work (to run all schedule func locally)
using task output we can see the results in a file or email it to someone

3. making a notification class
php artisan make:notification NotificationName
constructing mail message
setting up mamilserver (was not able to do it will do later)

4. making ques locally in the database
php artisan queue:table
setting up queue connection and use implements ShouldQueue in a custom command or job.php
this helps in running time-consuming tasks in the backgroud
use php artisan queue:work to run the queued tasks in the db
look in docs on how to use SuperVisor to make sure the queue worker is kept running always 

5. rate limiting the api
research on using redis for caching and limiting the app
throttling can be done in the routes api or they can also be added to the controllers via middleware
instead of defining requests/min to every controller individually 
a function name configured in the RouteServiceProvider like 'api' function 
the middleware will be then ('throttle:api') instead ('throttle:60,1')


