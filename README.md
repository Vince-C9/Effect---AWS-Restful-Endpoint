# Textract Demo for Effect 
What follows is a tech test proposed by Effect.   There are a number of things that have gone into this behind the scenes that will be 'off scene', I will do my best to list them here in order of occurrence.

I've chosen to use the PHP SDK for brevity, but also because I didn't really think the test was around creating my own way to interface with AWS.   The PHP SDK is a great bit of kit used to speed up the grunt work of authenticating and interfacing, and that's probably what I'd use on a day to day basis.

## Set up an IAM user & Access Group
Your mileage may vary as your groups may already be setup.  I've had to create a new user and access group to ensure that it can only access Textract.  I've called the group 'textract full access' and given it permissions by the same name, then assigned the user to that group.  This gives it programmatic access to the textract API.

This IAM user came with a key and a secret.  You can replace the values in your .env file to ensure that you can access the API in question.  You'll find the relevant keys in `api/env.example`.

# Setup

## Spin up Docker
Start your docker desktop (download if needed) and navigate using `windows powershell / terminal` to the root folder ( the same location as the docker compose file ).   Run `docker-compose up` - it should automatically build your environment for you.

To confirm, run `docker ps` and see whether there are new containers present.   If you have any issues with containers being named the same as existing ones, try to stop all of the running docker instances within docker desktop, then repeat `docker-compose up`

## Set up laravel

1. Navigate to the API folder and run `composer install`.
2. Copy the .env.example file to .env
3. Generate your security key.  Note: If you need to use docker for this because your machine doesn't have PHP or Artisan on it, postpone until you've spun up docker.  Generally given the volumes, doing this directly on your machine is quicker.  But needs must!
4. Migrate your database inside docker by using the following command: `docker-compose exec effect_api php artisan migrate:fresh`.  The first time you do this, you may be asked to create your database, as it may not yet exist in the docker instance.  Just select 'yes' in this instance.
5. Add your IAM user to the .env file per above if you haven't already done so.

Once you've followed these instructions, if you visit localhost:8000 you should see the standard Laravel fresh install page.  If not, use the on-screen errors to debug. 

## Running Tests
There are a few tests present in this build, but they are not quite where I'd like them to be.  I have written them as 'live' tests to begin with to test my config with the intention of converting them into mockeries later.  In addition, one of the tests currently fails due to a discrepancy between the test generated PDF type and the AWS expectation.   This is frustrating and a point that I would seek to improve in a real situation, however, the call itself when run live -does- resolve as expected.  This wouldn't really be an issue in a live situation as we would be looking to mock our third party API calls in our tests.

To run the tests, type `docker-compose exec effect_api php artisan test`.

## Hitting the endpoint
At this time there is no GUI.  You'll need to use Postman, or your favourite competitor to Postman in order to hit the endpoint due to the nature of Post requests.  I haven't set up any auth, as it seemed aside from this project to write login and register methods, but this again is a point I'd underline would not occur in a real project.

1. Set your HTTP method to POST.
2. Set your url to `localhost:8000/api/pdf/convert`
3. Click on `Body` (postman, your mileage may vary in other software)
4. Create a key of `pdf` and a value that is a file.  Upload `sample.pdf` included in this package (storage/app/public/pdf) or provide your own pdf file if needed.
5. Click Send.  You should receive a JSON message with success (or an error if things have gone horribly wrong).


## Checking if the data has written
You can use Tinker to check if the data has written as expected.  Type `docker-compose exec effect_api php artisan tinker` to run tinker within the docker container.

Type: `PDFChunks::all()` and/or `PDFContent::all()` to see the content of the models.   My intention was to have a second endpoing to display this data based on the ID provided, but I ran out of time.



# Areas of improvement

## Mockery / Mocked Tests
All third party API calls should be moved to a mock test.  We only care about what we build in terms to testing, it'd be impossible to test third party apps live and it would cost us a lot of money if we ran 1000's of tests that all pinged an AWS endpoint.

## Security
Auth is very much lacking here.  Any endpoint that reads or writes to AWS should be behind a guard of some sort to prevent unwanted bad actors from interacting with it.  I would likely rely on Sanctum for this given the decoupled nature of the API, sanctum seems a little better for things of this nature than alternatives.

## 

