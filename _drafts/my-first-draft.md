---
layout: post
title: My Draft BLog Post
subtitle: Mornings contain the secret to an extraordinarily successful life
cover: images/2.jpg
heroimage: images/blog/bg1.jpg 
thumbnail: 
share: 
category: [Analytics]
tags: [Data]
alt: Blog Post Thumbnail 1
author: Uğur Çetin
date: 16 August 2021
---
# {{ page.title }}

## {{ page.subtitle }}


This is a demo of all styled elements in Jekyll Now. 

[View the markdown used to create this post](https://raw.githubusercontent.com/barryclark/www.jekyllnow.com/gh-pages/_posts/2014-6-19-Markdown-Style-Guide.md).

This is a paragraph, it's surrounded by whitespace. Next up are some headers, they're heavily influenced by GitHub's markdown style.

## Header 2 (H1 is reserved for post titles)##

### Header 3

#### Header 4
 
A link to [Jekyll Now](http://github.com/barryclark/jekyll-now/). A big ass literal link <http://github.com/barryclark/jekyll-now/>
  
An image, located within /images

![an image alt text]({{ site.baseurl }}/images/jekyll-logo.png "an image title")

* A bulletted list
- alternative syntax 1
+ alternative syntax 2
  - an indented list item

1. An
2. ordered
3. list

Inline markup styles: 

- _italics_
- **bold**
- `code()` 
 
> Blockquote
>> Nested Blockquote 
 
Syntax highlighting can be used by wrapping your code in a liquid tag like so:

{{ "{% highlight javascript " }}%}  
/* Some pointless Javascript */
var rawr = ["r", "a", "w", "r"];
{{ "{% endhighlight " }}%}  

creates...

{% highlight javascript %}
/* Some pointless Javascript */
var rawr = ["r", "a", "w", "r"];
{% endhighlight %}
 
Use two trailing spaces  
on the right  
to create linebreak tags  
 
Finally, horizontal lines
 
----
****

Include Image
... which is shown in the screenshot below:
![My helpful screenshot]({{ site.url }}{{ site.baseurl }}/images/blog/bg1.jpg)


... you can [get the PDF]({{ site.url }}{{ site.baseurl }}/documents/JD BuWiFi Userguide.pdf) directly.

![My helpful screenshot]({{ page.heroimage | relative_url }})

***

# Markdown Cheatsheet

