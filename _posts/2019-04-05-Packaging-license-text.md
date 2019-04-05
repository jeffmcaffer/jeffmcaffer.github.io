---
layout: post
title: "Packaging license text: Just do it"
date: 2019-04-05 11:11:11
tags: opensource ospo
---

Packages are wonderful! They group together discrete bundles of function in "fun-sized" chunks that anyone can reuse. Unfortunately, many package ecosystems don't do a great job of including the text of the package's license in the package itself. By omitting this key piece of info, they make it extremely difficult for their community to comply with their license terms. 

<!--more-->

Here's a look at some data from [ClearlyDefined](https://clearlydefined.io):

Ecosystem | % with license text 
--- | --- 
Pod | 76
Crate | 59
Gem | 56
npm | 55
PyPI | 30
NuGet | 4
Maven | 0

This is preliminary data and there may be some anomalies in the measurements but given there are ~350K package versions in the dataset, the general point remains the same &mdash; license and attribution material in packages is pretty sparse.

This is an issue because even the simplest open source license (e.g., MIT) has terms that require consumers to do something. The most common is including the package's copyright(s) and license text when distributing the package. See [my post on open source compliance](https://mcaffer.com/2019/02/Open-source-compliance-gone-amok) for more detail. 

Package managers are fantastic at making it super simple for direct and indirect consumers to get packages. This enables package distributors, other open source projects, product teams) to simply get the required packages, bundle them up with their own code, and ship. If these packages all include the required attribution items, it's relatively easy for them to generate an explicit `NOTICE` file since all the raw materials are available in the packages themselves. Nice and easy.

If the packages don't include the license and copyright text, then what's the consuming team to do? They have a set of, perhaps 1000, packages but no attribution material. Assuming they know the license of the package (presumably they do otherwise they can't be sure of their right to use the package in the first place), teams can go to the [Open Source Initiative](https://opensource.org) or some other source and get a copy of the canonical license text. Unfortunately, this does not address the attribution requirements of many licenses (e.g., the MIT license requires the reproduction of the “above copyright notice” presumably for whatever source files the license was originally on). Sigh.

Teams can rifle through the files in the package looking for copyright statements. But many packages are "built" meaning that they do not include the original source so may not have any (or at least not all) copyright info. 

If the consumer is hip to the latest advances in this space and knows about [ClearlyDefined](https://clearlydefined.io) &mdash; a crowd-source effort to discover, curate and disseminate exactly this kind of info. There's a good chance they can get the required info. That's cool, they can even use ClearlyDefined's Notice file sharing mechanism (Share a workspace list of components as a notice file) to create the required attributions to include in their product. But where did that info come from? The package still did not have the license text in it.

Most typically it either came from ClearlyDefined weaseling around to find the precise source commit that matches the package version and then looking in there for the license text, or from some sort of human curation, or as outlined earlier, falling back to the canonical license text and scraping files for copyrights. Not much fun.

# What do to?

Fortunately, the solution is relatively simple. Including the license text in the package is often as easy as adding a line to the package build/publish script to identify an additional file (e.g., `LICENSE`) to be included in the packaged output. Package publishers can do this today.

Even better would be updating the package publishing tools themselves to check packages and ensure they have a license file and nudge or remind users where the file is missing or cannot be identified. To that last point, it would be better still if the package metadata allowed publishers (or the package manager) to explicitly identify the license file(s) in the package. This would remove all ambiguity. 

Some package managers are already there &mdash; Debian does a great job. Others are moving in this direction. npm warns users if their package does not identify their license using an [SPDX license identifier](https://spdx.org/licenses/). (Actually, it can be a license *expression* but that's for another post) That's great for knowing the terms helps but you still need the information demanded in the license, for example, the license text.

The NuGet team recently [updated their `nuspec`](https://github.com/NuGet/Home/wiki/Packaging-License-within-the-nupkg-(Technical-Spec)) metadata to allow identification or *either* an SPDX license expression *or* point to a license file. SPDX expressions are super useful but so, as we've seen, is the license text &mdash; this should not be an `or`. I've been chatting with the team to see how we can encourage more people to include the license text *as well as* spec a license expression. Let's see what happens.

# Wrap up

I've not done exhaustive research on which package managers promote the inclusion of license files but can say from the data we are seeing in ClearlyDefined, there are not many and/or they are not working particularly well &mdash; developers are a bit on their own.

If you do publish packages, please take a minute to check your packaging scripts and ensure they include the license file (you do have one, right?!) in the list of packaged files. It's really easy and really simplifies the lives of consumers who are trying to comply with your license. Who knows, perhaps you are consuming some packages and would benefit from them including license text...
