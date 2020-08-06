<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## About This Laravel Admin System

It's a backend CMS like admin system that can be used to manage a website.

Laravel version: 7
Scaffolding: Bootstrap

It has a couple build in features and relationships
- Pages
- Posts with the ability to add comments and categories to it
- Images
- User management

## How to install
- Clone the repo
- Run "composer install" to install required packages
- Setup a database
- Setup the .env file by renaming the .env.example to .env add your database credentials there
- Run "php artisan migrate"
- After everything is migrated you will have to register an admin user first  by going to /register and fillout the form

# Features

# User roles
- There are two user roles pre defined. Admin and user.
- Only admin can login to /admin

# Users
- Can create and modify their profile details (admin only)
- Admins can create, modify or delete users

# Pages
- Require a page template before the can work.
- Page templates require the filename before .blade.php   en index.blade.php will be index
- To setup a homepage a page has to be created first with a homepage page template and set as homepage under general settings
- Pages are related to slugs, images, users, and other pages
- URL routing is dynamic

# Posts
- Posts may or may not have one one many categories.
- One primary category can be added to the URL
- URL routing is dynamic based on uri and the category
- On the frontend comments can be created for posts
- There are relationships for: users, categories, primary category, slugs, images and comments

# Comments
- Comments are setup as many to many but at the moment only related to posts
- On the frontend logedin users can create a comment that first need to be approved
- Comments can have a parent comment
- There is some work done for comment management when approving or deleting comments that have child comments
- Child comments are hidden when parent is disabled or trashed
- Child comments are deleted when parents are deleted from trash

# Images
- The image gallery is using dropzone to auto upload images
- The images are saved in several diffrent sizes
- In the database you will have an image table that's related to the imageFile table
- The image table just containe image detail and for every diffrent file there will be a new entry in ImageFiles that contains file info like size, resolution etc.
- Images are saved in the storage folder

# Slugs
- Slugs for the frontend are based on a relationship and saved in the slugs table
- Slugs are automatically sanitized and corrected by the use of laravel-sluggable package
- We do auto routing for slugs with posts this is either the post or post with category
- Slug routing for pages accept one parent page in the url

# Notifications
- By default all notifications are saved in the DB
- Via profile settings users can enable mail notifications
- Notifications are setup as many to many but at the moment only used for comments



