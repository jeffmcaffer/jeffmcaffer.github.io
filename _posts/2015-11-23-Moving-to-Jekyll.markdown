---
layout: post
title:  "mcaffer.com moved to Jekyll"
date:   2015-11-23 11:11:11
tags: jekyll
---
Like so many others, I have moved my blog from WordPress on my hosting provider [Dreamhost](http://dreamhost.com) to be produced via Jekyll and hosted using GitHub Pages.  I made the switch for simplicity and to mess around with current technologies.  In this post I outline the steps I took and setup I use to create this blog itself.  Over time I'll likely update the blog to capture how each element of the blog works.

<!--more-->

# Why Jekyll
As mentioned above, there are a few reasons.

* Simplicity -- Jekyll isn't necessarily simpler.  You have to set it up on the machine you are using to author posts (if you want to preview) and while not hard, there is some stuff to do.  It is operationally simpler, however, in that once the site is rendered, there is no compute, nothing to get hacked (happening to my WP sites regularly), nothing to update.
* Open -- WP is definitely open but it is internally more complex and harder mess about with.  Perhaps its just a learning curve...
* Convention -- All the other open source project content I happen to deal with is in markdown and rendered more or less with the Jekyll engine so this is good practice.

# Initial setup
Setting this all up was resonably simple. 

1. Install Ruby.  I'm on Windows (yeah yeah) so had to [install Ruby first](http://rubyinstaller.org/downloads/). The instructions are pretty easy.  I used the 32 bit stable version.  No real value in 64 bit and running Jekyll is not rocket science. 
1. Get [Jekyll](http://jekyllrb.com).  This is pretty simple.   If you are going to be using stock GitHub Pages to deliver your site, check out the instructions on how to [get the exact GitHub setup on you machine](http://jekyllrb.com/docs/github-pages/).
1. Clone your site's GitHub repo.  Assuming you are going to host your site using GitHub Pages, clone the `master` (for orgs) or `gh-pages` (for projects) branch for the target repo onto your machine. 
1. Generate a site.  Run `jekyll new my-site-repo` where "my-site-repo" is name of your git repo and the command is run from the parent folder.  Then run `jekyll serve` from the `my-site-repo` folder to check it out at [`http:://localhost:4000`](http://localhost:4000).
1. Publish to GitHub.  Do a git commit and push to get the pages on GitHub.

Voila! The blog is up and running.  No real content but that's up to you anyway.  Now for the interesting customizations.

# Custom domain

Having your blog at yourname.github.io or some such is not that fun.  Luckily you can setup a custom domain and have it pointed to the published GitHub Pages.  This can be done for an "apex" domain like [mcaffer.com](http://mcaffer.com) or for a sub-domain like blog.mcaffer.com.  I did the apex domain.  GitHub has [instructions](https://help.github.com/articles/setting-up-a-custom-domain-with-github-pages/).  They are a little circuitous but basically net out to three steps.

1. Register you domain name.  I already had [mcaffer.com](http://mcaffer.com) so this was a no-op.  Hit up [godaddy](godaddy.com) or some other registrar to get your domain.
1. Create a `CNAME` file.  This tells GitHub where the site will show up in URL space.  The file must be all named in all CAPS and be at the root of your repo.  It must have just one line and that line is just the name of the (sub)domain where you are putting your blog.  My file just has `mcaffer.com` on a line by itself.   Note that you use a file called CNAME regardless of whether you are doing an apex domain or sub-domain.
1. Setup a DNS entry.  You have to tell "the internet" where your domain is located.  The steps will vary by domain registrar or DNS provider.  Check out the [handy instructions on GitHub](https://help.github.com/articles/adding-a-cname-file-to-your-repository/#next-steps-configuring-dns-settings).

# Comments
I want to engage with folks so enabling comments on the posts is key.  The easiest thing is to setup [Disqus](disqus.com). The following steps got it done for me:

1. Register with Disqus. Just folow the instructions at [Disqus](http://disqus.com) to get your account setup.
1. Configure my blog. For Jekyll integration, use the ["Universal" code](https://disqus.com/admin/universalcode/).  Again, the intstructions are pretty simple. I added a disqus.html file in the _includes folder and then included that in the post.html layout (I only wanted comments on my posts).
1. You have to setup values for `this.page.identifier` and `this.page.url`.  I used `page.peramlink` for these.

Note that Disqus has changed their integration and you can no longer style as much as you could before.  Nor can you eliminate some of the bits n bobs like the "Subscribe" and "Privacy" links along the bottom. Let me know if you find a way.

# Syntax highlighting

Jekyll can do syntax highlighting with [either Rouge or Pygments](http://jekyllrb.com/docs/templates/#code-snippet-highlighting).  Rouge is built into Jekyll so I started with that. Pygments requires Python and I figured fewer moving parts is better.  When I first pushed the repo to GitHub I got build warnings saying that Rouge was not supported and they were using Pygments instead.  I just tried it again and am not getting any errors and the highlighting in this post (below) appears to be working so it seems Rouge is built in and supported by GitHub.  Winner!

# Tag Cloud

I really like tag clouds and had one on my old blog.  You can see mine in action down the right-hand side of this post.

There are several Jekyll plugins for generating tag clouds but as far as I could see, none are supported on GitHub.  There are a number of non-plugin options like this one on [CodingTips](http://codingtips.kanishkkunal.in/tag-cloud-jekyll/).  Unfortunately, they all seem to use some linear font sizing algorithm.  That's less than optimal when your tags only have a few hits and when you have tags with lots of mentions.  Early in your blog's life there will be relatively few tag mentions so the fonts will be really small.  Similarly, later in your blog's life, the tags will have lots of mentions and the fonts will get really big. 

My approach is to make 10 font size buckets and then scale the fonts according to the dynamic range of the tag mentions.  That is, if the difference between the most mentioned and least mentioned tag is <= 10, a tag's font size is simply allocated based on its position in the range.  If the range is larger than 10 then the range is "compressed" and fonts allocated according to the compressed values.

The snippet below is `tagcloud.html` you can include wherever you want the tag cloud to show up.  It first computes the minimum and maximum mentions of tags across all the posts and then diffs those to get the range.  From there,  the cloud formed by creating the links and setting their font size based on where each tag's mention count fits in the range (scaled or unscaled appropriately). No plugins and only a little bit of gorpy Liquid code.

{% highlight liquid %}
{% raw %}
<div class="tag-cloud">

{% assign min = 100000 %}
{% assign max = 0 %}
{% for tag in site.tags %}
  {% if tag[1].size > max  %}
    {% assign max = tag[1].size %}
  {% endif %}
  {% if tag[1].size < min  %}
	  {% assign min = tag[1].size %}
  {% endif %}
{% endfor %}
{% assign range = max | minus: min | plus: 1 %}

{% assign sortedtags = site.tags | sort %}
{% for tag in sortedtags %}
  {% assign count = tag[1].size %}
  {% if range > 10 %}
    {% assign font = count | minus: min | times: 10 | divided_by: range | plus: 1 %}
  {% else %}
	  {% assign font = 10 | minus: range | divided_by: 2 | plus: count %}
  {% endif %}
  <a href="/tags.html#{{ tag | first }}" style="font-size: {{ font | times: 3 }}pt" >{{ tag | first }}</a>
{% endfor %}

</div>
{% endraw %}
{% endhighlight %}

# "Random" banner images
The site has a banner image that is typically a panorama shot that I took somewhere along the way. The image shown should change over time.  This could be done with some Javascript on the page that varied the image link but, in the interest of keeping it simple, the image selection should be part of the site itself.  Liquid does not have a random filter/function but it does have time.  In particular, it has `site.time`.  

# Wrap up
That's it for now. Going forward I'd like to add a post archive by date and a few affordances to make it easy for you to tweet the things you find interesting.  Mostly the site will stay simple.  Let me know in the comments if you have any suggestions.