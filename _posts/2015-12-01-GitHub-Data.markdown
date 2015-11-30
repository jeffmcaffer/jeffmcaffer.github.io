---
layout: post
title:  "Diving into GitHub Data"
date:   2015-12-01 11:11:11
tags: github data
---

GitHub is a veritable treasure trove of information about all kinds of things related to open source, various technologies, software engineering practices, programming patterns, social interactions, and so much more. I'm really excited to be diving into this space.  The first thing we are doing is sponsoring [GHTorrent](http://ghtorrent.org) to run on Azure and integrate with [Azure Data Lake](https://azure.microsoft.com/en-us/solutions/data-lake/)

<!--more-->

In my daily interaction with folks inside and outside Microsoft engaged in open source, it is very common to come across teams who would like to get a better understanding of what is going on in GitHub.  Some of the scenarios we see are:

* Project health -- understand characteristics of successful projects, tell how our projects are doing and to determine if someone else’s project is solid enough to depend on or worthy of investment
*	Azure security -- with the recent key compromises, Azure is keen to scan all of GitHub to find keys and warn owners
*	Developer behavior -- What is a Python developer?  Do most/many devs work across multiple techs, if so, which?  Is something trending?
*	Product insight -- Gain insight into product/platform/SDK uptake by monitoring projects using the technology of interest
*	SDK usage -- Analyze SDK usage for correctness, change impact, ...
*	Product implementation -- for example, Bing Developer Assistant harvests quality code from GitHub as a source of its coding suggestions
*	IP management -- IP scanning and license discovery etc

What do you want to know about what's happening in GitHub?  Add your thoughts to the comments below.

# GitHub data sources
GitHub provides several sources of data about the projects and teams it hosts.

* Website -- The [site for each repo](https://github.com/Microsoft/TypeScript/graphs/) has a number of charts and stats that show who is contributing, the watchers, forks, ...  This is consumable by humans but not so much by machines.  Some folks have been screen scraping these sites to get info. Not great but in some cases, this is the only source.
* API -- There is a pretty [rich set of APIs available on GitHub](https://developer.github.com/v3/).  With these you can access just about every aspect of  public (and your private) repos.  [GitHub rate-limits](https://developer.github.com/v3/rate_limit/) these APIs to 5000 requests/hour in an effort to keep the system usable.  As such, there is only so much you can do with API calls.
* Events -- [https://api.github.com/events](https://api.github.com/events) is a feed of all events happening in all public repos.  See an example event below.  As you can imagine, there are a lot of events (>50K/hour) so this data changes very quickly.  To get it all you have to read it often.  Reading it once a second (3600 times an hour) "should" get you everything and still stay under the rate limit.  That does not leave much headroom to work with the events.
* [Webhooks](https://developer.github.com/webhooks/) -- You can ask GitHub to call you back when various events occur on a [repo](https://developer.github.com/v3/repos/hooks/) or an [org](https://developer.github.com/v3/orgs/hooks/).  These webhooks deliver an event payload to a designated URL as the events occur.  You can only hook repos to which you have appropriate permissions.

All of these approaches have drawbacks: incomplete data, potential for missed data, high volume, API rate limiting, limited permissions, ...  What we really need is a shared service that gathers all this data and puts it in a queryable form.  Fortunately some fine folks in the community have been hard at work collecting up some of this info and making it available.

{% highlight json %}
{
  "id": "3389952959",
  "type": "PushEvent",
  "actor": {
    "id": 99999999,
    "login": "jeffmcaffer",
    "gravatar_id": "",
    "url": "https://api.github.com/Microsoft/typescript",
    "avatar_url": "https://avatars.githubusercontent.com/u/99999999?"
  },
  "repo": {
    "id": 0102030546,
    "name": "microsoft/typescript",
    "url": "https://api.github.com/repos/microsoft/typescript"
  },
  "payload": {
    "push_id": 883546547,
    "size": 1,
    "distinct_size": 1,
    "ref": "refs/heads/master",
    "head": "aaf5025dafa123a90ee94b0e9d48e6d22bbf8663",
    "before": "4b57fe306b51e7de39e5a67d0ffc4d5e8a904513",
    "commits": [
      {
        "sha": "5f0f9aa98566c87e1a496f5248c4d136f96731d5",
        "author": {
          "email": "jeffmcaffer@gmail.com",
          "name": "Jeff McAffer"
        },
        "message": "fix a simple problem",
        "distinct": true,
        "url": "https://api.github.com/repos/microsoft/typescript/commits/5f0f9aa98566c87e1a496f5248c4d136f96731d5"
      }
    ]
  },
  "public": true,
  "created_at": "2015-11-30T07:39:19Z"
}
{% endhighlight %}

# GitHub Archive
[GitHub Archive](http://githubarchive.org) is essentially a database of all the events on the [https://api.github.com/events](https://api.github.com/events) feed.  They make available hourly archives of some 20 different event types. You can download these, structure the data into a local database and query your heart out.  You can also [access the data through Google BigQuery](https://www.githubarchive.org/#bigquery).  There is a lot you can do with this data but it is a little limited for our purposes.

Like GitHub itself, the BigQuery service is rate-limited such that you can process 1TB of data per month with BigQuery.  This is great for investigation and modest sized datasets but we have thousands of repos to track.  We certainly can get the raw archives and put them in our own database but...

The data itself is rather limited.  The events captured are just that, the events. For example, the push event shown above identifies the user, the repo and the set of commits being pushed. The actual data is not included.  This high-level information is fine for some flavors of insight but many of the scenarios outlined above need more detail.  

# GHTorrent
[GHTorrent](http://ghtorrent.org) fill this gap by getting all the events and then walking the links in the events to transitively gather all of the data related to the event.  The events themselves are stashed in a MySQL database and the event payloads, the transitive data, is stored in a series of MongoDB tables related to the different types of data.

Like GitHub Archive, the GHTorrent data is available both to use online (rate-limited) or to download the bulk data and run yourself.  Unfortunately, the dataset is really pretty big (~7TB) so downloading is a challenge and querying in the online system can be slow.

# Path forward
In a bid to address these concerns and get the desired insights, the Open Source Programs Office (my team) and the Tools for Software Engineering (TSE) teams at Microsoft are joining forces with the Georgios Gousios from GHTorrent to host the infrastructure on Azure and pump the data in to Azure's new Data Lake service.  This has a number of interesting benefits:

* Stable home for GHTorrent as it is today
* Data in a scaleable store, Data Lake available as an HDFS store
* Access to the data using modern big data tools like Hadoop, Spark, HBase, Storm, ...
* Ability to include private repo data

There are still a lot of details being worked out but I'm hoping we get the system up and running in the next few weeks and have more to say then.
