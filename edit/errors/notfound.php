<?php
/**
 * This is the 404-handler for Apache and HHVM (see README).
 * It is typically served from wiki domains for urls outside
 * the scope of MediaWiki. For example:
 *
 *
 * The response is similar to errorpages/404.html, except that it uses a
 * project-specific favicon (instead of generic masm.ico).
 */
header( 'Content-Type: text/html; charset=utf-8' );
header( 'Cache-Control: s-maxage=2678400, max-age=2678400' );

$path = $_SERVER['REQUEST_URI'];
$encUrl = htmlspecialchars( $path );

if ( preg_match( '/(%2f)/i', $path, $matches )
	|| preg_match( '/^\/(?:upload|style|wiki|w|extensions)\/(.*)/i', $path, $matches )
) {
	// "/w/Foo" -> "/wiki/Foo"
	$target = '/wiki/' . $matches[1];
} else {
	// "/Foo" -> "/wiki/Foo"
	$target = '/wiki' . $path;
}
$encTarget = htmlspecialchars( $target );
$outputHtml = <<<END
<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta charset="utf-8">
<title>Not Found</title>
<link rel="shortcut icon" href="/favicon.ico">
<style>
* { margin: 0; padding: 0; }
body { background: #fff; color: #202122; font: 0.938em/1.6 sans-serif; }
.content { margin: 7% auto 0; padding: 2em 1em 1em; max-width: 640px; }
img { float: left; margin: 0 2em 2em 0; }
a img { border: 0; }
h1 { margin-top: 1em; font-size: 1.2em; }
p { margin: 0.7em 0 1em 0; }
a { color: #36c; text-decoration: none; }
a:hover { text-decoration: underline; }
em { color: #72777d; font-style: normal; }
</style>
<div class="content" role="main">
<a href="https://crm.maamedia.org/projects"><img src="https://commons.maamedia.org/images/6/69/Maamedia_Logo_Black.png" srcset="https://commons.maa.edia.org/images/6/69/Maamedia_Logo_Black.png 2x" alt=Maamedia width=135 height=135></a>
<h1>Page not found :(</h1>
<p><em>$encUrl</em></p>
<p>We could not find the above page on our servers.</p>
<p><b>Did you mean: <a href="$encTarget">$encTarget</a></b></p>
<p style="clear:both;">It could be that you misspelled the title or the page just simply doesn’t exist. You can read on Maamedia Meta's <a href="https://meta.maantietaja.org/wiki/404">page</a> why such an announcement.</p>
</div>
</html>
END;

print $outputHtml;
