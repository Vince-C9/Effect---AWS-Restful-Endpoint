# Textract Demo for Effect 
What follows is a tech test proposed by Effect.   There are a number of things that have gone into this behind the scenes that will be 'off scene', I will do my best to list them here in order of occurrence.

I've chosen to use the PHP SDK for brevity, but also because I didn't really think the test was around creating my own way to interface with AWS.   The PHP SDK is a great bit of kit used to speed up the grunt work of authenticating and interfacing, and that's probably what I'd use on a day to day basis.

### Set up an IAM user & Access Group
Your mileage may vary as your groups may already be setup.  I've had to create a new user and access group to ensure that it can only access Textract.  I've called the group 'textract full access' and given it permissions by the same name, then assigned the user to that group.  This gives it programmatic access to the textract API.

This IAM user came with a key and a secret.  You can replace the values in your .env file to ensure that you can access the API in question.

