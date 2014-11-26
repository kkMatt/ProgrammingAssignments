<div class="header-container">
	<header class="wrapper clearfix">
		<h1 class="title">NFQ task by Kestutis</h1>
		<nav>
			<ul>
				<li><a href="FTPFileBrowser.php">Code</a></li>
				<li><a href="UML">UML Diagram</a></li>
				<li><a href="#">GitHub</a></li>
				<li><a href="#">Notes</a></li>
			</ul>
		</nav>
	</header>
</div>

<div class="main-container">
	<div class="main wrapper clearfix">

		<article>
			<header>
				<h1>Users in the system</h1>
				<p>Bellow we list all our users in the system</p>
			</header>
			<section class="users-holder">
				<p>Tomas [X]</p>
			</section>
			<footer>
				<h3>API Usage notes</h3>
				<p>[command: "get_user"],[command:"get_user", id:1]</p>
			</footer>
		</article>

		<aside>
		<h3>More links</h3>
			<ul>
				<li><a href="http://flightphp.com/learn">Learn Flight Php</a></li>
				<li><a href="http://verekia.com/initializr/responsive-template">Learn initializr responsive</a></li>
			</ul>
			<h3>Users groups in the system</h3>
			<p class="user-groups-holder"></p>
		</aside>

	</div> <!-- #main -->
</div> <!-- #main-container -->

<div class="footer-container">
	<footer class="wrapper">
		<h3>2014 (C) Kestutis IT, Twitter: <a href="#">@KestutisIT</a></h3>
		<p><code><?php printf('Page rendered in %s msecs / Memory usage %s Kibytes',round(1e3*(microtime(TRUE)-Flight::get('id')),2),round(memory_get_usage(TRUE)/1e3,1)); ?></code></p>
	</footer>
</div>