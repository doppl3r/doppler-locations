# Doppler Locations

Create and manage your business pages directly on your WordPress dashboard. Includes a simplified page and template editor to enhance your online presence. Easily add a map of all your locations using the built-in shortcode feature. For multiple owners, assign users to any location.

## Features
 - Location Page Editor
 - Template Editor
 - Interactive Map (built with LeafletJS)
 - User Manager
 - Image Gallery
 - Video Player
 - Custom posts (News & Events)
 - Custom HTML/JS scripts per location

 ## Building Google Extension Release
  - Update release version in doppler-locations.php
  - Install 'gulp': ```npm install --save-dev gulp```
  - Install 'gulp-zip': ```npm install --save-dev gulp-zip```
  - Run gulp-build: ```node gulp-build.js```
  - Run gulp-dist: ```node gulp-dist.js```
  - Upload doppler-locations.zip located under ```/dist```