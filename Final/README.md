Cian Howell

I designed the layout for four of pages of this site and used bootstrap html and css to make this design. I used minmal Javascript and only used it to implement core functionalities. We plan on rewriting the site using php and to dynamically create pages. For the most part this project seems to be going
well and we will start to work perodically on the site as we rushed the end. Overall I think this project will be successful and perform its intented function. I added Create Read and Delete functionality to the website with PHP. I created an API (IDK if it would actually be considered one) that returns subcategories based on categories and subcategories based on other subcategories. I created the relations in the database. I implemented a post get redirect pattern on forms although I did not use headers and instead echoed a script with a location.href. I adjusted design accordingly with the content that is dynamically loaded on to the page. I used PDO prepare and htmlspecialchars trim to help prevent SQL injection and XSS attacks. This was a super swag money baller project not gonna lie.

Aaryaman Thuloj

I helped design layout for a couple of the pages and also works with Bootstrap, CSS, and HTML in order to help finish the project, and me and Cian discussed design ideas throughout. I created the sign-up form and used Bootstrap elements to make it as aesthetically pleasing as possible. I also fixed the directories of all our files, as they were all mostly stored in the root, and made an organized resources folder for everything that we used in its own subfolder. I also fixed all the validation errors that we had on each page and our CSS file. I definitely am excited to start working on the backend of the site, as I love working with that aspect of website design. I also worked with Sam on designing our slides presentation, focusing on the readability for an audience and how it looks.

I worked on a lot of backend for the final sprint. I added functionality to edit the key components listings, which is a part of the CRUD design guideline. I also implemented administrative features including admin accounts that have the ability to delete any listings and ban users. The ban functionality made it so that if you were banned, your RCSID was no longer allowed to access the website and you would be constantly redirected to a "banned" page with a message to contact an admin. I also wrote logic for the browse page that looped through the rows in our database and displayed all items not posted by the user and not sold. I helped write queries for a lot of our calls, and also implemented how items show up on the index page under their categories. I helped with database structure and some visual aspects such as fixing how images were displayed. I also helped with form validations and trying to prevent SQL injection and XSS attacks.

Samuel Leung

I was mainly in charge of how the database for the website was set up. I managed the database on phpmyadmin and created the design for the category tree used to store all the items in the website. I linked each of the categories to subcategories and made sure that Cian's API could use all the data properly. This proved to be a tedious task because we decided to use a 3-level category tree instead of a 2 level tree that Mercari and Craigslist uses. In addition, I also researched and compared our site to similar online sites such as Craigslist and Mercari to see how their sites are organized compared to ours. While I did not get to work on the website as extensively as Cian and Aaryaman because a lot of my time was spent on making the SQL queries to alter the category tables, I took a lot of time checking and learning the functionalities of the code that they wrote. We used my CAS account was used to test the non admin accounts and to check if we could ban a user. Then, I created a basic slides presentation with all the stuff that we wanted to present and had Aaryaman check it over before we presented. I worked with them to make sure we met all the criteria during the presentation.

Works Cited

Item Page Picture Changer - https://www.youtube.com/watch?v=Y36QpYcnbQY

CSS Structure and Media Queries inspired or taken from Cian Howell and Jerry Lu's Qti.ai

Bootstrap Docs used for bootstrap classes and Icons https://getbootstrap.com/docs/5.2/getting-started/introduction/

Sort and filter (although get was used exclusively) - https://www.youtube.com/watch?v=vu9-IymiOAQ

Mercari - https://www.mercari.com/

Craigslist - https://www.craigslist.org/

PHP Knowledge
