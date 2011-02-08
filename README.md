# HTML5 Boilerplate + Stacey 2.2.2

Two great tastes that taste great together!

## Getting Started

Included is a project.todo tasklist file which should walk you through what sorts of changes you should look out for and which files you should start customizing. The list may not be comprehensive yet, but it covers all the big, nonstandard ones out there.

## So what?

[Stacey](http://staceyapp.com) is a great filesystem backed cms, and it handles *many* cases for personal websites. I found myself creating a bare version of stacey a few times, and each time populating it with stock files: new jquery, yui css reset, html5shiv, etc. Then the [HTML5 Boilerplate](http://html5boilerplate.com/) showed up and somewhat standardized many of these dependencies, so it seemed natural to incorporate the two.

*Note*, this is not a stacey template (no design is included!), it's only the combination of both stacey and the boilerplate so you can go forth and spend time actually *designing* your own client's portfolio site (or what have you). The project structure is even broken up into two parts: assets (for pdfs or sketches of design) and web (for the working site). In many cases, you can create a virtualhost with its docroot as the web folder and get started.

Still, it incorporates the best of stacey (flexible templates & partials) with the best of the boilerplate, and adds in, for example, a version of hyphenator.js that you can turn on via comments. The best part, imho, is that the boilerplate's `style.css` is also rendered via a template, which allows you to have the cleanliness of @imports, but mid-file, and in many locations. Additionally, robots.txt is handled via a template.

## What's changed?
This fork of stacey makes one minor change to the behavior of stacey:

  * .css, .md and .txt files may used instead of .txt files for template content

Back around v2.2.0, stacey added the ability to serve css and text templates, which naturally is quite useful if you have a massive css reset like one found in the html 5 boilerplate. Still, you had to place your css in these awkward .txt files which, if you're ocd, causes some annoying syntax highlighting issues. 

Additionally, because much of the rendered content is markdown (or can be, it's your choice!), it seemed natural to save the content files as .md files rather than .txt files. These are entirely superficial changes which, at last check, make up a total of three diffed lines of code. All other behavior in stacey is unaltered.

