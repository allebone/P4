Allebone.Me - Project Four Repository
===================


Greetings.  I'm Bryan, and this is the Repository for my Project Four.  
**Github** will contain the most up-to-date Commits for this project.  


----------


URL for Project Four
-------------

##**[http://p4.allebone.me](http://p4.allebone.me)**


> **Note:**

> - All of the links and necessary resources are hosted within a Digital Ocean Droplet at the above link (and requisite sub folders). Additionally, the DNS Name Services are provided through the educational assistance program of NameCheap.com. I chose to allow NameCheap to continue to maintain the Name Server control (of forwarding) for the time being, as I didn't want to complicate matters with propagation delay. 

----------

Project Description
-------------------

Project Four is the culmination of this semester's work in Laravel/PHP. More advanced concepts in Laravel, the MVC method, CRUD via MySQL, and other underlying technologies (PHP, HTML5, et al.)  For my demonstration, I choose an RSVP System, but had several issues unable to be rectified, beginngin several weeks ago. In the end, I choose instead to design the example project of a "Task Manager" which incorporated several of the advanced features and all the minimum requirements from the Final Project specification. Namely:

Requirements:

- User Authentication with Individual Task Lists
- Consolidated Task Listing at Login (Incomplete in Bold)
- Selectable Individual Pages per Status (Completed, Incomplete, and All)
- A Modal Window for Adding new Tasks
- A Modal Window for Editing/Completing Tasks (and their details)
- Task Status: Shows Incomplete or Date Completed (becomes unbolded, as well)  
- Error Checking: No empty Task fields, email signups/registrations
    
Completed Extra Challenges

- User Authentication using the Sentry (See Below Rationale)
- User Registration using email
- Password recovery using email tokens
- Ability to Email a task reminder


Demo Information
--------------------

> **Presentation:** My Demo can be found [HERE](http://screencast.com/).

Additional Information
--------------------

### Outside Dependencies and Citation

The following items were included for attached rationale:

##**[Bootstrap GitHub](https://github.com/twbs/bootstrap)**
	
>	Utilizing the Bootstrap Framework gave me the opportunity to uniformly present information within my site. Its requisite theme from CSS is also represented below as a utilized dependency. The color mapping, sized character depictions, and quick implementation of anchored areas are unparallelled for a fledgling designer. 

##**Bootstrap Theme (.css)**
 
>	I don't have the luxury of time/experience to create eye pleasing color palates, and functional design.  Twitter is generous enough to provide these under reusable  licensing terms. I altered them (within the confines of the licensing structure) to facilitate features/color schemes within my design.  I've listed this separately due to its alteration within Licensing. 

##**[Font Awesome](http://fortawesome.github.io/Font-Awesome/)**

>	I utilized the Font Awesome inclusions so that I could use the their fancy Icon Sets. For instance, Facebook, LinkedIn, GitHub, and Pied Piper are the only icons used in the contact area: doing more with less in terms of visual appeal.Also, there are LESS versions and pre-processing already apparent for efficiency.

##**[Ham Sandwich](https://github.com/fzaninotto/Faker)**

>	I utilized the Faker PHP Library to facilitate creation of several fake identities. 

##**[Sentry - Authentication/Authorization Framework](https://github.com/cartalyst/sentry)**

>	I utilized the Sentry, authentication and authorization Framework. I was more aware of the features and setup compared to oauth, having implemented it prior to this class.  
