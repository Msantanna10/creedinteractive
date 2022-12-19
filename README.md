# Creed Interactive | Code Challenge
In this code challenge, I have created an awesome plugin to read a JSON file and add its data to a custom post type with custom taxonomies.

## Demo
To make everything easier, I'm providing a [demo](https://domamo.com.br/creedinteractive/) where the theme already works with the plugin. You can [login](https://domamo.com.br/creedinteractive/wp-admin) as administrator using "creedinteractive" as username and password.

## How To Use
This custom theme is very easy to use as it does not depend on any third party file other than the theme and the custom plugin itself.
* Download and activate the "code-challenge" theme inside wp-content->themes
* Download and activate the "podcasts-json" plugin inside wp-content->plugin
* In the dashboard, navigate to "Appearances->Menus" and create a menu called "Main Menu". Add some custom links so you can see them on the frontend (at the moment, only parent links will be displayed in the menu).

You're all set to see it in action!

## Style Changes
To update the theme styles:
* Open the theme in your terminal
* Run `npm i` to install the packages
* Run `gulp` to run the process and continually compile the SCSS files into the CSS directory

## Global Options
![Global options](https://i.imgur.com/izlrqiC.jpg)
The plugin creates a custom options page so you can decide about the synchronization behavior. Here are the options:
**1 - I'd like to force podcasts from the JSON:** Podcasts can be deleted, but they will remain in the trash. However, once you permanently delete them, they will be re-added from the JSON file.
**2 - I'd like to be able to delete them permanently:**  As the name suggests, by activating this option you will be able to delete podcasts permanently and they will not be re-added.

## Podcasts Post Type
![Post Type](https://i.imgur.com/fX1l33c.jpg)
The plugin creates a custom post type called "podcasts" and inserts all podcasts from the JSON file as posts. In addition to that, two custom taxonomies are created and all images are added to the site's media library with custom sizes to avoid requests to external sources.

## Custom Endpoint for the REST API
![Custom Endpoint](https://i.imgur.com/KAjGNsh.jpg)
Everything gets even better! A custom route is created and returns a real-time JSON of posts created from the file. It works with GET parameters to limit the number of podcasts and to work with pagination.
Example:
`https://domamo.com.br/creedinteractive/wp-json/podcasts/v1/all` will return all podcasts
`https://domamo.com.br/creedinteractive/wp-json/podcasts/v1/all?count=5` will return the last 5 podcasts
`https://domamo.com.br/creedinteractive/wp-json/podcasts/v1/all?count=5&page=2` will return 5 podcasts from the second page

## Conclusion
The project itself is using the custom route to display the podcasts on the homepage! Therefore, the "Load more" button on the homepage has been added so that you have a good experience in pulling podcasts with new real-time requests to the route with the pagination parameter. All files have several comments explaining a little about what is being done.

Thank you very much for your attention.
