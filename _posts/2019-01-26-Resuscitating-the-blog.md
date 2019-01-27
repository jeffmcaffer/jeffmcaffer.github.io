---
layout: post
title: "Resuscitating the blog"
date: 2019-01-26 11:11:11
tags: jekyll
---

I made a resolution &mdash; not really for the new year just all on its own &mdash; to start sharing more of what's
going on in the world around me. We'll see if I keep it up. For now, I've updated the blog's look a bit and
have a few topics lined up in my head. In the event that someone else is trying similar GH Pages machinations,
I've capture some useful info here. Bear with me (or do something else useful) if this is all old hat to you.

<!--more-->

# Basic GH Pages update

I set this up three years ago and since then, a few things have changed. First step was to get the basic infrastructure up to date.

## Markdown formatters

GitHub now only supports `kramdown` and the `rouge` highlighters. Luckily I was already using those. I did notice however that
the configuration has a new format more like this:

```yaml
kramdown:
  input: GFM
  syntax_highlighter: rouge
  syntax_highlighter_opts:
    css_class: "highlight"
```

Not sure if the old style would work (I last generated the site a while ago). I updated it anyway. Also had to mess a bit with the styling. Not sure how it was before but with the current highlighting I was getting a horizontal scroll area even for narrow text and the color was off. A tweak to the `overflow` property solved that.

```css
.highlight {
    overflow: auto;
    ...
```

## https

Mid-last year GitHub introduced [https for custom domained GH Pages](https://github.blog/2018-05-01-github-pages-custom-domains-https/). This is an awesome and welcomed addition. I set about updating the configuration. My DNS is on GoDaddy (not sure why any more, will likely move) and they do not support `ANAME` or `ALIAS`. So, as per [the GitHub doc](https://help.github.com/articles/setting-up-an-apex-domain/#configuring-a-records-with-your-dns-provider), updated the DNS `A`
records to point to the new addresses. In the end it all worked out but unfortunately several steps in the doc are of the flavor of:

1. Add all these entries in your DNS server.
1. Before changing your DNS server, do this other thing.

I definitely did things out of order. Not sure if it actually mattered or I was just too impatient or what. I had a whole writeup of what I tried etc but deleted it because it literally just started working now. Moral of the story? _Patience_.

# Bit o' stylin'

## Full width header

I generally like full width headers etc so did some tweaks to make the banner full width but with the rest still constrained to at most 1100px wide. Easy enough. Err, well, my prior banners were all 130px high PNGs. I wanted the new banner layout to be 200px high. I also wanted the banner image to scale properly for different window sizes. That is, I want the height to stay the same and the image to scale up/down proportionally.

Turns out that `background-size: cover` is your friend there. Just create a full width `<div>` that is the
height you want (200 in my case), set the `background` to be the image, and the `background-size: cover`. I made it much
harder than it had to be in the process of figuring that one out. `cover` just stretchs (proportionally) or clips as needed to, well, cover the entire background of the element.

## Pop that header text

Perhaps something changed between when I first did this setup and now. Looking at the old version, my name and quippy
saying up there at the top right was not at all standing out over the image. Well that was not going to do. I had been using a
`text-shadow` with white to help the black text pop but the effect was not strong enough. I found a bunch of different
approaches to `blur`ing the background etc. but many seemed complex or overly dramatic. In the end I settled on a `<div>` with a gradient background like this:

```css
background: linear-gradient(
  to right,
  rgba(255, 255, 255, 0),
  rgba(255, 255, 255, 0.6) 40%,
  rgba(255, 255, 255, 0.7) 70%,
  rgba(255, 255, 255, 0.8)
);
```

Key bits there are the color (white), the changing alpha (opacity) value, and the %s. Going from left to right we start fully opaque (0 on the alpha channel) then drive up to 0.6 alpha at 40% of the way across, then a bit more alpha (opacity) at 70% across, and finally end up at 0.8 alpha. I spent quite a bit of time messing around with different increments
and alphas to get it smooth. I think it worked out reasonably. Open to suggestions.

## Random banners

In the original blog I had a random banner, sort of. Using some Jekyll magic detailed in a [previous post](/2015/11/Moving-to-Jekyll), the _build_ of the site would randomly pick an image from a table of images
and statically bind that into the site. It would stay that way until the site was built again. Sorta boring. I wanted more randomness (who doesn't?). Time for a bit of JavaScript.

```javascript
  <script>
    window.onload = () => {
      var image = Math.floor(Math.random() * 7)
      var header = document.querySelector('.site-header')
      header.style.background = `transparent url(/images/header/${image}.jpg) no-repeat center bottom`
      header.style.backgroundSize = 'cover'
    }
  </script>
```

The `background` for an element is a style thing, not an element thing. That means you can easily just get the element
and bash the style. The value of a style prop is just the string that you would normally have written in the CSS file. So I just renamed all of my images to be numbered and generated a random URL for the background. You can also see the aforementioned `cover` for the `background-size`.

One interesting thing came up while doing this. It appears you cannot set some of the background related style props in CSS (well SASS) and some in JavaScript. When I put the `background-size` setting in the CSS, it appears to have been overwritten by the JavaScript code. Perhaps I was doing something wrong? The above worked so I didn't spend a long time fretting over it. Some day perhaps.

## New images

The original images used in the banners were mosly panoramas from sailing around the British Virgin Islands with the family some years ago. Great memories. I've been doing some other things lately so thought I'd update the pics, what with all that new found height and variable width in the banner... Can you guess what I've been up to?

## Favicon

Oddly the old blog did not have a favicon. The old old site did. Anyway, for this revamped blog I decided to use a helmet as a nod to my racing. I poked around for a bit looking for helmet icon that I could color and ideally scale etc. Turns out that the state of licensing in the image world is very unclear (something I'll blog about later). Since I lacked clarity on the terms under which I could use the images I found, I ended up drawing my own.

<img src="/images/helmet.png" alt="helmet" width="64" height="64" class="center">

Took me all of 5 minutes using [INKSCAPE](https://inkscape.org/). You can see the icon on this page's tab and the SVG is in the GitHub repo.

Aside: I quite like INKSCAPE (they seem to capitalize so I'll follow suit). I've used it to do all sorts of stuff including laying out dozens and dozens of hexagons in a pattern for vinyl cutting and application to the race car. It's certainly has its quirks but I actually prefer it to Illustrator for the things that I do.

#Wrap up

That's all I'm going to do on the blog infrastructure for now. Next will be some technical content I think. Let me know if there is anything you want to hear about related to [Microsoft and open source](https://opensource.microsoft.com), [Pro3 racing](https://pro3-racing.com) or the [Alfa Romeo Giulia Quadrafoglio](https://www.alfaromeousa.com/cars/giulia/quadrifoglio).
