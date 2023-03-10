# Project Journal

## Week of Jan 9th

- Began the project journal
- Set-up Cloudinary account
- Uploaded all required files to cloudinary
- Currenlty working on the rough draft of the first couple pages

## Week of Jan 16th

- Created the SQL instance on GCP
- Created a bucket to hold the `travel-db-dump.sql` file and imported to db
- Created config.php to connect to db
- Looked into CSS frameworks as I had never used one before
- Tailwind CSS and Pico CSS look neat, I will stick with Pico for now
- Created the resgistration and login pages
- Made the required logic to have a user be able to register through the registration page (A lot more difficult than I thought it would be)
- I found a very useful tutorial [tutorial](https://youtu.be/BaEm2Qv14oU).

## Week of Jan 23rd

- Realized that the way that I started the project was not the best way to go about it so I decided to refactor/restart the project
- This time it adheres much more to the functional requirements
- Have a working admin page to log in
- Have a working browse page to view all the images

## Week of Jan 30th

- Not a lot of work done this week
- Restructured the way the db is set up to be more in line with class examples

## Week of Feb 6th

- Fixed querys to retrieve proper data
- Completed pagination for browse page
- Created all of the querys for the browse page
- Fixed favicon
- Still link the querys to the search selects
- Rating sort is not working for some reason

## Week of Feb 13th

- Completely changed the way that queries are made to the db. This made the page much much faster.
- 'Fixed' the sorting, it is not doing the paramenter binding
- Almost done for the php side, just need a few more things like the admin log in

## Week of Feb 20th and Feb 27th

- Did not do any work at all 😅

## Week of Mar 6th

- Had some issues moving the db over from GCP to the codespace but all is good now, and I continued to work on the project.
- Admin page now has server side validation, ran into a couple issues with this like dealing with the return of the digest when the user is not found. Eventually got everything working.
- Added functionality to search for country, city, and rating.
- Added functionality to change the rating.
- After merging branches it seems that my DB disappeared?? Had to run the script again and recreate tables and data.
- Finished the API endpoints.
- I believe that the only thing missing from the backend is the confirmation message after changing the rating.