## Table of Contents  
[Headers](#headers)  
[Emphasis](#emphasis)  
[Lists](#lists)  
[Links](#links)  
[Images](#images)  
[Tables](#tables)  
[Blockquotes](#blockquotes)  
[Inline HTML](#html)  
[Horizontal Rule](#hr)  
[Line Breaks](#lines)  
[YouTube Videos](#videos)  

<a name="headers"/>

# Headers
```markdown
# Heading 1
## Heading 2
### Heading 3
#### Heading 4
##### Heading 5
###### Heading 6
```
... becomes ...

> # Heading 1
> ## Heading 2
> ### Heading 3
> #### Heading 4
> ##### Heading 5
> ###### Heading 6

<a name="emphasis"/>

# Emphasis

```markdown
Emphasis, aka italics, with *asterisks* or _underscores_.
Strong emphasis, aka bold, with **asterisks** or __underscores__.
Combined emphasis with **asterisks and _underscores_**.
Strikethrough uses two tildes. ~~Scratch this.~~
```

... becomes ...


> Emphasis, aka italics, with *asterisks* or _underscores_.
> Strong emphasis, aka bold, with **asterisks** or __underscores__.
> Combined emphasis with **asterisks and _underscores_**.
> Strikethrough uses two tildes. ~~Scratch this.~~


<a name="lists"/>

# Lists

(In this example, leading and trailing spaces are shown with with dots: ⋅)

```markdown
1. First ordered list item
2. Another item
⋅⋅* Unordered sub-list.
1. Actual numbers don't matter, just that it's a number
⋅⋅1. Ordered sub-list
4. And another item.

⋅⋅⋅You can have properly indented paragraphs within list items. Notice the blank line above, and the leading spaces (at least one, but we'll use three here to also align the raw Markdown).

⋅⋅⋅To have a line break without a paragraph, you will need to use two trailing spaces.⋅⋅
⋅⋅⋅Note that this line is separate, but within the same paragraph.⋅⋅
⋅⋅⋅(This is contrary to the typical GFM line break behaviour, where trailing spaces are not required.)

* Unordered list can use asterisks
- Or minuses
+ Or pluses
```
... becomes ...

> 1. First ordered list item
> 2. Another item
>   * Unordered sub-list.
> 1. Actual numbers don't matter, just that it's a number
>   1. Ordered sub-list
> 4. And another item.
>    You can have properly indented paragraphs within list items. Notice the blank line above, and the leading spaces (at least one, but we'll use three here to also align the raw Markdown).  
>    To have a line break without a paragraph, you will need to use two trailing spaces.  
>    Note that this line is separate, but within the same paragraph.    
>    (This is contrary to the typical GFM line break behaviour, where trailing spaces are not required.)
> * Unordered list can use asterisks
> - Or minuses
> + Or pluses

<a name="links"/>

# Links

There are two ways to create links.

```markdown
[I'm an inline-style link](https://www.google.com)
[I'm an inline-style link with title](https://www.google.com "Google's Homepage")
[I'm a relative reference to a repository file](../blob/master/LICENSE)
[You can use numbers for reference-style link definitions][1]

Or leave it empty and use the [link text itself].

[1]: http://slashdot.org
[link text itself]: http://www.reddit.com
```
... becomes ...

> [I'm an inline-style link](https://www.google.com)  
> [I'm an inline-style link with title](https://www.google.com "Google's Homepage")  
> [I'm a relative reference to a repository file](../blob/master/LICENSE)  
> [You can use numbers for reference-style link definitions][1]

> Or leave it empty and use the [link text itself].

> [1]: http://slashdot.org
> [link text itself]: http://www.reddit.com

<a name="images"/>

# Images

```markdown
Inline-style:
![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 1")

Reference-style:
![alt text][logo]

[logo]: https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 2"
```
... becomes ...

> Here's our logo (hover to see the title text):  
> Inline-style:  
> ![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 1")  
> Reference-style:  
> ![alt text][logo]  
>
> [logo]: https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 2"  

<a name="tables"/>

# Tables

Tables aren't part of the core Markdown spec, but they are part of GFM and *Markdown Here* supports them. They are an easy way of adding tables to your email -- a task that would otherwise require copy-pasting from another application.

```markdown
Colons can be used to align columns.

| Tables        | Are           | Cool  |
| ------------- |:-------------:| -----:|
| col 3 is      | right-aligned | $1600 |
| col 2 is      | centered      |   $12 |
| zebra stripes | are neat      |    $1 |

There must be at least 3 dashes separating each header cell.
The outer pipes (|) are optional, and you don't need to make the
raw Markdown line up prettily. You can also use inline Markdown.

Markdown | Less | Pretty
--- | --- | ---
*Still* | `renders` | **nicely**
1 | 2 | 3
```
... becomes ...

> Colons can be used to align columns.
>
> | Tables        | Are           | Cool |
> | ------------- |:-------------:| -----:|
> | col 3 is      | right-aligned | $1600 |
> | col 2 is      | centered      |   $12 |
> | zebra stripes | are neat      |    $1 |  
>  
> There must be at least 3 dashes separating each header cell. The outer pipes ( \| ) are optional, and you don't need to make the raw Markdown line up prettily. You can also use inline Markdown.
>
> Markdown | Less | Pretty
> --- | --- | ---
> *Still* | `renders` | **nicely**
> 1 | 2 | 3

<a name="blockquotes"/>

# Blockquotes

```m
> Blockquotes are very handy in email to emulate reply text.
> This line is part of the same quote.

Quote break.

> This is a very long line that will still be quoted properly when it wraps. Oh boy let's keep writing to make sure this is long enough to actually wrap for everyone. Oh, you can *put* **Markdown** into a blockquote.
```

becomes:

> Blockquotes are very handy in email to emulate reply text.
> This line is part of the same quote.

Quote break.

> This is a very long line that will still be quoted properly when it wraps. Oh boy let's keep writing to make sure this is long enough to actually wrap for everyone. Oh, you can *put* **Markdown** into a blockquote.

<a name="html"/>

# Inline HTML

You can also use raw HTML in your Markdown, and it'll mostly work pretty well.

```no-highlight
<dl>
  <dt>Definition list</dt>
  <dd>Is something people use sometimes.</dd>

  <dt>Markdown in HTML</dt>
  <dd>Does *not* work **very** well. Use HTML <em>tags</em>.</dd>
</dl>
```

<dl>
  <dt>Definition list</dt>
  <dd>Is something people use sometimes.</dd>

  <dt>Markdown in HTML</dt>
  <dd>Does *not* work **very** well. Use HTML <em>tags</em>.</dd>
</dl>

<a name="hr"/>

# Horizontal Rule

```
Three or more...

---

Hyphens

***

Asterisks

___

Underscores
```

Three or more...

---

Hyphens

***

Asterisks

___

Underscores

<a name="lines"/>

# Line Breaks

My basic recommendation for learning how line breaks work is to experiment and discover -- hit &lt;Enter&gt; once (i.e., insert one newline), then hit it twice (i.e., insert two newlines), see what happens. You'll soon learn to get what you want. "Markdown Toggle" is your friend.

Here are some things to try out:

```
Here's a line for us to start with.

This line is separated from the one above by two newlines, so it will be a *separate paragraph*.

This line is also a separate paragraph, but...
This line is only separated by a single newline, so it's a separate line in the *same paragraph*.
```

Here's a line for us to start with.

This line is separated from the one above by two newlines, so it will be a *separate paragraph*.

This line is also begins a separate paragraph, but...  
This line is only separated by a single newline, so it's a separate line in the *same paragraph*.

(Technical note: *Markdown Here* uses GFM line breaks, so there's no need to use MD's two-space line breaks.)

<a name="videos"/>

# YouTube Videos

They can't be added directly but you can add an image with a link to the video like this:

```no-highlight
<a href="http://www.youtube.com/watch?feature=player_embedded&v=YOUTUBE_VIDEO_ID_HERE
" target="_blank"><img src="http://img.youtube.com/vi/YOUTUBE_VIDEO_ID_HERE/0.jpg"
alt="IMAGE ALT TEXT HERE" width="240" height="180" border="10" /></a>
```

Or, in pure Markdown, but losing the image sizing and border:

```no-highlight
[![IMAGE ALT TEXT HERE](http://img.youtube.com/vi/YOUTUBE_VIDEO_ID_HERE/0.jpg)](http://www.youtube.com/watch?v=YOUTUBE_VIDEO_ID_HERE)
```

Referencing a bug by #bugID in your git commit links it to the slip. For example #1.

---

License: [CC-BY](https://creativecommons.org/licenses/by/3.0/)



# A sample Markdown document

This is a sample document so you can preview the color schemes.

## Text Formatting

Markdown supports _italics_, __bold__, and ___bold italics___ style using underscores.

Markdown supports *italics*, **bold**, and ***bold italics*** style using asterisks.

There are also inline styles like `inline code in monospace font` and ~~strikethrough style~~.

__There may be ~~strikethroughed text~~ or `code text` inside bold text.__

_And There may be ~~strikethroughed text~~ or `code text` inside italic text._

> __Here is some quotation__. Lorem ~~ipsum~~ dolor sit amet, consectetur  
> adipisicing elit, *sed* do eiusmod tempor incididunt ut labore et
> dolore magna aliqua. Ut enim <b>ad</b> minim <kbd>veniam</kbd>, quis nostrud exercitation.
> 
> <code>
>   code block
> </code>

Inline <kbd>key</kbd> or ~~<kbd>key</kbd>~~ other <b>bold html</b> tags.

<table align="center">
    <tr width="85%">
        <td>column&nbsp;text</td>
    </tr>
</table>

## Links and References

To reference something from a URL, [Named Links][links],
[Inline links](https://example.com/index.html "Description") and direct link like <https://example.com/>
are of great help. Sometimes ![A picture][sample image] is worth a thousand words.

---

This [[SamplePage]] is a wiki link.

## Lists

There are two types of lists, ordered and unordered.

1. Item 1 
   <kbd>key</kbd>
2. Item 2
3. Item 3

1) Item 1
2) Item 2
3) Item 3

* Item A
    - Sub list
        + Sub sub list
        + Sub sub list 2
    - Sub list 2
* Item B
* Item C

## Tables

Col 1 | Col 2
-----:|-------
what  | else

## Code Blocks

Anything indented more than 3 characters is treated as raw code block.

    function fibo(n) {
        fibo.mem = fibo.mem || []; // I am some comment
        return fibo.mem[n] || fibo.mem[n] = n <= 1 ? 1 : fibo(n - 1) + fibo(n - 2);

Fenced code blocks support syntax highlighting and are wrapped in triple backticks.

```javascript
function fibo(n) {
    fibo.mem = fibo.mem || []; // I am some comment
    return fibo.mem[n] || fibo.mem[n] = n <= 1 ? 1 : fibo(n - 1) + fibo(n - 2);
}
```

```diff
diff --git a/schemes/Preview.md b/schemes/Preview.md
index 3d4b1fe..a85a22a 100644
--- a/schemes/Preview.md
+++ b/schemes/Preview.md
@@ -89,6 +89,12 @@ function fibo(n) {
 
-## Deleted
+## Inserted
```

## CriticMarkup

This is {++ inserted ++} and {-- deleted --} or {== highlighted ==}{>> comment <<} text.

We can also {~~ substitute ~> something ~~}.

## Reference Definitions

[^1]: This is a footnote definition

[links]: https://example.com/index.html
[sample image]: https://example.com/sample.png